<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2017/12/27
 * Time: 17:37
 */

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sowork\TLRV\TLRVNodes;

class TLRVNodesTest extends TestCase
{
//    use DatabaseTransactions;

    public function testAddNode(){
        $res = TLRVNodes::create(['key' => 'root category']);
        dd($res);
    }
}