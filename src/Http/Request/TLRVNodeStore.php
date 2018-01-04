<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2018/1/3
 * Time: 13:36
 */

namespace Sowork\TLRV\Http\Request;



use Illuminate\Foundation\Http\FormRequest;

class TLRVNodeStore extends FormRequest
{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'id' => 'required|integer',
            'node_key' => 'required|max:191',
        ];
    }

}