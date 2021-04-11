<?php

namespace App\Http\Controllers;

use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\File;

use Monolog\Logger;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\DuCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Bin;
use App\User;
use App\Category;
use App\Setting;
use App\Msisdn;
use App\Brand;
use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\DuIntgration;

class DuController extends Controller
{


    public function index(Request $request)
    {
        $request['operator_id'] = Du_Bundle_Route;
        $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
        if (Post::where('operator_id', $request->operator_id)->exists()) {
            $operator = $request->get('operator_id');
            $api = $this->init()[0];
            $brands    = $api->get_all_brands($request);
            $products = $api->get_all_categories_with_products($request);
            $featured = $api->get_latest_featured_for_slider($request);
            //  dd($featured);
            return view('du.arabic.front_end.home', compact('products', 'featured', 'request', 'brands'));
        } else {
            return view('du.arabic.front_end.not-found', compact('request'));
        }
    }

    public function consent_page(Request $request)
    {
        $msisdn = $request['msisdn'];
        $operator_code = $request['op_code'];
        return view('du.arabic.front_end.consent', compact('msisdn', 'operator_code'));
    }

    public function get_post(Request $request, $uid)
    {
        session(['operator_id' => get_operator()]);
        $request['operator_id'] = $request->url();
        $product = DB::table('posts')
            ->join('operators', 'posts.operator_id', '=', 'operators.id')
            ->join('products', 'posts.product_id', '=', 'products.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('posts.featured', '=', 1)
            ->where('posts.active', '=', 1)
            ->where('products.active', '=', 1)
            ->where('posts.show_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('products.expire_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('posts.url', '=', $request['operator_id'])
            ->select('products.*', 'brands.*', 'categories.*', 'operators.*', 'products.id AS product_id', 'operators.id AS operator_id', 'posts.show_date AS show_date', 'posts.id AS postId')
            ->first();
        if ($product == !null) {
            return view('du.arabic.front_end.landing_post', compact('product', 'request'));
        } else {
            return view('du.arabic.front_end.not-found', compact('request'));
        }
    }

    public function get_brand_products(Request $request)
    {
        $request['operator_id'] = Du_Bundle_Route;
        $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
        if (Post::where('operator_id', $request->operator_id)->exists()) {
            $api = $this->init()[0];
            $products = $api->get_products_by_brandV3($request);
            if ($request["start"]) {
                $view = view('du.arabic.front_end.brand_load', compact('products'))->render();
                return Response(array('html' => $view, 'count' => count($products)));
            }
            if ($products == -1)
                return view('du.arabic.front_end.not-found', compact('request'));
            return view('du.arabic.front_end.brand', compact('products', 'request'));
        } else {
            return view('du.arabic.front_end.not-found', compact('request'));
        }
    }

    public function get_product(Request $request)
    {
        $request['operator_id'] = Du_Bundle_Route;
        $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
        if (Post::where('operator_id', $request->operator_id)->exists()) {
            $api = $this->init()[0];
            $product = $api->view_prodcut_details($request);
            if ($product == -1)
                return view('du.arabic.front_end.not-found', compact('request'));
            $OtherProducts = $api->view_prodcut_linked($request);
            //dd($OtherProducts);
            if ($request["start"]) {
                $view = view('du.arabic.front_end.OtherProducts_load', compact('OtherProducts'))->render();
                return Response(array('html' => $view));
            }
            return view('du.arabic.front_end.product', compact('product', 'request', 'OtherProducts'));
        } else {
            return view('du.arabic.front_end.not-found', compact('request'));
        }
    }

    public function products_by_category(Request $request)
    {
        $request['operator_id'] = Du_Bundle_Route;
        $enable_test = DB::table('settings')->where('key', 'like', 'enable_test')->first()->value;
        if (Post::where('operator_id', $request->operator_id)->exists()) {
            $api = $this->init()[0];
            $products = $api->get_products_by_categories_V2($request);
            if ($request["start"]) {
                $view = view('du.arabic.front_end.category_load', compact('products'))->render();
                return Response(array('html' => $view, 'count' => count($products)));
            }
            if ($products == -1)
                return view('du.arabic.front_end.not-found', compact('request'));
            return view('du.arabic.front_end.category', compact('products', 'request'));
        } else {
            return view('du.arabic.front_end.not-found', compact('request'));
        }
    }

    public function search_view(Request $request)
    {
        $results = array();
        return view('du.arabic.front_end.search', compact('results', 'request'));
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
        return view('du.arabic.front_end.terms', compact('result', 'request'));
    }
    public function init()
    {
        $settings = array();
        $api = new DuCategoryController();
        $settings[0] = Setting::where('key', 'LIKE', '%website title%')->first();
        $settings[1] = Setting::where('key', 'LIKE', '%logo%')->first();
        $settings[2] = Setting::where('key', 'LIKE', '%facebook%')->first();
        $settings[3] = Setting::where('key', 'LIKE', '%twitter%')->first();
        return [$api, $settings];
    }

    public function du_landing(request $request)
    {
        $peroid = isset($request->peroid)  ?  $request->peroid  : "daily";
        $lang =  isset($request->lang) ? $request->lang : "ar";
        return view('du.arabic.landing_v2.du_landing', compact("peroid", "lang"));
    }

    public function du_landing_success()
    {
        date_default_timezone_set("Africa/Cairo");
        $URL = \Request::fullUrl();
        // make log
        $actionName = "DU SecureD Pincode Success";
        $parameters_arr = array(
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'URL' => $URL
        );
        $this->log($actionName, $URL, $parameters_arr);


        return view('du.arabic.landing_v2.du_landing_success');
    }

    public function cheeckSub($number,$service)
    {
       // Get cURL resource
       $curl = curl_init();
       // Set some options - we are passing in a useragent too here
       curl_setopt_array($curl, [
           CURLOPT_RETURNTRANSFER => 1,
           CURLOPT_URL => DU_CHECKSUB,
           CURLOPT_POST => 1,
           CURLOPT_POSTFIELDS => 'msisdn='.$number.'&serviceid='.$service,
       ]);
       // Send the request & save response to $resp
       $resp = curl_exec($curl);
       $res  = json_decode($resp);
       // Close request to clear up some resources
       curl_close($curl);

       return $res;
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


        require('uuid/UUID.php');
        $trxid = \UUID::v4();

        if (isset($_REQUEST['peroid']) && $_REQUEST['peroid'] != "") {
            $plan = $_REQUEST['peroid'];

            if ($plan  == "daily") {
                $serviceid = "waffarlydaily";
                $price = 2;
                $num = 1;
            } elseif ($plan  == "weekly") {
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

        $redirect =  url('/du_landing');

        if($this->cheeckSub($msisdn,$serviceid)){
            session(['MSISDN' => $msisdn, 'Status' => 'active','currentOp'=> du_operator_id]);
            return redirect($redirect);
        }

        // activation api :   http://pay-with-du.ae/20/digizone/digizone-flaterdaily-1-ar-doi-web?origin=digizone&uid=971555802322&trxid=56833e8d-c21b-453b-9e2a-f33f20415ae2&serviceProvider=secured&serviceid=flaterdaily&plan=daily&price=2&locale=ar
        //  f5d1048a-995e-11e7-abc4-cec278b6b50a
        //http://pay-with-du.ae/20/digizone/digizone-{$serviceid}-{$num}-{$local}-doi-web?
        // $URL = "http://pay-with-du.ae/20/digizone/digizone-{$serviceid}-{$num}-{$local}-doi-web?origin=digizone&uid=$msisdn&trxid=$trxid&serviceProvider=secured&serviceid=$serviceid&plan=$plan&price=$price&locale=$local&redirectUrl={$redirect}";

        $URL = "http://secure-payment.ae/digizone/{$serviceid}-{$num}-{$local}-doi-web?origin=digizone&uid=$msisdn&trxid=$trxid&serviceProvider=digizone&serviceid=$serviceid&plan=$plan&price=$price&locale=$local&redirectUrl={$redirect}";

        // make log
        $actionName = "DU SecureD Pincode Send";
        $parameters_arr = array(
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'URL' => $URL
        );
        $this->log($actionName, $URL, $parameters_arr);

        $DuIntgration =    new DuIntgration();
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

        $peroid = isset($request->peroid)  ?  $request->peroid  : "daily";
        $lang =  isset($request->lang) ? $request->lang : "ar";
        return view('du.arabic.landing_v2.du_unsub', compact("peroid", "lang"));
    }



    public function du_unsubcr(request $request)
    {
        $peroid = isset($request->peroid)  ?  $request->peroid  : "daily";
        $lang =  isset($request->lang) ? $request->lang : "ar";
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

    public function logout_web(Request $request)
    {
        Session::forget('MSISDN');
        Session::forget('currentOp');
        return redirect('/du_landing');
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
}
