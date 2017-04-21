<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0" />
    <meta name="format-detection" content="telephone=no" /><!--禁止识别为手机号-->
    <!--   <link rel="shortcut icon" href="favicon.ico"  />
      <link rel="Bookmark" href="favicon.ico"  />-->
    <!--jQuery weui-->
    <link rel="stylesheet" href="http://wx.365xuet.com/Public/Weui/css/weui.min.css">
    <link rel="stylesheet" href="http://wx.365xuet.com/Public/Weui/css/jquery-weui.css">
    <!-- Standard iPhone -->
    <link rel="apple-touch-icon" href="apple-touch-icon.png" />
    <!-- Retina iPhone -->
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-120x120.png" />
    <!-- Standard iPad -->
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-iphone-76x76.png" />
    <!-- Retina iPad -->
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-152x152.png" />
    <link rel="stylesheet" type="text/css" href="/tushuguanli/Public/css/style.css">
    <script type="application/javascript" src="http://wx.365xuet.com/Public/Weui/js/jquery-2.1.4.js"></script>
    <script type="application/javascript" src="http://wx.365xuet.com/Public/Weui/js/jquery-weui.min.js"></script>
</head>
<body>
<div class="login"><img src="/tushuguanli/Public/Weixin/images/logo.png"></div>
<div class="login_1">
    <form name="form1" id="form1" action="<?php echo U('Public/login');?>" method="post">
        <ul>

            <li class="login_line"><img src="/tushuguanli/Public/Weixin/images/member.png">
                <input name="t_mobile" id="t_mobile" type="tel" class="login_input" value="" placeholder="手机号码" maxlength="11" style="color:#666;"></li>
            <li class="login_line"><img src="/tushuguanli/Public/Weixin/images/passwords.png">
                <input name="t_password" id="t_password" type="password" class="login_input" value="" placeholder="密码" maxlength="20" style="color:#666;"></li>
            <li>
                <div class="login_left"><input type="checkbox"  class="login_checkbox"  name="chk_isremember" value="1" id="chk_isremember" checked>
                    <label for="chk_isremember">记住账号</label></div>
                <div class="login_right"><a href="zhmm"></a></div>
            </li>
        </ul>
        <label class="radio-inline">
            <input type="radio" name="identify" id="inlineRadio1" value="student" checked> 学生
        </label>
        <input type="hidden" name="url" id="url" value="<?php echo ($url); ?>" />
        <label class="radio-inline">
            <input type="radio" name="identify" id="inlineRadio2" value="teacher"> 老师
        </label>
        <button class="login_but" type="button" name="btn_login" onclick="login();">登录</button>
        <button class="login_but" style="background-color:green;margin-top:0px;" type="button" name="jump_wx" onclick="window.location.href='<?php echo U("Public/wx_login");?>'">微信登录</button>
    </form>
    <div style="width: 60%;float:right;text-align: right;margin-right: 5px">没有帐号？<a href="<?php echo U('register');?>">立即注册</a></div>
    <div style="width: 35%;float:left;text-align: left;margin-right: 5px"><a href="<?php echo U('forget');?>">找回密码</a></div>
</div>
</body>
</html>
<script>
    $(function(){
        if($.cookie("isremember")!=null&&$.cookie("isremember")!="")
        {
            var mobile=$.cookie("loginid");
            var password=$.cookie("password");
            if(mobile!=null&&mobile!="")
                $("#t_mobile").val(mobile);
            if(password!=null&&password!="")
                $("#t_password").val(password);
            $("#chk_isremember").attr("checked","checked");
        }
    });
    function login()
    {
        var mobile=$("#t_mobile").val();
        var password=$("#t_password").val();
        if(!isMobile(mobile))
        {
            myAlert("请输入正确的手机号码");
            return false;
        }
        else if(password.length<4||password.length>20)
        {
            myAlert("请输入规范的密码");
            return false;
        }
        $("#form1").submit();
    }
    function jump_wx(){
        window.location.href="jd.com";
    }
</script>