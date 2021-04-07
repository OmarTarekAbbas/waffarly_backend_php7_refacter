<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Content;
use App\Country;
use App\Operator;
use App\RbtCode;
use App\Provider;

use Validator;
use Auth;

class RbtController extends Controller
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
        $contents = Content::where('content_type_id', 4)->get();
        //dd($contents);
        return view('rbt.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contents  = Content::where('content_type_id', 4)->get();
        $operators = Operator::all();
        //$providers = Provider::all();
        $rbt      = NULL;
        return view('rbt.form', compact('contents', 'operators', 'rbt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'rbt_code' => 'required',
            'content_id' => 'required',
            'operator_id' => 'required'
        ]);
        //$content  = Content::create($request->all());
        $content = Content::findOrFail($request->content_id);
        $pro_id = $content->category->provider->id;
        $content->provider_id = $pro_id;

        foreach ($request->operator_id as  $key => $operator_id) {
            $content->rbt_operators()->attach([$operator_id => ['rbt_code' => $request->rbt_code[$key], 'provider_id' => $pro_id]]);
            // dd('here');
        }

        // $rbt = new RbtCode();
        // $rbt->rbt_code = $request->rbt_code[$key];
        // $rbt->content_id = $content->id;
        // $rbt->provider_id = $pro_id;
        // $rbt->operator_id = $request->operator_id[$key];
        // //dd($pro_id);
        // $rbt->save();


        \Session::flash('success', 'rbt created Successfully');
        return redirect('rbt/' . $request->content_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contents =  Content::whereId($id)->get();
        return view('rbt.index', compact('contents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $rbt = RbtCode::findOrFail($id);
        $contents = Content::where('content_type_id', 4)->get();
        $operators = Operator::all();
        return view('rbt.form', compact('rbt', 'contents', 'operators'));
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
            'rbt_code' => 'required',
            'content_id' => 'required',
            'operator_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $rbt = RbtCode::findOrFail($id);
        $content = Content::findOrFail($request->content_id);
        $rbt->update($request->all());

        \Session::flash('success', 'RbtCode Update Successfully');
        return redirect('rbt/' . $request->content_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $rbt = RbtCode::findOrFail($id);
        $rbt->delete();
        \Session::flash('success', 'RbtCode Delete Successfully');
        return back();
    }
}
