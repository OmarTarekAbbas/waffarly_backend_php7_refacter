<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('products.listproducts');
    }

    public function allData()
    {

        $products = Product::with('category')->with('brand')->selectRaw('products.*,REPLACE(REPLACE(active, "1", "Yes") , "0", "No") AS active,REPLACE(REPLACE(featured, "1", "Yes") , "0", "No") AS featured,DATE_FORMAT(show_date, "%d-%m-%Y") as show_date')->get();
        // dd($products);
        return \DataTables::of($products)
            ->addColumn('title', function (Product $product) {
                return $product->title;

            })
            ->addColumn('product_image', function (Product $product) {
                return '<img src="'.url("uploads/".$product->product_image).'" class="img-circle" width="160px" height="160px">';

            })
            ->addColumn('active', function (Product $product) {
                if($product->active == "Yes")
                return '<span class="label label-success">Yes</span>';
                else
                return '<span class="label label-danger">No</span>';

            })
            ->addColumn('featured', function (Product $product) {
                if($product->featured == "Yes")
                return '<span class="label label-success">Yes</span>';
                else
                return '<span class="label label-danger">No</span>';

            })
            ->addColumn('category', function (Product $product) {
                return $product->category->title;
            })
            ->addColumn('brand', function (Product $product) {
                return $product->brand->brand_name;
            })

            ->addColumn('action', function(Product $product) {

                $value = $product;
                return view('products.c_inner', compact('value'))->render();
            })
            ->escapeColumns([])
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id');
        $brands = Brand::pluck('brand_name', 'id');
        return view('products.product', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product($request->all());
        $product['show_date'] = Carbon::createFromFormat('d/m/Y', $request['show_date'])->toDateTimeString();
        $product['expire_date'] = Carbon::createFromFormat('d/m/Y', $request['expire_date'])->toDateTimeString();
        $brand = Brand::Find($request->brand_id);
        $category = Category::Find($request->category_id);
        $product['title'] = $category->title . " - " . $brand->brand_name;
        $file = $request->file('product_image');
        $destinationFolder = "uploads/";
        $uniqID = uniqid();
        $product['product_image'] = 'products_images/' . $uniqID . "." . $file->getClientOriginalExtension();
        $file->move($destinationFolder . '/products_images/', $uniqID . "." . $file->getClientOriginalExtension());
        \Session::flash('success', 'Product added successfully');
        $product->save();
        return redirect('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $content = Product::findOrFail($id);
    //   dd($content);
      return view('products.show_post',compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::pluck('title', 'id');
        $brands = Brand::pluck('brand_name', 'id');
        return view('products.editproduct', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $check = Product::where('title', $request['title'])->where('id', '!=', $id)->get();
        if (count($check) > 0) {
            \Session::flash('failed', 'this product already exists');
            return redirect('products');
        }
        $imgExtensions = array("png", "jpeg", "jpg", "gif", 'PNG');
        $newProduct = $request->all();
        $oldProduct = Product::findOrFail($id);
        $destinationFolder = "uploads/";
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', 'Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..');
                return redirect('products');
            }
            $uniqueID = uniqid();
            $file->move($destinationFolder . '/products_images/', $uniqueID . "." . $file->getClientOriginalExtension());
            $newProduct['product_image'] = 'products_images/' . $uniqueID . "." . $file->getClientOriginalExtension();
            if (file_exists($oldProduct['product_image'])) {
                Storage::delete($oldProduct['product_image']);
            }
        } else {
            $newProduct['product_image'] = $oldProduct['product_image'];
        }
        $newProduct['show_date'] = Carbon::createFromFormat('d/m/Y', $request['show_date'])->toDateTimeString();
        $newProduct['expire_date'] = Carbon::createFromFormat('d/m/Y', $request['expire_date'])->toDateTimeString();
        $brand = Brand::Find($request->brand_id);
        $category = Category::Find($request->category_id);
        $newProduct['title'] = $category->title . " - " . $brand->brand_name;
        $oldProduct->update($newProduct);
        \Session::flash('success', 'Product Updated successfully');
        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (file_exists($product['product_image'])) {
            Storage::delete($product['product_image']);
        }

        Product::destroy($id);
        \Session::flash('success', 'post deleted successfully');
        return redirect('products');
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->restore();
        \Session::flash('success', 'Product Restored');
        return redirect('products');
    }

    public function deleteForever($id)
    {
        $product = Product::onlyTrashed()->find($id);
        Storage::delete($product['product_image']);
        $product->forceDelete();
        \Session::flash('success', 'Product Deleted');
        return redirect('products');
    }

    public function get_posts($id)
    {
        $product = Product::findOrFail($id);
        $posts = $product->posts;
        return view('posts.post', compact('posts'));
    }

    public function getDeleteOld()
    {

        return view('products.delproduct');
    }

    public function postDeleteOld(Request $request)
    {

        $date = date_create_from_format('d/m/Y', $request->form_date);
        $products = Product::where('show_date', '<=', $date)->get();
        // dd($products);
        foreach ($products as $product) {
            if (file_exists($product['product_image']))
            //  Storage::delete($product['product_image']);
            {
                Product::where('id', $product->id)->update(array('active' => 0));
            }

        }
        \Session::flash('success', 'Products Archived Successfully');
        return redirect('products');
    }

    public function createPatch(Request $request)
    {
        $brandID = null;
        if ($request->brand_id) {
            $brandID = $request->brand_id;
        }
        $categories = Category::pluck('title', 'id');
        $brands = Brand::pluck('brand_name', 'id');
        return view('products.multiUpload', compact('categories', 'brands', 'brandID'));
    }

    public function UploadPatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        //read file
        $path = $request->file('file')->getRealPath();
        $data = \Excel::load($path, function ($reader) {

        })->get();
        if (!empty($data) && $data->count()) {
            $v = 0;
            $i = 0;
            foreach ($data as $key => $value) {
                if (empty($value->path)) {
                    $v++;
                } else {
                    $i++;
                    $product = new Product($request->all());
                    $product['show_date'] = Carbon::createFromFormat('d/m/Y', $request['show_date'])->toDateTimeString();
                    $product['expire_date'] = Carbon::createFromFormat('d/m/Y', $request['expire_date'])->toDateTimeString();
                    $brand = Brand::Find($request->brand_id);
                    $category = Category::Find($request->category_id);
                    $product['title'] = $category->title . " - " . $brand->brand_name;
                    $product['product_image'] = $value->path;
                    $product->save();
                }
            }
        }
        \Session::flash('done', 'Your Data has successfully imported');
        //\Session::flash('valid', 'Your Data has ' . $i . ' Valid Record');
        /*if ($v > 0) {
        \Session::flash('unvalid', 'Your Data has ' . $v . ' Unvalid Record');
        }*/

        return redirect('products');
    }

    public function template_excel()
    {
        \Excel::create('ImportTemplate', function ($excel) {

            // Set the title
            $excel->setTitle('Import Template File');
            $data = ["path"];
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($data, null, 'A1');
            });
        })->download('xlsx');
    }

}

