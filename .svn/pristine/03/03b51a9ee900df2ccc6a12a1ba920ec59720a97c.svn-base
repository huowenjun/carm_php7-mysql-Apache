<?php
namespace app\admin\model;

use think\Model;
use think\Request;
class Role extends Model
{
	protected $name = 'role';
	protected $pk = 'id';
	public function allList($page = 15)
	{
		$data = $this->order('id DESC')
			->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
		return $data;
	}
}