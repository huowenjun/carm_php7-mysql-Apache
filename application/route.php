<?php

use think\Route;

// 定义路由规则
Route::rule('/', 'index/index/index');//首页
Route::rule('ad', 'admin/index/index');//首页
Route::rule('cache', 'admin/index/cache');//首页
Route::rule('upImages', 'admin/upload/upimages');//上传图片
Route::rule('CupImages', 'admin/upload/co_upimages');//上传图片
Route::rule('baseImage', 'admin/upload/base64');//上传图片
Route::rule('system-login', 'admin/login/index');//登录
Route::rule('system-verify', 'admin/login/verify');//验证码
Route::rule('system-logout', 'admin/login/logout');//登出
Route::rule('system-menulist', 'admin/systems/menulist');//菜单列表
Route::rule('system-addmenu', 'admin/systems/add_menu');//增加菜单
Route::rule('system-updateMenu', 'admin/systems/update_menu');//修改菜单
Route::rule('system-updateSort', 'admin/systems/update_sort');//更新菜单排序
Route::rule('system-deleteMenu', 'admin/systems/delete_menu');//删除菜单
//员工管理
Route::rule('adminmember', 'admin/administrator/index');//管理员列表
Route::rule('addmember', 'admin/administrator/add_member');//增加管理员
Route::rule('disabledAdmin', 'admin/administrator/disabled_admin');//禁/启管理员
Route::rule('editmember', 'admin/administrator/edit_member');//修改员工
Route::rule('AssRole', 'admin/administrator/assigning_role');//设置权限
Route::rule('delmember', 'admin/administrator/destroy');//删除员工

//只能管理
Route::rule('roleList', 'admin/role/roleList');//授权角色
Route::rule('addRole', 'admin/role/add_role');//增加角色
Route::rule('upRole', 'admin/role/update_role');//修改角色
Route::rule('authGroup', 'admin/role/auth_group');//授权角色
Route::rule('roleTree', 'admin/role/role_tree');//获取授权菜单
Route::rule('systemLogLists', 'admin/systems/system_log_lists');//系统日志
Route::rule('storeManagement', 'admin/store/index');//门店列表
Route::rule('addStore', 'admin/store/add_store');//增加门店
Route::rule('upStore', 'admin/store/update_store');//修改门店
Route::rule('delStore', 'admin/store/delete_store');//删除门店
Route::rule('system-config', 'admin/system/systemconfig_index');//系统设置-编辑页面
Route::rule('addSystem', 'admin/system/add_systemconfig');//系统设置-添加
Route::rule('upSystem', 'admin/system/update_systemconfig');//系统设置-编辑
//主页

//服务类型
Route::rule('ServiceType', 'admin/service_type/index');//服务类型-列表
Route::rule('addService', 'admin/service_type/add');//服务类型-添加
Route::rule('upService', 'admin/service_type/update');//服务类型-编辑
Route::rule('deService', 'admin/service_type/destroy');//服务类型-删除
//市场管理
Route::rule('Market', 'admin/market/index');//市场管理-列表
Route::rule('addMarket', 'admin/market/add');//市场管理-添加
Route::rule('upMarket', 'admin/market/update');//市场管理-编辑
Route::rule('staMarket', 'admin/market/toggle');//市场管理-删除

//项目类型
Route::rule('ProjectType', 'admin/project_type/index');//项目类型-列表
Route::rule('addProject', 'admin/project_type/add');//项目类型-添加
Route::rule('upProject', 'admin/project_type/update');//项目类型-编辑
Route::rule('deProject', 'admin/project_type/destroy');//项目类型-删除

// 车商管理
Route::rule('CarDealer', 'admin/users/index');//车商-列表
Route::rule('addCarDealer', 'admin/users/add');//车商-添加
Route::rule('upCarDealer', 'admin/users/update');//车商-编辑
Route::rule('deCarDealer', 'admin/users/destroy');//车商-删除
Route::rule('CarDealerShenhe', 'admin/users/shenhe'); //车商审核
// 车源管理
Route::rule('CarSource', 'admin/car_source/index');//车源-列表
Route::rule('addCarSource', 'admin/car_source/add');//车源-添加
Route::rule('upCarSource', 'admin/car_source/update');//车源-编辑
Route::rule('deCarSource', 'admin/car_source/destroy');//车源-删除
//维保查询
Route::rule('CarInquire', 'admin/inquire/index');//车源-删除
/**
 * 活动中心
 * @user:hwj
 */
