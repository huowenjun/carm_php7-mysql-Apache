<?php
namespace app\admin\model;

use think\Model;
use think\Request;
class Store extends Model
{
	protected $name = 'store';
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