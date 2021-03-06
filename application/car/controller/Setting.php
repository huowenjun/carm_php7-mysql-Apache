<?php
namespace app\car\controller;

use token\App;
use think\Session;
use think\Cache;
class Setting extends Controller
{
	// //二级城市列表
	// public function cities_list()
	// {
		
	// 	return $this->renderSuccess('sucess',Cache::get('car_city_list'));
	
	// }
	// 手车市场列表
	public function market_list(){
		if(request()->isPost()){

			$cache_key = 'car_api_market_list';
			$post = request()->post();
			$result = $this->validate(
			    $post,
			    [
			        'token'  => 'require',
			        'id'   => 'require',
			    ],
				[
			        'token.require'  => '请先登录',
			        'id.require'   => '请先选择城市',
			    ]
			);
			if(true !== $result){
			    return $this->renderError($result);
			}
			$where['room_city'] = $post['id'];
			$where['status'] = 1;
			$list = db('market')->where($where)->field('id,name text,py')->order('py')->select();
            $list2 = [];
			foreach ($list as $k => $v) {
                $list2[$v['py']]['key'] = $v['py'];
                $list2[$v['py']]['values'][] = $v;
            }
			return $this->renderSuccess('sucess',array_values($list2));
		}else{
		 	return $this->renderError('请求错误###');
		}
	}	
	//一级城市
	public function province_list()
	{
		if(request()->isPost()){
			$post = request()->post();
			$type = isset($post['type']) == 1?$post['type']:2;
			$cache_key = 'car_api_province_list';
			if(!GetCache($cache_key)){
				$list = db('citys')->field('code id,name text,qname texts,initial')->where('type',1)->order('initial ASC')->select();
				SetCache($cache_key,$list,3600*24*7);
			}
			$list = GetCache($cache_key);
			if($type == 1){
				$cache_key2 = 'car_api_province_lists';
				if(!GetCache($cache_key2)){
					$list2 = [];
					foreach ($list as $k => $v) {
						$list2[$v['initial']]['key'] = $v['initial'];
						$list2[$v['initial']]['values'][] = $v;
					}
					$list2 = array_values($list2);
					SetCache($cache_key2,$list2,3600*24*7);
				}
				return $this->renderSuccess('sucess',GetCache($cache_key2));
			}else if($type == 2){
				return $this->renderSuccess('sucess',$list);
			}
		}else{
		 	return $this->renderError('请求错误###');
		}
	}
	//二级城市
	public function cities_list()
	{
		if(request()->isPost()){
			$where ['type'] = 2;
			$post = request()->post();
			if(!empty(isset($post['id']))){
				$where ['parentCode'] = $post['id'];
			}
			$list = db('citys')->field('code id,name text,qname texts')->where($where)->order('initial ASC')->select();
			return $this->renderSuccess('sucess',$list);
		}else{
		 	return $this->renderError('请求错误###');
		}
		
	}
	// 三级城市
	public function areas_list()
	{
		if(request()->isPost()){
			$where ['type'] = 3;
			$post = request()->post();
			$where ['parentCode'] = $post['id'];
			$list = db('citys')->field('code id,name text,qname texts')->where($where)->order('initial ASC')->select();
			return $this->renderSuccess('sucess',$list);
			return $this->renderSuccess('sucess',Cache::get('car_city_list'));
		}else{
		 	return $this->renderError('请求错误###');
		}
	
	}
}