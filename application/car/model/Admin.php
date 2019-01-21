<?php
namespace app\admin\model;

use think\Model;
use think\Request;
class Admin extends Model
{
	protected $name = 'admin';
	protected $pk = 'id';
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