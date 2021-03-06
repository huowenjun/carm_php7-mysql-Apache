<?php
/**
 * 属性--品牌
 * User: 霍文俊
 * Date: 2019/1/24
 * Time: 10:25
 */

namespace app\admin\model;


use think\Model;
use think\Request;
use traits\model\SoftDelete;

class Brand extends Model
{
    protected $name = 'brand';
    protected $pk = 'id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    /**
     * 属性--品牌列表
     * @param $page
     * @param $where
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function allList($page,$where){
        $data = $this
            ->field(['id','img','name'])
            ->where($where)
            ->order('id DESC')
            ->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
        return $data;
    }
}