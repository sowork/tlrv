<?php

namespace Sowork\TLRV\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TLRVNodeSearch extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

//        var zNodes =[
//			{ id:1, pId:0, name:"父节点 1", open:true},
//			{ id:11, pId:1, name:"叶子节点 1-1"},
//			{ id:12, pId:1, name:"叶子节点 1-2"},
//			{ id:13, pId:1, name:"叶子节点 1-3"},
//			{ id:2, pId:0, name:"父节点 2", open:true},
//			{ id:21, pId:2, name:"叶子节点 2-1"},
//			{ id:22, pId:2, name:"叶子节点 2-2"},
//			{ id:23, pId:2, name:"叶子节点 2-3"},
//			{ id:3, pId:0, name:"父节点 3", open:true},
//			{ id:31, pId:3, name:"叶子节点 3-1"},
//			{ id:32, pId:3, name:"叶子节点 3-2"},
//			{ id:33, pId:3, name:"叶子节点 3-3"}
//		];

        return [
            'id' => $this->id,
            'pId' => $this->parent_id ?: '0',
            'name' => $this->node_key,
            'open' => $this->when($this->parent_id == null, true),
            'node_value' => $this->node_value,
            'node_uid' => $this->node_uid,
            'addition_data' => $this->addition ? $this->addition->addition_data : '' // optional 方法
        ];
    }
}
