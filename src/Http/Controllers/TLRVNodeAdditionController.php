<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2017/12/29
 * Time: 14:16
 */

namespace Sowork\TLRV\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sowork\TLRV\TLRVNode;
use Sowork\TLRV\TLRVNodeAddition;

class TLRVNodeAdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function search(){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('id');
        $node = TLRVNode::find($id);
        try {
            $res = true;
            DB::transaction(function () use ($node, $id, $request) {
                $node->fill($request->only('node_value', 'node_uid'))->save();
                TLRVNodeAddition::addNodeAddition($id, $request->input('addition_data'));
            });
        }catch (\Exception $e){
            $res = false;
        }finally{
            return response()->json([
                'code' => $res ? '0' : '-1',
                'msg' => $res ? '保存成功' : '保存失败',
                'data' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}