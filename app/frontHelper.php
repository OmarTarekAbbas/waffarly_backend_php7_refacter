<?php

use App\Brand;
use App\Category;
use App\Country;
use App\Operator;
use App\Provider;
use App\Setting;

if (!function_exists('setting')) {
    /**
     * Method setting
     *
     * @param string $key
     *
     * @return string
     */
    function setting($key)
    {
        $data = \DB::table('settings')->where('key', 'like', '%' . $key . '%')->first();
        return $data ? $data->value : '';
    }
}

function get_providers()
{

    $providers = null;
    $providers = Provider::where('title', 'not like', '%دليل المسلم%')->get();
    return $providers;
}

function provider_service($id)
{

    $services = $id;
    $services = Category::where('provider_id', $id)->get();
    return $services;
}

// function provider_content($id) {

//     $services = $id;
//     $services = Content::where('provider_id', $id)->get();
//     return $services;
// }

function general_service()
{

    $generalProvider = Provider::where('title', 'like', '%دليل المسلم%')->first();
    $generalService = null;
    if ($generalProvider) {
        $generalService = Category::where('provider_id', $generalProvider->id)->get();
    }
    return $generalService;
}

function Etisalat()
{
    $country = Country::where('title', 'egypt')->first();
    if (!empty($country)) {
        $op = Operator::where('country_id', $country->id)->where('name', 'etisalat')->first();
        if (!empty($op)) {
            return $op->id;
        }
    }
    return 4;
}

function categories()
{
    $categories = Category::get(['id', 'title']);
    return $categories;
}

function brands()
{
    $brands = Brand::get(['id', 'brand_name']);
    return $brands;
}

function etisalat_crypt($string, $action = 'e')
{

    $output = false;
    $encrypt_method = "aes-128-cbc";
    $key = 'IV98723000ZDFrtx';
    $iv = str_repeat(chr(0), 16);

    if ($action == 'e') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    } else if ($action == 'd') {
        $output = openssl_decrypt($string, $encrypt_method, $key, 0, $iv);
        $output_array = explode("&user", $output);
        $output = $output_array[1];
    }

    return $output;
}
