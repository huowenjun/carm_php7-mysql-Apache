<?php
namespace app\admin\controller;

use think\Cache;
use app\admin\model\Menu as MenuModel;
use app\admin\model\SystemLog as SystemLogModel;
class Systems extends Controller
{
	// 菜单列表
	public function menulist()
	{
		$model = new MenuModel;
		$data = collection($model->allList())->toArray();
		$list = !empty($data) ? \Tree::getTreeNoFindChild($data) : [];
		return $this->fetch('menulist', ['list'=>$list]);
	}
	// 增加菜单
	public function add_menu()
	{		
		$model = new MenuModel;
		if($this->request->isAjax()){
			$post = $this->postData();
			$r = $model->allowField(true)->save($post);
			if($r){
				$this->add_SystemLog('菜单', '增加', $post['name']);
				Cache::rm('data');
				return ['ret'=>200, 'msg'=>'操作成功'];
			}
			else{
				return ['ret'=>0, 'msg'=>'操作失败'];
			}
		}
		else{
			$data = collection($model->allList())->toArray();
			$list = !empty($data) ? \Tree::getTreeNoFindChild($data) : [];
			return $this->fetch("add_menu", ['list'=>$list]);
		}
	}
	// 修改菜单
	public function update_menu()
	{
		$model = new MenuModel;
		if($this->request->isAjax()){
			$post = $this->postData();
			$r = $model->allowField(true)->save($post, ['id'=>$post['pkid']]);
			if($r){
				Cache::rm('data');
				$contents = $post['name'] === $post['beName'] ? $post['name'] : $post['name']." (".$post['beName'].") ";
				$this->add_SystemLog('菜单', '修改', $contents);
				return ['ret'=>200, 'msg'=>'操作成功'];
			}
			else{
				return ['ret'=>0, 'msg'=>'操作失败'];
			}
		}
		else{
			$get = $this->getData();
			$data = collection($model->allList())->toArray();
			$lists = array();
			foreach($data as $v){
				if($v['id'] == $get['id']){
					$lists = $v;
					break;
				}
			}
			$list = !empty($data) ? \Tree::getTreeNoFindChild($data) : [];
			return $this->fetch("update_menu", ['list'=>$list, 'lists'=>$lists]);
		}
	}
	// 修改菜单排序
	public function update_sort()
	{
		if($this->request->isAjax()){
			$post = $this->postData();
			foreach($post as $k=>$v){
				if(!empty($_v = explode('_', $k))){
					$data[] = ['id'=>$_v[0], 'sort'=>$v];
				}
			}
			$model = new MenuModel;
			$model->saveAll($data);
			Cache::rm('data');
			$this->add_SystemLog('菜单', '排序', '菜单');
			return ['msg'=>'更新成功'];
		}
	}
	// 删除菜单
	public function delete_menu()
	{
		if($this->request->isAjax()){
			$post = $this->postData();
			$model = new MenuModel;
			$model->destroy($post['pkid']);
			Cache::rm('data');
			$this->add_SystemLog('菜单', '删除', $post['beName']);
			return ['msg'=>'删除成功'];
		}
	}
	// 系统日志
	public function system_log_lists()
	{
		$where = array();
		$get = $this->getData();
		if(!empty($get['name'])){
			$where['c_name'] = ['like', $get['name'] . '%'];
		}
		if(!empty($get['keys'])){
			$where['contents'] = ['like', $get['keys'] . '%'];
		}
		if(!empty($get['date'])){
			$date = explode(" - ", $get['date']);
			$where['ctime'] = [['gt', strtotime($date[0])], ['lt', strtotime($date[1])]];
		}
		$model = new SystemLogModel;
		$list = $model->allList($where, 20);
		return $this->fetch('system_log_lists', ['list'=>$list]);
	}
}
