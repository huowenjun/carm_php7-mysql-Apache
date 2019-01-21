<?php
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use think\captcha\Captcha;
use think\Session;
use token\App;
class Login extends Controller
{
	public function index()
	{
		if($this->request->isAjax()){
			$post = $this->postData();
			$captcha = new Captcha();
			if(!$captcha->check($post['verify'], 2)){
                return ['ret' => -1, 'msg' => '图像验证码错误'];
            }
			$result = AdminModel::where(['admin_name'=>$post['user_name'], 'status'=>1])->find();
			if(empty($result)){
                return ['ret' => -1, 'msg' => '用户不存在'];
            }
			$inPWD = md5($post['password'] . $result['rand_str']);
			if($result['password'] == $inPWD){
				$result->edit(['ip'=>$this->request->ip()]);
				$token = App::get_access_token($result['id']);
				Session::set('token', $token);
				Session::set('admin_info', $result);
				return ['ret' => 200, 'msg' => '登录成功，跳转中...'];
			}
			else{
				return ['ret' => -1, 'msg' => '登录密码错误'];
			}
		}
		else{
			$this->view->engine->layout(false);
			return $this->fetch();
		}
	}
	public function logout()
    {
        Session::delete('token');
        Session::delete('admin_info');
        $this->redirect('/system-login');
    }
	public function verify()
    {
        $captcha = new Captcha(['fontSize'=>15, 'length'=>5, 'useCurve'=>false, 'useNoise'=>true]);
		$captcha->codeSet = '0123456789';
		return $captcha->entry(2);
    }
}
