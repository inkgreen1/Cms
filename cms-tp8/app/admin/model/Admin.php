<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Admin extends Model
{
    //

    protected function getLastlogintimeAttr($value){
        return $value?date('Y-m-d H:i:s', $value): $value;
    }
}
