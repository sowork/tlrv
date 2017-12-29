<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2017/12/27
 * Time: 17:10
 */

namespace Sowork\TLRV;


class TLRV
{

    public static $runsMigrations = true;


    /**
     * 配置yauth不使用默认迁移
     */
    public static function ignoreMigrations(){
        static::$runsMigrations = false;
    }

}