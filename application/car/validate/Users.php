<?php
namespace app\car\validate;

use think\Validate;
class Users extends Validate
{
    protected $rule = [
        'login_account'  => 'require|alphaNum|min:8|unique:users',
        'password' => 'require|min:8|confirm:repassword|checkNochs',
        'repassword' => 'require|min:8|confirm:password|checkNochs',
        'shop_name'  => 'require|max:20',
        'user_name'  => 'require|max:20',
        'user_tel'  => 'require|checkphone',
        'room_city'  => 'require',
        'market'  => 'require',
        'address'  => 'require|max:20',
    ];
    
    protected $message = [
        'login_account.require'  =>  '请输入登录账号',
        'login_account.alphaNum'  =>  '账号格式不正确',
        'login_account.min'  =>  '账号长度不能少于8位',
        'login_account.unique'  =>  '此账号已存在,请直接登录',
        'password.require' =>  '请输入登录密码',
        'password.min' =>  '密码不能少于8位',
        'password.confirm' =>  '两次输入密码不一致',
        'repassword.require' =>  '请输入重复登录密码',
        'repassword.confirm' =>  '两次输入密码不一致',
        'repassword.min' =>  '重复密码不能少于8位',
        'shop_name.require'  =>  '请输入店铺名称',
        'shop_name.max'  =>  '店铺名称字数限制20',
        'user_name.require'  =>  '请输入负责人名称',
        'user_name.max'  =>  '负责人名称字数限制20',
        'user_tel.require'  =>  '请输入联系电话',
        'room_city.require'  =>  '请选择城市',
        'market.require'  =>  '请选择市场',
        'address.require'  =>  '请输入详细地址',
        'address.max'  =>  '详细地址字数限制20',

    ];
    
    protected $scene = [
        'add'   =>  ['login_account','password','repassword'],
        'edit'  =>  ['password','repassword'],
        'first_edit'=> ['shop_name','user_name','user_tel','room_city','market','address']
    ];
    /*非中文汉字验证*/
     protected function checkNochs($value,$rule,$data)
    {
         $rule = '/[\x{4e00}-\x{9fa5}]/u';
        if (isset($this->regex[$rule])) {
            $rule = $this->regex[$rule];
        }
        if (0 !== strpos($rule, '/') && !preg_match('/\/[imsU]{0,4}$/', $rule)) {
            // 不是正则表达式则两端补上/
            $rule = '/^' . $rule . '$/';
        }
        $key = '';
        foreach ($data as $k => $v) {
            if($v == $value){
                $key = $k; 
            }
        }
         if($key == 'password'){
            $msg = "密码必须为非汉字";
        }elseif($key == 'repassword'){
            $msg = "重复密码必须为非汉字";
        }
         return preg_match($rule, (string) $value) === 1 ?$msg:true;
    }
    protected function checkphone($value,$rule,$data)
    {
         $rule = '/^1[3-9]{1}[0-9]{9}$/';
         $msg = '联系电话格式不正确';
         return preg_match($rule, (string) $value) === 1 ? true : $msg ;
    }
}