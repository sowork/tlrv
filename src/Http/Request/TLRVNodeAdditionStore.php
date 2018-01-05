<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2018/1/3
 * Time: 13:36
 */

namespace Sowork\TLRV\Http\Request;



use Illuminate\Foundation\Http\FormRequest;

class TLRVNodeAdditionStore extends FormRequest
{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'id' => 'required|integer',
            'node_value' => 'max:191',
            'node_uid' => 'max:191',
        ];
    }

}