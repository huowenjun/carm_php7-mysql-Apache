<?php
namespace app\admin\model;

use think\Model;
use think\Request;
class SystemLog extends Model
{
	protected $name = 'system_log';
	protected $pk = 'id';
	public function allList($where = array(), $page = 15)
	{
		$data = $this->order('id DESC')
			->where($where)
			->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
		return $data;
	}
}