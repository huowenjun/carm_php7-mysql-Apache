<?php
namespace app\admin\controller;

use app\admin\model\Store as StoreModel;
class Store extends Controller
{
	// 门店列表
	public function index()
	{
		$model = new StoreModel;
		$where = array();
		$list = $model->allList($where);
		return $this->fetch('index', ['list'=>$list]);
	}
	// 增加门店
	public function add_store()
	{
		if($this->request->isAjax()){
			$model = new StoreModel;
			$post = $this->postData();
			$post['ctime'] = time();
			$r = $model->allowField(true)->save($post);
			if($r){
				$this->add_SystemLog('门店', '增加', $post['store_name']);
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
	// 修改门店
	public function update_store()
	{
		$model = new StoreModel;
		if($this->request->isAjax()){
			$post = $this->postData();
			$post['utime'] = time();
			$r = $model->allowField(true)->save($post, ['id'=>$post['pkid']]);
			if($r){
				$contents = $post['store_name'] === $post['beName'] ? $post['store_name'] : $post['store_name']." (".$post['beName'].") ";
				$this->add_SystemLog('门店', '修改', $contents);
				return ['ret'=>200, 'msg'=>'操作成功'];
			}
			else{
				return ['ret'=>0, 'msg'=>'操作失败'];
			}
		}
		else{
			$get = $this->getData();
			$list = $model->get($get['id']);
			return $this->fetch('update_store', ['list'=>$list]);
		}
	}
	// 删除门店
	public function delete_store()
	{
		if($this->request->isAjax()){
			$post = $this->postData();
			$model = new StoreModel;
			$model->destroy($post['pkid']);
			$this->add_SystemLog('门店', '删除', $post['beName']);
			return ['msg'=>'删除成功'];
		}
	}
}
