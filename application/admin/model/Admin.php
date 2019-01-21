<?php
namespace app\admin\model;

use think\Model;
use think\Request;
class Admin extends Model
{
	protected $name = 'admin';
	protected $pk = 'id';
	public function allList($where = array(),$page = 15)
	{
		$data = $this->where($where)->field('*,room_city room_city_name')->with('adminrole')->order('id DESC')
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
     public function adminrole()
    {
        return $this->hasMany('AdminRole','admin_id')->field('*,role_id role_name')->order('id');
    }
    protected function getRoomCityNameAttr($ids){
    	return db('cities')->where('area_code',$ids)->value('area_name');
    }
    
    // protected function getRoleNameAttr($id){
    //     // $model = new RoleModel;
    //     return db('role')->where('id',$id)->value('utime');
    // }
}