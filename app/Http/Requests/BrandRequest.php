<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BrandRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'image' => 'required|mimes:jpeg,jpg,png',
                        'brand_name' => 'required|min:3|unique:brands'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'brand_name' => 'required',
                        
                    ];
                }
            default:break;
        }
    }

}
