<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\Yaml\Tests\B;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller {

    public function __construct() {
        if (!file_exists('uploads/brands_images')) {
            mkdir('uploads/brands_images', 0777, true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('brands.addbrand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request) {
        $brand = new Brand($request->all());
        $file = $request->file('image');
        $destinationFolder = "uploads/";
        $uniqID = uniqid();
        $brand['image'] = 'brands_images/' . $uniqID . "." . $file->getClientOriginalExtension();
        $file->move($destinationFolder.'/brands_images/', $uniqID . "." . $file->getClientOriginalExtension());
        $brand->save();
        \Session::flash('success', 'Brand Added Successfully');
        return redirect('brands');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $brand = Brand::findOrFail($id);
        return view('brands.editbrand', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id) {
        $check = Brand::where('brand_name', $request['brand_name'])->where('id', '!=', $id)->get();
        if (count($check) > 0) {
            \Session::flash('failed', 'This brand Already exists');
            return redirect('brands');
        }
        $oldBrand = Brand::findOrFail($id);
        $newBrand = $request->all();
        $destinationFolder = "uploads/";
        $imgExtensions = array("png", "jpeg", "jpg", "gif", "PNG");
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', 'Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..');
                return redirect('brands');
            }
            $uniqueID = uniqid();
            $file->move($destinationFolder.'/brands_images/', $uniqueID . "." . $file->getClientOriginalExtension());
            $newBrand['image'] = 'brands_images/' . $uniqueID . "." . $file->getClientOriginalExtension();
            if (file_exists($oldBrand['image'])) {
                Storage::delete($oldBrand['image']);
            }
        } else {
            $newBrand['image'] = $oldBrand['image'];
        }
        $oldBrand->update($newBrand);
        \Session::flash('success', 'Brand Updated successfully');
        return redirect('brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $brand = Brand::find($id);
        if (file_exists($brand['image']))
            Storage::delete($brand['image']);
        Brand::destroy($id);
        \Session::flash('success', 'Brand Deleted successfully');
        return redirect('brands');
    }

}
