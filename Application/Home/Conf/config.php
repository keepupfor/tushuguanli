<?php
return array(
    //'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
    'DB_HOST'               => 'localhost', // 服务器地址
    'DB_NAME'               => 'school39',          // 数据库名
    'DB_USER'               => 'root',      // 用户名
    'DB_PWD'                => 'root',          // 密码
    'DB_PORT'               => '3306',        // 端口
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         => 1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           => '', // 指定从服务器序号
    'DB_SQL_BUILD_CACHE'    => false, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE'    => 'file',   // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH'   => 20, // SQL缓存的队列长度
    'DB_SQL_LOG'            => APP_DEBUG, // SQL执行日志记录
//    'URL_MODEL'             => 2,

    'LOG_RECORD'            =>  true,   // 默认不记录日志
    'LOG_TYPE'              =>  'File', // 日志记录类型 默认为文件方式
    'LOG_LEVEL'             =>  'EMERG,ALERT,CRIT,ERR,INFO',// 允许记录的日志级别
    'LOG_EXCEPTION_RECORD'  =>  true,    // 是否记录异常信息日志

    'MODULE_ALLOW_LIST'    =>    array('Weixin'),
    'DEFAULT_MODULE'       =>    'Weixin',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
//	'WEB_SITE_URL'=>'http://wx.360xuet.com',//网站配置地址
    'LOAD_EXT_FILE' =>'extfunction',


    //支付宝配置参数
    'alipay'=>array(
        'partner'=>'2088221257097452',//合作身份者id，以2088开头的16位纯数字
        'seller_id'=>'2088221257097452',//收款支付宝账号
        'key'=>'mch5r0gwsjxus6z0hh3nzldh3esw5md8',//安全检验码，以数字和字母组成的32位字符
        'sign_type'=>strtoupper('MD5'),//签名方式 不需修改
        'input_charset'=>strtolower('utf-8'),//字符编码格式 目前支持 gbk 或 utf-8
        'cacert'=>getcwd().'\\cacert.pem',//ca证书路径地址，用于curl中ssl校验,请保证cacert.pem文件在当前文件夹目录中
        'transport'=>'http',//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    ),
    //以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；

//    'alipay'   =>array(
//        //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
//        'seller_email'=>'pay@xxx.com',
//        //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
//        'notify_url'=>'/Pay/index/notifyurl',
//        //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
//        'return_url'=>'/Pay/index/returnurl',
//        //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
//        'successpage'=>'User/myorder?ordtype=payed',
//        //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
//        'errorpage'=>'User/myorder?ordtype=unpay',
//    ),

);
