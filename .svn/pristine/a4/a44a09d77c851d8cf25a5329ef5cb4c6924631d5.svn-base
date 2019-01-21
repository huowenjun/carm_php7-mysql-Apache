<?php
namespace app\admin\controller;

use app\admin\model\Role as RoleModel;
use app\admin\model\Menu as MenuModel;
use app\admin\model\SystemLog as SystemLogModel;
use token\App;
use think\Cache;
use think\Session;
class Controller extends \think\Controller
{
	protected $admin_info;
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
     * 后台初始化
     */
    public function _initialize()
    {
		// 登录信息
        $this->admin_info = Session::get('admin_info');
        $this->token = Session::get('token');
         // 系统配置信息信息
        if(!Session::get('baseinfo')){
        	$baseinfo = db('system_info')->column('values','keys');
        	Session::set('baseinfo',$baseinfo);
        }
        //市级城市缓存  
        if(!Cache::get('city_list')){
        	$city_list = db('cities')->field('area_code id,area_name text')->select();
        	Cache::set('city_list',$city_list);
        }
        $this->baseinfo = Session::get('baseinfo');
		// 当前路由信息
        $this->getRouteinfo();
		// 验证登录
        $this->checkLogin();
		// 全局layout
        $this->layout();
	}
	/**
     * 全局layout模板输出
     */
    private function layout()
    {
		$menu = $this->menu();
		$this->assign([
			'group' => $this->group,
			't_nav' => $menu['t_nav'],				// 后台导航
			't_menu' => $menu['t_menu'],			// 后台菜单
			'admin_info' => $this->admin_info,		// 登录信息
			'role_operation_ids' => $menu['role_operation_ids'],	// 权限组id
			'baseinfo' => $this->baseinfo,		// 系统配置信息
		]);
	}
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
     * 后台菜单配置
     * @return array
     */
    private function menu()
    {
		// 全部菜单
		if(Cache::has('data')) {
			$data = Cache::get('data');
			$t_data = Cache::get('t_data');
		}
		else{
			$data = MenuModel::all(function($query){
				$query->order('sort', 'asc');
			});
			$data = collection($data)->toArray();
			foreach($data as $v1){
				if($v1['pid']){
					$t_data[] = $v1;
				}
			}
			Cache::set('data', $data);
			Cache::set('t_data', $t_data);
		}
		$role_operation_ids = array();
		$admin_info = $this->admin_info;
		// 判定是否为管理员
		if($admin_info['id'] == 1){
			foreach($data as $vs){
				$role_operation_ids[] = $vs['id'];
			}
		}
		else{
			// 权限组
			if(Cache::has('Auth' . $admin_info['role_id'])){
				$role_operation_id = Cache::get('Auth' . $admin_info['role_id']);
				$role_operation_ids = explode(',', $role_operation_id);
			}
			else{
				$role_operation_id = RoleModel::where('id', $admin_info['role_id'])->value('operation_id');
				$role_operation_ids = explode(',', $role_operation_id);
				Cache::set('Auth' . $admin_info['role_id'], $role_operation_id);
			}
		}
		// dump($role_operation_ids);
		// die();
		$menu = !empty($data) ? \Tree::getTreeNoFindChild($data) : [];
		// 当前URL
		$currentUrl = 'admin' . '/' . $this->routeUri;
		$p_nav	= array();
		$p_menu = array();
		$t_nav 	= array();
		$t_menu = array();
		$c_menu = array();
		
		if($currentUrl === 'admin/index/index'){
			// 菜单顶部
			$t_nav[] = ['id'=>0, 'name'=>'首页', 'route'=>'/ad', 'selected'=>1];
			foreach($menu as $v2){
				if(in_array($v2['id'], $role_operation_ids)){
					$route = '/';
					if(!empty($v2['child'])){
						foreach($v2['child'] as $v3){
							if(!empty($v3['child'])){
								foreach($v3['child'] as $v10){
									if(in_array($v10['id'], $role_operation_ids)){
										$route = $v10['route'];
										break;
									}
								}
							}
							if($route != '/'){
								break;
							}
						}
					}
					$t_nav[] = ['id'=>$v2['id'], 'name'=>$v2['name'], 'route'=>$route, 'selected'=>0];
				}
			}
			// 菜单左侧
			
		}
		else{
			// 菜单顶部
			$found_key = array_search($currentUrl, array_column($data, 'url'));
			$p_nav = \Tree::getParents($data, $data[$found_key]['id']);
			$t_nav[] = ['id'=>0, 'name'=>'首页', 'route'=>'/ad', 'selected'=>0];
			// dump($menu);die;
			foreach($menu as $v2){
				if(in_array($v2['id'], $role_operation_ids)){
					$route = '/';
					if(!empty($v2['child'])){
						foreach($v2['child'] as $v3){
							if(!empty($v3['child'])){
								foreach($v3['child'] as $v10){
									if(in_array($v10['id'], $role_operation_ids)){
										$route = $v10['route'];
										break;
									}
								}
							}
							if($route != '/'){
								break;
							}
						}
					}
					if(is_numeric(array_search($v2['id'], array_column($p_nav, 'id')))){
						$t_nav[] = ['id'=>$v2['id'], 'name'=>$v2['name'], 'route'=>$route, 'selected'=>1];
						$c_menu = $v2['child'];
					}
					else{
						$t_nav[] = ['id'=>$v2['id'], 'name'=>$v2['name'], 'route'=>$route, 'selected'=>0];
					}
				}
				
			}
			// 菜单左侧
			$found_key = array_search($currentUrl, array_column($t_data, 'url'));
			$p_menu = \Tree::getParents($t_data, $t_data[$found_key]['id']);
			foreach($c_menu as $v4){
				if(in_array($v4['id'], $role_operation_ids)){
					$nAry = array();
					if(!empty($v4['child'])){
						foreach($v4['child'] as $v5){
							if(in_array($v5['id'], $role_operation_ids)){
								if(is_numeric(array_search($v5['id'], array_column($p_menu, 'id')))){
									$nAry[] = ['name'=>$v5['name'], 'route'=>$v5['route'], 'selected'=>1];
								}
								else{
									$nAry[] = ['name'=>$v5['name'], 'route'=>$v5['route'], 'selected'=>0];
								}
							}
						}
					}
					$t_menu[] = ['name'=>$v4['name'], 'icon'=>$v4['icon'], 'child'=>$nAry];
				}
			}
		}
		return array('t_nav'=>$t_nav, 't_menu'=>$t_menu, 'role_operation_ids'=>$role_operation_ids);
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
			$this->redirect('/system-login');
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
	// 添加系统日志
	protected function add_SystemLog($module = '', $actions = '', $contents = '')
	{
		$admin = $this->admin_info;
		$data['bid'] = $admin['id'];
		$data['c_name'] = $admin['admin_name'];
		$data['module'] = $module;
		$data['actions'] = $actions;
		$data['contents'] = $contents;
		$data['ctime'] = time();
		$model = new SystemLogModel;
		$model->allowField(true)->save($data);
	}
}