<?php
/**
 * Created by PhpStorm.
 * User: 霍文俊
 * Date: 2019/1/25
 * Time: 10:11
 */

namespace app\car\controller;


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
    public function listSpec(){
        $post = $this->postData();
        $where = array();
        if($post['s_id']!=0){
            $where['s_id']=$post['s_id'];
        }
        $data = $this->obj->field(['id','name','type'])->where($where)->select();
        $list2 = [];
        foreach ($data as $k => $v) {
            $list2[$v['type']]['key'] = $v['type'];
            $list2[$v['type']]['values'][] = $v;
        }
        return $this->renderSuccess('sucess',array_values($list2));
    }
}