<?php

namespace App\Http\Controllers;

use App\Content;
use App\Country;
use App\Http\Controllers\Controller;
use App\Operator;
use App\Post;
use App\Product;
use Auth;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->get_privilege();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(5)->all();
        // dd($contents);
        return view('post.index', compact('posts'));
    }

    public function allData()
    {
        if (isset($request->post_id)) {
            $posts = Content::find($request->post_id)->posts;
        } else {
            $posts = Post::all();
        }
        $datatable = \DataTables::of($posts)
            ->addColumn('index', function (Post $post) {
                return '<input class="select_all_template" type="checkbox" name="selected_rows[]" value="{{$content->id}}" class="roles" onclick="collect_selected(this)">';
            })
            ->addColumn('content', function (Post $post) {
                return $post->product->title;
            })
            ->addColumn('published_date', function (Post $post) {
                return $post->published_date;
            })
            ->addColumn('Status', function (Post $post) {
                if ($post->active) {
                    return 'active';
                } else {
                    return 'not active';
                }

            })
            ->addColumn('url', function (Post $post) {
                return '<td>
            <input type="text"  id="url_h' . $post->content_id . $post->id . '" value="' . $post->url . '">
            <span class="btn">' . Operator::find($post->operator_id)->country->title . '-' . Operator::find($post->operator_id)->name . '</span>
            <span class="btn" onclick="x = document.getElementById(' . "'url_h" . $post->content_id . $post->id . "'); x.select();document.execCommand('copy')" . '"> <i class="fa fa-copy"></i> </span>';
            })
            ->addColumn('user', function (Post $post) {
                return $post->user->name;
            })
            ->addColumn('action', function (Post $post) {
                return '<td class="visible-md visible-lg">
                        <div class="btn-group">
                            <a class="btn btn-sm show-tooltip" href="' . url("post/" . $post->id . "/edit") . '" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-sm show-tooltip btn-danger" onclick="return ConfirmDelete();" href="' . url("post/" . $post->id . "/delete") . '" title="Delete"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>';
            })
            ->escapeColumns([])
            ->make(true);

        return $datatable;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contents = Product::all();
        $operators = Operator::all();
        $post = null;
        return view('post.form', compact('contents', 'operators', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'published_date' => 'required|date',
            'product_id' => 'required',
            'active' => 'required',
            'operator_id' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

        $content = Product::findOrFail($request->product_id);

        foreach ($request->operator_id as $operator_id) {
            $operator = $content->operators()->attach([$operator_id => ['url' => url('view_content/' . $request->product_id . '?OpID=' . $operator_id),
                'published_date' => $request->published_date, 'active' => $request->active, 'user_id' => Auth::user()->id]]);
        }

        $posts = Post::where('product_id', $request->product_id)->whereIn('operator_id', $request->operator_id)->get();
        //$random = md5(uniqid($posts, true));
        $random = mt_rand(100000, 999999);
        //dd($random);
        foreach ($posts as $post) {
            Post::find($post->id)->update([
                'url' => url('view_content/' . $request->product_id . '?OpID=' . $post->operator_id),
            ]);
        }

        \Session::flash('success', 'post created Successfully');
        return redirect('products/'.$request->product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $operator =  Operator::findOrFail($id);
        // $place_id = [];
        // foreach ($operator->posts as $post) {
        //   array_push($place_id,$post->place_id);
        // }
        // $places = Content::whereIn('id',$place_id)->get();
        // return view('front.place_in_post' , compact('operator','places','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $contents = Product::all();
        $operators = Operator::all();
        return view('post.form', compact('post', 'contents', 'operators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'published_date' => 'required|date',
            'product_id' => 'required',
            'active' => 'required',
            'operator_id' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $input = $request->only('published_date', 'active', 'product_id');
            $post = Post::findOrFail($id);
            // $content = Content::findOrFail($request->product_id);
            $post->update($input+['operator_id' => $request->operator_id[0], 'url' => url('view_content/'.$request->product_id.'?OpID='.$request->operator_id[0]), 'user_id' => Auth::id()]);

        \Session::flash('success', 'Post Update Successfully');
        return redirect('products/'.$request->product_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        \Session::flash('success', 'Post Delete Successfully');
        return back();
    }
}
