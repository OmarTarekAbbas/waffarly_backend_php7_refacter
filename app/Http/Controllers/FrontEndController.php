<?php

namespace App\Http\Controllers;

use App\Bin;
use App\Brand;
use App\Category;
use App\DuIntgration;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Controller;
use App\Msisdn;
use App\Post;
use App\Product;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// require_once 'soup_api/nusoap/lib/nusoap.php' ;

class FrontEndController extends Controller
{

    public $front_view = "front_end.";
    // --------------Live -----------------//
    private $privateKey = "6g8UUH6mlUilXpOSssp8";
    private $publicKey = "fhCP5KoWwDET9G9N9odF";
    private $subscriptionPlanId = 514;
    private $service_name = "yallawaffar";
    public $customerAccountNumber = "customer159635721";
    private $status = "live";

    public function index(Request $request)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $products = $this->join_all_table($request)->get();
        if ($request->has('OpID')) {
            $featured = $this->join_all_table($request)->orderBy('posts.updated_at', 'DESC')->take(3)->get();
        } else {
            $featured = $this->join_all_table($request)->orderBy('products.updated_at', 'DESC')->take(3)->get();
        }
        return view('front_end.home', compact('products', 'featured', 'request', 'brands', 'categories'));
    }

    public function get_brand_products(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $products = $this->join_all_table($request)->where('brand_id', $id)->paginate(10);
        if ($request->ajax()) {
            if (count($products) > 0) {
                $html = view('front_end.brand_load', compact('products'))->render();
            } else {
                $html = "";
            }
            return Response(array('html' => $html));
        }

        return view('front_end.brand', compact('products', 'brand', 'request'));
    }

    public function get_product(Request $request, $id)
    {
        $product = $this->join_all_table($request)->where('products.id', $id)->first();
        if (request()->get('OpID') == Etisalat_Bundle_Route) {
            if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {
                return view('front_end.product', compact('product'));
            } else {
                $URL = $request->fullUrl();
                Session::put('RUrl',$URL);
                return redirect(url(Etisalat_Bundle_Route . '/login_web'));
            }
        } else {
            return view('front_end.product', compact('product'));
        }
    }

    public function products_by_category(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $products = $this->join_all_table($request)->where('category_id', $id)->paginate(10);
        if ($request->ajax()) {
            if (count($products) > 0) {
                $html = view('front_end.category_load', compact('products'))->render();
            } else {
                $html = "";
            }
            return Response(array('html' => $html));
        }
        return view('front_end.category', compact('products', 'request'));

    }

    public function search_view(Request $request)
    {
        $results = array();
        return view('front_end.search', compact('results', 'request'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $products = $this->join_all_table($request)->where('categories.title', 'LIKE', '%' . $keyword . '%')->get();
        $brands = $this->join_all_table($request)->where('brand_name', 'LIKE', '%' . $keyword . '%')->get();
        $pr = $this->join_all_table($request)->where('products.title', 'LIKE', '%' . $keyword . '%')->get();
        if (count($pr) > 0) {
            return $pr;
        }

        if (count($brands) > 0) {
            return $brands;
        }

        if (count($products) > 0) {
            return $products;
        }

        // return $results;
    }

    public function terms(Request $request)
    {
        return view('front_end.terms');
    }

    public function join_all_table(Request $request)
    {
        if ($request->has('OpID')) {
            $products = Post::select('posts.*', 'brands.*', 'categories.*', 'products.*', 'brands.image AS image_brand', 'categories.image AS image_category', 'products.id AS id', 'posts.id AS post_id', 'brands.id AS brand_id', 'categories.id AS category_id', 'categories.title AS category_name')
                ->join('operators', 'posts.operator_id', '=', 'operators.id')
                ->join('products', 'posts.product_id', '=', 'products.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('posts.active', '=', 1)
                ->where('products.active', '=', 1)
                ->where('posts.published_date', '<=', Carbon::now()->format('Y-m-d'))
                ->where('products.expire_date', '>=', Carbon::now()->format('Y-m-d'))
                ->where('posts.operator_id', '=', $request->OpID);
        } else {
            $products = Product::select('brands.*', 'categories.*', 'products.*', 'brands.image AS image_brand', 'categories.image AS image_category', 'products.id AS id', 'brands.id AS brand_id', 'categories.id AS category_id', 'categories.title AS category_name')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('products.featured', '=', 1)
                ->where('products.active', '=', 1)
                ->where('products.show_date', '<=', Carbon::now()->format('Y-m-d'))
                ->where('products.expire_date', '>=', Carbon::now()->format('Y-m-d'));

        }
        return $products;
    }

    public function login(Request $request)
    {
        if (Session::has('phone_number') && Session::has('status') && Session::get('status') == "active") {
            return redirect('/');
        }

        if (isset($_GET['operator_id']) && !empty($_GET['operator_id'])) {
            $operator_id = $_GET['operator_id'];
        }

        return view('front_end.login', compact('operator_id', 'request'));
    }

    public function postLogin(Request $request)
    {
        $phone_number = $request->MSISDN;
        if (isset($phone_number[0]) && $phone_number[0] != '0') {
            $phone_number = '0' . $phone_number;
        }
        if (!preg_match('/^01[0-9]{9}$/', $phone_number)) {
            $request->session()->flash('failed', 'هذا الرقم غير صحيح');
            return back();
        }

        $msisdn = Msisdn::where('phone_number', $phone_number)->first();
        if ($msisdn && $msisdn->status == 'active') {
            session(['phone_number' => $phone_number, 'status' => 'active']);
            //    $currentCountry = $this->ip_info("Visitor", "Country");  // Kuwait
            return redirect('/?operator_id=7');
            /*
            if($currentCountry == "Kuwait"){
            return redirect('/?operator_id=7');
            }else{
            return redirect('/');
            }
             */

            return redirect('/?operator_id=7');
        } elseif ($msisdn && $msisdn->status == "inactive") {
            $request->session()->flash('failed', 'تم تسجيل هذا الرقم من قبل لكن لم يتم تأكيده رجاء ادخال الرقم المكون من خمس ارقام الذى تم ارساله لك من قبل ');
            return redirect('/confirm');
        } else {
            $request->session()->flash('failed', 'هذا رقم غير مسجل في الخدمة');
            return redirect('/register');
        }
    }

    public function ip_info($ip = null, $purpose = "location", $deep_detect = true)
    {
        $output = null;
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }

                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }

            }
        }
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), null, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America",
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
                            "continent_code" => @$ipdat->geoplugin_continentCode,
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1) {
                            $address[] = $ipdat->geoplugin_regionName;
                        }

                        if (@strlen($ipdat->geoplugin_city) >= 1) {
                            $address[] = $ipdat->geoplugin_city;
                        }

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

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function register(Request $request)
    {

        Session::forget('contract_id'); // to remove any contract_id from session

        if (isset($_GET['operator_id']) && !empty($_GET['operator_id'])) {
            $operator_id = $_GET['operator_id'];
        }

        return view('front_end.signup', compact('operator_id', 'request'));
    }

    public function postRegister(Request $request)
    {
        date_default_timezone_set('Africa/Cairo');
        $phone_number = $request->MSISDN;
        if (isset($phone_number[0]) && $phone_number[0] != '0') {
            $phone_number = '0' . $phone_number;
        }
        if (!preg_match('/^01[0-9]{9}$/', $phone_number)) {
            $request->session()->flash('failed', 'هذا الرقم غير صحيح');
            return back();
        }

        $msisdn = Msisdn::where('phone_number', $phone_number)->first();
        if ($msisdn && $msisdn->status == 'active') {
            $request->session()->flash('failed', 'تم تسجيل هذا الرقم من قبل رجاء تسجيل الدخول');
            return back();
        } elseif ($msisdn && $msisdn->status == "inactive") {

            $request->session()->flash('failed', 'تم تسجيل هذا الرقم من قبل لكن لم يتم تأكيده رجاء ادخال الرقم المكون من خمس ارقام الذى تم ارساله لك من قبل ');
            return back();
        } elseif (!$msisdn) {
            $msisdn = new Msisdn();
            $msisdn->phone_number = $phone_number;
            $msisdn->status = 'inactive';
            $msisdn->save();
        }

        while (true) {
            $bin_code = rand(pow(10, 4), pow(10, 5) - 1);
            if (Bin::where('bin', '=', $bin_code)->get()->isEmpty()) { //to make not reapeated bin with 5 digits
                break;
            }
        }

        $bin_ = new Bin();
        $bin_->bin = $bin_code;
        $bin_->end_time = Carbon::now('Africa/Cairo')->addHours(1);
        $msisdn->bins()->save($bin_);

        //   $message = 'كود التفعيل  ' . $bin_code;
        $message = $bin_code;
        $URL = DEV_SMS_SEND_MESSAGE;
        $param = "phone_number=" . $phone_number . "&message=" . $message;
        $result = $this->content_post($URL, $param);
        $request->session()->flash('success', 'تم ارسال رقم مكون من خمس ارقام الى رقم التليفون الذى ادخلته رجاء ادخال الخمس ارقام حتى يتم تاكيد رقم التليفون ');

        if ($result == "1") {
            session(['register_phone' => $phone_number]);
            $request->session()->flash('success', 'تم ارسال رقم مكون من خمس ارقام الى رقم التليفون الذى ادخلته رجاء ادخال الخمس ارقام حتى يتم تاكيد رقم التليفون ');
            return redirect('confirm');
        }
    }

    public function pinValidation(Request $request)
    {

        $bin = Bin::where('bin', '=', $request->PIN)->first();
        if ($bin) {
            $end_date = new Carbon($bin->end_time, 'Africa/Cairo');
            $created_at = new Carbon($bin->created_at, 'Africa/Cairo');
            $msisdn = $bin->msisdn;
            if (!Carbon::now('Africa/Cairo')->between($created_at, $end_date)) {
                // return $bin;
                $request->session()->flash('failed', 'لقد انتهت صلاحية هذا الرقم وتم ارسال رقم اخر الى تليفونك');
                // delete all bins for that msisdn
                $bins = $msisdn->bins;
                foreach ($bins as $bin) {
                    $bin->delete();
                }

                while (true) {
                    $bin_code = rand(pow(10, 4), pow(10, 5) - 1);
                    if (Bin::where('bin', '=', $bin_code)->get()->isEmpty()) {
                        break;
                    }
                }
                $bin_ = new Bin();
                $bin_->bin = $bin_code;
                $bin_->end_time = Carbon::now('Africa/Cairo')->addHours(1);
                $msisdn->bins()->save($bin_);
                //  $message = "رجاء ادخال هذا الرقم" . $bin_->bin . " حتى تتم عملية الاشتراك";
                $message = $bin_->bin;
                $URL = DEV_SMS_SEND_MESSAGE;
                $param = "phone_number=" . $bin->msisdn->phone_number . "&message=" . $message;
                $result = $this->content_post($URL, $param);

                return back();
            } else {
                $msisdn->status = "active";
                $msisdn->save();
                $request->session()->flash('success', 'تم تأكيد الرقم بنجاح ');
                session(['phone_number' => $bin->msisdn->phone_number, 'status' => 'active']);
                return redirect('/');
            }
        } else {
            $request->session()->flash('failed', 'الرقم الذى ارسلته غير صحيح الرجاء محاولة ادخال الرقم مره اخري ');
            return back();
        }
        return back();
    }

    public function content_post($URL, $param)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function init()
    {
        $settings = array();
        $api = new CategoryController();
        $settings[0] = Setting::where('key', 'LIKE', '%website title%')->first();
        $settings[1] = Setting::where('key', 'LIKE', '%logo%')->first();
        $settings[2] = Setting::where('key', 'LIKE', '%facebook%')->first();
        $settings[3] = Setting::where('key', 'LIKE', '%twitter%')->first();
        return [$api, $settings];
    }

    public function standards(Request $request)
    {
        $api = $this->init()[0];
        $obj = $api->get_all_categories_with_latest($request);
        return $obj;
    }

    //====================== TPAY Integration ============================================//

    public function post_contract_request(Request $request)
    {

        $client = new \SoapClient("http://$this->status.tpay.me/api/TPaySubscription.svc?singleWsdl", array('trace' => true, "exceptions" => 0));
        //   $client = new \nusoap_client(url('soup_api/TPAY.wsdl'),true);
        $client->soap_defencoding = 'UTF-8';
        //   $todayDate = gmdate("Y-m-d H:i:s\Z") ;
        $todayDate = "2017-12-20 20:30:41Z";
        //$todayDate = date('Y-m-d H:i:s\Z',strtotime($todayDate." +2 hours"));

        $customerAccountNumber = "customer159635721";
        $msisdn = $request['msisdn'];
        $operatorCode = $request['operator_code'];
        $subscriptionPlanId = 60604; // for orange
        $initialPaymentproductId = "yallawaffar";
        $initialPaymentDate = $todayDate;
        $executeInitialPaymentNow = 'false';
        $recurringPaymentproductId = "yallawaffar";
        $productCatalogName = "yallawaffar";
        $executeRecurringPaymentNow = 'false';
        $contractStartDate = $todayDate;
        //  $tommorrowDate = date('Y-m-d H:i:s\Z',strtotime($todayDate." +3 day")) ;
        $tommorrowDate = "2017-12-21 21:30:41Z";
        $contractEndDate = $tommorrowDate;
        $autoRenewContract = 'true';
        $language = 2;
        $sendVerificationSMS = 'true';
        $allowMultipleFreeStartPeriods = "false";
        $headerEnrichmentReferenceCode = "";
        $smsId = "";

        $message = $customerAccountNumber . $msisdn . $operatorCode . $subscriptionPlanId . $initialPaymentproductId .
            $initialPaymentDate . $executeInitialPaymentNow . $recurringPaymentproductId .
            $productCatalogName . $executeRecurringPaymentNow . $contractStartDate .
            $contractEndDate . $autoRenewContract .
            $language . $sendVerificationSMS . $allowMultipleFreeStartPeriods . $headerEnrichmentReferenceCode . $smsId;

        echo $message;
        echo "<br>";

        $privateKey = "YSSd8msGWd0XTpZ94KZN";
        $signature = "GCLOGWWB3FgsDKA11Dwc:" . hash_hmac('sha256', $message, $privateKey);

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
            "smsId" => "",
        );
    }

    public function tpay_subscribe_json(Request $request)
    {

        $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/AddSubscriptionContractRequest";

        $startDate = gmdate("Y-m-d H:i:s\Z");
        $startDate = date('Y-m-d H:i:s\Z', strtotime($startDate . " +1 hour")); // only in local
        $endDate = date('Y-m-d H:i:s\Z', strtotime($startDate . " +1 year"));

        $msisdn = preg_replace('/^2/', '', $_REQUEST['msisdn']);

        $customerAccountNumber = $this->customerAccountNumber; // can by anything
        $msisdn = $msisdn;
        $operatorCode = $_REQUEST['operatorCode'];
        $subscriptionPlanId = $this->subscriptionPlanId; // catlog plan id
        $initialPaymentproductId = $this->service_name; // product name
        $initialPaymentDate = $startDate;
        $executeInitialPaymentNow = "false";
        $recurringPaymentproductId = $this->service_name;
        $productCatalogName = $this->service_name; // catlog name
        $executeRecurringPaymentNow = "false";
        $contractStartDate = $startDate;
        $contractEndDate = $endDate;
        $autoRenewContract = "true";
        $language = 2;
        $sendVerificationSMS = "true";
        $allowMultipleFreeStartPeriods = "false";
        if (isset($request['refNo'])) {
            $refNo = $request['refNo'];
        } else {
            $refNo = "";
        }

        $headerEnrichmentReferenceCode = $refNo;
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
            "headerEnrichmentReferenceCode" => $headerEnrichmentReferenceCode,
            "smsId" => "",
        );

        $result_json = $this->get_content_post($URL, $parameters_arr);

        $result = json_decode($result_json);

        // create a log channel
        $actionName = "AddSubscriptionContractRequest_HE";
        $this->log($actionName, $URL, $parameters_arr); // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr); // log out

        $response = array();

        if ($result->operationStatusCode == 51) {

            // return back();
            if ($result->errorMessage == "This user already subscribed to the given product") {

                $shortCode = $this->shortCode("60201"); // HE default is orange
                // already subscribe message
                //    لديك اشتراك مفعل فى خدمة استقيموا من IVAS بقيمة 2 جنيها يوميا  للوصول الى الخدمة قم بزيارة URL لإلغاء الاشتراك ارسل stop EST الى Short code
                $messageBody = "لديك اشتراك مفعل فى خدمة يلا وفر من IVAS بقيمة 2 جنيها يوميا للوصول الى الخدمة قم بزيارة ";
                $messageBody .= url("");
                $messageBody .= "    تكلفة الخدمة 2 جنيها يوميا ";
                $messageBody .= " لإلغاء الاشتراك ارسل stop waffar الى ";
                $messageBody .= $shortCode;
                $messageBody .= "  مجانا  ";

                $response['message'] = $messageBody;
                $response['val'] = 1;
            } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
                $response['message'] = "يجب الانتظار دقيقتين";
                $response['val'] = 2;
            } else {
                $response['message'] = $result->errorMessage;
                $response['val'] = 3;
            }
        } else {

            $response['message'] = "تم الاشتراك بنجاح";
            $response['val'] = 4;
            $response['subscriptionContractId'] = $result->subscriptionContractId;

            // insert here in our database
            $Msisdn = new Msisdn();
            $Msisdn->phone_number = $msisdn;
            $Msisdn->status = 'active';
            $Msisdn->operatorCode = $operatorCode;
            $Msisdn->contract_id = $result->subscriptionContractId;
            $Msisdn->subscribe_type = "HE";
            $Msisdn->save();
            session(['phone_number' => $msisdn, 'status' => 'active']);

            $shortCode = $this->shortCode($Msisdn->operatorCode);

            // send welcome message to end user
            $messageBody = "شكراَ لإشتراكك فى خدمة يلا وفر ";
            $messageBody .= "يمكنك الوصول الى حسابك و الإستمتاع بالخدمة من خلال زيارة موقعنا  ";
            $messageBody .= "  " . url("/");
            $messageBody .= " سوف يتم خصم 2 جنيها يوميا ";
            $messageBody .= "  لكى تتمكن من إلغاء الإشتراك الخاص بكم الرجاء تسجيل الدخول على الحساب الخاص بك و الضغط على إلغاء الإشتراك أو أرسل كلمة  ";
            $messageBody .= "  stop waffar  ";
            $messageBody .= "  الي  ";
            $messageBody .= $shortCode;
            $messageBody .= "  مجانا  ";
            $messageBody .= " لاى استفسار تواصل معنا على  ";
            $messageBody .= "support@yallawaffar.com";

            $Msisdn = "2" . $Msisdn->phone_number;
            $this->SendFreeMTMessage($messageBody, $Msisdn, $operatorCode);
        }

        $response = json_encode($response);
        return $response;
    }

    public function tpay_subscribe_json_old(Request $request)
    {

        $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/AddSubscriptionContractRequest";
        $startDate = gmdate("Y-m-d H:i:s\Z");
        $startDate = date('Y-m-d H:i:s\Z', strtotime($startDate . " +1 hour")); // only in local
        $endDate = date('Y-m-d H:i:s\Z', strtotime($startDate . " +1 day"));
        $endDate = date('Y-m-d H:i:s\Z', strtotime($endDate . " +2 hour")); // in local + 2 but ib server + 1

        $msisdn = preg_replace('/^2/', '', $_REQUEST['msisdn']);

        $customerAccountNumber = "customer159635721";
        $msisdn = $msisdn;
        $operatorCode = $_REQUEST['operatorCode'];
        $subscriptionPlanId = 60604;
        $initialPaymentproductId = "yallawaffar";
        $initialPaymentDate = $startDate;
        $executeInitialPaymentNow = "false";
        $recurringPaymentproductId = "yallawaffar";
        $productCatalogName = "yallawaffar";
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

        $privateKey = "YSSd8msGWd0XTpZ94KZN";
        $signature = "GCLOGWWB3FgsDKA11Dwc:" . hash_hmac('sha256', $message, $privateKey);

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
            "smsId" => "",
        );

        $result_json = $this->get_content_post($URL, $parameters_arr);

        $result = json_decode($result_json);

        // print_r($result_json) ;
        //  print_r($result) ;
        // create a log channel
        $actionName = "AddSubscriptionContractRequest_HE";
        $this->log($actionName, $URL, $parameters_arr); // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr); // log out

        $response = array();
        if ($result->operationStatusCode == 51) {

            // return back();
            if ($result->errorMessage == "This user already subscribed to the given product") {
                $response['message'] = "انت مشترك بالفعل";
                $response['val'] = 1;
            } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
                $response['message'] = "يجب الانتظار دقيقتين";
                $response['val'] = 2;
            } else {
                $response['message'] = $result->errorMessage;
                $response['val'] = 3;
            }
        } else {

            $response['message'] = "تم ارسال رقم التاكيد الى رقم التليفون الذى ادخلته رجاء ادخاله حتى يتم تاكيد رقم التليفون";
            $response['val'] = 4;
            $response['subscriptionContractId'] = $result->subscriptionContractId;

            // insert here in our database
            $Msisdn = new Msisdn();
            $Msisdn->phone_number = $msisdn;
            $Msisdn->status = 'inactive';
            $Msisdn->operatorCode = $operatorCode;
            $Msisdn->contract_id = $result->subscriptionContractId;
            $Msisdn->save();
            session(['contract_id' => $result->subscriptionContractId]);
        }

        $response = json_encode($response);
        // print_r($response) ; die;
        return $response;
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

        if (preg_match('/^2[0-9]{11}$/', $phone_number)) { // mean this number is leading with 2   for egypt operators => so we remove 2
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
            return redirect('landing'); // old confirm
        } elseif ($msisdn && $msisdn->status == "inactive") {
            $request->session()->flash('success_pincode', 'تم تسجيل هذا الرقم من قبل لكن لم يتم تأكيده رجاء ادخال كود التفعيل ');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('landing'); // old confirm
        } elseif ($msisdn && $msisdn->status == "pending") {
            $request->session()->flash('failed', 'رقمك موقوف');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('landing'); // old confirm
        } elseif ($msisdn && $msisdn->status == "under_processing") {
            $request->session()->flash('failed', 'طلبك تحت المعالجة ');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('landing'); // old confirm
        } elseif ($msisdn && $msisdn->status == "error") {
            $request->session()->flash('failed', 'جدث خطأ');
            session(['contract_id' => $msisdn->contract_id]);
            return redirect('landing'); // old confirm
        }

        $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/AddSubscriptionContractRequest";
        $startDate = gmdate("Y-m-d H:i:s\Z");
        $startDate = date('Y-m-d H:i:s\Z', strtotime($startDate . " +1 hour")); // only in local
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
            "smsId" => "",
        );

        $result_json = $this->get_content_post($URL, $parameters_arr);

        // print_r($result_json); die;

        $result = json_decode($result_json);

        // create a log channel
        $actionName = "AddSubscriptionContractRequest";
        $this->log($actionName, $URL, $parameters_arr); // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr); // log out

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

    public function login_contract_id(Request $request)
    {
        $contract_id = $request['contract_id'];
        $msisdn = Msisdn::where('contract_id', $contract_id)->orderBy('id', 'DESC')->first();
        if ($msisdn && $msisdn->status == 'active') {
            session(['phone_number' => $msisdn->phone_number, 'status' => 'active']);

            // create a log channel
            $URL = $request->fullUrl();
            $actionName = "HE login";
            $parameters_arr = array(
                "phone_number" => $msisdn->phone_number,
            );

            // log
            $this->log($actionName, $URL, $parameters_arr); // log in

            return response()->json(["result" => true]);
        } else {
            return response()->json(["result" => false]);
        }
    }

    public function loginPinCode(Request $request, $phone, $pincode)
    {
        if ($phone && $pincode) {
            $phone_number = $phone;
            $msisdn = Msisdn::where('phone_number', $phone_number)->orderBy('id', 'DESC')->first();
            $operatorCode = $msisdn->operatorCode;

            // make validation for egypt numbers that start with 2
            if (!preg_match('/^([0-9]{1})?[0-9]{11}$/', $phone_number)) {
                $request->session()->flash('failed', 'هذا الرقم غير صحيح');
                return back();
            }

            if (preg_match('/^2[0-9]{11}$/', $phone_number)) { // mean this number is leading with 2   for egypt operators => so we remove 2
                $phone_number = ltrim($phone_number, '2');
            }

            $msisdn = Msisdn::where('phone_number', $phone_number)->orderBy('id', 'DESC')->first();
            if ($msisdn && $msisdn->status == 'active') {

                $bin = Bin::where('msisdn_id', $msisdn->id)->orderBy('id', 'DESC')->first();
                if ($bin) {
                    if ($bin->bin == $pincode) {
                        session(['phone_number' => $phone_number, 'status' => 'active']);
                        return redirect('/');
                    } else {
                        // send welcome message to end user
                        $messageBody = url("loginPC") . "/" . $msisdn->phone_number . "/" . $bin->bin;
                        $Msisdn = "2" . $msisdn->phone_number;
                        $operatorCode = $msisdn->operatorCode;
                        $this->SendFreeMTMessage($messageBody, $Msisdn, $operatorCode);

                        $message = "تم ارسال الينك الخاص بالدخول وهو ";
                        $message .= url("loginPC") . "/" . $msisdn->phone_number . "/" . $bin->bin;

                        $request->session()->flash('success', $message);
                        return redirect('/landing');
                    }
                } else {

                    $request->session()->flash('failed', 'هذا رقم غير مسجل في الخدمة');
                    return redirect('/register');
                }
            } else if ($msisdn && $msisdn->status == 'under_processing') {
                $request->session()->flash('failed', 'طلبك تحت المعالجة');
                return redirect('/landing');
            } else if ($msisdn && $msisdn->status == 'pending') {
                $request->session()->flash('failed', 'رقمك موقوف');
                return redirect('/landing');
            } else if ($msisdn && $msisdn->status == 'error') {
                $request->session()->flash('failed', 'حدث خطأ');
                return redirect('/landing');
            } else {
                $request->session()->flash('failed', 'هذا رقم غير مسجل في الخدمة');
                return redirect('/landing');
            }
        } else {
            $view = "error";
            return view($this->front_view . $view);
        }
    }

    public function shortCode($contractId)
    {
        $shortCode = "";
        switch ($contractId) {
            case "60201":
                $shortCode = 5030;
                break;
            case "60202":
                $shortCode = 6699;
                break;
            case "60203":
                $shortCode = 1722;
                break;
            default:
                $shortCode = 5030;
        }

        return $shortCode;
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

    public function confirm(Request $request)
    {

        if (isset($_GET['operator_id']) && !empty($_GET['operator_id'])) {
            $operator_id = $_GET['operator_id'];
        }

        return view('front_end.confirm', compact('operator_id', 'request'));
    }

    public function tpay_subscribe_verify_pincode(Request $request)
    {

        $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/VerifySubscriptionContract";

        // $subscriptionContractId= $_REQUEST['subscriptionContractId'];
        $subscriptionContractId = Session::get('contract_id');
        $pinCode = $_REQUEST['pinCode'];
        $message = $subscriptionContractId . $pinCode;
        $privateKey = $this->privateKey;
        $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

        $parameters_arr = array(
            "signature" => $signature,
            "subscriptionContractId" => $subscriptionContractId,
            "pinCode" => $pinCode,
        );
        $result_json = $this->get_content_post($URL, $parameters_arr);
        $result = json_decode($result_json);

        // create a log channel
        $actionName = "VerifySubscriptionContract";
        $this->log($actionName, $URL, $parameters_arr); // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr); // log out

        if ($result->operationStatusCode == 0 && $result->subscriptionContractId != 0) { // success
            // update msisdn status
            $Msisdn = Msisdn::where('contract_id', Session::get('contract_id'))->orderBy('id', 'desc')->first();
            $operatorCode = $Msisdn->operatorCode;
            $Msisdn->status = "active";
            $Msisdn->save();

            // create bin for this msisdn
            $bin = new Bin();
            $bin->msisdn_id = $Msisdn->id;
            $bin->bin = $pinCode;
            $bin->save();

            session(['contract_id' => $result->subscriptionContractId, 'phone_number' => $Msisdn->phone_number, 'status' => 'active']);

            $shortCode = $this->shortCode($Msisdn->operatorCode);
            // send welcome message to end user
            $messageBody = "شكراَ لإشتراكك فى خدمة يلا وفر ";
            $messageBody .= "يمكنك الوصول الى حسابك و الإستمتاع بالخدمة من خلال زيارة موقعنا  ";
            $messageBody .= url("loginPC") . "/" . $Msisdn->phone_number . "/" . $bin->bin;
            $messageBody .= " سوف يتم خصم 2 جنيها يوميا ";
            $messageBody .= "  لكى تتمكن من إلغاء الإشتراك الخاص بكم الرجاء تسجيل الدخول على الحساب الخاص بك و الضغط على إلغاء الإشتراك أو أرسل كلمة  ";
            $messageBody .= "  stop waffar  ";
            $messageBody .= "  الي  ";
            $messageBody .= $shortCode;
            $messageBody .= "  مجانا  ";
            $messageBody .= " لاى استفسار تواصل معنا على  ";
            $messageBody .= "support@yallawaffar.com";

            $phone = "2" . $Msisdn->phone_number;
            $this->SendFreeMTMessage($messageBody, $phone, $operatorCode);

            $link = url("loginPC") . "/" . $Msisdn->phone_number . "/" . $bin->bin;
            $request->session()->flash('link', $link);
            $request->session()->flash('msisdn_subscribe_before', $Msisdn->phone_number);
            $request->session()->flash('contract_id', $Msisdn->contract_id);
            $request->session()->flash('success_new_user', "success");
            $request->session()->flash('shortCode', $shortCode);
            return redirect('/landing');
        } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
            $request->session()->flash('failed', "يجب الانتظار دقيقتين");
            return back();
        } elseif ($result->errorMessage == "Subscription Contract Is Already Verified") {
            $request->session()->flash('failed', "تم تأكيد هذا الرقم سابقا");
            return back();
        } elseif ($result->errorMessage == "Invalid Pincode") {
            $request->session()->flash('success_pincode', "رقم التاكيد خطأ حاول مرة أخري");
            return back();
        } else {
            $request->session()->flash('failed', $result->errorMessage);
            return back();
        }
    }

    public function ResendVerifySubscriptionContract(Request $request)
    { // resend verification pincode for susbcribe
        if (Session::has('contract_id')) {
            $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/SendSubscriptionContractVerificationSMS";
            $subscriptionContractId = Session::get('contract_id');

            $message = $subscriptionContractId;

            $privateKey = $this->privateKey;
            $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

            $parameters_arr = array(
                "signature" => $signature,
                "subscriptionContractId" => $subscriptionContractId,
            );

            $result_json = $this->get_content_post($URL, $parameters_arr); // here is json
            $result = json_decode($result_json); // here is objects
            // create a log channel
            $actionName = "ResendVerifySubscriptionContract";
            $this->log($actionName, $URL, $parameters_arr); // log in
            $result_arr = (array) $result; // here is array
            $this->log($actionName, $URL, $result_arr); // log out

            if ($result->operationStatusCode == 51) {

                // return back();
                if ($result->errorMessage == "This user already subscribed to the given product") {
                    $request->session()->flash('failed', "انت مشترك بالفعل");
                    return redirect('landing'); // login
                } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
                    $request->session()->flash('failed', "يجب الانتظار دقيقتين");
                    return back();
                } else {
                    $request->session()->flash('failed', $result->errorMessage);
                    return back();
                }
            } else {
                $request->session()->flash('success_pincode', 'تم ارسال كود التأكيد مرة أخري');
                //  session(['phone_number' => $Msisdn->phone_number]);
                session(['contract_id' => $result->subscriptionContractId]);
                return redirect('landing'); //  confirm
            }
        } else {

            return redirect('landing');
        }
    }

    public function unsub(Request $request)
    {
        $operator_id = "";
        Session::forget('contract_id'); // to remove any contract_id from session
        Session::forget('phone_number'); // to remove any contract_id from session

        if (isset($_GET['operator_id']) && !empty($_GET['operator_id'])) {
            $operator_id = $_GET['operator_id'];
        }

        return view('front_end.unsub', compact('operator_id', 'request'));
    }

    public function SendSubscriptionCancellationPinSMS(Request $request)
    {

        $phone_number = $request['MSISDN'];

        if (preg_match('/^2[0-9]{11}$/', $phone_number)) { // mean this number is leading with 2   for egypt operators => so we remove 2
            $phone_number = ltrim($phone_number, '2');
        }

        $msisdn = Msisdn::where('phone_number', $phone_number)->orderBy('id', 'DESC')->first();
        if ($msisdn) {
            $subscriptionContractId = $msisdn->contract_id;
        } else {

            $request->session()->flash('failed', "هذا الرقم غير مسجل بالخدمة");
            return back();
        }

        $operatorCode = $msisdn->operatorCode;

        $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/SendSubscriptionCancellationPinSMS";

        // $subscriptionContractId= $_REQUEST['subscriptionContractId'];
        $phone_number = $_REQUEST['MSISDN'];
        session(['phone_number' => $phone_number]);

        $message = $subscriptionContractId;
        $privateKey = $this->privateKey;
        $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

        $parameters_arr = array(
            "signature" => $signature,
            "subscriptionContractId" => $subscriptionContractId,
        );

        $result_json = $this->get_content_post($URL, $parameters_arr);
        $result = json_decode($result_json);
        // create a log channel
        $actionName = "SendSubscriptionCancellationPinSMS";
        $this->log($actionName, $URL, $parameters_arr); // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr); // log out

        if ($result->operationStatusCode == 0 && $result->subscriptionContractId != 0) { // success
            session(['contract_id' => $result->subscriptionContractId]);
            $request->session()->flash('success', 'تم ارسال الكود لالغاء الاشتراك');
            return redirect('/unsub_confirm');
        } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
            $request->session()->flash('failed', "يجب الانتظار دقيقتين");
            return back();
        } else {
            $request->session()->flash('failed', "$result->errorMessage");
            return back();
        }
    }

    public function SendSubscriptionCancellationPinSMSResend(Request $request)
    {

        if (Session::has('phone_number')) {
            $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/SendSubscriptionCancellationPinSMS";

            // $subscriptionContractId= $_REQUEST['subscriptionContractId'];
            $phone_number = Session::get('phone_number');

            $Msisdn = Msisdn::where(['phone_number' => $phone_number, 'status' => 'active'])->first();
            if ($Msisdn) {
                $subscriptionContractId = $Msisdn->contract_id;
            } else {

                $request->session()->flash('failed', "هذا الرقم غير مسجل بالخدمة");
                return back();
            }

            $message = $subscriptionContractId;

            $privateKey = $this->privateKey;
            $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

            $parameters_arr = array(
                "signature" => $signature,
                "subscriptionContractId" => $subscriptionContractId,
            );

            $result_json = $this->get_content_post($URL, $parameters_arr);
            $result = json_decode($result_json);
            // create a log channel
            $actionName = "SendSubscriptionCancellationPinSMS";
            $this->log($actionName, $URL, $parameters_arr); // log in
            $result_arr = (array) $result;
            $this->log($actionName, $URL, $result_arr); // log out

            if ($result->operationStatusCode == 0 && $result->subscriptionContractId != 0) { // success
                session(['contract_id' => $result->subscriptionContractId]);
                $request->session()->flash('success', 'تم ارسال الكود مرة اخري لالغاء الاشتراك');
                return redirect('/unsub_confirm');
            } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
                $request->session()->flash('failed', "يجب الانتظار دقيقتين");
                return back();
            } else {
                $request->session()->flash('failed', $result->errorMessage);
                return back();
            }
        } else {
            return redirect('/unsub');
        }
    }

    public function unsub_confirm(Request $request)
    {

        if (isset($_GET['operator_id']) && !empty($_GET['operator_id'])) {
            $operator_id = $_GET['operator_id'];
        }

        return view('front_end.unsub_confirm', compact('operator_id', 'request'));
    }

    public function VerifySubscriptionCancellationPin(Request $request)
    {

        $URL = "http://$this->status.tpay.me/api/TPaySubscription.svc/json/VerifySubscriptionCancellationPin";

        // $subscriptionContractId= $_REQUEST['subscriptionContractId'];
        $subscriptionContractId = Session::get('contract_id');
        $pinCode = $_REQUEST['pinCode'];

        $message = $subscriptionContractId . $pinCode;

        $privateKey = $this->privateKey;
        $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

        $parameters_arr = array(
            "signature" => $signature,
            "subscriptionContractId" => $subscriptionContractId,
            "pinCode" => $pinCode,
        );

        $result_json = $this->get_content_post($URL, $parameters_arr);
        $result = json_decode($result_json);
        // create a log channel
        $actionName = "VerifySubscriptionCancellationPin";
        $this->log($actionName, $URL, $parameters_arr); // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr); // log out

        if ($result->operationStatusCode == 0 && $result->subscriptionContractId != 0) { // success
            $request->session()->flash('success', 'تم الغاء الاشتراك بنجاح');
            // update msisdn status
            $Msisdn = Msisdn::where('contract_id', $subscriptionContractId)->orderBy('id', 'DESC')->first();
            $Msisdn->status = "unsub";
            $Msisdn->save();

            Session::forget('contract_id'); // to remove any contract_id from session
            Session::forget(''); // to remove any contract_id from session
            // create bin for this msisdn
            $bin = new Bin();
            $bin->msisdn_id = $Msisdn->id;
            $bin->bin = $pinCode;
            $bin->save();

            return redirect('/landing');
        } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
            $request->session()->flash('failed', "يجب الانتظار دقيقتين");
            return back();
        } elseif ($result->errorMessage == "Invalid Pincode") {
            $request->session()->flash('failed', "رقم التاكيد خطأ");
            return back();
        } else {
            $request->session()->flash('failed', $result->errorMessage);
            return back();
        }
    }

    public function directUnsubscribeWithHE(Request $request)
    {

        $response = array();

        $subscriptionContractId = $request['contract_id'];
        $msisdn = Msisdn::where(['contract_id' => $subscriptionContractId, 'status' => 'active'])->orderBy('id', 'DESC')->first();
        if ($msisdn && $msisdn->status == 'active') {
            $URL = "http://$this->status.TPAY.me/api/TPAYSubscription.svc/Json/CancelSubscriptionContractRequest";
            $message = $subscriptionContractId;

            $privateKey = $this->privateKey;
            $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

            $parameters_arr = array(
                "signature" => $signature,
                "subscriptionContractId" => $subscriptionContractId,
            );

            $result_json = $this->get_content_post($URL, $parameters_arr);
            $result = json_decode($result_json);
            // create a log channel
            $actionName = "DirectUnsubscribeWithHE";
            $this->log($actionName, $URL, $parameters_arr); // log in
            $result_arr = (array) $result;
            $this->log($actionName, $URL, $result_arr); // log out

            if ($result->operationStatusCode == 0 && $result->subscriptionContractId != 0) { // success
                $request->session()->flash('success', 'تم الغاء الاشتراك بنجاح');
                // update msisdn status
                $Msisdn = Msisdn::where('contract_id', $subscriptionContractId)->first();
                $Msisdn->status = "unsub";
                $Msisdn->save();

                Session::forget('contract_id'); // to remove any contract_id from session
                Session::forget('phone_number'); // to remove any contract_id from session

                $response['message'] = "تم الغاء الاشتراك بنجاج";
                $response['val'] = 1;
                //  return redirect('/login');
            } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
                $response['message'] = "يجب الانتظار دقيقتين";
                $response['val'] = 2;
            } else {
                $response['message'] = $result->errorMessage;
                $response['val'] = 3;
            }
        }

        $response = json_encode($response);
        return $response;
    }

    public function sendUrlToActiveUser(Request $request, $MSISDN)
    {
        $phone_number = $MSISDN;
        $msisdn = Msisdn::where('phone_number', $phone_number)->orderBy('id', 'DESC')->first();
        if ($msisdn && $msisdn->status == 'active') {

            $bin = Bin::where('msisdn_id', $msisdn->id)->orderBy('id', 'DESC')->first();
            if ($bin) {
                $shortCode = $this->shortCode($msisdn->operatorCode);
                // send welcome message to end user
                $messageBody = "شكراَ لإشتراكك فى خدمة يلا وفر ";
                $messageBody .= "يمكنك الوصول الى حسابك و الإستمتاع بالخدمة من خلال زيارة موقعنا  ";
                $messageBody .= url("loginPC") . "/" . $msisdn->phone_number . "/" . $bin->bin;
                $messageBody .= " سوف يتم خصم 2 جنيها يوميا ";
                $messageBody .= "  لكى تتمكن من إلغاء الإشتراك الخاص بكم الرجاء تسجيل الدخول على الحساب الخاص بك و الضغط على إلغاء الإشتراك أو أرسل كلمة  ";
                $messageBody .= "  stop waffar  ";
                $messageBody .= "  الي  ";
                $messageBody .= $shortCode;
                $messageBody .= "  مجانا  ";
                $messageBody .= " لاى استفسار تواصل معنا على  ";
                $messageBody .= "support@yallawaffar.com";

                $Msisdn = "2" . $msisdn->phone_number;
                $operatorCode = $msisdn->operatorCode;
                $result = $this->SendFreeMTMessage($messageBody, $Msisdn, $operatorCode);
                if ($result == "success") {
                    $login_link = url("loginPC") . "/" . $msisdn->phone_number . "/" . $bin->bin;
                    $request->session()->flash('success', 'تم ارسال الرابط الخاص بالدخول');
                    $request->session()->flash('login_link', $login_link);
                } elseif ($result == "wait") {
                    $request->session()->flash('success', 'يجب الانتظار دقيقتين');
                } else {
                    $request->session()->flash('failed', 'حدث خطأ');
                }

                return redirect('/landing');
            } else {
                $request->session()->flash('failed', 'هذا رقم غير مسجل في الخدمة');
                return redirect('/landing');
            }
        }
    }

    public function SendFreeMTMessage($messageBody, $Msisdn, $operatorCode)
    {

        $URL = "http://$this->status.TPAY.me/api/TPAY.svc/json/SendFreeMTMessage";

        $message = $messageBody . $Msisdn . $operatorCode;

        // islamic setting

        $privateKey = $this->privateKey;
        $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

        $parameters_arr = array(
            "signature" => $signature,
            "messageBody" => $messageBody,
            "msisdn" => $Msisdn,
            "operatorCode" => $operatorCode,
        );

        //  print_r($parameters_arr); die;

        $result_json = $this->get_content_post($URL, $parameters_arr);
        $result = json_decode($result_json);
        // create a log channel
        $actionName = "SendFreeMTMessage";
        $this->log($actionName, $URL, $parameters_arr); // log in
        $result_arr = (array) $result;
        $this->log($actionName, $URL, $result_arr); // log out

        $messageStatus = "";

        if ($result->messageDeliveryStatus == "true") { // success
            $messageStatus = "success";
        } elseif (strpos($result->errorMessage, "wait for 2 minutes before issuing same request") !== false) {
            $messageStatus = "wait";
        } else {
            $messageStatus = "fail";
        }

        return $messageStatus;
    }

    public function HE_set_user_session(Request $request)
    {
        $result = array();
        $contract_id = $request->contract_id;

        $Msisdn = Msisdn::where('contract_id', $contract_id)->first();

        if ($Msisdn) {
            $result['val'] = 1;
            session(['phone_number' => $Msisdn->phone_number, 'status' => 'active']);
        } else {
            $result['val'] = 0;
        }

        return json_encode($result);
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

    public function landing(Request $request)
    {

        // if (Session::has('phone_number') && Session::has('status') && Session::get('status') == "active") {
        //     return redirect('/');
        // }else{
        // header inrichemnt DETECT
        $result = array();
        // get client ip
        $ip = $_SERVER["REMOTE_ADDR"];

        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

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
        $this->log($actionName, $URL, $parameters_arr); // log in

        return view($this->front_view . 'landing');
        //    }
    }

    public function notify(Request $request)
    {

        //  http://localhost/islamic_portal_backend/notify?action=SubscriptionContractStatusChanged&subscriptionContractId=400560&customerAccountNumber=customer159635721&status=Suspended&reason=&digest=JoEmCoAROhdqtmwPYX0N:bdd04a44cb7e39cb74fb6e4c4f6b889b77e9fb28b500a6409ae51db394b82d89

        $URL = $request->fullUrl();
        $sys_status = "Not meet condition";

        $action = $request->action;
        $subscriptionContractId = $request->subscriptionContractId;
        $customerAccountNumber = $request->customerAccountNumber;
        $status = $request->status;
        $reason = $request->reason;
        $digest = $request->digest;

        $message = $action . $subscriptionContractId . $customerAccountNumber . $status . $reason;

        $privateKey = $this->privateKey;
        $signature = $this->publicKey . ":" . hash_hmac('sha256', $message, $privateKey);

        /*      var_dump( $this->customerAccountNumber) ;
        echo "<hr>" ;
        var_dump( $signature );

        echo "<hr>" ;
        echo "the request  :" ;
        echo "<hr>" ;

        var_dump( $customerAccountNumber );
        echo "<hr>" ;
        var_dump( $digest );

        die; */

        if ($signature == $digest && $customerAccountNumber == $this->customerAccountNumber) { // update mu database
            // update
            $Msisdn = Msisdn::where('contract_id', $subscriptionContractId)->orderBy('id', 'DESC')->first();
            if ($Msisdn) {

                switch ($status) {
                    case "Active":
                        $sys_status = "active";
                        break;
                    case "Canceled":
                        $sys_status = "unsub";
                        break;
                    case "Suspended":
                        $sys_status = "pending";
                        break;
                    case "Purged":
                        $sys_status = "pending";
                        break;
                    case "PendingOnCallback":
                        $sys_status = "under_processing";
                        break;
                    default:
                        $sys_status = "error";
                }

                $Msisdn->status = $sys_status;
                $Msisdn->save();
            } else {
                $result['status'] = 0;
                $result['message'] = "subscriptionContractId not found";
            }

            $result['status'] = 1;
            $result['message'] = "success";
        } else {
            $result['status'] = 0;
            $result['message'] = "digest or customerAccountNumber  not correct";
        }

        // create a log channel
        $actionName = "TPAY Notification Api";
        $parameters_arr = array(
            "action" => $action,
            "subscriptionContractId" => $subscriptionContractId,
            "customerAccountNumber" => $customerAccountNumber,
            "status" => $status,
            "reason" => $reason,
            "digest" => $digest,
            "myResult" => $result,
            "myDigest" => $signature,
            "my_sys_status" => $sys_status,
        );

        // log
        $this->log($actionName, $URL, $parameters_arr); // log in

        return json_encode($result);
    }

    public function test_login(Request $request)
    {
        session(['phone_number' => "01223872695", 'status' => 'active']);
        return redirect('/');
    }

    public function ads($transaction_id, $aff_id)
    {
        $arr = array();
        $arr['transaction_id'] = $transaction_id;
        $arr['aff_id'] = $aff_id;

        return json_encode($arr);
    }

    public function du_landing(request $request)
    {
        $peroid = isset($request->peroid) ? $request->peroid : "daily";
        $lang = isset($request->lang) ? $request->lang : "ar";
        return view('landing_v2.du_landing', compact("peroid", "lang"));
    }

    public function du_landing_success()
    {
        date_default_timezone_set("Africa/Cairo");
        $URL = \Request::fullUrl();
        // make log
        $actionName = "DU SecureD Pincode Success";
        $parameters_arr = array(
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'URL' => $URL,
        );
        $this->log($actionName, $URL, $parameters_arr);

        return view('landing_v2.du_landing_success');
    }

    public function DuSecureRedirect(request $request)
    {
        date_default_timezone_set("Africa/Cairo");

        if (isset($_REQUEST['number']) && $_REQUEST['number'] != "") {
            $msisdn = $_REQUEST['number'];
            $msisdn = "971" . $msisdn;
        } else {
            $msisdn = "";
        }

        require 'uuid/UUID.php';
        $trxid = \UUID::v4();

        if (isset($_REQUEST['peroid']) && $_REQUEST['peroid'] != "") {
            $plan = $_REQUEST['peroid'];

            if ($plan == "daily") {
                $serviceid = "waffarlydaily";
                $price = 2;
                $num = 1;
            } elseif ($plan == "weekly") {
                $serviceid = "waffarlyweekly";
                $price = 14;
                $num = 7;
            } else {
                $serviceid = "waffarlydaily";
                $price = 2;
                $num = 1;
            }
        } else { // default is daily
            $serviceid = "waffarlydaily";
            $plan = "daily";
            $price = 2;
            $num = 1;
        }

        if (isset($_REQUEST['lang']) && $_REQUEST['lang'] != "") {
            $local = $_REQUEST['lang'];
        } else { // default is arabic
            $local = "ar";
        }

        $redirectUrl = url('/home');

        // activation api :   http://pay-with-du.ae/20/digizone/digizone-flaterdaily-1-ar-doi-web?origin=digizone&uid=971555802322&trxid=56833e8d-c21b-453b-9e2a-f33f20415ae2&serviceProvider=secured&serviceid=flaterdaily&plan=daily&price=2&locale=ar
        //  f5d1048a-995e-11e7-abc4-cec278b6b50a
        //http://pay-with-du.ae/20/digizone/digizone-{$serviceid}-{$num}-{$local}-doi-web?
        $URL = "http://pay-with-du.ae/20/digizone/digizone-{$serviceid}-{$num}-{$local}-doi-web?origin=digizone&uid=$msisdn&trxid=$trxid&serviceProvider=secured&serviceid=$serviceid&plan=$plan&price=$price&locale=$local&redirectUrl={$redirectUrl}";

        // make log
        $actionName = "DU SecureD Pincode Send";
        $parameters_arr = array(
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'URL' => $URL,
        );
        $this->log($actionName, $URL, $parameters_arr);

        $DuIntgration = new DuIntgration();
        $DuIntgration->url = $URL;
        $DuIntgration->trxid = $trxid;
        $DuIntgration->uid = $msisdn;
        $DuIntgration->serviceid = $serviceid;
        $DuIntgration->plan = $plan;
        $DuIntgration->price = $price;
        $DuIntgration->local = $local;
        $DuIntgration->save();

        return redirect($URL);
    }

    public function du_unsubc(request $request)
    {

        $peroid = isset($request->peroid) ? $request->peroid : "daily";
        $lang = isset($request->lang) ? $request->lang : "ar";
        return view('landing_v2.du_unsub', compact("peroid", "lang"));
    }

    public function du_unsubcr(request $request)
    {
        $peroid = isset($request->peroid) ? $request->peroid : "daily";
        $lang = isset($request->lang) ? $request->lang : "ar";
        $number = "971" . $request->number;
        $pero = $peroid;
        $URL = DU_UNSUB_SYSTEM;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "msisdn=" . $number . "&serviceid=waffarly" . $pero);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);
        if ($server_output == 1) {
            if ($lang == 'ar') {
                $msg = 'تم الغاء الاشتراك بنجاح';
            } else {
                $msg = 'Unsubscribed Successfully';
            }
            return redirect('du_landing/' . $peroid . '/' . $lang)->with('success', $msg);
        } else {
            if ($lang == 'ar') {
                $msg = 'الرقم غير صحيح';
            } else {
                $msg = 'Wrong Number';
            }
            return redirect('du_unsubc/' . $peroid . '/' . $lang)->with('failed', $msg);
        }
    }
}
