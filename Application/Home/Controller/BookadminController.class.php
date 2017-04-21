<?php
namespace Home\Controller;
use Think\Controller;
class BookadminController extends Controller {
    public function index(){
        $url=$_SERVER['HTTP_REFERER'];
        $this->assign("url",$url);
        $this->display();
    }
}