Route::rule('indexActivity', 'admin/activity/index');//活动中心列表
Route::rule('infoActivity', 'admin/activity/info');//活动中心详情
Route::rule('editActivity', 'admin/activity/edit');//活动中心增加--修改
Route::rule('delActivity', 'admin/activity/del');//活动中心删除

/**
 * 参与活动
 * @user:hwj
 */
Route::rule('indexAcl', 'admin/activity_log/index');//活动中心列表
Route::rule('infoAcl', 'admin/activity_log/info');//活动中心详情

/**
 * 属性--品牌
 * @user:hwj
 */
Route::rule('indexBrand', 'admin/brand/index');
Route::rule('editBrand', 'admin/brand/edit');
Route::rule('infoBrand', 'admin/brand/info');
Route::rule('delBrand', 'admin/brand/del');

/**
 * 属性--品牌--系列
 * @user:hwj
 */
Route::rule('indexSeries', 'admin/series/index');
Route::rule('editSeries', 'admin/series/edit');
Route::rule('infoSeries', 'admin/series/info');
Route::rule('delSeries', 'admin/series/del');

/**
 * 属性--系列--车型
 * @user:hwj
 */
Route::rule('indexSpec', 'admin/spec/index');
Route::rule('editSpec', 'admin/spec/edit');
Route::rule('infoSpec', 'admin/spec/info');
Route::rule('delSpec', 'admin/spec/del');

/**
 * 属性--车龄（说明：此数据存储在文件）
 * @user:hwj
 */

Route::rule('indexCarAge', 'admin/car_age/index');
Route::rule('editCarAge', 'admin/car_age/edit');
Route::rule('delCarAge', 'admin/car_age/del');

/**
 * 属性--价格（说明：此数据存储在文件）
 * @user:hwj
 */
Route::rule('indexPrice', 'admin/price/index');
Route::rule('editPrice', 'admin/price/edit');
Route::rule('delPrice', 'admin/price/del');



//前台页面 路由
Route::rule('index', 'index/index/index');//首页
Route::rule('service', 'index/service/index');//服务
Route::rule('case', 'index/case/index');//案例
Route::rule('about', 'index/about/index');//关于
Route::rule('news', 'index/news/index');//新闻
Route::rule('contact', 'index/contact/index');//联系

//api 接口
// 前台登录
Route::rule('cdd_login', 'car/login/login');//登录
Route::rule('cdd_registered', 'car/login/registered');//注册
Route::rule('cdd_eduser', 'car/login/users_edit');//注册

Route::rule('CarProvinceList', 'car/setting/province_list'); //省份表
Route::rule('CarCitiesList', 'car/setting/cities_list');//市接口
Route::rule('CarAreasList', 'car/setting/areas_list');//区接口
Route::rule('CarMarketList', 'car/setting/market_list');//二手车市场接口

/**
 * API
 * @user:hwj
 * 活动中心
 */
Route::rule('getActivity', 'car/activity/listA');//查看用户活动明细
Route::rule('setActivity', 'car/activity/addA');//用户参与活动中心的数据添加

/**
 * api
 * @user:hwj
 * 属性--品牌
 */
Route::rule('getBrand', 'car/brand/listB');//获取品牌列表
/**
 *api
 * @user:hwj
 * 品牌--系列
 */
Route::rule('getSeries','car/series/listS');//获取品牌下的系列
/**
 * api
 * @user:hwj
 * 系列--车型
 */
Route::rule('getSpec','car/spec/listSpec');//获取此系列下的车型
/**
 * api
 * @uses:hwj
 * 车龄
 */
Route::rule('getCarAge','car/car_age/getCarAge');//获取车龄
/**
 * api
 * @user:hej
 * 价格
 */
Route::rule('getPrice','car/price/getPrice');//获取价格