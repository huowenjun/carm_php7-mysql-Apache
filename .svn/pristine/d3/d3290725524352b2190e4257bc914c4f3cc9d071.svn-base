<?php
/**
 * 系列--车型
 * User: 霍文俊
 * Date: 2019/1/25
 * Time: 9:44
 */
namespace app\admin\model;
use think\Model;
use think\Request;
use traits\model\SoftDelete;

class Spec extends Model
{
    protected $name = 'spec';
    protected $pk = 'id';
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    /**
     * 系列--车型
     * @param $page
     * @param $where
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function allList($page,$where){
        $data = $this
            ->alias('s')
            ->field(['s.id','s.name s','s.type','se.name se'])
            ->join('series se','s.s_id=se.id')
            ->where($where)
            ->order('s.id DESC')
            ->paginate($page, false, [
                'query' => Request::instance()->request()
            ]);
        return $data;
    }
}