<?php
namespace app\car\controller;
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
	public function _initialize()
    {
        header('Access-Control-Allow-Origin:*');
        // 登录信息
        $this->token = request()->post('token');
        // $this->token = Session::get('car_api_token');
        // //市级城市缓存  
        if(!Cache::get('car_city_list')){
            $car_city_list = db('cities')->field('area_code id,area_name text')->limit(15)->select();
            Cache::set('car_city_list',$car_city_list);
        }
        // 当前路由信息
        $this->getRouteinfo();
        // 验证登录
        $this->checkLogin();
    }
	/* @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        //登录页面
        'login/login',
        'login/registered',
        // 'setting/province_list',
        // 'setting/cities_list',
        // 'setting/market_list',

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
     * 验证登录状态
     */
    private function checkLogin()
    {
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }
        // 验证登录状态
        $islogin = App::get_islogin($this->token);
        
        if(!$islogin){
            die(json_encode(['code'=>401,'请先登录'],JSON_UNESCAPED_UNICODE));
            return false;
        }
        return true; 
        
    }
	/**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $data = [])
    {
        return json(compact('code', 'msg','data'));
    }
	
    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $data = [])
    {
        return $this->renderJson(1, $msg, (object)$data);
    }
	
    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $data = [])
    {
        return $this->renderJson(0, $msg, (object)$data);
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