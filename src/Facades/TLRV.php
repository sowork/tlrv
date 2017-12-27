<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2017/12/27
 * Time: 16:29
 */

namespace Sowork\TLRV\Facades;


use Illuminate\Support\Facades\Facade;

class TLRV extends Facade
{

    protected static function getFacadeAccessor(){
        return 'tlrv';
    }

}