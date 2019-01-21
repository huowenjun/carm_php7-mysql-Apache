<?php
/**
 * Created by PhpStorm.
 * User: 简配
 * Date: 2018/12/12
 * Time: 11:17
 */

namespace app\admin\model;


use think\Model;

class CaseHome extends Model
{
    protected $insert = ['id','ctime','utime'];
    protected $name="case";
     protected $createTime = 'ctime';
    protected $updateTime = 'utime';
    protected function setCtimeAttr(){
        return time();
    }
    protected function setUtimeAttr(){
        return time();
    }
    /**
     * 分页
     * @param 搜索条件 $where array
     * @param 查询数据 $field  string
     * @param 单页数据量 $num int
     * @param 页面 $page int
    */
    public function PageList( $where = array() , $field = '*', $num = 10 , $page = 1){
        $list = $this->field($field)->where($where)->paginate($num,false,['query'=>request()->param()]);
        return $list;
    }
}