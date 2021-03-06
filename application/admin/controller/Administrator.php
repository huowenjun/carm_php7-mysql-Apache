<?php
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\model\Role as RoleModel;
use app\admin\model\AdminRole as AdminRoleModel;
use think\Cache;
use think\Session;
class Administrator extends Controller
{
	public function _initialize()
    {
    	parent::_initialize(); // TODO: Change the autogenerated stub
    	// 二级市  列表 
    	$this->assign('city_list',Cache('city_list'));
    	// 职能列表
    	if(!GetCache('position_list')){
    		$position_list = db('role')->field('id,name')->order('level')->select();
    		SetCache('position_list',$position_list);
    	}
    	$this->assign('position_list',GetCache('position_list'));
    }
	// 管理员列表
	public function index()
	{
		$this->assign('pagetitle','员工管理');
		$model = new AdminModel;
		$post = request()->post();
		$where = [];
		if(!empty($post['uname'])){
			$where['uname'] = $post['uname'];
		}
		if(!empty($post['admin_name'])){
			$where['admin_name'] = $post['admin_name'];
		}
		if(!empty($post['tel'])){
			$where['tel'] = $post['tel'];
		}
		if(!empty($post['role_id'])){
			$where['role_id'] = $post['role_id'];
		}
		if(!empty($post['room_city'])){
			$where['room_city'] = $post['room_city'];
		}
		// $list = $model->where($where)->paginate();
		// dump($list);die;
		$admin_info = $this->admin_info;
		if($admin_info['room_city']){
			$where['room_city'] = $admin_info['room_city'];
		}
		// $where ['id'] = ['neq',$admin_info['id']];
		$list = $model->allList($where);
		// dump($list->toarray());die;
		return $this->fetch('index', ['list'=>$list,'search_list'=>$post]);
	}
	// 增加管理员
	public function add_member()
	{
		$this->assign('pagetitle','增加员工');
		$model = new AdminModel;
		$admin_role_model = new AdminRoleModel;
		if($this->request->isAjax()){
			$post = $this->postData();
			// return json($post);
			$v = $model->where('admin_name', $post['admin_name'])->find();
			if($v){
				return ['ret'=>0, 'msg'=>'重复的域账号'];
			}
			else{
				$data['rand_str'] = $this->rand_string();
				$data['password'] = md5($post['repassword'] . $data['rand_str']);
				$data['admin_name'] = $post['admin_name'];
				$data['uname'] = $post['uname'];
				$data['tel'] = $post['tel'];
				$data['uname'] = $post['uname'];
				$data['room_city'] = $post['room_city'];
				$data['role_id'] = RoleModel::where('id','in',$post['position_id'])->order('level ASC')->value('id');
				$model->startTrans();
				$admin_role_model->startTrans();
				$r = $model->allowField(true)->save($data);
				if($r){
					$data2 = [];
					foreach ($post['city-picker'] as $k => $v) {
						$data2[$k]['city_picker'] = $v;
						$data2[$k]['provinceId'] = $post['provinceId'][$k];
						$data2[$k]['cityId'] = $post['cityId'][$k];
						$data2[$k]['role_id'] = $post['position_id'][$k];
						$data2[$k]['admin_id'] = $model->id;
					}
					// return $data2;
					$ids = array_column($data2, 'role_id');
					return RoleModel::where(['id','in',$ids])->order('level DESC')->find();

					$r2 = $admin_role_model->saveAll($data2);
					
					$model->commit();
					if($r2){
						$admin_role_model->commit();
					}
					$this->add_SystemLog('员工', '增加', $data['admin_name']);
					return ['ret'=>200, 'msg'=>'操作成功'];
				}
				else{
					$model->rollback();
					$admin_role_model->rollback();
					return ['ret'=>0, 'msg'=>'操作失败'];
				}
			}
		}
		else{
			return $this->fetch();
		}
	}
	// 禁/开管理员
	public function disabled_admin($id, $status, $beName)
	{
		if($this->request->isAjax()){
			if($id == 1){
				return ['ret'=>0, 'msg'=>'不能禁用超级管理员'];
			}
			else{
				$model = new AdminModel;
				$r = $model->save(['status'=>$status], ['id'=>$id]);
				if($r){
					$this->add_SystemLog('员工', $status == 1 ? '开启' : '禁用', $beName);
					return ['ret'=>200, 'msg'=>'操作成功'];
				}
				else{
					return ['ret'=>0, 'msg'=>'操作失败'];
				}
			}
			
		}
	}
	// 修改 员工信息
	public function edit_member()
	{
		$model = new AdminModel;
		$admin_role_model = new AdminRoleModel;
		if($this->request->isAjax()){
			$admin = $this->admin_info;
			if($admin['id'] != 1){
				return ['ret'=>0, 'msg'=>'不能修改超级管理员'];
			}
			$post = $this->postData();
			
			// return json($post);

			$model->startTrans();
			$admin_role_model->startTrans();
			if($post['password'] === $post['repassword']){
				$v = $model->where('id', '<>', $post['id'])->where('admin_name', $post['admin_name'])->find();
				if($v){
					return ['ret'=>0, 'msg'=>'重复的域账号'];
				}
				else{
					$data['admin_name'] = $post['admin_name'];
					if(!empty($post['repassword']) && !empty($post['password'])){
						$data['rand_str'] = $this->rand_string();
						$data['password'] = md5($post['repassword'] . $data['rand_str']);
					}
					$data['uname'] = $post['uname'];
					$data['tel'] = $post['tel'];
					$data['uname'] = $post['uname'];
					$data['room_city'] = $post['room_city'];
					$data['role_id'] = RoleModel::where('id','in',$post['position_id'])->order('level ASC')->value('id');   // 权限以 级别最大为准
					$r = $model->save($data, ['id'=>$post['id']]);
					// return json($post);
					if($r !== false){
						$data2 = [];  //编辑的
						$data3 = [];  //新增的
						foreach ($post['admonrole_id'] as $k => $v) {
							if($v){
								$data2[$k]['id'] = $v;
								$data2[$k]['city_picker'] = $post['city-picker'][$k];
								$data2[$k]['provinceId'] = $post['provinceId'][$k];
								$data2[$k]['cityId'] = $post['cityId'][$k];
								$data2[$k]['role_id'] = $post['position_id'][$k];
								$data2[$k]['admin_id'] = $post['id'];
							}else{
								$data3[$k]['city_picker'] = $post['city-picker'][$k];
								$data3[$k]['provinceId'] = $post['provinceId'][$k];
								$data3[$k]['cityId'] = $post['cityId'][$k];
								$data3[$k]['role_id'] = $post['position_id'][$k];
								$data3[$k]['admin_id'] = $post['id'];
							}
							
						}
						// return $data3;
						$r2 = $admin_role_model->saveAll($data2);
						$r3 = $admin_role_model->saveAll($data3);
						
						$model->commit();
						if($r2 !== false || $r3 !== false){
							$admin_role_model->commit();
						}
						$contents = $post['admin_name'] === $post['beName'] ? $post['admin_name'] : $post['admin_name']." (".$post['beName'].") ";
						$this->add_SystemLog('员工', '修改', $contents);
						return ['ret'=>200, 'msg'=>'操作成功'];
					}
					else{
						$model->rollback();
						$admin_role_model->rollback();
						return ['ret'=>0, 'msg'=>'操作失败'];
					}
				}
			}
			else{
				return ['ret'=>0, 'msg'=>'两次密码不一致'];
			}
		}
		else{
			$get = $this->getData();
			$list = $model->get($get['id']);
			return $this->fetch('edit_member', ['list'=>$list]);
		}
	}
	public function destroy()
    {
        $model = new AdminModel;
        $admin_role_model = new AdminRoleModel;
		$model->startTrans();
		$admin_role_model->startTrans();
        if($this->request->isAjax())
        {
            $post = $this->getData();
            $info = $model->get($post['id']);
            if($post['id'] && $info){
            	
                $r = $model->destroy($post['id']);
                if($r){
                	$admin_role_model->where('admin_id',$post['id'])->delete();
                	$model->commit();
					$admin_role_model->commit();
                    $this->add_SystemLog('员工', '删除', $info['uname']?:'异常');
                    return ['ret'=>200, 'msg'=>'删除成功'];
                }
            }
        }else{
        	$model->rollback();
			$admin_role_model->rollback();
            return ['ret'=>401, 'msg'=>'请求错误'];
        }
    }
	// // 设置权限
	// public function assigning_role()
	// {
	// 	$model = new AdminModel;
	// 	if($this->request->isAjax()){
	// 		$post = $this->postData();
	// 		$model->save(['role_id'=>$post['roleId']], ['id'=>$post['pkid']]);
	// 		$this->add_SystemLog('员工', '设置权限', $post['beName']);
	// 		return ['ret'=>200, 'msg'=>'操作成功'];
	// 	}
	// 	else{
	// 		$roleModel = new RoleModel;
	// 		$get = $this->getData();
	// 		$list = $model->get($get['id']);
	// 		$roleList = $roleModel->all();
	// 		return $this->fetch('assigning_role', ['list'=>$list, 'roleList'=>$roleList]);
	// 	}
	// }
}
