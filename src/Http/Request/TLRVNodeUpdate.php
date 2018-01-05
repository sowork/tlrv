<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2018/1/3
 * Time: 13:36
 */

namespace Sowork\TLRV\Http\Request;



use Illuminate\Foundation\Http\FormRequest;

class TLRVNodeUpdate extends FormRequest
{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'type' => 'required|in:inner,prev,next,update',
            'tar_id' => 'integer',
            'node_key' => 'max:191',
        ];
    }

}