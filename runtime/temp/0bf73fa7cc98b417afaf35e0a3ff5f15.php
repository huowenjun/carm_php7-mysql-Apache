<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"F:\carm\public/../application/admin\view\users\index.html";i:1548036518;s:50:"F:\carm\application\admin\view\layouts\layout.html";i:1548036518;}*/ ?>
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
			<style type="text/css">	
/*.container_body{width: 95%;margin: 15px 2.5%}
.sidebar{width:6.25%}
.content{width: 93.2%}*/
</style>

		<div style="display: flex;
overflow-x: auto;
overflow-y: hidden;">
			<div style="flex-shrink: 0;">
<div class="content-hd">
	<fieldset class="layui-elem-field layui-field-title" >
		<legend><?php echo $pagetitle; ?></legend>
		
		<?php if(in_array(10, $role_operation_ids)): ?>
		<!-- <div style="text-align: left;"> -->
			<!-- <a href="addmember.html" class="layui-btn layui-btn-sm layui-btn-normal">增加成员</a> -->
		<!-- </div> -->
		<?php endif; ?>
		<form class="layui-form" action="/adminmember" method="post">
			
			<div class="layui-inline layui-search">
				<label class="layui-form-label">车商编号</label>
				<div class="layui-input-inline">
					<input name="code" placeholder="请输入姓名" autocomplete="off" value="<?php echo input('code')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">城市</label>
				<div class="layui-input-inline">
					<select name="room_city" lay-search>
					<option value="">请选择</option>
						<?php if(is_array($city_list) || $city_list instanceof \think\Collection || $city_list instanceof \think\Paginator): $i = 0; $__LIST__ = $city_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ct): $mod = ($i % 2 );++$i;?>
							<option value="<?php echo $ct['id']; ?>" <?php if(input('room_city') == $ct['id']){echo 'selected';}?>><?php echo $ct['text']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">市场</label>
				<div class="layui-input-inline">
					<select name="market_id" lay-search>
					<option value="">请选择</option>
						<?php if(is_array($market_list) || $market_list instanceof \think\Collection || $market_list instanceof \think\Paginator): $i = 0; $__LIST__ = $market_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mk): $mod = ($i % 2 );++$i;?>
							<option value="<?php echo $mk['id']; ?>" <?php if(input('market_id') == $mk['id']){echo 'selected';}?>><?php echo $mk['text']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">车商</label>
				<div class="layui-input-inline">
					<input name="user_name" placeholder="联系人" autocomplete="off" value="<?php echo input('user_name')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-inline">
				<select name="status" lay-search>
					<option value="">全部</option>
					<option value="1" <?php if(input('status') == 1){echo 'selected';}?>>正常</option>
					<option value="3" <?php if(input('status') == 3){echo 'selected';}?>>到期</option>
					<option value="5" <?php if(input('status') == 5){echo 'selected';}?>>黑名单</option>
				</select>
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">审核状态</label>
				<div class="layui-input-inline">
				<select name="review" lay-search>
					<option value="">全部</option>
					<option value="1" <?php if(input('review') == 1){echo 'selected';}?>>正常</option>
					<option value="2" <?php if(input('review') == 2){echo 'selected';}?>>到期</option>
					<option value="4" <?php if(input('review') == 4){echo 'selected';}?>>黑名单</option>
				</select>
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">注册时间</label>
				<div class="layui-input-inline">
					<input name="zhuce" placeholder="" id="zhuce" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">开通时间</label>
				<div class="layui-input-inline">
					<input name="kaitong" placeholder="" id="kaitong" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">到期时间</label>
				<div class="layui-input-inline">
					<input name="daoqi" placeholder="" id="daoqi" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">收藏时间</label>
				<div class="layui-input-inline">
					<input name="shoucang" placeholder="" id="shoucang" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">看车时间</label>
				<div class="layui-input-inline">
					<input name="kanche" placeholder="" id="kanche" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">在售时间</label>
				<div class="layui-input-inline">
					<input name="zaishou" placeholder="" id="zaishou" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">店铺名称</label>
				<div class="layui-input-inline">
					<input name="shop_name" placeholder="联系人" autocomplete="off" value="<?php echo input('shop_name')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">电话</label>
				<div class="layui-input-inline">
					<input name="user_tel" placeholder="联系电话" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">会员级别</label>
				<div class="layui-input-inline">
				<select name="level" lay-search>
					<option value="">全部</option>
					<option value="1" <?php if(input('level') == 1){echo 'selected';}?>>普通会员</option>
					<option value="5" <?php if(input('level') == 5){echo 'selected';}?>>调度会员</option>
					<option value="10" <?php if(input('level') == 10){echo 'selected';}?>>充值会员</option>
				</select>
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">发车时间</label>
				<div class="layui-input-inline">
					<input name="fache" placeholder="" id="fache" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">成交时间</label>
				<div class="layui-input-inline">
					<input name="chengjiao" placeholder="" id="chengjiao" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">下架时间</label>
				<div class="layui-input-inline">
					<input name="xiajia" placeholder="" id="xiajia" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">查看车源时间</label>
				<div class="layui-input-inline">
					<input name="chakan" placeholder="" id="chakan" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">拨打时间</label>
				<div class="layui-input-inline">
					<input name="boda" placeholder="" id="boda" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
			<div class="layui-inline layui-search">
				<label class="layui-form-label">维保查询时间</label>
				<div class="layui-input-inline">
					<input name="weibao" placeholder="" id="weibao" autocomplete="off" value="<?php echo input('user_tel')?>" class="layui-input layui-input-search" type="text">
				</div>
			</div>
				<button class="layui-btn layui-btn-primary layui-search" lay-submit lay-filter="formDemo">搜索</button>
			<?php if(in_array(57, $role_operation_ids)): ?>
				<a href="addCarDealer.html" class="layui-btn layui-btn-sm layui-btn-normal">增加成员</a>
			<?php endif; ?>
		</form>	
	</fieldset>
