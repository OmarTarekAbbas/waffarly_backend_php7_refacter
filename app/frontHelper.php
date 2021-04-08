<?php

use App\Setting;
use App\Category;
use App\Provider;
use App\Content;

if (! function_exists('setting')) {
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

function get_providers() {

    $providers = null;
    $providers = Provider::where('title', 'not like', '%دليل المسلم%')->get();
    return $providers;
}

function provider_service($id) {

    $services = $id;
    $services = Category::where('provider_id', $id)->get();
    return $services;
}

// function provider_content($id) {

//     $services = $id;
//     $services = Content::where('provider_id', $id)->get();
//     return $services;
// }

function general_service() {

    $generalProvider = Provider::where('title', 'like', '%دليل المسلم%')->first();
    $generalService = null;
    if ($generalProvider) {
        $generalService = Category::where('provider_id', $generalProvider->id)->get();
    }
    return $generalService;
}
