<?php
/**
 * Created by PhpStorm.
 * User: 简配
 * Date: 2018/12/11
 * Time: 15:34
 */
namespace app\admin\model;
use think\Model;
use think\Request;
class System extends Model
{
    protected $name = 'system_info';
    protected $insert = ['id','ctime','utime'];
    protected $autoWriteTimestamp = true;
    protected function getCtimeAttr($time){
        return $time?date('Y-m-d H:i:s',$time):'';
    }
    protected function setValuesAttr($text){
        if(is_array($text)){
            return json_encode($text);
        }else{
            return htmlspecialchars($text);
        }

    }
    public function allList($page = 15)
    {
        $data = $this->order('id DESC')
            ->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
        return $data;
    }
    public function edit($data)
    {
        $data['last_time'] = time();
        return $this->allowField(true)->save($data);
    }
}