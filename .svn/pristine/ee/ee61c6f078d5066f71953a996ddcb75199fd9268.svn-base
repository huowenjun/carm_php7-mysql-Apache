<?php
/**
 * 系列
 * User: 霍文俊
 * Date: 2019/1/24
 * Time: 14:13
 */
namespace app\admin\model;

use think\Model;
use think\Request;
use traits\model\SoftDelete;

class Series extends Model
{
    protected $name = 'series';
    protected $pk = 'id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    /**
     * 品牌--系列
     * @param $page
     * @param $where
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function allList($page,$where){
        $data = $this
            ->alias('s')
            ->field(['s.id','s.name s','s.type','b.name b'])
            ->join('brand b','s.b_id=b.id')
            ->where($where)
            ->order('s.id DESC')
            ->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
        return $data;
    }
}