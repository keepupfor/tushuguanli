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
    <link rel="stylesheet" type="text/css" href="/bookmanage/Public/css/style.css">
    <script type="application/javascript" src="http://wx.365xuet.com/Public/Weui/js/jquery-2.1.4.js"></script>
    <script type="application/javascript" src="http://wx.365xuet.com/Public/Weui/js/jquery-weui.min.js"></script>
</head>
<title>365首页</title>
<body ontouchstart>
<div class="top">
    <div class="h-p">
        <div class="left-t">
            <div class="right-t-div">
                <span class="right-t-l">
                    <img src="http://wx.365xuet.com/Public/Weixin/images/search-icon.png"/>
                </span>
                <span class="right-t-2">请输入图书名称</span>
            </div>
        </div>
        <div class="right-t"><a href="" class="weui_btn weui_btn_mini weui_btn_primary">查询</a></div>
    </div>
</div>
<div class="book_list">
    <ul>
        <li>
            <div class="book_left">
            <img src="https://img3.doubanio.com/lpic/s29276401.jpg" alt=""></div>
            <div class="book_right">
                <span>书名:好好学习</span>
                <span >作者: 成甲</span>
                <span >出版社:中信出版社</span>
                <span >定价:42.00</span>
                <span >ISBN:9787508671581</span>

            </div>
        </li>
        <li>
            <div class="book_left">
                <img src="https://img3.doubanio.com/lpic/s29276401.jpg" alt=""></div>
            <div class="book_right">
                <span>书名:好好学习</span>
                <span >作者: 成甲</span>
                <span >出版社:中信出版社</span>
                <span >定价:42.00</span>
                <span >ISBN:9787508671581</span>

            </div>
        </li>
        <li>
            <div class="book_left">
                <img src="https://img3.doubanio.com/lpic/s29276401.jpg" alt=""></div>
            <div class="book_right">
                <span>书名:好好学习</span>
                <span >作者: 成甲</span>
                <span >出版社:中信出版社</span>
                <span >定价:42.00</span>
                <span >ISBN:9787508671581</span>

            </div>
        </li>
        <li>
            <div class="book_left">
                <img src="https://img3.doubanio.com/lpic/s29276401.jpg" alt=""></div>
            <div class="book_right">
                <span>书名:好好学习</span>
                <span >作者: 成甲</span>
                <span >出版社:中信出版社</span>
                <span >定价:42.00</span>
                <span >ISBN:9787508671581</span>

            </div>
        </li>
        <li>
            <div class="book_left">
                <img src="https://img3.doubanio.com/lpic/s29276401.jpg" alt=""></div>
            <div class="book_right">
                <span>书名:好好学习</span>
                <span >作者: 成甲</span>
                <span >出版社:中信出版社</span>
                <span >定价:42.00</span>
                <span >ISBN:9787508671581</span>

            </div>
        </li>
    </ul>
</div>
<div class="footer">
    <ul>
        <a href="<?php echo U('Index/index');?>"><li><img src="http://wx.365xuet.com/Public/Weixin/images/footer-1-off.png"><img src="http://wx.365xuet.com/Public/Weixin/images/footer-1-on.png"><br><span>图书查询</span></li></a>
        <a href="<?php echo U('Import/fenlei');?>"><li><img src="http://wx.365xuet.com/Public/Weixin/images/footer-2-off.png"><img src="http://wx.365xuet.com/Public/Weixin/images/footer-2-on.png"><br><span>图书录入</span></li></a>
        <a onclick="login()"><li><img src="http://wx.365xuet.com/Public/Weixin/images/footer-4-off.png"><img src="http://wx.365xuet.com/Public/Weixin/images/footer-4-on.png"><br><span>我的</span></li></a>
    </ul>
</div>
<script src="http://wx.365xuet.com/Public/Weui/js/jquery.min..js"></script>
<script>
    function login(){
        var url = window.location.href;
        window.location.href = "/bookmanage/index.php/Public/login?url=" + url;
    }
    $(".footer ul a").click(function(){
//        alert($(this).siblings().find("img:eq(1)").html());
        $(".footer ul a").find("li img:odd").hide();
        $(".footer ul a").find("li img:even").show();
        $(this).find("img:eq(0)").hide();
        $(this).find("img:eq(1)").show();
    });
</script>
</body>
<script>
    //顶部搜索框变色
    $().ready(function(){
        (function(){
            pos = 0;
            ticking = false;
            var header = document.querySelector(".h-p");
            window.addEventListener("scroll", function(e){
                pos = window.scrollY;
                if(pos > 100&&!ticking){
                    header.classList.add("scrolledDown");
                    ticking = true;
                }
                if(pos < 100 && ticking){
                    header.classList.remove("scrolledDown");
                    ticking = false;
                }
            });
        })();
    });
</script>
</html>