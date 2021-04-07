<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Content;
use App\Provider;
use App\Category;
use App\Audio;
use App\Post;
use App\Operator;
use App\RbtCode;
use Monolog\Logger;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Session;


class FrontController extends Controller
{

    public function index()
    {
        return view('front.index');
    }

    public function index_mobile()
    {
        return view('front.index_');
    }

    public function home(Request $request)
    {

        if ($request->has('OpID')) {
            $opID = $request->OpID;
            $main_video = Post::join('contents', 'contents.id', '=', 'posts.content_id')
                ->where('posts.operator_id', $opID)
                ->where('posts.active', 1)
                ->where('posts.published_date', '>=', date('y-m-d'))
                ->where('contents.content_type_id', 5)
                ->orderBy('posts.created_at', 'Desc')->first();
        } else {
            $main_video = Content::where('content_type_id', 5)
                ->where(function ($query) {
                    return $query->where('created_at', 'like', date('Y-m-d') . '%')
                        ->orWhere('created_at', '<=', date('Y-m-d'));
                })->orderBy('created_at', 'Desc')->first();
        }
        $providers = get_providers();
        $generalService = general_service();
        $topics = Category::whereNull('parent_id')->get();
        $prayer_times = $this->prayTimesCal();
        $hjrri_date = $this->hjrri_date_cal();
        return view('front.home', compact('main_video', 'providers', 'generalService', 'topics', 'prayer_times', 'hjrri_date'));
    }

    public function services($id, Request $request)
    {
        if ($request->filled('rbt')) {
            if ($request->rbt == $id) {
                $provider = Provider::FindOrFail($id);
                $rbtCodes = RbtCode::where('provider_id', $request->rbt)->get();
                foreach ($rbtCodes as  $rbtCode) {
                    $contents[] = Content::where('id', $rbtCode->content_id)->get();
                }
                //dd($rbtCodes);
                return view('front.services_id', compact('contents', 'provider'));
            } else {
                return response()->view('front.error');
            }
        } else {
            $provider = Provider::FindOrFail($id);
            return view('front.services', compact('provider'));
        }
    }



    public function contents($id, Request $request)
    {
        //dd($id);
        $category = Category::FindOrFail($id);
        $services = $category->contents;
        //$title = $service->title;
        if ($request->has('OpID')) {
            $opID = $request->OpID;
            $contents = Post::join('contents', 'contents.id', '=', 'posts.content_id')
                ->where('posts.operator_id', $opID)
                ->where('posts.active', 1)
                ->where('posts.published_date', '>=', date('y-m-d'))
                ->get();
        } else {
            $contents = Content::where('category_id', $id)->get();
        }
        // foreach($services as $service){
        //     if ($service->content_type_id == 5) {
        //         return view('front.videos', compact('contents'));
        //     } elseif ($service->content_type_id == 4) {
        //         return view('front.audios', compact('contents'));
        //     } elseif ($service->content_type_id == 3) {
        //         return view('front.videos', compact('contents'));
        //     }elseif ($service->content_type_id == 6) {
        //         return view('front.iframe', compact('contents'));
        //     }else{
        //         return view('front.text', compact('contents'));
        //     }
        // }
        return view('front.videos', compact('services', 'contents'));
    }

    public function view_content($id)
    {
        $content = Content::FindOrFail($id);
        $operators = "";

        $prayer_times = $this->prayTimesCal();
        $new_pt = array();
        $en = ['am', 'pm'];
        $ar = ['صباحا', 'مساء'];
        $hjrri_date = $this->hjrri_date_cal();
        foreach ($prayer_times as $key => $value) {
            array_push($new_pt, str_replace($en, $ar, $value));
        }
        $rbtCodes = RbtCode::all();

        foreach ($rbtCodes as  $rbtCode) {

            $operators = Operator::where('id', $rbtCode->operator_id)->get();
        }
        //dd($operators);
        return view('front.play_video', compact('content', 'new_pt', 'hjrri_date', 'prayer_times', 'operators'));
    }

