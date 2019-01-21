<?php
/**
 * Created by PhpStorm.
 * User: 简配
 * Date: 2018/12/11
 * Time: 15:15
 */

namespace app\admin\controller;
use app\admin\model\System as SystemModel;
use think\Session;
class System extends Controller
{
//    function save_systemconfig(){
//        $model = new SystemModel;
//        $where = array();
//        $list = $model->allList($where);
//        return $this->fetch('index', ['list'=>$list]);
//    }
    function systemconfig_index(){
        $this->assign('pagetitle','系统配置列表');
        $model = new SystemModel;
        $where = array();
        $list = $model->allList($where);
        return $this->fetch('index', ['list'=>$list]);
    }
    function add_systemconfig(){
        $this->assign('pagetitle','添加系统配置');
        if($this->request->isAjax()){
            $model = new SystemModel;
            $post = $this->postData();
            $post['ctime'] = time();
            $post['utime'] = time();
            $r = $model->allowField(true)->save($post);
            if($r){
                $baseinfo = db('system_info')->column('values','keys');
                Session::set('baseinfo',$baseinfo);  //配置有变更，更新缓存信息
                $this->add_SystemLog('系统配置', '增加', $post['name']);
                return ['ret'=>200, 'msg'=>'操作成功'];
            }
            else{
                return ['ret'=>0, 'msg'=>'操作失败'];
            }
        }
        else{
            return $this->fetch();
        }
    }
    function update_systemconfig($id){
        $this->assign('pagetitle','编辑系统配置');
        $model = new SystemModel;
        if($this->request->isAjax()){
            $post = $this->postData();
            $post['utime'] = time();
            $r = $model->allowField(true)->isUpdate(true)->save($post);
            if($r !== false){
                $baseinfo = db('system_info')->column('values','keys');
                Session::set('baseinfo',$baseinfo);  //配置有变更，更新缓存信息
                $this->add_SystemLog('系统配置', '编辑', $post['name']);
                return ['ret'=>200, 'msg'=>'操作成功'];
            }
            else{
                return ['ret'=>0, 'msg'=>'操作失败'];
            }
        }
        else{
            $info = $model->find($id);
            return $this->fetch('',['info'=>$info]);
        }
    }
}