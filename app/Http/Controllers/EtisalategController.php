<?php

namespace App\Http\Controllers;

use App\EtisalatCharge;
use App\EtisalatMsisdn;
use App\EtisalatNotification;
use App\Http\Controllers\API\EtisalatCategoryController;
use App\Http\Controllers\Controller;
use App\Msisdn;
use App\Post;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class EtisalategController extends Controller
{
    //   public function __construct() {
    //         $this->log();
    //     }
    public function detect()
    {
        Session::forget('dataPhoneNo');
        Session::forget('phone');
        session(['OpID' => Etisalat_Bundle_Route]);

        $request = Request::capture();
        $url = $request->fullUrl();

        $url_arr = explode("&param=", $url);
        $directUrl = isset($url_arr[0]) ? $url_arr[0] : "";
        $chiper = isset($url_arr[1]) ? $url_arr[1] : "";

        session(['chiper' => $chiper]);
        $URL = ETISALAT_SYSTEM . "/getPhone?param=" . $chiper;
        $dataPhoneNo = $this->get_content($URL);
        $checkPhone = trim('2' . $dataPhoneNo); // add 2
        session(['dataPhoneNo' => $dataPhoneNo]);

        $URL = ETISALAT_SYSTEM . "/checksub?param=" . $chiper;
        $result = $this->get_content($URL);

        $MSISDN = "";
        // check susbcription
        // 1= active  , 2= not_active  , 3=  not_subscribed , 4= login from wifi
        if ($result == 1) { // subscribed and active
            $URL2 = ETISALAT_SYSTEM . "/getPhone?param=" . $chiper;
            $MSISDN = $this->get_content($URL2);

            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'active']);

            if (Session::has('RUrl')) {
                return redirect(url(Session::get('RUrl')));
            } else {
                return redirect(url('/' . Session::get('OpID')));
            }
        } elseif ($result == 2) { // not active
            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'تم ايقاف الباقة بناء علي طلبك..برجاء اعادة الاشتراك']);
            return redirect(Session::get('OpID') . '/login');
        } elseif ($result == 3) { // not subscribe
            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'أنت غير مشترك في خدمه وفرلي. أشترك الان ']);
            return redirect(Session::get('OpID') . '/login');
        } elseif ($result == 4) { // 4= login from wifi
            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => "للاستمتاع بهذه الخدمة يرجى دخول الانترنت عن طريق باقات الانترنت لاتصالات"]);
            return redirect(Session::get('OpID') . '/login_web');
        } elseif ($chiper == "") { // 4= login from wifi
            session(['Status' => 'login wifi']);
            return redirect(Session::get('OpID') . '/login_web');
        }
    }

    public function login()
    {
        $Request = Request::capture();
        session(['OpID' => Etisalat_Bundle_Route]);
        if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {
            return redirect(url(Etisalat_Bundle_Route));
        } else {
            return view('etisalateg.arabic.login');
        }
    }

    public function ValidateLogin()
    {
        session(['OpID' => Etisalat_Bundle_Route]);
        $Request = Request::capture();

        // check susbcription
        // 1= active  , 2= not_active  , 3=  not_subscribed , 4= login from wifi
        if ($result == 1) { // subscribed and active
            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'active']);

            return redirect($Request->fullUrl());
        } elseif ($result == 2) { // not active
            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'عفوا رصيدك لا يكفى برجاء اعادة شحن الرصيد ثم اعد المحاولة']);
            return view('etisalateg.arabic.login')->with('error', 'عفوا رصيدك لا يكفى برجاء اعادة شحن الرصيد ثم اعد المحاولة');
        } elseif ($result == 3) { // not subscribe
            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'عفوا أنت غير مشترك فى هذه الخدمة أتصل بـ  920 أو *92# واستمتع بخدمه وفرلي ']);
            return view('etisalateg.arabic.login')->with('error', 'عفوا أنت غير مشترك فى هذه الخدمة أتصل بـ  920 أو *92# واستمتع بخدمه وفرلي ');
        } elseif ($result == 4) { // 4= login from wifi
            session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'للاستمتاع بهذه الخدمة يرجى دخول الانترنت عن طريق باقات الانترنت لاتصالات ']);
            return view('etisalateg.arabic.login')->with('error', "للاستمتاع بهذه الخدمة يرجى دخول الانترنت عن طريق باقات الانترنت لاتصالات ");
        } else {
            return redirect(url('/' . Etisalat_Bundle_Route));
        }
    }

    public function mada_test_links()
    {
        session(['OpID' => Etisalat_Bundle_Route]);
        $MSISDN = "test";
        session(['MSISDN_ETISALAT' => $MSISDN, 'Status' => 'active']);
        sleep(5); // to take time to save session
        return redirect(Session::get('OpID'));
    }

    public function login_web(Request $request)
    {
        $Request = Request::capture();
        $phone_number = '';

        if ($request->filled("msisdn")) {

            $phone_number = $request->msisdn;
            $phone_number = etisalat_crypt($phone_number, 'd');

            if (isset($phone_number[0]) && $phone_number[0] != '0') {
                $phone_number = '0' . $phone_number;
            }

            if (!preg_match('/^011[0-9]{8}$/', $phone_number)) {
                $request->session()->flash('failed', 'هذا الرقم غير صحيح');
                return redirect(url(Etisalat_Bundle_Route . '/login_web'));
            }
        }

        session(['OpID' => Etisalat_Bundle_Route]);
        if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {
            return redirect(url('?OpID=' . Etisalat_Bundle_Route));
        } else {
            return view('etisalateg.arabic.login_web', compact("phone_number"));
        }
    }

    public function etisalat_newsub()
    {
        return view('etisalateg.arabic.redirectpage');
    }

    public function validateLogin_web(Request $request)
    {
        session(['OpID' => Etisalat_Bundle_Route]);
        date_default_timezone_set('Africa/Cairo');

        $phone_number = $request->MSISDN;

        if (isset($phone_number[0]) && $phone_number[0] != '0') {
            $phone_number = '0' . $phone_number;
        }

        if (!preg_match('/^011[0-9]{8}$/', $phone_number)) {
            $request->session()->flash('failed', 'هذا الرقم غير صحيح');
            return redirect(url(Etisalat_Bundle_Route . '/login_web'));
        }

        $phone_number = trim($phone_number);
        $checkPhone = trim('2' . $phone_number);
        $EtisalatMsisdn = EtisalatMsisdn::where('MSISDN', $phone_number)->first();
        if ($EtisalatMsisdn) {
            if ($EtisalatMsisdn->final_status == 1) {
                session(['MSISDN_ETISALAT' => $phone_number, 'Status' => 'active']);
                if (Session::has('RUrl') && Session::get('RUrl') != "") {
                    return redirect(Session::get('RUrl'));
                } else {
                    return redirect(url('?OpID=' . Etisalat_Bundle_Route));
                }
                return redirect('?OpID=' . Etisalat_Bundle_Route);
            }
        } else {
            return redirect('etisalat/newsub?msisdn=' . $phone_number);
        }

        $URL = ETISALAT_SYSTEM . "/checkphone?phone=" . $checkPhone;
        $result = $this->get_content($URL); //    1= active  , 2= not_active  , 3=  not_subscribed , 4= phone not entered

        if ($result == "1") { // active
            // to see if subscriber is login or not  -- 0 = error  , 1 = not login , 2 =  already login
            $URL = ETISALAT_SYSTEM . "/webAppLogin?phone=" . $checkPhone;
            $result = $this->get_content($URL);

            if ($result == "1" || $result == "2") {
                session(['MSISDN_ETISALAT' => $phone_number, 'Status' => 'active']);
                if (Session::has('RUrl') && Session::get('RUrl') != "") {
                    return redirect(Session::get('RUrl'));
                } else {
                    return redirect(url('?OpID=' . Etisalat_Bundle_Route));
                }
                return redirect(url('?OpID=' . Etisalat_Bundle_Route));
            }
            //elseif ($result == "2") { // login
            //  $request->session()->flash('failed', 'للاستمتاع بهذه الخدمة يرجى دخول الانترنت عن طريق باقات الانترنت لاتصالات');
            //   return redirect(Session::get('OpID') . '/login_web');
            //  }
        } elseif ($result == "2") { // not_active
            $request->session()->flash('failed', 'تم ايقاف الباقة بناء علي طلبك..برجاء اعادة الاشتراك');
            return back();
        } elseif ($result == "3") { // not_subscribed
            $request->session()->flash('failed', 'أنت غير مشترك في خدمه وفرلي. أشترك الان (عملاء جدد)');
            return back();
        } else {
            $request->session()->flash('failed', 'يجب اخال رقم التليفون');
            return back();
        }
    }

    public function register2_form()
    {
        session(['OpID' => Etisalat_Bundle_Route]);
        return view('etisalateg.arabic.subscribe.enter-number');
    }

    public function register2(Request $request)
    {
        // return $request->all();
        date_default_timezone_set('Africa/Cairo');
        $phone_number = $request->MSISDN;
        if (isset($phone_number[0]) && $phone_number[0] != '0') {
            $phone_number = '0' . $phone_number;
        }
        if (!preg_match('/^011[0-9]{8}$/', $phone_number)) {
            $request->session()->flash('failed', 'هذا الرقم غير صحيح');
            // return  $request->all();
            return back();
        }

        $checkPhone = trim('2' . $phone_number); // add 2

        $URL = ETISALAT_SYSTEM . "/checkphone?phone=" . $checkPhone;
        $result = $this->get_content($URL); //    1= active  , 2= not_active  , 3=  not_subscribed , 4= phone not entered
        if ($result == "1") { // active
            $request->session()->flash('failed', 'تم تسجيل هذا الرقم من قبل رجاء تسجيل الدخول');
            return back();
        } else { // create new subscriber or update not active by Vcode , pin created , pin end
            $URL = ETISALAT_SYSTEM . "/addUpdateSubscriber?phone=" . $checkPhone;
            $vcode = $this->get_content($URL);
            if ($vcode != 0) { // we get pincode
                $message = 'كود التفعيل  ' . $vcode;
                $URL = DEV_SMS_SEND_MESSAGE;
                $param = "phone_number=" . $phone_number . "&message=" . $message;
                $result = $this->get_content_post($URL, $param);
                session(['register_phone' => $phone_number]);
                if ($result == "1") {
                    $request->session()->flash('success', 'تم ارسال رقم مكون من خمس ارقام الى رقم التليفون الذى ادخلته رجاء ادخال الخمس ارقام حتى يتم تاكيد رقم التليفون ');
                    return redirect(Etisalat_Bundle_Route . '/confirm');
                }
            }
        }
    }

    public function confirm_form2()
    {
        return view('etisalateg.arabic.subscribe.validate-pin');
    }

    public function PinValidation2(Request $request)
    {
        $user = new User();

        $vcode = $request->PIN;
        $phone = Session::get('register_phone');
        $checkPhone = trim('2' . $phone); // add 2

        $URL = ETISALAT_SYSTEM . "/checkVcode?phone=" . $checkPhone . "&vcode=" . $vcode;

        $susbcriber = $this->get_content($URL); //  susbcriber object
        //dd($susbcriber);

        $susbcriber = json_decode($susbcriber);

        // print_r($susbcriber) ; die;
        if ($susbcriber) {

            $created_at = new Carbon($susbcriber->bin_created_time, 'Africa/Cairo');
            $end_date = new Carbon($susbcriber->bin_end_time, 'Africa/Cairo');

            if (!Carbon::now('Africa/Cairo')->between($created_at, $end_date)) {
                // return $bin;
                $request->session()->flash('failed', 'لقد انتهت صلاحية هذا الرقم وتم ارسال رقم اخر الى تليفونك');

                $URL = ETISALAT_SYSTEM . "/addUpdateSubscriber?phone=" . $checkPhone;
                $vcode = $this->get_content($URL);
                $message = "رجاء ادخال هذا الرقم" . $vcode . " حتى تتم عملية الاشتراك";
                $URL = DEV_SMS_SEND_MESSAGE;
                $param = "phone_number=" . $phone . "&message=" . $message;
                $result = $this->get_content_post($URL, $param);
                return back();
            } else {

                $URL = ETISALAT_TIBCO_SUBSCRIPTION . "/subscriber.php?phone=" . $phone;

                $result = $this->get_content($URL); //    1= SUCCESS  else  ERROR
                $result = preg_replace('/\s+/', '', $result); // to remove extra space created by soap request

                if ($result == "1") { // active
                    // make susbcriber login from web
                    $URL = ETISALAT_SYSTEM . "/setActiveWebLogin?phone=" . $checkPhone;
                    $result = $this->get_content($URL);

                    $request->session()->flash('success_validate', 'تم تأكيد الرقم بنجاح');
                    session(['MSISDN_ETISALAT' => $phone, 'Status' => 'active']);
                    return redirect(Etisalat_Bundle_Route);
                } else {
                    $request->session()->flash('failed', 'فشلت العملية');
                    return back();
                }
            }
        } else {
            $request->session()->flash('failed', 'الرقم الذى ارسلته غير صحيح الرجاء محاولة ادخال الرقم مره اخري ');
            return back();
        }

        return back();
    }

    // enable user to subscribe when enter from mobile data
    public function dataSubscribe()
    {
        // get phone number from cipher
        Session::forget('phone');
        $chiper = Session::get('chiper');
        $URL = ETISALAT_SYSTEM . "/getPhone?param=" . $chiper;
        $dataPhoneNo = $this->get_content($URL);
        $checkPhone = trim('2' . $dataPhoneNo); // add 2
        session(['dataPhoneNo' => $dataPhoneNo]);

        // susbscription api to that number
        $URL = ETISALAT_TIBCO_SUBSCRIPTION . "/subscriber.php?phone=" . $dataPhoneNo;
        $result = $this->get_content($URL); //    1= SUCCESS  else  ERROR
        $result = preg_replace('/\s+/', '', $result); // to remove extra space created by soap request

        if ($result == "1") { // SUCCESS
            // make susbcriber login from web
            $URL = ETISALAT_SYSTEM . "/setActiveWebLogin?phone=" . $checkPhone;
            $result = $this->get_content($URL);

            session(['MSISDN_ETISALAT' => $dataPhoneNo, 'Status' => 'active']);
            return redirect(Etisalat_Bundle_Route);
        } else {
            //  $request->session()->flash('failed', 'فشلت العملية');
            session(['Status' => "فشلت العملية"]);
            return back();
        }
    }

    // enable user to subscribe by enter phone number
    public function directSubscribe()
    {
        Session::forget('dataPhoneNo');
        session(['OpID' => Etisalat_Bundle_Route]);
        $Request = Request::capture();
        $dataPhoneNo = $Request->phone;
        $checkPhone = trim('2' . $dataPhoneNo); // add 2

        session(['phone' => $dataPhoneNo, 'OpID' => Etisalat_Bundle_Route, 'Status' => 'تأكيد العملية']);
        return redirect(Session::get('OpID') . '/login');
    }

    // enable user to subscribe by enter cipher
    public function directSubscribeChiper($cipher)
    {
        Session::forget('dataPhoneNo');
        session(['OpID' => Etisalat_Bundle_Route]);

        // decrypt cipher text from etisalat
        /*
        $method = "aes-128-cbc"; // in java   AES+Base64
        $encryption_key = '0111145789facbed';
        $iv = str_repeat(chr(0), 16);   //  in java  =    AES/CBC/PKCS5Padding    // chr(0) = ""
        $encrypted = $cipher;
        $checkPhone = openssl_decrypt($encrypted, $method, $encryption_key, 0, $iv);
         */

        // you may change these values to your own
        $secret_key = 'etisalat';
        $secret_iv = 'etisalat';

        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $checkPhone = openssl_decrypt(base64_decode($cipher), $encrypt_method, $key, 0, $iv);

        $dataPhoneNo = substr($checkPhone, 1); // to remove 2

        session(['phone' => $dataPhoneNo, 'OpID' => Etisalat_Bundle_Route, 'Status' => 'تأكيد العملية']);
        return redirect(Session::get('OpID') . '/login');
    }

    // enable user to subscribe by enter phone number
    public function directSubscribeAction()
    {
        session(['OpID' => Etisalat_Bundle_Route]);
        $Request = Request::capture();
        $dataPhoneNo = $Request->phone;
        $checkPhone = trim('2' . $dataPhoneNo); // add 2
        //   echo $dataPhoneNo ; die;
        // susbscription api to that number
        $URL = ETISALAT_TIBCO_SUBSCRIPTION . "/subscriber.php?phone=" . $dataPhoneNo;
        $result = $this->get_content($URL); //    1= SUCCESS  else  ERROR
        $result = preg_replace('/\s+/', '', $result); // to remove extra space created by soap request

        if ($result == "1") { // SUCCESS
            // make susbcriber login from web
            $URL = ETISALAT_SYSTEM . "/setActiveWebLogin?phone=" . $checkPhone;
            $result = $this->get_content($URL);

            session(['MSISDN_ETISALAT' => $dataPhoneNo, 'Status' => 'active']);
            return redirect(Etisalat_Bundle_Route);
        } else {
            //  $request->session()->flash('failed', 'فشلت العملية');
            session(['Status' => "فشلت العملية"]);
            return redirect(Session::get('OpID') . '/login');
        }
    }

    public function logout_web(Request $request)
    {
        Session::forget('MSISDN_ETISALAT');
        return redirect(Etisalat_Bundle_Route . '/login_web');
    }

    public function get_content($URL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $URL);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function get_content_post($URL, $param)
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

    public static function GetPageData($URL)
    {

        $ch = curl_init();
        $timeout = 500;
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POSTREDIR, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function index(Request $request)
    {
        $request['operator_id'] = Etisalat_Bundle_Route;
        $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
        if (Post::where('operator_id', $request->operator_id)->exists()) {
            $operator = $request->get('operator_id');
            $api = $this->init()[0];
            $brands = $api->get_all_brands($request);
            $products = $api->get_all_categories_with_products($request);
            $featured = $api->get_latest_featured_for_slider($request);
            //  dd($featured);
            return view('etisalateg.arabic.front_end.home', compact('products', 'featured', 'request', 'brands'));
        } else {
            return view('etisalateg.arabic.front_end.not-found', compact('request'));
        }
    }

    public function consent_page(Request $request)
    {
        $msisdn = $request['msisdn'];
        $operator_code = $request['op_code'];
        return view('etisalateg.arabic.front_end.consent', compact('msisdn', 'operator_code'));
    }

    public function get_post(Request $request)
    {
        session(['operator_id' => get_operator()]);
        if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {
            $request['operator_id'] = $request->url();
            $product = DB::table('posts')
                ->join('operators', 'posts.operator_id', '=', 'operators.id')
                ->join('products', 'posts.product_id', '=', 'products.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('posts.active', '=', 1)
                ->where('products.active', '=', 1)
                ->where('posts.show_date', '<=', Carbon::now()->format('Y-m-d'))
                ->where('products.expire_date', '>=', Carbon::now()->format('Y-m-d'))
                ->where('posts.url', '=', $request['operator_id'])
                ->select('products.*', 'brands.*', 'categories.*', 'operators.*', 'products.id AS product_id', 'operators.id AS operator_id', 'posts.show_date AS show_date', 'posts.id AS postId')
                ->first();
            if ($product == !null) {
                return view('etisalateg.arabic.front_end.landing_post', compact('product', 'request'));
            } else {
                return view('etisalateg.arabic.front_end.not-found', compact('request'));
            }
        } else {
            session(['RUrl' => Session::get('operator_id') . '/landing/' . $uid]);
            return redirect(url(Etisalat_Bundle_Route . '/login_web'));
        }
    }

    public function get_brand_products(Request $request)
    {
        $request['operator_id'] = Etisalat_Bundle_Route;
        if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {
            $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
            if (Post::where('operator_id', $request->operator_id)->exists()) {
                $api = $this->init()[0];
                $products = $api->get_products_by_brandV3($request);
                if ($request["start"]) {
                    $view = view('etisalateg.arabic.front_end.brand_load', compact('products'))->render();

                }
                if ($products == -1) {
                    return view('etisalateg.arabic.front_end.not-found', compact('request'));
                }

                return view('etisalateg.arabic.front_end.brand', compact('products', 'request'));
            } else {
                return view('etisalateg.arabic.front_end.not-found', compact('request'));
            }
        } else {
            return redirect(url(Etisalat_Bundle_Route . '/login_web'));
        }
    }

    public function get_product(Request $request)
    {

        $request['operator_id'] = Etisalat_Bundle_Route;

        if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {
            $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
            if (Post::where('operator_id', $request->operator_id)->exists()) {
                $api = $this->init()[0];
                $product = $api->view_prodcut_details($request);
                if ($product == -1) {
                    return view('etisalateg.arabic.front_end.not-found', compact('request'));
                }

                $OtherProducts = $api->view_prodcut_linked($request);
                //dd($OtherProducts);
                if ($request["start"]) {
                    $view = view('etisalateg.arabic.front_end.OtherProducts_load', compact('OtherProducts'))->render();
                    return Response(array('html' => $view));
                }
                return view('etisalateg.arabic.front_end.product', compact('product', 'request', 'OtherProducts'));
            } else {
                return view('etisalateg.arabic.front_end.not-found', compact('request'));
            }
        } else {
            return redirect(url(Etisalat_Bundle_Route . '/login_web'));
        }
    }

    public function products_by_category(Request $request)
    {
        $request['operator_id'] = Etisalat_Bundle_Route;

        if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {
            $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
            if (Post::where('operator_id', $request->operator_id)->exists()) {
                $api = $this->init()[0];
                $products = $api->get_products_by_categories_V2($request);
                if ($request["start"]) {
                    $view = view('etisalateg.arabic.front_end.category_load', compact('products'))->render();
                    return Response(array('html' => $view, 'count' => count($products)));
                }
                if ($products == -1) {
                    return view('etisalateg.arabic.front_end.not-found', compact('request'));
                }

                return view('etisalateg.arabic.front_end.category', compact('products', 'request'));
            } else {
                return view('etisalateg.arabic.front_end.not-found', compact('request'));
            }
        } else {
            return redirect(url(Etisalat_Bundle_Route . '/login_web'));
        }
    }

    public function search_view(Request $request)
    {
        if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active') {

            $results = array();
            return view('etisalateg.arabic.front_end.search', compact('results', 'request'));
        } else {
            return redirect(url(Etisalat_Bundle_Route . '/login_web'));
        }
    }

    public function search(Request $request)
    {
        $api = $this->init()[0];
        $results = $api->SearchByKeyword($request);
        return $results;
    }

    public function terms(Request $request)
    {
        $api = $this->init()[0];
        $request['key'] = "Terms";
        $result = $api->get_setting($request);
        return view('etisalateg.arabic.front_end.terms', compact('result', 'request'));
    }
    public function init()
    {
        $settings = array();
        $api = new EtisalatCategoryController();
        $settings[0] = Setting::where('key', 'LIKE', '%website title%')->first();
        $settings[1] = Setting::where('key', 'LIKE', '%logo%')->first();
        $settings[2] = Setting::where('key', 'LIKE', '%facebook%')->first();
        $settings[3] = Setting::where('key', 'LIKE', '%twitter%')->first();
        return [$api, $settings];
    }

    public function etisalat_notification()
    {
        $string = file_get_contents('php://input');
        $result['request'] = $string;

        $request_array = array(
            'MSISDN' => ['start' => '<tem:MSISDN>', 'end' => '</tem:MSISDN>'],
            'serviceName' => ['start' => '<tem:serviceName>', 'end' => '</tem:serviceName>'],
            'tokenId' => ['start' => '<tem:tokenId>', 'end' => '</tem:tokenId>'],
            'channel' => ['start' => '<tem:channel>', 'end' => '</tem:channel>'],
            'operation' => ['start' => '<tem:operation>', 'end' => '</tem:operation>'],
        );

        $post_array = array();
        foreach ($request_array as $key => $value) {
            $start = $value['start'];
            $end = $value['end'];

            $startpos = strpos($string, $start) + strlen($start);
            if (strpos($string, $start) !== false) {
                $endpos = strpos($string, $end, $startpos);
                if (strpos($string, $end, $startpos) !== false) {
                    $post_array[$key] = substr($string, $startpos, $endpos - $startpos);
                } else {
                    $post_array[$key] = "";
                }
            }
        }

        if (!request()->has('msisdn')) {
            $request_array2 = array(
                'serviceName' => ['start' => '<tem:string>', 'end' => '</tem:string>'],
            );

            $service_array = array();
            foreach ($request_array2 as $key => $value) {
                $start = $value['start'];
                $end = $value['end'];

                $startpos = strpos($post_array['serviceName'], $start) + strlen($start);
                if (strpos($post_array['serviceName'], $start) !== false) {
                    $endpos = strpos($post_array['serviceName'], $end, $startpos);
                    if (strpos($post_array['serviceName'], $end, $startpos) !== false) {
                        $service_array[$key] = substr($post_array['serviceName'], $startpos, $endpos - $startpos);
                    } else {
                        $service_array[$key] = "";
                    }
                }
            }
        }

        if (request()->has('msisdn')) {
            $EtisalatNotification['MSISDN'] = request()->get('msisdn');
            $EtisalatNotification['operation'] = 'sub';
        } else {
            $EtisalatNotification['MSISDN'] = isset($post_array['MSISDN']) ? $post_array['MSISDN'] : '';
            $EtisalatNotification['operation'] = isset($post_array['operation']) ? $post_array['operation'] : '';
        }

        $EtisalatNotification['request'] = $string;
        $EtisalatNotification['serviceName'] = isset($service_array['serviceName']) ? $service_array['serviceName'] : '';
        $EtisalatNotification['tokenId'] = isset($post_array['tokenId']) ? $post_array['tokenId'] : '';
        $EtisalatNotification['channel'] = isset($post_array['channel']) ? $post_array['channel'] : '';

        $record = EtisalatNotification::create($EtisalatNotification);

        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
        <soapenv:Body>
                <NotificationResponse>
                <NotificationResult>
                <MSISDN>' . $EtisalatNotification['MSISDN'] . '</MSISDN>
                <ServiceName>' . $EtisalatNotification['serviceName'] . '</ServiceName>
                    <ResponseCode>0</ResponseCode>
                    <Description>Success</Description>
                    <RecordId>' . $record->id . '</RecordId>
                </NotificationResult>
                </NotificationResponse>
        </soapenv:Body>
      </soapenv:Envelope>';

        $record->response = $xml;
        $record->save();

        if ($EtisalatNotification['operation'] == 'sub') {
            $EtisalatMsisdn = EtisalatMsisdn::where('MSISDN', $EtisalatNotification['MSISDN'])->first();
            if ($EtisalatMsisdn) {
                $EtisalatMsisdn->final_status = 1;
                $EtisalatMsisdn->save();
            } else {
                $EtisalatMsisdn['MSISDN'] = $EtisalatNotification['MSISDN'];
                $EtisalatMsisdn['record_id'] = $record->id;
                $EtisalatMsisdn['final_status'] = 1;
                EtisalatMsisdn::create($EtisalatMsisdn);
            }
        } elseif ($EtisalatNotification['operation'] == 'unsub') {
            $EtisalatMsisdn = EtisalatMsisdn::where('MSISDN', $EtisalatNotification['MSISDN'])->first();
            if ($EtisalatMsisdn) {
                $EtisalatMsisdn->final_status = 0;
                $EtisalatMsisdn->save();
            }
        }

        if (request()->has('msisdn')) {
            return redirect(Etisalat_Bundle_Route . '/login_web')->with('success', 'تم الاشتراك بنجاح');
        } else {
            return $xml;
        }
    }

    public function notification_rest(Request $request)
    {
        $EtisalatNotification['MSISDN'] = $request->get("MSISDN");
        $EtisalatNotification['operation'] = $request->get("operation");
        $EtisalatNotification['serviceName'] = $request->get("serviceName");
        $EtisalatNotification['tokenId'] = $request->get("tokenId");
        $EtisalatNotification['channel'] = $request->get("channel");

        $record = EtisalatNotification::create($EtisalatNotification);

        $result_array = array();
        $result_array["MSISDN"] = $EtisalatNotification['MSISDN'];
        $result_array["serviceName"] = $EtisalatNotification['serviceName'];
        $result_array["ResponseCode"] = 0;
        $result_array["Description"] = "Success";
        $result_array["RecordId"] = $record->id;

        $result = json_encode($result_array);

        $record->request = json_encode($request->all());
        $record->response = $result;
        $record->save();

        // upadte our syn DB
        if ($EtisalatNotification['operation'] == 'sub') {
            $EtisalatMsisdn = EtisalatMsisdn::where('MSISDN', $EtisalatNotification['MSISDN'])->first();
            if ($EtisalatMsisdn) {
                $EtisalatMsisdn->final_status = 1;
                $EtisalatMsisdn->save();
            } else {
                $EtisalatMsisdn['MSISDN'] = $EtisalatNotification['MSISDN'];
                $EtisalatMsisdn['record_id'] = $record->id;
                $EtisalatMsisdn['final_status'] = 1;
                $EtisalatMsisdn['subscribe_date'] = date("Y-m-d");
                $EtisalatMsisdn['next_charging_date'] = Carbon::now()->addDay(1);
                EtisalatMsisdn::create($EtisalatMsisdn);
            }
        } elseif ($EtisalatNotification['operation'] == 'unsub') {
            $EtisalatMsisdn = EtisalatMsisdn::where('MSISDN', $EtisalatNotification['MSISDN'])->first();
            if ($EtisalatMsisdn) {
                $EtisalatMsisdn->final_status = 0;
                $EtisalatMsisdn->save();
            }
        }

        return $result;

    }

    public function charging_response_simulate()
    {
        $xml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
                <SOAP-ENV:Body>
                    <ns0:ChargeServiceResponse xmlns:ns0="http://www.etisalat.com.eg/services/Service/ChargeService/xsd/v1">
                        <ns1:header xmlns:ns1="http://etisalat.com.eg/EMF/MessageResponseHeaderV1.0.xsd" xmlns:ns0="http://www.etisalat.com.eg/services/Diameter/Charging/RateSubscriberByService/xsd/v1">
                            <ns1:RespondingSystem />
                            <ns1:Transaction>
                            <ns1:transactionID>b46a6d816897466ab68ad9634667d316</ns1:transactionID>
                            </ns1:Transaction>
                            <ns1:serviceStatus>
                            <ns1:status>SUCCESS</ns1:status>
                            <ns1:statusDetail>
                                Etisalat CRM Transformation – AIR Services Interface Specifications

                                Version: 1.0 Page 11 of 18
                                <ns1:errorCode>ESB-00000</ns1:errorCode>
                                <ns1:errorMSG>Success</ns1:errorMSG>
                            </ns1:statusDetail>
                            </ns1:serviceStatus>
                            <ns1:Properties />
                        </ns1:header>
                    </ns0:ChargeServiceResponse>
                </SOAP-ENV:Body>
                </SOAP-ENV:Envelope>';
        return $xml;
    }

    public function charging()
    {
        $soap_request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://www.etisalat.com.eg/services/Service/ChargeService/xsd/v1" xmlns:mes="http://etisalat.com.eg/EMF/MessageRequestHeaderV1.0.xsd">
        <soapenv:Header/>
        <soapenv:Body>
           <v1:ChargeServiceRequest>
              <mes:header>
                 <!--Optional:-->
                 <mes:messageIdentifier>
                    <!--Optional:-->
                    <mes:messageName>?</mes:messageName>
                    <!--Optional:-->
                    <mes:messageVersion>?</mes:messageVersion>
                 </mes:messageIdentifier>
                 <!--Optional:-->
                 <mes:Credential>
                    <!--Optional:-->
                    <mes:UserId>?</mes:UserId>
                    <!--Optional:-->
                    <mes:Password>?</mes:Password>
                    <!--Optional:-->
                    <mes:ServiceName>?</mes:ServiceName>
                 </mes:Credential>
                 <!--Optional:-->
                 <mes:Transaction>
                    <!--Optional:-->
                    <mes:transactionID>?</mes:transactionID>
                    <!--Optional:-->
                    <mes:transactionType>?</mes:transactionType>
                    <!--Optional:-->
                    <mes:transactionDomain>?</mes:transactionDomain>
                 </mes:Transaction>
                 <!--Optional:-->
                 <mes:RequestingSystem>
                    <!--Optional:-->
                    <mes:correlationID>?</mes:correlationID>
                    <!--Optional:-->
                    <mes:requestingApplicationName>?</mes:requestingApplicationName>
                 </mes:RequestingSystem>
                 <!--Optional:-->
                 <mes:Properties>
                    <!--Zero or more repetitions:-->
                    <mes:Attribute>
                       <mes:key>?</mes:key>
                       <mes:value>?</mes:value>
                    </mes:Attribute>
                 </mes:Properties>
              </mes:header>
              <v1:RequestBody>
                 <!--Optional:-->
                 <v1:MSISDN>?</v1:MSISDN>
                 <!--Optional:-->
                 <v1:serviceName>?</v1:serviceName>
                 <!--Optional:-->
                 <v1:serviceID>?</v1:serviceID>
                 <!--Optional:-->
                 <v1:billingAmount>?</v1:billingAmount>
                 <!--Optional:-->
                 <v1:tokenID>?</v1:tokenID>
                 <!--Optional:-->
                 <v1:chargingInfo>
                    <!--Zero or more repetitions:-->
                    <v1:chargingItem>
                       <!--Optional:-->
                       <v1:Name>?</v1:Name>
                       <!--Optional:-->
                       <v1:Value>?</v1:Value>
                    </v1:chargingItem>
                 </v1:chargingInfo>
              </v1:RequestBody>
           </v1:ChargeServiceRequest>
        </soapenv:Body>
     </soapenv:Envelope>';

        $header = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: \"/services/SubscriptionThirdParty/Services\"", // we must put /
            "SerialNumber: V_IVAS123",
            "CAissuer: V_IVAS",
            "Content-length: " . strlen($soap_request),
        );

        $URL = url('/') . "/api/charging_response_simulate";

        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, $URL);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $soap_request);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);

        // to dump request
        $f = fopen('request.txt', 'w');
        curl_setopt_array($soap_do, array(
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_STDERR => $f,
        ));

        $output = curl_exec($soap_do);

        curl_close($soap_do);

        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($output);

        $XMLresults = $doc->getElementsByTagName("transactionID");
        $transactionID = $XMLresults->item(0)->nodeValue;

        $XMLresults = $doc->getElementsByTagName("status");
        $status = $XMLresults->item(0)->nodeValue;

        $XMLresults = $doc->getElementsByTagName("errorCode");
        $errorCode = $XMLresults->item(0)->nodeValue;

        $XMLresults = $doc->getElementsByTagName("errorMSG");
        $errorMSG = $XMLresults->item(0)->nodeValue;

        /*$XMLresults = $doc->getElementsByTagName("RequestID");
        $RequestID = $XMLresults->item(0)->nodeValue;*/

        // echo $transactionID;
        // echo "<br>";
        // echo $status;
        // echo "<br>";
        // echo $errorCode;
        // echo "<br>";
        // echo $errorMSG;
        // echo "<br>";
        /*echo $RequestID;
        echo "<br>" ;*/

        $EtisalatCharge['subscriber_id'] = 1;
        $EtisalatCharge['billing_request'] = $soap_request;
        $EtisalatCharge['billing_response'] = $status;
        $EtisalatCharge['status_code'] = $errorCode;
        $EtisalatCharge['charging_date'] = date('Y-m-d');

        $record = EtisalatCharge::create($EtisalatCharge);

        $URL = url()->full();
        // make log
        $actionName = "Etisalat Charge";
        $parameters_arr = array(
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'URL' => $URL,
            'EtisalatCharge' => $EtisalatCharge,
        );
        $this->log($actionName, $URL, $parameters_arr);

        $soup_response = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
        <SOAP-ENV:Body>
            <ns0:ProcessRequestResponse xmlns:ns0="http://www.etisalat.com.eg/services/Subscription/ProcessRequest/xsd/v1">
                <ns1:header xmlns:ns1="http://etisalat.com.eg/EMF/MessageResponseHeaderV1.0.xsd">
                    <ns1:RespondingSystem/>
                    <ns1:Transaction>
                    <ns1:transactionID>' . $transactionID . '</ns1:transactionID>
                    </ns1:Transaction>
                    <ns1:serviceStatus>
                    <ns1:status>' . $status . '</ns1:status>
                    <ns1:statusDetail>
                        <ns1:errorCode>' . $errorCode . '</ns1:errorCode>
                        <ns1:errorMSG>' . $errorMSG . '</ns1:errorMSG>
                    </ns1:statusDetail>
                    </ns1:serviceStatus>
                </ns1:header>
                <ns0:ResponseBody>
                    <ns0:RequestID>' . $record->id . '</ns0:RequestID>
                </ns0:ResponseBody>
            </ns0:ProcessRequestResponse>
        </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>';

        return $soup_response;

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

    public function etisalat_daily_charging(Request $request)
    {
        $EtisalatMsisdns = EtisalatMsisdn::where('next_charging_date', date("Y-m-d"))->where(function ($query) {
            $query->where('final_status', '=', 1)
                ->orWhere('final_status', '=', 2);
        })->get();

        foreach ($EtisalatMsisdns as $EtisalatMsisdn) {
            $URL = 'http://10.2.10.15:8310/~newetisalat/api/charging?MSISDN=' . $EtisalatMsisdn->MSISDN . '&serviceID=ET_Wafarlly';
            $get_content = $this->get_content($URL);
            // $get_content = "ESB-00000";
            if ($get_content == "ESB-00000") { //Success
                $EtisalatMsisdn->final_status = 1;
                $EtisalatMsisdn->next_charging_date = Carbon::now()->addDay(1);
            } else { //fail
                $EtisalatMsisdn->final_status = 2;
            }
            $EtisalatMsisdn->save();
            $etisalat_charges = new EtisalatCharge();
            $etisalat_charges->subscriber_id = $EtisalatMsisdn->id;
            $etisalat_charges->billing_request = $URL;
            $etisalat_charges->billing_response = $get_content;
            $etisalat_charges->status_code = $get_content;
            $etisalat_charges->charging_date = date("Y-m-d");
            $etisalat_charges->save();
        }
        return "OK etisalat_daily_charging";
    }

    public function etisalat_yesterday_final_failed(Request $request)
    {
        $Date = date("Y-m-d", strtotime("-1 days"));
        $etisalat_yesterday_final_faileds = EtisalatMsisdn::where('next_charging_date', $Date)->where('final_status', '=', 2)->get();
        foreach ($etisalat_yesterday_final_faileds as $value) {
            $value->grace_days = $value->grace_days + 1;
            $value->next_charging_date = date("Y-m-d");
            if ($value->save()) {
                if ($value->grace_days == grace_days_100) {
                    $value->final_status = 0;
                    $value->save();
                }
            }
        }
        return "OK etisalat_yesterday_final_failed";
    }
}
