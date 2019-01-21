<?php
namespace app\admin\model;
use think\Model;
use app\admin\model\Role as RoleModel;
class AdminRole extends Model
{
    protected $insert = ['id','ctime','utime'];
    protected $name="admin_role";
     protected $createTime = 'ctime';
    protected $updateTime = 'utime';
    protected function setCtimeAttr(){
        return time();
    }
    protected function setUtimeAttr(){
        return time();
    }
    /**
     * 分页
     * @param 搜索条件 $where array
     * @param 查询数据 $field  string
     * @param 单页数据量 $num int
     * @param 页面 $page int
    */
    public function PageList( $where = array() , $field = '*', $num = 10 , $page = 1){
        $list = $this->field($field)->where($where)->paginate($num,false,['query'=>request()->param()]);
        return $list;
    }
    public function edit($data)
    {
        return $this->allowField(true)->isUpdate(true)->save($data);
    }
    public function add($data)
    {
       return $this->allowField(true)->isUpdate(false)->save($data);

    }
    public function role_name()
    {
        return $this->hasOne('Role','role_id')->value('name');
    }
    protected function getRoleNameAttr($id){

        $model = new RoleModel;
        return $model->where('id',$id)->value('name');
    }
    // protected function SetDescribeAttr($text){
    //     return htmlspecialchars($text);
    // }
}