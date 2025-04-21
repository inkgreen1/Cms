<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\model\concern\SoftDelete;

use think\Model;

/**
 * @mixin \think\Model
 */
class Content extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deletetime';

    protected $type = [
        'audit' => 'integer',
        'status' => 'integer',
    ];

    protected function setTagAttr($value)
    {
        return $value && is_array($value) ? implode(',', $value) : $value;
    }

    protected function getTagAttr($value):array
    {
      return $value?explode(',', $value): [];
    }
    
    protected function category(){
        return $this->belongsTo('Category', 'category_id')->bind(['category_text'=>'name']);
    }
}
