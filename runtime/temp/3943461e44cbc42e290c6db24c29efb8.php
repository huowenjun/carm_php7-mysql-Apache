<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"F:\carm\public/../application/admin\view\store\index.html";i:1548036518;s:50:"F:\carm\application\admin\view\layouts\layout.html";i:1548036518;}*/ ?>
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
			<div class="content-hd">
	<fieldset class="layui-elem-field layui-field-title" >
		<legend>门店列表</legend>
		<?php if(in_array(27, $role_operation_ids)): ?>
		<div style="text-align: left;">
			<a href="addStore.html" class="layui-btn layui-btn-sm layui-btn-normal">增加门店</a>
		</div>
		<?php endif; ?>
	</fieldset>
</div>
<div style="padding: 0px 10px 0px 10px;">
	<table class="layui-table" >
		<colgroup>
			<col width="60">
			<col width="120">
			<col width="120">
			<col width="120">
			<col width="100">
			<col width="150">
			<col width="150">
			<col>
		</colgroup>
		<thead>
			<tr>
				<th>ID</th>
				<th>门店名称</th>
				<th>LOGO</th>
				<th>门店电话</th>
				<th>联系人</th>
				<th>详细地址</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php if (!(empty($list->total()))): foreach ($list as $vo): ?>
		<tr>
			<td><?php echo $vo['id']; ?></td>
			<td><?php echo $vo['store_name']; ?></td>				
			<td><a href="<?php echo $vo['logo']; ?>" title="点击查看大图" target="_blank"><img <?php echo $vo['logo'] ? 'src="'. $vo['logo'] .'"' : ''; ?> wider="10%" height="10%" ></a></td>
			<td><?php echo $vo['mobile']; ?></td>
			<td><?php echo $vo['linkman']; ?></td>
			<td><?php echo $vo['address']; ?></td>
			<td><?php echo $vo['ctime'] ? date("y-m-d H:i:s", $vo['ctime']) : ''; ?></td>
			<td>
			<?php if($admin_info['id'] == 1): ?>
				<a class="rha-bt-a" href="upStore.html?id=<?php echo $vo['id']; ?>">修改</a>
				<a href="javascript:;" onclick="Del('<?php echo $vo['id']; ?>', '<?php echo $vo['store_name']; ?>')" class="rha-bt-a" >删除</a>
			<?php else: if(in_array(28, $role_operation_ids)): ?>
				<a class="rha-bt-a" href="upStore.html?id=<?php echo $vo['id']; ?>">修改</a>
				<?php endif; if(in_array(29, $role_operation_ids)): ?>
					<a href="javascript:;" onclick="Del('<?php echo $vo['id']; ?>', '<?php echo $vo['store_name']; ?>')" class="rha-bt-a" >删除</a>
				<?php endif; endif; ?>
			</td>
		</tr>
		<?php endforeach; else: ?>
		<tr>
			<td colspan="8">暂无记录</td>
		</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<?php if (!(empty($list))): ?>
		<div style="text-align: left;"><?php echo $list->render(); ?></div>
	<?php endif; ?>
</div>
<script>
function Del(pkid, beName)
{
	layui.use('layer', function(){
		var layer = layui.layer;
		layer.confirm('你确定要删除吗？', {
			btn: ['是','不'] //按钮
		}, function(){
			$.post(
				'delStore',
				{'pkid':pkid, 'beName':beName},
				function(obj){
					layer.msg(obj.msg, {time: 1500}, function(){
						window.location.reload();
					});
				},
				"json"
			);
		});
	});
}
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