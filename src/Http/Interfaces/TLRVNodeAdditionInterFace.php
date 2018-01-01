<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2017/12/28
 * Time: 11:10
 */
namespace Sowork\TLRV\Http\Interfaces;

use Baum\Extensions\Eloquent\Model;

interface TLRVNodeAdditionInterFace
{
    public static function addNodeAddition($node_id, $addition);
}