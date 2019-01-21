<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"F:\carm\public/../application/admin\view\systems\menulist.html";i:1548036518;s:50:"F:\carm\application\admin\view\layouts\layout.html";i:1548036518;}*/ ?>
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
		<legend>菜单列表</legend>
		<?php if(in_array(5, $role_operation_ids)): ?>
		<div style="text-align: left;">
			<a href="system-addmenu.html" class="layui-btn layui-btn-sm layui-btn-normal">增加菜单</a>
			
			<a href="" class="layui-btn layui-btn-sm layui-btn-normal">Excel导入</a>
		</div>
		<?php endif; ?>
	</fieldset>
</div>

<form class="layui-form" action="" style="padding: 0px 10px 0px 10px;">
	<table class="layui-table">
		<colgroup>
			<col width="100">
			<col width="500">
			<col>
		</colgroup>
		<thead>
			<tr>
				<th>排序</th>
				<th>菜单名称</th>
				<th>地址</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($list as $v): ?>
			<tr>
				<td><input style="width: 35px; text-align:center" name="<?php echo $v['id']; ?>_<?php echo $v['sort']; ?>" value="<?php echo $v['sort']; ?>"></td>
				<td><?php echo $v['name']; ?></td>
				<td><?php echo $v['url']; ?></td>
				<td>
				<?php if(in_array(19, $role_operation_ids)): ?>
					<a class="rha-bt-a" href="system-updateMenu.html?id=<?php echo $v['id']; ?>">修改</a>
				<?php endif; if(in_array(20, $role_operation_ids)): ?>
					<a href="javascript:;" onclick="delMenu('<?php echo $v['id']; ?>', '<?php echo $v['name']; ?>')" class="rha-bt-a" >删除</a>
				<?php endif; ?>
				</td>
			</tr>
			<?php if(!(empty($v['child']))): if(is_array($v['child'])): $i = 0; foreach ($v['child'] as $v2): ++$i; ?>
			<tr>
				<td><input style="width: 35px; text-align:center" name="<?php echo $v2['id']; ?>_<?php echo $v2['sort']; ?>" value="<?php echo $v2['sort']; ?>"></td>
				<td>&nbsp;&nbsp;&nbsp; ├<?php echo $v2['name']; ?></td>
				<td><?php echo $v2['url']; ?></td>
				<td>
				<?php if(in_array(19, $role_operation_ids)): ?>
					<a class="rha-bt-a" href="system-updateMenu.html?id=<?php echo $v2['id']; ?>">修改</a>
				<?php endif; if(in_array(20, $role_operation_ids)): ?>
					<a href="javascript:;" onclick="delMenu('<?php echo $v2['id']; ?>', '<?php echo $v['name']; ?>')" class="rha-bt-a" >删除</a>
				<?php endif; ?>
				</td>
			</tr>
			<?php if(!(empty($v2['child']))): if(is_array($v2['child'])): $ii = 0; foreach ($v2['child'] as $v3): ++$ii; ?>
			<tr>
				<td><input style="width: 35px; text-align:center" name="<?php echo $v3['id']; ?>_<?php echo $v3['sort']; ?>" value="<?php echo $v3['sort']; ?>"></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ├<?php echo $v3['name']; ?></td>
				<td><?php echo $v3['url']; ?></td>
				<td>
				<?php if(in_array(19, $role_operation_ids)): ?>
					<a class="rha-bt-a" href="system-updateMenu.html?id=<?php echo $v3['id']; ?>">修改</a>
				<?php endif; if(in_array(20, $role_operation_ids)): ?>
					<a href="javascript:;" onclick="delMenu('<?php echo $v3['id']; ?>', '<?php echo $v['name']; ?>')" class="rha-bt-a" >删除</a>
				<?php endif; ?>
				</td>
			</tr>
			<?php if(!(empty($v3['child']))): if(is_array($v3['child'])): $iii = 0; foreach ($v3['child'] as $v4): ++$iii; ?>
			<tr>
				<td><input style="width: 35px; text-align:center" name="<?php echo $v4['id']; ?>_<?php echo $v4['sort']; ?>" value="<?php echo $v4['sort']; ?>"></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ├<?php echo $v4['name']; ?></td>
				<td><?php echo $v4['url']; ?></td>
				<td>
				<?php if(in_array(19, $role_operation_ids)): ?>
					<a class="rha-bt-a" href="system-updateMenu.html?id=<?php echo $v4['id']; ?>">修改</a>
				<?php endif; if(in_array(20, $role_operation_ids)): ?>
					<a href="javascript:;" onclick="delMenu('<?php echo $v4['id']; ?>', '<?php echo $v['name']; ?>')" class="rha-bt-a" >删除</a>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; endif; endif; endforeach; endif; endif; endforeach; endif; endif; endforeach; ?>
		</tbody>
	</table>
	<?php if($admin_info['id'] == 1): ?>
		<div class="layui-form-item">
			<button class="layui-btn layui-btn-sm" lay-submit lay-filter="updateSort">更新排序</button>
		</div>
	<?php else: if(in_array(22, $role_operation_ids)): ?>
		<div class="layui-form-item">
			<button class="layui-btn layui-btn-sm" lay-submit lay-filter="updateSort">更新排序</button>
		</div>
		<?php endif; endif; ?>
</form>
<script>
layui.use('form', function(){
    var form = layui.form;
	form.on('submit(updateSort)', function (data) {
		$.post(
			"system-updateSort",
			data.field,
			function (obj) {
				layer.msg(obj.msg, {time: 1500});
			},
			"json"
		);
		return false;
	});
});
function delMenu(pkid, beName)
{
	layui.use('layer', function(){
		var layer = layui.layer;
		layer.confirm('你确定要删除吗？', {
			btn: ['是','不'] //按钮
		}, function(){
			$.post(
				'system-deleteMenu',
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