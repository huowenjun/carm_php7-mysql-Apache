<?php
/**
 * 活动中心
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
    protected function getCityAttr($value){
        $city = Cache('city_list');
        foreach($city as $k=>$v)
        {
            if($v['id']==$value){
                return $v['text'];
            }
        }
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
            ->field(['id','title','activity_time','city','sum_people','sum_b','type'])
            ->where($where)
            ->order('id DESC')
            ->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
        return $data;
    }

    public function resave($data=false){
        if(isset($data['id'])&&$data['id']!=''){//修改
            unset($data['Pname']);
            $data['utime']=TIME;
            $bool = $this->save($data, ['id' => $data['id']]);
            if($bool){
                db('activity_to')
                    ->where(['activity_id'=>$data['id']])
                    ->update([
                        'sum_b_day'=>$data['sum_b_day'],
                        'sum_n_day'=>$data['sum_n_day'],
                        'sum_b_month'=>$data['sum_b_month'],
                        'sum_n_month'=>$data['sum_n_month'],
                        'city'=>$data['city'],
                        'type'=>$data['type'],
                        'activity_info'=>$data['activity_info'],
                        'activity_time'=>$data['activity_time'],
                        'utime'=>$data['utime'],
                        'title'=>$data['title']
                    ]);

            }
        }else{
            unset($data['id']);
            unset($data['Pname']);
            $data['ctime'] = TIME;
            $bool = $this->getLastInsID($this->save($data));
            if($bool){
                db('activity_to')->insert([
                    'activity_id'=>$bool,
                    'sum_b_day'=>$data['sum_b_day'],
                    'sum_n_day'=>$data['sum_n_day'],
                    'sum_b_month'=>$data['sum_b_month'],
                    'sum_n_month'=>$data['sum_n_month'],
                    'city'=>$data['city'],
                    'type'=>$data['type'],
                    'activity_info'=>$data['activity_info'],
                    'activity_time'=>$data['activity_time'],
                    'ctime'=>$data['ctime'],
                    'title'=>$data['title']
                ]);
            }
        }//添加
        return $bool;
    }
}