<?php
namespace app\car\controller;

use app\admin\model\Users as UsersModel;
use app\admin\model\UsersMoney as UsersMoneyModel;
use app\admin\model\UsersInfo as UsersInfoModel;
use token\App;
use think\Session;
use think\Cache;
class Login extends Controller
{
	//注册
	public function registered(){
		if(request()->isPost()){
			$post = request()->post();
			$result = $this->validate($post,'Users.add');
			if(true !== $result){
			    // 验证失败 输出错误信息
			    return $this->renderError($result);
			}
			$model = new UsersModel;

			$data['rand_str'] = $this->rand_string();
			$data['password'] = md5($post['repassword'] . $data['rand_str']);
			$data['login_account'] = $post['login_account'];
			$data['code'] = $model->addcode();  //车商编号
			$r = $model->together('usermoney')->allowField(true)->isUpdate(false)->save($data);
			if($r){
				$data['token'] = $token = App::get_api_access_token($model->id);
				Session::set('car_api_token', $token);
				return $this->renderSuccess('注册成功,请登录',$data);
			}else{
				return $this->renderError('注册失败');
			}
		}else{
		 	return $this->renderError('请求错误###');
		}
	}
	// 登录
	public function login(){
		if(request()->isPost()){
			$post = request()->post();
			if(empty($post['login_account'])){
				return $this->renderError('请输入登录账号');
			}
			if(empty($post['password'])){
				return $this->renderError('请输入登录密码');
			}
			//依据账号查询数据，返回相应的数据
			$result = UsersModel::where(['login_account'=>$post['login_account']])
                ->field('id,password,status,review,start_time,end_time,rand_str,last_login_time')
                ->find();
			if(empty($result)){
                return json(['code' => 401, 'msg' => '账号或密码错误']);
            }else{
            	$inPWD = md5($post['password'] . $result['rand_str']);
				if($result['password'] == $inPWD){
					$msg['status'] = $this->status_validate($result['status']);
					$msg['review'] = $this->review_validate($result['review']);
					// ismaturity  fasle:账号未到期  true  账号到期或未开通，
					if(empty($result['start_time']) || empty($result['end_time'])){  //开通 -结束时间是否存在
						$msg['ismaturity'] = true;
					}else{
						if(time() >= $result['start_time'] && time() <= $result['end_time']){   // 当前时间是否在  开通结束的时间之内
							$msg['ismaturity'] = false;
						}else{
							$msg['ismaturity'] = true;
						}
					}
					// 账号状态正常或者  未注册完可以执行登录
					if($msg['status']['code'] == 201 || $msg['status']['code'] == 210 || $msg['review']['code'] == 101){
						$token = App::get_api_access_token($result['id']);
						Session::set('car_api_token', $token);
						$result->last_login_time = time();
						$result->utime = time();
						$result->save();
						// 判断最后的登录时间跟当前时间是否同一天  否 则  登录天数+1
						if(empty($result['last_login_time']) || (date('ymd',$result['last_login_time']) !== date('ymd',time()))){
							$result->setInc('login_days', 1);
						} 
						$data = UsersModel::where('id',$result['id'])->field('shop_name,user_name,img,level level_name,user_tel,user_tel user_tel_sta')->find();
						$data['token'] = $token;
						return json(['code' => 200, 'msg' => $msg,'data'=>$data]);
					}else{
						return json(['code' => 401, 'msg' => $msg]);
					}
				}else{
					return json(['code' => 401, 'msg' => '账号或密码错误']);
				}
            }
			if($r){
				return $this->renderSuccess('注册成功,请登录');
			}else{
				return $this->renderError('注册失败');
			}
		}else{
		 	return $this->renderError('请求错误###');
		}
	}
	// 编辑车商信息
	public function users_edit()
	{
		if(request()->isPost()){
			$post = request()->post();
			if(!cache($post['token'])){
				return $this->renderError('登录过期或已失效，请重新登录');
			}
			// echo $post['user_tel'];die;
			$result = $this->validate($post,'Users.first_edit');
			if(empty($post['img']) && empty($post['photo'])){
				return $this->renderError('请最少上传一张图片');
			}
			if(true !== $result){
			    // 验证失败 输出错误信息
			    return $this->renderError($result);
			}
			$where['id'] = cache($post['token']);
			$where['status'] = ['in',[0,1]];
			$userinfo = UsersModel::where($where)->find();
			// return json($userinfo);die;
			$userinfo->shop_name = $post['shop_name'];
			$userinfo->user_name = $post['user_name'];
			$userinfo->user_tel = $post['user_tel'];
			$userinfo->room_city = $post['room_city'];
			$userinfo->market = $post['market'];
			$userinfo->address = $post['address'];
			$userinfo->review = 1;  //待审核
			$userinfo->sta = 10;  //待审核
			$userinfo->img = $post['img'];
			$userinfo->photo = isset($post['photo']) ?:'';
			$r = $userinfo->save();
			if($r !== false){
				$model = new UsersModel;
				$data = $model->geteditinfo($where['id']);
				return $this->renderSuccess('提交成功',$data);
			}else{
				return $this->renderError('提交失败');
			}
		}else{
		 	return $this->renderError('请求错误###');
		}
	}
	/**审核状态，返回 状态描述
	*审核状态 1: 待审核  2审核通过  4审核未通过
	*/
	protected function review_validate($sta){
	
		switch ($sta) {
			case '0':
				$msg['code'] = 101;
				$msg['msg'] = '注册未完成';
				break;
			case '1':
				$msg['code'] = 105;
				$msg['msg'] = '账号还在审核中，请耐心等待';
				break;
			case '2':
				$msg['code'] = 108;
				$msg['msg'] = '账号审核已通过';
			case '4':
				$msg['code'] = 110;
				$msg['msg'] = '账号审核未通过，请联系销售';
				break;
			default:
				$msg['code'] = 444;
				$msg['msg'] = '账号状态非正常，请联系销售';
				break;
		}
		return $msg;
	}
	/**
	*账号状态返回 状态 和描述
	*账号状态 1：正常   3：到期  5：黑名单
	*/
	protected function status_validate($sta){
	
		switch ($sta) {
			case '0':
				$msg['code'] = 201;
				$msg['msg'] = '注册未完成';
				break;
			case '1':
				$msg['code'] = 210;
				$msg['msg'] = '账号状态正常';
				break;
			case '3':
				$msg['code'] = 214;
				$msg['msg'] = '会员已到期，请联系销售!';
			case '5':
				$msg['code'] = 225;
				$msg['msg'] = '账号已被拉入黑名单，请联系销售!';
				break;
			default:
				$msg['code'] = 444;
				$msg['msg'] = '账号状态非正常，请联系销售!';
				break;
		}
		return $msg;
	}

	// function checkNochs($value,$rule='',$data=[])
	
   //  {
   //      // $rule = '/[^\x{4e00}-\x{9fa5}]+$/u';
   //      $rule = '/[\x{4e00}-\x{9fa5}]/u';
   //      // return $rule;
   //      if (isset($this->regex[$rule])) {
   //          $rule = $this->regex[$rule];
   //      }
   //      if (0 !== strpos($rule, '/') && !preg_match('/\/[imsU]{0,4}$/', $rule)) {
   //          // 不是正则表达式则两端补上/
   //          $rule = '/^' . $rule . '$/';
   //      }
   //      $key = '';
   //      foreach ($data as $k => $v) {
   //      	// return $v;
   //      	if($v == $value){
   //      		$key = $k; 
   //      	}
   //      }
   //      // return $key;
   //       if($key == 'password'){
   //          $msg = "密码必须为非汉字";
   //      }elseif($key == 'repassword'){
   //          $msg = "重复密码必须为非汉字";
   //      }
   //      // return $msg;
   //       return preg_match($rule, (string) $value) === 1 ?$msg:true;
   //      // return preg_match($rule, (string) $value);
   //      // return is_scalar($value) && 0 === preg_match($rule, (string) $value);
   //  }
}
