<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:57:"F:\carm\public/../application/admin\view\login\index.html";i:1548039153;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title>车多点 · 平台管理系统</title>
	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_base.css" />
	<link rel="stylesheet" type="text/css" href="/static/layui/css/layui.css" />
	<script type="text/javascript" src="/static/jquery/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="/static/layui/layui.js"></script>
</head>
<body class="login_body">
<div id="login_wrapper">
    <div class="rha_login">
        <div class="mod-body ">
            <div class="logo-content">
                <h2>Login please · 平台管理系统</h2>
                <form class="layui-form" id="loginform">
                    <ul>
                        <li>
                            <input name="user_name" lay-verify="required" placeholder="请输入用户名" type="text"
                                   autocomplete="off" class="layui-input">
                        </li>
                        <li>
                            <input name="password" lay-verify="required" placeholder="请输入密码" type="password"
                                   autocomplete="off" class="layui-input">
                        </li>

                        <li>
                            <div class="layui-row">
                                <div class="layui-col-md5">
                                    <input name="verify" lay-verify="required" placeholder="图像验证码" type="text"
                                           autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-col-md6" style="padding-left: 10px;">
                                    <img src="system-verify" id="verify_code" onclick="this.src='system-verify?'+Math.random();">
                                </div>
                            </div>
                        </li>
                        <li class="alert alert-danger collapse error_message">
                            <i class="icon icon-delete"></i> <em></em>
                        </li>
                        <li class="last">
                            <div class="layui-input-inline login-btn">
                                <button type="submit" lay-submit="" lay-filter="login" class="layui-btn">登录</button>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    layui.use('form', function () {
        (function () {
            var isIE = function () {
                var U = navigator.userAgent,
                    IsIE = U.indexOf('MSIE') > -1,
                    a = IsIE ? /\d+/.exec(U.split(';')[1]) : 'no ie';
                return a <= 8;
            }();
            if (isIE) {
                layer.alert('你的浏览器内核版本过低,若有极速模式请选择使用极速模式或者使用谷歌、火狐浏览器。');
            }
        })();
        var form = layui.form;
        form.on('submit(login)', function (data) {
            $.post(
               "system-login",
               data.field,
               function (obj) {
                    console.log(obj);
                    if (obj.ret == 200) {
                        layer.msg(obj.msg, {time: 1500, anim: 1}, function () {
                            location.href = "<?php echo url('/ad'); ?>";
                        });
                    } else {
						layer.msg(obj.msg, {time: 1500, anim: 6});
						$("#verify_code").trigger("click");
                    }
               },
               "json"
           );
            return false;
        });
    });
</script>
</body>
</html>