</div>
<div style="padding: 0px 10px 0px 10px;">
	<table class="layui-table" >
		<!-- <colgroup>
			<col width="150">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col width="200">
			<col>
		</colgroup> -->
		<thead>
			<tr>
				<th style="width:150px;">车商编号</th>
				<th style="width:150px;">店铺名称</th>
				<th style="width:150px;">负责人</th>
				<th style="width:150px;">电话</th>
				<th style="width:150px;">城市</th>
				<th style="width:150px;">归属市场</th>
				<th style="width:150px;">地址</th>
				<th style="width:150px;">审核状态</th>
				<th style="width:150px;">状态</th>
				<th style="width:150px;">会员级别</th>
				<th style="width:150px;">注册时间</th>
				<th style="width:150px;">审核时间</th>
				<th style="width:150px;">开通时间</th>
				<th style="width:150px;">到期时间</th>
				<th style="width:150px;">储值金额</th>
				<th style="width:150px;">发车量</th>
				<th style="width:150px;">在售量</th>
				<th style="width:150px;">成交量</th>
				<th style="width:150px;">下架量</th>
				<th style="width:150px;">车源查看量</th>
				<th style="width:150px;">电话拨打量</th>
				<th style="width:150px;">车源收藏量</th>
				<th style="width:150px;">中介看车量</th>
				<th style="width:150px;">登录天数</th>
				<th style="width:150px;">多币额</th>
				<th style="width:150px;">维保查询量</th>
				<th style="width:150px;">图片</th>
				<th style="width:150px;">操作</th>
			</tr>
		</thead>
		<tbody>
		<?php if (!(empty($list->total()))): foreach ($list as $vo): ?>
		<tr>
			<td><?php echo $vo['code']; ?></td>
			<td><?php echo $vo['shop_name']; ?></td>
			<td><?php echo $vo['user_name']; ?></td>
			<td><?php echo $vo['user_tel']; ?></td>
			<td><?php echo $vo['room_city_name']; ?></td>
			<td><?php echo $vo['market_name']; ?></td>
			<td><?php echo $vo['address']; ?></td>
			<td><?php echo $vo['review_name']; ?></td>
			<td><?php echo $vo['status_name']; ?></td>
			<td><?php echo $vo['level_name']; ?></td>
			<td><?php echo $vo['ctime']; ?></td>
			<td><?php echo $vo['review_times']; ?></td>
			<td><?php echo $vo['start_times']; ?></td>
			<td><?php echo $vo['end_times']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['login_days']; ?></td>
			<td><?php echo $vo['gold']+$vo['money']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td><?php echo $vo['cash']; ?></td>
			<td>
				<?php if(in_array(12, $role_operation_ids)): if($vo['status'] == '5'): ?>
						<a class="rha-bt-a ajax-switch" href="StaCarDealer.html?id=<?php echo $vo['id']; ?>&status=1&user_name=<?php echo $vo['user_name']; ?>" con="确认要取消拉黑【<?php echo $vo['user_name']; ?>】吗">取消拉黑</a>
						<!-- <a class="rha-bt-a" onclick="tollgesta('<?php echo $vo['id']; ?>', '1', '<?php echo $vo['user_name']; ?>')" href="javascript:;">取消拉黑</a> -->
					<?php else: ?>
						<a class="rha-bt-a ajax-switch" href="StaCarDealer.html?id=<?php echo $vo['id']; ?>&status=1&user_name=<?php echo $vo['user_name']; ?>" con="确认要拉黑【<?php echo $vo['user_name']; ?>】吗">拉黑</a>
						<!-- <a class="rha-bt-a" onclick="tollgesta('<?php echo $vo['id']; ?>', '5', '<?php echo $vo['user_name']; ?>')" href="javascript:;">拉黑</a> -->
					<?php endif; endif; if(in_array(58, $role_operation_ids)): ?>
					<a class="rha-bt-a" href="upCarDealer.html?id=<?php echo $vo['id']; ?>">编辑</a>
				<?php endif; if(in_array(59, $role_operation_ids)): ?>
					<a class="rha-bt-d ajax-delete" href="deCarDealer.html?id=<?php echo $vo['id']; ?>">删除</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; else: ?>
		<tr>
			<td colspan="8" style="text-align: center;">暂无记录</td>
		</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<?php if (!(empty($list))): ?>
		<div style="text-align: left;"><?php echo $list->render(); ?></div>
	<?php endif; ?>
