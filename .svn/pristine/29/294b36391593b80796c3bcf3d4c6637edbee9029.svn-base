<?php
/**
 * Created by PhpStorm.
 * User: 简配
 * Date: 2018/12/25
 * Time: 9:34
 */
namespace app\admin\model;

use think\Model;
use think\Request;
class UsersMoney extends Model
{
    // protected $table = '';
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