<?php
namespace app\admin\model;

use think\Model;
use think\Request;
class UsersInfo extends Model
{
    protected $insert = ['id','ctime','utime'];
    protected $createTime = 'ctime';
    protected $updateTime = 'utime';
    protected function setCtimeAttr(){
        return time();
    }
    protected function setUtimeAttr(){
        return time();
    }
}