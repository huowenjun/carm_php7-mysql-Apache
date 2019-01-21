<?php
namespace app\admin\model;
// 市场管理
use think\Model;
use think\Request;
class Market extends Model
{
    protected $insert = ['id','ctime','utime'];
    protected $pk = 'id';
     protected function setCtimeAttr(){
        return time();
    }
    protected function setUtimeAttr(){
        return time();
    }
    public function GetAllList()
    {
        return $this->all();
    }
	public function allList($where = array(),$page = 20)
	{
		$data = $this->where($where)->field('*,room_city room_city_name,start_time start_time_date')->order('id DESC')
			->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
		return $data;
	}
	public function add($data)
    {
        return $this->allowField(true)->isUpdate(false)->save($data);
    }
    public function edit($data)
    {
        return $this->allowField(true)->isUpdate(true)->save($data);
    }

    protected function getRoomCityNameAttr($ids){
        return db('cities')->where('area_code',$ids)->value('area_name');
    }
    protected function getStartTimeDateAttr($time){
        // return db('cities')->where('area_code',$ids)->value('area_name');
        return $time?date('Y-m-d H:i',$time):'';
    }
}