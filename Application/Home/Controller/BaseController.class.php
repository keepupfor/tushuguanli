<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function __construct()
    {
        parent::__construct();
        if(!check_login())
        {
            $this->error('请先登录！',U('Login/login'));
        }
    }
}