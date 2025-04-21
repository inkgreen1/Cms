<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\AdminController;

class Dashboard extends AdminController
{   
    /**
     * 面板统计
     *
     * @return void
     */
    public function datas()
    {
        $data = [
            [
                "title" => "文章数量",
                "count" => \app\admin\model\Content::count(),
                "icon" => "Tickets"
            ],
            [
                "title" => "待审核数量",
                "count" => \app\admin\model\Content::where('audit',0)->count(),
                "icon" => "Memo"
            ],
            [
                "title" => "管理员数量",
                "count" => \app\admin\model\Admin::count(),
                "icon" => "Histogram"
            ],
            [
                "title" => "分类数量",
                "count" => \app\admin\model\Category::count(),
                "icon" => "Operation"
            ]
        ];
        return success('',$data);
    }

    /**
     * 内容数量
     *
     * @return void
     */
    public function contentdatas()
    {
        $model = new \app\admin\model\Content;
        $data = [
            'values' => [
                ['value' => $model->where('audit',0)->count(), 'name' => '待审核'],
                ['value' => $model->where('audit',1)->count(), 'name' => '已审核'],
                ['value' => $model->where('audit',2)->count(), 'name' => '已拒绝'],
            ]
        ];
        return success('',$data);
    }

    /**
     * 一周内容数量
     *
     * @return void
     */
    public function weekdatas()
    {

        $weeks = ['周一','周二','周三','周四','周五','周六','周日'];
        $model = new \app\admin\model\Content;

        $weekStart = date('Y-m-d 00:00:00',strtotime('this week monday'));
        $weekEnd = date('Y-m-d 23:59:59',strtotime('this week sunday'));

        $datas = $model->whereBetweenTime('createtime',$weekStart,$weekEnd)
        ->field([
            'DATE_FORMAT(FROM_UNIXTIME(createtime),"%Y-%m-%d") as day',
            'DAYOFWEEK(FROM_UNIXTIME(createtime)) as weekday',
            'count(*) as count'
        ])
        ->group('day')
        ->select()->toArray();

        $counts = array_column($datas,'count','weekday');

        $values = [];
        foreach ($weeks as $key => $value) {
            $index =$key==6?1: $key+2;
            $values[] = isset($counts[$index])?$counts[$index] : 0;
        }


        return success('',[
            "keys"=>$weeks,
            "values"=>$values
        ]);
    }
}