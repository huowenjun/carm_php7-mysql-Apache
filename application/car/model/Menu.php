<?php
namespace app\admin\model;

use think\Model;
class Menu extends Model
{
	protected $name = 'menu';
	protected $pk = 'id';
	public function allList()
	{
		$data = $this->order("sort ASC")->select();
		return $data;
	}
	
}