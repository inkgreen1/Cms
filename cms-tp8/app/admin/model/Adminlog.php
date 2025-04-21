<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Adminlog extends Model
{
    protected function admin(){
        return $this->belongsTo('Admin', 'admin_id')->bind(['admin_name'=>'nickname']);
    }
}
