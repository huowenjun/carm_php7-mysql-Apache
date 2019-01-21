<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"F:\carm\public/../application/admin\view\index\index.html";i:1548036518;s:50:"F:\carm\application\admin\view\layouts\layout.html";i:1548036518;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title><?php echo $baseinfo['admin_name']; ?> · 平台管理系统</title>
	
	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_base.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/css/page.css" />
	<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" />
	<link rel="stylesheet" type="text/css" href="/static/layui/city-picker/city-picker.css"  rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="/static/icon/icon.css" />
	<script type="text/javascript" src="/static/jquery/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="/static/layui/layui.js"></script>

	 <script src="/static/layui/city-picker/city-picker.data.js"></script>
	 <script type="text/javascript" src="/static/common.js"></script>
<!-- 	 <script src="/static/common/jQueryDistpicker/js/distpicker.data.js"></script>
	  <script src="/static/common/jQueryDistpicker/js/distpicker.js"></script>
	  <script src="/static/common/jQueryDistpicker/js/main.js"></script> -->
</head>
<body class="trade-order">
	<div class="topbar">
		<div class="wrap">
			<ul>
				<li>欢迎你，<a class="name" href="javascript:;"><?= $admin_info['admin_name'] ?></a>
					<a class="quit" href="system-logout"><i class="rha-icon" style="">&#xe609;</i>退出登录</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="header">
		<div class="wrap">
			<div class="logo">
				<h1 class="main-logo"><a href=""></a></h1>
				<div class="sub-logo"></div>
			</div>
			<div class="nav">
				<ul>
					<?php foreach ($t_nav as $nav): ?>
					<li class="<?php if($nav['selected'] === 1): ?>selected<?php endif; ?>">
						<a href="<?php echo $nav['route']; ?>"><?php echo $nav['name']; ?></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="container_body wrap">
		<div class="sidebar">
			<div class="menu">
				<?php foreach ($t_menu as $menu): ?>
				<dl>
					<dt><i class="type-ico ico-trade rha-icon "><?php echo $menu['icon']; ?></i><?php echo $menu['name']; ?></dt>
					<?php if(!(empty($menu['child']))): $i = 0; foreach ($menu['child'] as $menus): $i++; ?>
						<dd class="<?php if($menus['selected'] === 1): ?>selected<?php endif; ?>"><a href="<?php echo $menus['route']; ?>"><?php echo $menus['name']; ?></a></dd>
					<?php endforeach; endif; ?>
				</dl>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- 内容区域 start -->
		<div class="content">
			<!-- <h1>首页</h1> -->
<div class="bdsharebuttonbox" data-tag="share_1">
	<img style="padding-left: 0;background-image: url('');height: 16px;line-height: 16px;margin: 6px 6px 6px 0;" src="/static/admin/images/fenxiang.png" class="bds_more" data-cmd="more">
</div>
<script>
	$(function(){
		var bdText = '分享标题';
		var bdDesc = '分享摘要';
		var bdUrl = 'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=3574250824,2028333054&fm=27&gp=0.jpg';
		var bdPic = '分享图片';
		window._bd_share_config = {
			common : {
				bdText : bdText,	
				bdDesc : bdDesc,	
				bdUrl : bdUrl, 	
				bdPic : bdPic
			},
			share : [{
				"bdSize" : 16
			}],
		}
		with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
	})
	
</script>
		</div>
		<!-- 内容区域 end -->
	</div>
	<div class="footer">
		<div class="wrap">
			<!-- <a href="http://www.mcbn.cn/" target="_blank">北京明创百年科技有限公司</a> -->
			北京明创百年科技有限公司
			<i class="vs">|</i>
			Copyright © <?php echo date('Y'); ?> All Rights Reserved.
		</div>
	</div>
</body>
<script>
    layui.use('element', function(){
        var element = layui.element;
    });
    var layer
    layui.use('layer', function(){
        layer = layui.layer;
    });
</script>
</html>