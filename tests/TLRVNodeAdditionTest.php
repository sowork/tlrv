<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2017/12/27
 * Time: 17:37
 */

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sowork\TLRV\TLRVNode;
use Sowork\TLRV\TLRVNodeAddition;

class TLRVNodeAdditionTest extends TestCase
{
//    use DatabaseTransactions;

    public function testAddNodeAddition(){

        $rootData = [
            'node_key' => '设置',
            'node_value' => '1001',
        ];
        $root = TLRVNode::create($rootData);

        $result = TLRVNodeAddition::addNodeAddition($root, 'add addition');
        $this->assertTrue($result);
    }


}