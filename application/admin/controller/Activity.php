<?php
/**
 * 活动中心
 * User: 霍文俊
 * Date: 2019/1/21
 * Time: 14:36
 */

namespace app\admin\controller;


use think\Request;
use \app\admin\model\Activity as ActivityM;

class Activity extends Controller
{
    private $type;
    private $obj;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->type = config('activity_type');
        $this->obj = new ActivityM();
    }

    /**
     * 活动中心列表
     * @return mixed
     */
    public function index()
    {
        $where = array();
        $get = $this->getData();
        if (!empty($get['title'])) {
            $where['title'] = ['like', $get['title'] . '%'];
        }
        if (!empty($get['date'])) {
            $date = explode(" - ", $get['date']);
            $where['activity_time'] = [['gt', strtotime($date[0])], ['lt', strtotime($date[1])]];
        }
        $data = $this->obj->allList(PAGE, $where);
        return $this->fetch('', ['list' => $data]);
    }

    public function info()
    {
        $id = $this->getData()['id'];
        $data = $this->obj->where(['id' => $id])->find();
        return $this->fetch('', ['data' => $data]);
    }

    /**
     * 编辑
     * @return mixed
     */
    public function edit()
    {
        if (request()->isAjax()) {

        } else {
            $data = '';
            $get = $this->getData();
            if (isset($get['id'])) {
                $data = $this->obj->where(['id' => $get['id']])->find();
            }
            return $this->fetch('', ['data' => $data]);
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        if (request()->isAjax()) {

        } else {

        }
    }
}