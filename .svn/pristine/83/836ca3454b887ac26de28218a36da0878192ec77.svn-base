<?php
/**
 * Created by PhpStorm.
 * User: 霍文俊
 * Date: 2019/1/22
 * Time: 14:06
 */

namespace app\car\model;


use think\Model;
use traits\model\SoftDelete;

class Activity extends Model
{
    protected $name = 'activity_log';
    protected $pk = 'id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected function getTypeUAttr($value)
    {
        return config('activity_type')[$value];
    }

    protected function getCityAttr($value)
    {
        $city = Cache('city_list');
        foreach ($city as $k => $v) {
            if ($v['id'] == $value) {
                return $v['text'];
            }
        }
    }

    protected function getActivityTimeAttr($value)
    {
        return explode(" - ", $value);
    }

    /**
     * 活动列表
     * @param $page
     * @param $now_page
     * @param $where
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function allList($page, $now_page, $where)
    {
        $now_page = ($now_page - 1) * $page;
        $data = $this
            ->alias('log')
            ->field([
                'log.id',
                'log.activity_id',
                'log.sum_b_u',
                'log.sum_n_u',
                'sum_b_d_u',
                'sum_n_d_u',
                'sum_b_m_u',
                'sum_n_m_u',
                'type_u',
                'sum_b_day',
                'sum_n_day',
                'sum_b_month',
                'sum_n_month',
                'activity_info',
                'activity_time',
                'title'
            ])
            ->join('activity_to to', 'to.activity_id=log.activity_id')
            ->where($where)
            ->order('log.id DESC')
            ->limit($now_page, $page)
            ->select();
        $str='';
        foreach($data as $v){
            $str.=$v->activity_id.',';
        }
        $str = rtrim($str,',');
        $aData = db('activity_to')->where(['activity_id'=>['not in',$str],'delete_time'=>NULL])->select();
        foreach ($aData as $v){
            $v['title']=$v['title'];
            $v['sum_b_u']=0;
            $v['sum_n_u']=0;
            $v['sum_b_d_u']=0;
            $v['sum_n_d_u']=0;
            $v['sum_b_m_u']=0;
            $v['sum_n_m_u']=0;
            $v['type_u'] = config('activity_type')[$v['type']];
            $v['activity_time'] = explode(' - ',$v['activity_time']);
            $data[]=(object)$v;
        }
        return $data;
    }
}