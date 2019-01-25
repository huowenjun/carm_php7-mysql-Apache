<?php
/**
 * Created by PhpStorm.
 * User: 霍文俊
 * Date: 2019/1/21
 * Time: 14:48
 */

namespace app\admin\model;


use think\Model;
use think\Request;
use traits\model\SoftDelete;
class Activity extends Model
{
    protected $name = 'activity';
    protected $pk = 'id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected function getTypeAttr($value){
        return config('activity_type')[$value];
    }
    protected function getActivityTimeAttr($value){
        return date('y-m-d H:i',$value);
    }
    protected function getActivityCityAttr($value){
        return db('cities')->field(['area_name'])->where(['area_code'=>$value])->find()['area_name'];
    }

    /**
     * 活动列表
     * @param $page
     * @param $where
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function allList($page,$where){
        $data = $this
            ->where($where)
            ->order('id DESC')
            ->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
        return $data;
    }
}