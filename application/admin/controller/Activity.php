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
            $where['title'] = ['like', '%'.$get['title'] . '%'];
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
            $post = $this->postData();
            $bool = $this->obj->resave($post);
            if($bool){
                $msg=$post['title'];
                $action = '添加';
                if(empty($post['id'])){
                    $msg=$post['title'].'('.$post['Pname'].')';
                    $action = '修改';
                }
                $this->add_SystemLog('活动中心',$action,$msg);
                return ['ret' => 200, 'msg' => '操作成功'];
            }else{
                return ['ret' => 0, 'msg' => '操作失败'];
            }
        } else {
            $data = '';
            $get = $this->getData();
            if (isset($get['id'])) {
                $data = $this->obj->where(['id' => $get['id']])->find();
            }
            $city_list=Cache('city_list');//读取缓存市级列表
            return $this->fetch('', ['data' => $data,'city_list'=>$city_list,'type'=>$this->type]);
        }
    }

    /**
     * 删除
     */
    public function del()
    {
        if (request()->isAjax()) {
            $post = $this->postData();
            $bool = $this->obj->destroy($post['pkid']);
            $res = db('activity_to')->where(['activity_id'=>$post['pkid']])->find();
            if($res){
                db('activity_to')->where(['activity_id'=>$post['pkid']])->update(['delete_time'=>time()]);
            }
            if (!$bool) {
                return ['msg' => '删除失败'];
            }
            $this->add_SystemLog('活动中心', '删除', $post['beName']);
            return ['msg' => '删除成功'];
        } else {
            return ['ret' => 0, 'msg' => '非法请求'];
        }
    }
}