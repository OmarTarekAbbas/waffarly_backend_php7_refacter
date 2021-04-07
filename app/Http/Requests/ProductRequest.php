<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [] ;
            }
            case 'POST':
            {
                return [
                    'product_image' => 'required|mimes:jpeg,jpg,png',
                    'category_id'   => 'required' ,
                    'brand_id'      => 'required',
                 //   'title'          => 'required|unique:products'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'category_id'   => 'required' ,
                    'brand_id'      => 'required' ,
                  //  'title'         => 'required|unique:products,title,'.$this->route()->getParameter('products')
                ];
            }
            default:break;
        }

    }
}