</div>
</div>
</div>
<script>
	$(document).on('mouseenter', '.look_smal', function(){
		tip_index = '';
		if($(this).next('.look_all').children('font').length >2){
			tip_index=layer.tips($('.look_all').html(), '.look_smal', {
		        tips: [4, '#666'],
		        area: ['auto', 'auto'],
		        time: 50000
		    });
		}
	    
	}).on('mouseleave', '.look_smal', function(){
	    layer.close(tip_index);
	});
function disabledAdmin(id, status, beName) {
	var txt = status == 1 ? '开启' : '禁用';
	layui.use('layer', function(){
		var layer = layui.layer;
		layer.confirm('你确定需要'+ txt +'吗？', {
			btn: ['是','不'] //按钮
		}, function(){
			$.post(
				'disabledAdmin',
				{'id':id, 'status':status, 'beName':beName},
				function(obj){
					if(obj.ret == 200){
						layer.msg(obj.msg, {time: 1500}, function(){
							window.location.reload();
						});
					}
					else{
						layer.msg(obj.msg, {time: 1500, anim: 6});
					}
				},
				"json"
			);
		});
	});
}
layui.use('laydate',function () {
	var laydate = layui.laydate;
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 
	laydate.render({
	  elem: '#zhuce'
	  ,type: 'date'
	  ,range: '~'
	  ,format: 'yyyy年M月d日'
	}); 

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