    public function sebha()
    {

        return view('front.sebha');
    }

    public function zakah()
    {

        return view('front.zakah');
    }

    public function merath()
    {

        return view('front.merath');
    }

    public function merath_calc()
    {

        return view('front.merath_calc');
    }

    // salah time
    public function salah_time()
    {
        $prayer_times = $this->prayTimesCal();
        $hjrri_date = $this->hjrri_date_cal();

        return view('front.salah_time', compact('prayer_times', 'hjrri_date'));
    }

    public function prayTimesCal()
    {
        $ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $new_arr[] = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));
        //  echo "Latitude:".$new_arr[0]['geoplugin_latitude']." and Longitude:".$new_arr[0]['geoplugin_longitude'];

        if (isset($new_arr[0]['geoplugin_latitude']) && isset($new_arr[0]['geoplugin_longitude'])) {
            $latitude = $new_arr[0]['geoplugin_latitude'];
            $longitude = $new_arr[0]['geoplugin_longitude'];
        } else {
            $latitude = "30";
            $longitude = "31";
        }

        include(public_path('plugins/PrayTime.php'));
        $method = 5; // Egyptian General Authority of Survey
        $timeZone = +2;
        $date = strtotime(date("Y-n-j"));  // php date month and day without leading zero   ... Use j instead of d and n instead of m:

        $prayTime = new \PrayTime($method);
        $prayTime->timeFormat = 1;  // 12-hour format
        $times = $prayTime->getPrayerTimes($date, $latitude, $longitude, $timeZone);
        $prayer_times = array();
        foreach ($times as $key => $value) {
            if ($prayTime->timeNames_ar[$key] == "Sunrise" || $prayTime->timeNames_ar[$key] == "Sunset") {
                continue;
            }
            $prayer_times[$prayTime->timeNames_ar[$key]] = $value;
        }

        return $prayer_times;
    }

    public function hjrri_date_cal()
    {
        // Hijri date
        $hjrri_date = array();
        include(public_path('plugins/HijriDate.php'));
        $hijri = new \HijriDate();
        $current_date = date("Y-m-d", strtotime("+1 day"));
        // $current_date = date("Y-m-d");
        $hijri = new \HijriDate(strtotime($current_date));

        $day = $hijri->get_day();
        $month = $hijri->get_month_name_ar($hijri->get_month());
        $year = $hijri->get_year();

        $hjrri_date_object = new \stdClass();
        $hjrri_date_object->day = $day;
        $hjrri_date_object->month = $month;
        $hjrri_date_object->year = $year;

        return $hjrri_date_object;
    }


    public function op_id(Request $request)
    {
        if ($request->filled('op_id')) {
            if (Post::where('operator_id', $request->op_id)->exists()) {
                $posts = Post::where('operator_id', $request->op_id)->get();
                //dd($posts);
                foreach ($posts as  $post) {
                    $contents[] = Content::where('id', $post->content_id)->get();
                    //dd($contents);
                }
                return view('front.opid', compact('contents'));
            } else {
                return response()->view('front.error');
            }
        } else {
            $contents = Content::all();
            return view('front.opid1', compact('contents'));
        }
    }

    public function op_id_au(Request $request)
    {
        if ($request->filled('op_id')) {
            if (RbtCode::where('operator_id', $request->op_id)->exists()) {
                $rbtCodes = RbtCode::where('operator_id', $request->op_id)->get();
                foreach ($rbtCodes as  $rbtCode) {
                    $contents[] = Content::where('id', $rbtCode->content_id)->get();
                }
                return view('front.opid', compact('contents'));
            } else {
                return response()->view('front.error');
            }
        } else {
            $rbtCodes = RbtCode::all();
            foreach ($rbtCodes as  $rbtCode) {
                $contents[] = Content::where('id', $rbtCode->content_id)->get();
            }
            return view('front.opid', compact('contents'));
        }
    }




    // end salah time
    public function mosque()
    {

        return view('front.mosque');
    }

    public function azan()
    {

        $providers = Provider::with('audio')->get();
        $providers = Audio::with('provider')->groupBy('provider_id')->get();

        return view('front.azan', compact('providers'));
    }

    public function list_azan(Request $request)
    {

        $audios = Audio::where('provider_id', $request->id)->get();
        $data = view('front.list_azan', compact('audios'))->render();

        return Response($data);
    }

    public function rbts(Request $request)
    {

        if ($request->has('OpID')) {
            $opID = $request->OpID;
            $rbts = Audio::where('operator_id', $opID)->whereNull('video_id')->get();
        } else {
            $rbts = Audio::whereNull('video_id')->get();
        }
        return view('front.rbts', compact('rbts'));
    }

    public function view_rbt($id)
    {

        $rbt = Audio::FindOrFail($id);
        $prayer_times = $this->prayTimesCal();
        $hjrri_date = $this->hjrri_date_cal();
        return view('front.inner_rbt', compact('rbt', 'prayer_times', 'hjrri_date'));
    }



    /* ======================= new landing =================== */

    public $front_view = "front.";
    // --------------Live -----------------//
    private $privateKey = "6g8UUH6mlUilXpOSssp8";
    private $publicKey = "fhCP5KoWwDET9G9N9odF";
    private $subscriptionPlanId = 514;
    private $service_name = "yallawaffar";
    public $customerAccountNumber = "customer159635721";
    private $status = "live";


    public function unsub(Request $request)
    {

        Session::forget('contract_id'); // to remove any contract_id from session
        Session::forget('phone_number'); // to remove any contract_id from session

        if (isset($_GET['operator_id']) && !empty($_GET['operator_id']))
            $operator_id = $_GET['operator_id'];
        return view('front.unsub', compact('operator_id', 'request'));
    }


    public function new_landing(Request $request)
    {
        // if (Session::has('phone_number') && Session::has('status') && Session::get('status') == "active") {
        //     return redirect('/');
        // }else{
        // header inrichemnt DETECT
        $result = array();
        // get client ip
        $ip = $_SERVER["REMOTE_ADDR"];

        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
            $ip = $_SERVER['HTTP_CLIENT_IP'];


        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $deviceModel = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $deviceModel = "";
        }


        $country_from_ip = $this->ip_info("Visitor", "Country");
        $result['date'] = Carbon::now()->format('Y-m-d H:i:s');
        $result['ip'] = $ip;
        $result['country'] = $country_from_ip;
        $result['deviceModel'] = $deviceModel;
        $result['AllHeaders'] = $_SERVER;


        $actionName = "Hits";
        $URL = $request->fullUrl();
        $parameters_arr = $result;
        $this->log($actionName, $URL, $parameters_arr);  // log in

        return view($this->front_view . 'new_landing');
        //    }
    }

    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
    {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "country" => @$ipdat->geoplugin_countryName,
                            "country_code" => @$ipdat->geoplugin_countryCode,
                            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    public function log($actionName, $URL, $parameters_arr)
    {
        date_default_timezone_set("Africa/Cairo");
        $date = date("Y-m-d");
        $log = new Logger($actionName);
        // to create new folder with current date  // if folder is not found create new one
        if (!File::exists(storage_path('logs/' . $date . '/' . $actionName))) {
            File::makeDirectory(storage_path('logs/' . $date . '/' . $actionName), 0775, true, true);
        }

        $log->pushHandler(new StreamHandler(storage_path('logs/' . $date . '/' . $actionName . '/logFile.log', Logger::INFO)));
        $log->addInfo($URL, $parameters_arr);
    }

    public function AddSubscriptionContractRequest(Request $request)
    {

        $phone_number = $request->MSISDN;

        $operatorCode = $request['operatorCode'];


        // make validation for egypt numbers that start with 2
        if (!preg_match('/^([0-9]{1})?[0-9]{11}$/', $phone_number)) {
            $request->session()->flash('failed', 'هذا الرقم غير صحيح');
            return back();
        }

        if (preg_match('/^2[0-9]{11}$/', $phone_number)) {  // mean this number is leading with 2   for egypt operators => so we remove 2
            $phone_number = ltrim($phone_number, '2');
        }

        $msisdn = Msisdn::where('phone_number', $phone_number)->orderBy('id', 'Desc')->first();
        if ($msisdn && $msisdn->status == 'active') {

            $shortCode = $this->shortCode($msisdn->operatorCode);
            $bin = Bin::where('msisdn_id', $msisdn->id)->orderBy('id', 'DESC')->first();
            if ($bin) {
                // already subscribe message
                //    لديك اشتراك مفعل فى خدمة استقيموا من IVAS بقيمة 2 جنيها يوميا  للوصول الى الخدمة قم بزيارة URL لإلغاء الاشتراك ارسل stop EST الى Short code
                $messageBody = "لديك اشتراك مفعل فى خدمة يلا وفر من IVAS بقيمة 2 جنيها يوميا للوصول الى الخدمة قم بزيارة ";
                $messageBody .= url("loginPC") . "/" . $msisdn->phone_number . "/" . $bin->bin;
                $messageBody .= "    تكلفة الخدمة 2 جنيها يوميا ";
                $messageBody .= " لإلغاء الاشتراك ارسل stop waffar الى ";
                $messageBody .= $shortCode;
                $messageBody .= "  مجانا  ";

                $link = url("loginPC") . "/" . $msisdn->phone_number . "/" . $bin->bin;

                $request->session()->flash('link', $link);
                $request->session()->flash('shortCode', $shortCode);

                $request->session()->flash('success_url_resend_again', $messageBody);
                $request->session()->flash('succss_subscribe_before', $messageBody);
                $request->session()->flash('msisdn_subscribe_before', $msisdn->phone_number);
            } else {
                $request->session()->flash('failed', 'حدث خطأ');
            }
            return redirect('landing');  // old confirm
        } elseif ($msisdn && $msisdn->status == "inactive") {
            $request->session()->flash('success_pincode', 'تم تسجيل هذا الرقم من قبل لكن لم يتم تأكيده رجاء ادخال كود التفعيل ');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('landing');  // old confirm
        } elseif ($msisdn && $msisdn->status == "pending") {
            $request->session()->flash('failed', 'رقمك موقوف');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('landing');  // old confirm
        } elseif ($msisdn && $msisdn->status == "under_processing") {
            $request->session()->flash('failed', 'طلبك تحت المعالجة ');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('landing');  // old confirm
        } elseif ($msisdn && $msisdn->status == "error") {
            $request->session()->flash('failed', 'جدث خطأ');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('new_landing');  // old confirm
        }


        $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/AddSubscriptionContractRequest";
        $startDate = gmdate("Y-m-d H:i:s\Z");
        $startDate = date('Y-m-d H:i:s\Z', strtotime($startDate . " +1 hour"));  // only in local
        $endDate = date('Y-m-d H:i:s\Z', strtotime($startDate . " +1 year"));

        // 012 -> 60201 orange
        // 010 -> 60202 vodafone
        // 011 -> 60203 etisalat

        $customerAccountNumber = $this->customerAccountNumber;
        $msisdn = $_REQUEST['MSISDN'];

        $operatorCode = $request['operatorCode'];

        $subscriptionPlanId = $this->subscriptionPlanId;
        $initialPaymentproductId = $this->service_name;
        $initialPaymentDate = $startDate;
        $executeInitialPaymentNow = "false";
        $recurringPaymentproductId = $this->service_name;
        $productCatalogName = $this->service_name;
        $executeRecurringPaymentNow = "false";
        $contractStartDate = $startDate;
        $contractEndDate = $endDate;
        $autoRenewContract = "true";
        $language = 2;
        $sendVerificationSMS = "true";
        $allowMultipleFreeStartPeriods = "false";
        $headerEnrichmentReferenceCode = "";
        $smsId = "";

        $message = $customerAccountNumber . $msisdn . $operatorCode . $subscriptionPlanId . $initialPaymentproductId .
            $initialPaymentDate . $executeInitialPaymentNow . $recurringPaymentproductId .
            $productCatalogName . $executeRecurringPaymentNow . $contractStartDate .
            $contractEndDate . $autoRenewContract .
            $language . $sendVerificationSMS . $allowMultipleFreeStartPeriods . $headerEnrichmentReferenceCode . $smsId;

        $privateKey = $this->privateKey;
        $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

        $parameters_arr = array(
            "signature" => $signature,
            "customerAccountNumber" => $customerAccountNumber,
            "msisdn" => $msisdn,
            "operatorCode" => $operatorCode,
            "subscriptionPlanId" => $subscriptionPlanId,
            "initialPaymentproductId" => $initialPaymentproductId,
            "initialPaymentDate" => $initialPaymentDate,
            "executeInitialPaymentNow" => 'false',
            "recurringPaymentproductId" => $recurringPaymentproductId,
            "productCatalogName" => $productCatalogName,
            "executeRecurringPaymentNow" => 'false',
            "contractStartDate" => $contractStartDate,
            "contractEndDate" => $contractEndDate,
            "autoRenewContract" => 'true',
            "language" => $language,
            "sendVerificationSMS" => 'true',
            "allowMultipleFreeStartPeriods" => "false",
            "headerEnrichmentReferenceCode" => "",
            "smsId" => ""
        );

        $result_json = $this->get_content_post($URL, $parameters_arr);

        // print_r($result_json); die;

        $result = json_decode($result_json);

        // create a log channel
        $actionName = "AddSubscriptionContractRequest";
        $this->log($actionName, $URL, $parameters_arr);  // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr);  // log out

        if ($result->operationStatusCode == 51) {

            // return back();
            if ($result->errorMessage == "This user already subscribed to the given product") {
                $request->session()->flash('success_url_resend_again', "انت مشترك بالفعل");

                $msisdn = Msisdn::where('phone_number', $msisdn)->where('status', 'active')->orderBy('id', 'Desc')->first();
                if ($msisdn) {
                    $shortCode = $this->shortCode($msisdn->operatorCode);
                    $bin = Bin::where('msisdn_id', $msisdn)->orderBy('id', 'DESC')->first();
                    $link = url("loginPC") . "/" . $msisdn . "/" . $bin->bin;
                    $request->session()->flash('link', $link);
                    $request->session()->flash('shortCode', $shortCode);
                } else {
                    $request->session()->flash('failed', "جدث خطأ");
                }

                return redirect('landing');
            } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
                $request->session()->flash('failed', "يجب الانتظار دقيقتين");
                return back();
            } else {
                $request->session()->flash('failed', $result->errorMessage);
                return back();
            }
        } else {
            $request->session()->flash('success_pincode', 'تم ارسال رقم التاكيد رجاء ادخاله');
            // insert here in our database
            $msisdn = new Msisdn();
            $msisdn->phone_number = $phone_number;
            $msisdn->status = 'inactive';
            $msisdn->operatorCode = $operatorCode;
            $msisdn->save();
            $Msisdn = Msisdn::find($msisdn->id);

            //  session(['phone_number' => $Msisdn->phone_number]);
            session(['contract_id' => $result->subscriptionContractId]);
            $Msisdn->contract_id = $result->subscriptionContractId;
            $Msisdn->save();

            return redirect('landing');
        }
    }


    public function get_content_post($URL, $param)
    {

        $content = json_encode($param);

        //   print_r($content); die;

        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
