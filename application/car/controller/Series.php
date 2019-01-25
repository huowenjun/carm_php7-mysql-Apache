<?php
/**
 * Created by PhpStorm.
 * User: 霍文俊
 * Date: 2019/1/25
 * Time: 9:11
 */

namespace app\car\controller;


use think\Request;
use \app\admin\model\Series as SeriesM;
class Series extends Controller
{
    public $obj;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->obj = new SeriesM();
    }

    public function listS()
    {
        $post = $this->postData();
        $where = array();
        if($post['b_id']!=0){
            $where['b_id']=$post['b_id'];
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