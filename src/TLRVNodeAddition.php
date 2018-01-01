<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 2017/12/28
 * Time: 11:02
 */

namespace Sowork\TLRV;


use Illuminate\Database\Eloquent\Model;
use \Baum\Extensions\Eloquent\Model as BaumModel;
use Sowork\TLRV\Http\Interfaces\TLRVNodeAdditionInterFace;

class TLRVNodeAddition extends Model implements TLRVNodeAdditionInterFace
{
    protected $table = 'tlrv_node_additions';

    public $fillable = ['addition_data', 'node_id'];

    public static function addNodeAddition($node_id, $addition){
            $node = self::firstOrNew(['node_id' => $node_id]);
            $node->addition_data = empty($addition) ? '' : $addition;
            return $node->save();
    }
}