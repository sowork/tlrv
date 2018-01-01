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
use Sowork\TLRV\Http\Resources\TLRVNodeSearch;
use Sowork\TLRV\TLRVNode;
use Sowork\TLRV\TLRVNodeAddition;

class TLRVNodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('tlrv::tlrv-node');
    }

    public function search(){
        $nodes = TLRVNode::roots()->get();
        $temp = [];
        foreach ($nodes as $node){
            $tree = $node->descendantsAndSelf()->with('addition')->get();
            $temp = array_merge($temp, TLRVNodeSearch::collection($tree)->resource->toArray());
        }

        return response()->json([
            'code' => '0',
            'msg' => '查询成功',
            'data' => $temp
        ]);
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
        //
        $data = $request->all();
        if(empty($data['id'])){
            $node = TLRVNode::create($request->only(['node_key', 'node_value']));
        }else{
            $node = TLRVNode::find($data['id'])->children()->create($request->only(['node_key', 'node_value']));
        }

        return response()->json([
            'code' => $node->exists ? '0' : '-1',
            'msg' => $node->exists ? '添加成功' : '添加失败',
            'data' => $node->exists ? $node : ''
        ]);
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
        $node = TLRVNode::find($id);
        echo $node->moveToLeftOf($request->input('tar_id'));
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
        $node = TLRVNode::where('id', $id)->first();
        $res = false;
        if($node){
            $del_nodes = $node->getDescendantsAndSelf();
            DB::beginTransaction();
            try{
                if($del_nodes){
                    $del_ids = array_column($del_nodes->toArray(), 'id');
                    TLRVNodeAddition::whereIn('node_id', $del_ids)->delete();
                }
                $node->delete($id);
                $res = true;
            }catch (\Exception $e){
                $res = false;
                DB::rollBack();
            }finally{
                DB::commit();
            }
        }

        return response()->json([
            'code' => $res ? '0' : '-1',
            'msg' => $res ?  '操作成功' : '操作失败',
            'data' => ''
        ]);
    }
}