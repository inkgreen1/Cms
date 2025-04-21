<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Role extends Model
{
    public function setRulesAttr($data)
    {
      return $data?implode(',',$data):'';
    }

    public function ruleListArray()
    {
      $datas = $this->ruleListTree();
      $arr = [];
      foreach ($datas as $key => $value) {
        $arr[] = $value["rule"];
        if($value["children"]){
          foreach ($value["children"] as $k => $v) {
            $arr[] = $v["rule"];
          }
        }
      }
      return $arr;
    }

    public function ruleListObject()
    {
      $datas = $this->ruleListTree();
      $arr = [];
      foreach ($datas as $key => $value) {
        $arr[$value["rule"]] = $value["label"];
        if($value["children"]){
          foreach ($value["children"] as $k => $v) {
            $arr[$v["rule"]] =$value["label"]. ' - '. $v["label"];
          }
        }
      }
      return $arr;
    }

    public function ruleListTree()
    {
      return [
        [
            'rule' => '/content',
            'label' => "内容管理",
            'children' => [
                [
                    'rule' => '/content/list',
                    'label' => "查看",
                ],
                [
                    'rule' => '/content/add',
                    'label' => "发布",
                ],
                [
                    'rule' => '/content/edit',
                    'label' => "修改",
                ],
                [
                    'rule' => '/content/del',
                    'label' => "删除",
                ],
                [
                    'rule' => '/content/changeaudit',
                    'label' => "审核",
                ],
                [
                    'rule' => '/content/changestatus',
                    'label' => "状态",
                ],
                [
                  'rule' => '/content/getcontent',
                  'label' => "获取内容",
                ],
            ],
        ],
        [
            'rule' => "/role",
            'label' => "权限管理",
            'children' => [
                [
                    'rule' => "/role/list",
                    'label' => "角色查看",
                ],
                [
                    'rule' => "/role/add",
                    'label' => "角色创建",
                ],
                [
                    'rule' => "/role/edit",
                    'label' => "角色修改",
                ],
                [
                    'rule' => "/role/del",
                    'label' => "角色删除",
                ],
            ],
        ],
        [
            'rule' => "/adminuser",
            'label' => "管理员管理",
            'children' => [
                [
                    'rule' => "/adminuser/list",
                    'label' => "查看",
                ],
                [
                    'rule' => "/adminuser/add",
                    'label' => "创建",
                ],
                [
                    'rule' => "/adminuser/edit",
                    'label' => "修改",
                ],
                [
                    'rule' => "/adminuser/del",
                    'label' => "删除",
                ],
            ],
        ],
        [
            'rule' => "/cate",
            'label' => "分类管理",
            'children' => [
                [
                    'rule' => "/cate/list",
                    'label' => "查看",
                ],
                [
                    'rule' => "/cate/add",
                    'label' => "创建",
                ],
                [
                    'rule' => "/cate/edit",
                    'label' => "修改",
                ],
                [
                    'rule' => "/cate/del",
                    'label' => "删除",
                ],
                [
                  'rule' => "/cate/pidlist",
                  'label' => "父分类列表",
              ],
            ],
        ],
        [
            'rule' => "/system",
            'label' => "系统管理",
            'children' => [
                [
                    'rule' => "/system/site",
                    'label' => "站点管理",
                ],
                [
                    'rule' => "/system/site/logo",
                    'label' => "站点logo",
                ],
                [
                    'rule' => "/system/site/status",
                    'label' => "站点状态",
                ],
                [
                    'rule' => "/site/getinfo",
                    'label' => "获取站点信息",
                ],
                [
                    'rule' => "/site/save",
                    'label' => "修改站点信息",
                ],
                [
                    'rule' => "/system/files",
                    'label' => "附件管理",
                ],
                [
                    'rule' => "/system/files/list",
                    'label' => "附件列表",
                ],
                [
                    'rule' => "/system/files/del",
                    'label' => "附件删除",
                ],
                [
                    'rule' => "/system/adminlog",
                    'label' => "管理员日志管理",
                ],
                [
                    'rule' => "/system/adminlog/list",
                    'label' => "管理员日志列表",
                ],
                [
                    'rule' => "/system/adminlog/del",
                    'label' => "管理员日志删除",
                ],
            ],
        ],
      ];
    }
}
