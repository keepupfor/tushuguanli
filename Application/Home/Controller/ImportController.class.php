<?php
namespace Home\Controller;
use Think\Controller;
class ImportController extends BaseController {
    public function index(){
        $this->assign("foot",2);
        $this->display();
    }
}