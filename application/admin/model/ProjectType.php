<?php
/**
 * Created by PhpStorm.
 * User: 简配
 * Date: 2018/12/12
 * Time: 14:33
 */

namespace app\admin\model;


use think\Model;
use think\Request;
class ProjectType extends Model
{
    protected $name = 'project_type';
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
        return $this->allowField(true)->isUpdate(true)->save($data);
    }
    public function add($data)
    {
        return $this->allowField(true)->isUpdate(false)->save($data);
    }
}