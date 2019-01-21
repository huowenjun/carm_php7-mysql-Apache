<?php
namespace app\index\controller;

use token\App;
use think\Cache;
use think\Session;
class Controller extends \think\Controller
{
	/* @var string $route 当前控制器名称 */
    protected $controller = '';

    /* @var string $route 当前方法名称 */
    protected $action = '';

    /* @var string $route 当前路由uri */
    protected $routeUri = '';
	
	/* @var string $route 当前路由：分组名称 */
    protected $group = '';
	
	/* @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'login/index',
        'login/verify',
    ];

	/**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);
        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;
    }

	/**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }
	
    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }
	
    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(0, $msg, $url, $data);
    }
	
    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData()
    {
        return $this->request->post();
    }
	// 获取get数组
	protected function getData()
    {
        return $this->request->get();
    }
	// 生成随机字符串
	protected function rand_string($len = 6)
	{
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
		return $str;
	}
}