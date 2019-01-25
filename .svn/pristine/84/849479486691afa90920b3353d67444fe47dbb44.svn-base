<?php
/**
 * 参与活动
 * User: 霍文俊
 * Date: 2019/1/21
 * Time: 14:48
 */

namespace app\admin\model;


use think\Model;
use think\Request;
use traits\model\SoftDelete;
class ActivityLog extends Model
{
    protected $name = 'activity_log';
    protected $pk = 'id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';


//    protected function getCityAttr($value){
//        $city = Cache('city_list');
//        foreach($city as $k=>$v)
//        {
//            if($v['id']==$value){
//                return $v['text'];
//            }
//        }
//    }
    protected function getTypeUAttr($value){
        return config('activity_type')[$value];
    }
    /**
     * 参与活动
     * @param $page
     * @param $where
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function allList($page,$where){
        $data = $this
            ->alias('alog')
            ->field([
                'alog.id',
                'activity_id',
                'u.login_account',
                'sum_b_u',
                'sum_n_u',
                'sum_b_d_u',
                'sum_n_d_u',
                'sum_b_m_u',
                'sum_n_m_u',
                'type_u'
            ])
            ->join('users u','alog.u_id=u.id')
            ->where($where)
            ->order('alog.id DESC')
            ->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
        return $data;
    }

}