<?php
namespace app\admin\controller;

use think\Cache;
use app\admin\model\Menu as MenuModel;
use app\admin\model\Role as RoleModel;
use app\admin\model\Admin as AdminModel;
class Role extends Controller
{
	// 角色列表
	public function roleList()
	{
		$model = new RoleModel;
		$list = $model->allList();
		return $this->fetch('roleList', ['list'=>$list]);
	}
	// 增加角色
	public function add_role()
	{
		if($this->request->isAjax()){
			$post = $this->postData();
			$post['utime'] = time();
			$model = new RoleModel;
			$r = $model->allowField(true)->save($post);
			if($r){
				$this->add_SystemLog('角色', '增加', $post['name']);
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
	// 修改角色
	public function update_role()
	{
		$model = new RoleModel;
		if($this->request->isAjax()){
			$post = $this->postData();
			$post['utime'] = time();
			$r = $model->allowField(true)->save($post, ['id'=>$post['pkid']]);
			if($r){
				$contents = $post['name'] === $post['beName'] ? $post['name'] : $post['name']." (".$post['beName'].") ";
				$this->add_SystemLog('角色', '修改', $contents);
				return ['ret'=>200, 'msg'=>'操作成功'];
			}
			else{
				return ['ret'=>0, 'msg'=>'操作失败'];
			}
		}
		else{
			$get = $this->getData();
			$list = $model->get($get['id']);
			return $this->fetch('update_role', ['list'=>$list]);
		}
	}
	// 授权
	public function auth_group()
	{
		$model = new RoleModel;
		if($this->request->isAjax()){
			$post = $this->postData();
			$post['utime'] = time();
			$r = $model->allowField(true)->save($post, ['id'=>$post['pkid']]);
			if($r){
				Cache::rm('Auth' . $post['pkid']);
				Cache::set('Auth' . $post['pkid'], $post['operation_id']);
				$this->add_SystemLog('角色', '授权', $post['beName']);
				return ['ret'=>200, 'msg'=>'授权成功'];
			}
			else{
				return ['ret'=>0, 'msg'=>'授权失败'];
			}
		}
		else{
			$get = $this->getData();
			// $AdminModel = new AdminModel;
			// $list = $AdminModel->get($get['id']);
			$list = $model->get($get['id']);
			return $this->fetch('auth_group', ['list'=>$list]);
		}
	}
	public function role_tree()
	{
		$post = $this->postData();
		$RoleModel = new RoleModel;
		$role = $RoleModel->get($post['pkid']);
		$roles = explode(',', $role['operation_id']);
		$model = new MenuModel;
		$allData = MenuModel::all(function($query){
			$query->order('sort', 'asc');
		});
		$allData = collection($allData)->toArray();
		$menu = !empty($allData) ? \Tree::getTreeNoFindChild($allData) : [];
		$data = array();
		foreach($menu as $v1){
			$nAry1 = array();
			if(!empty($v1['child'])){
				foreach($v1['child'] as $v2){
					$nAry2 = array();
					if(!empty($v2['child'])){
						foreach($v2['child'] as $v3){
							$nAry3 = array();
							if(!empty($v3['child'])){
								foreach($v3['child'] as $v4){
									$nAry3[] = ['id'=>$v4['id'], 'title'=>$v4['name'], 'isLast'=>!empty($v4['child']) ? false : true, 'level'=>4, 'parentId'=>$v4['pid'], 'checkArr'=>[['type'=>0, 'isChecked'=>in_array($v4['id'], $roles) ? 1 : 0]]];
								}
							}
							$nAry2[] = ['id'=>$v3['id'], 'title'=>$v3['name'], 'isLast'=>!empty($v3['child']) ? false : true, 'level'=>3, 'parentId'=>$v3['pid'], 'checkArr'=>[['type'=>0, 'isChecked'=>in_array($v3['id'], $roles) ? 1 : 0]], 'children'=>$nAry3];
						}
					}
					$nAry1[] = ['id'=>$v2['id'], 'title'=>$v2['name'], 'isLast'=>!empty($v2['child']) ? false : true, 'level'=>2, 'parentId'=>$v2['pid'], 'checkArr'=>[['type'=>0, 'isChecked'=>in_array($v2['id'], $roles) ? 1 : 0]], 'children'=>$nAry2];
				}
			}
			$data[] = ['id'=>$v1['id'], 'title'=>$v1['name'], 'isLast'=>!empty($v1['child']) ? false : true, 'level'=>1, 'parentId'=>0, 'checkArr'=>[['type'=>0, 'isChecked'=>in_array($v1['id'], $roles) ? 1 : 0]], 'children'=>$nAry1];
		}
		return json(['status'=>['code'=>200, 'message'=>'获取成功'], 'data'=>$data]);
	}
}
