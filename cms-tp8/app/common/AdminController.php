<?php
declare (strict_types = 1);

namespace app\common;

use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class AdminController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;
    protected $user = null;
    protected $userid = null;
    protected $token = null;


    protected $field = '*';
    protected $withoutField = [];
    protected $allowField = [];
    protected $model = null;
    
    // 在添加或修改时,新增或处理的字段
    protected $modifyDatas = [];

    
    protected $adminLimit = false;
    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        trace('基类','error');
        $this->app     = $app;
        $this->request = $this->app->request;

        $this->userid = $this->request->uid;
        $this->token = $this->request->token;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
       
    }

    public function getUser()
    {
        return \app\admin\model\Admin::find($this->userid);
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, string|array $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    /**
     * 生成where条件
     *
     * @param Array $datas
     * @return void
     */
    protected function buildWhere(array $datas)
    {
        $where = [];
        if(!isset($datas["filter"])) return $where;
        foreach ($datas["filter"] as $key => $value) {
            if ($value !== '') {
                if (!is_string($value)) {
                    if (!isset($value["opt"])) {
                        if(empty($value)) continue;
                        $where[] = [$key, 'between', $value];
                    } else {

                        $opt = $value["opt"];
                        $val = $value["val"];
                        if ($val !== '') {
                            // like like% %like between in

                            switch ($opt) {
                                case 'like':
                                    $where[] = [$key, 'like', "%$val%"];
                                    break;
                                case 'like%':
                                    $where[] = [$key, 'like', "$val%"];
                                    break;
                                case '%like':
                                    $where[] = [$key, 'like', "%$val"];
                                    break;

                                case 'between':
                                case 'in':
                                    if (is_array($val)) {
                                        $where[] = [$key, $opt, $val];
                                    }
                                    break;
                                case 'date':
                                    $where[] = [$key, 'between time', [date('Y-m-d 00:00:00',strtotime($val)), date('Y-m-d 23:59:59', strtotime($val))]];
                                    break;
                                case 'daterange':
                                    // $where[] = [$key, 'between time', [strtotime($val[0]), strtotime($val[1])]];
                                    $where[] = [$key, 'between time', $val];
                                    break;
                                case 'datetime':
                                    $where[] = [$key, '=', strtotime($val)];
                                    break;

                                case 'find in set':
                                    $where[] = [$key, 'find in set', $val];
                                    break;

                                default:
                                    # code...
                                    break;
                            }
                        }
                    }
                } else {

                    $where[] = [$key, '=', $value];
                }
            }
        }
        return $where;
    }



    // 增删改查
    /**
     * 查看列表
     *
     * @return void
     */
    public function list()
    {
        $datas = input('post.');

        $where = $this->buildWhere($datas);

        if($this->adminLimit == 'personal'){
            $where["admin_id"] = $this->userid;
        }

        $order = [];
        if(isset($datas["order"]) && !empty($datas["order"])){
            // desc asc
            if($datas["order"]["order"] == 'descending'){
                $orderType = 'desc';
            }
            else{
                $orderType = 'asc';
            }
            $order = [
                $datas["order"]["prop"]=> $orderType
            ];
        }

        $obj = $this->model->where($where);
        if(empty($this->withoutField)){
            $obj->field($this->field);
        }
        else{
            $obj->withoutField($this->withoutField);
        }
        if(isset($datas["page"]) && isset($datas["limit"])){
            $list = $obj->order($order)->paginate();
            return success('', $list->items(),1, $list->total());
        }
        else{
            $list = $obj->order($order)->select();
            return success('', $list);
        }

    }


    /**
     * 添加
     *
     * @return void
     */
    public function add()
    {
        $datas = input('post.');
        if(in_array('admin_id', $this->allowField)){
            $datas["admin_id"] = $this->userid;
        }
        $datas = array_merge($datas,$this->modifyDatas);
        $res = $this->model->allowField($this->allowField)->save($datas);
        if ($res) {
            return success('创建成功');
        } else {
            return error('创建失败');
        }
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $datas = input('post.');

        $datas = array_merge($datas,$this->modifyDatas);
        $obj = $this->model->find($datas["id"]);
        $res = $obj->allowField($this->allowField)->save($datas);
        if ($res) {
            return success('更新成功');
        } else {
            return error('更新失败');
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        $id = input('id');
        if($this->adminLimit == 'personal'){
            if(!$this->model->where('id',$id)->where('admin_id',$this->userid)->find()){
                return error('无权删除');
            }
        }
        // if(is_array($id)){
        //     $obj = $this->model->whereIn('id',$id);
        // }
        // else{
        //     $obj = $this->model->find($id);
        // }        
        if ($this->model::destroy($id)) {
            return success('删除成功');
        } else {
            return error('删除失败');
        }
    }
}
