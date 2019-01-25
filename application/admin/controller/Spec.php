<?php
/**
 * 系列--车型
 * User: 霍文俊
 * Date: 2019/1/25
 * Time: 9:43
 */

namespace app\admin\controller;

use think\Request;
use \app\admin\model\Spec as SpecM;

class Spec extends Controller
{
    public $obj;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->obj = new SpecM();
    }

    /**
     * 属性--车型列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $where = array();
        $list = $this->obj->allList(PAGE, $where);
        return $this->fetch('', ['list' => $list]);
    }

    /**
     * 添加修改
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        if ($this->request->isAjax()) {
            $post = $this->postData();
            $data['s_id'] = $post['s_id'];
            $data['name'] = $post['name'];
            $data['type'] = $post['type'];
            if (isset($post['id'])) {//修改
                $data['utime'] = TIME;
                $bool = $this->obj->save($data, ['id' => $post['id']]);
                $action = '修改';
                $msg = $post['name'] . '(' . $post['Pname'] . ')';

            } else {//添加
                $data['ctime'] = TIME;
                $bool = $this->obj->save($data);
                $action = '添加';
                $msg = $data['name'];
            }
            if ($bool) {
                $this->add_SystemLog('车型', $action, $msg);
                return ['ret' => 200, 'msg' => '操作成功'];
            } else {
                return ['ret' => 0, 'msg' => '操作失败'];
            }
        } else {
            $get = $this->getData();
            $title = isset($get['id']) ? 1 : 0;
            $list = array();
            if ($title) {
                $list = $this->obj->where(['id' => $get['id']])->find();
            }
            //车型列表
            $b_list = db('series')->field(['id','name'])->order('id','desc')->select();
            return $this->fetch('', ['title' => $title, 'list' => $list,'b_list'=>$b_list]);
        }
    }

    /**
     * 数据删除
     * @return array
     */
    public function del()
    {
        if ($this->request->isAjax()) {
            $post = $this->postData();
            $bool = $this->obj->destroy($post['pkid']);
            if ($bool) {
                $this->add_SystemLog('系列车型', '删除', $post['beName']);
                return ['msg' => '删除成功'];
            } else {
                return ['ret' => 0, 'msg' => '删除失败'];
            }
        } else {
            return ['ret' => 0, 'msg' => '非法请求'];
        }
    }

    /*
     * 数据详情
     */
    public function info()
    {
        $id = $this->getData()['id'];
        $data = $this->obj
            ->alias('s')
            ->field(['s.id','s.name s','s.type','se.name se'])
            ->join('series se','s.s_id=se.id')
            ->where(['s.id' => $id])
            ->find();
        return $this->fetch('', ['data' => $data]);
    }
}