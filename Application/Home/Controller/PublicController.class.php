<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 11:16
 */

namespace Weixin\Controller;

use Think\Controller;
use Think\Model;

class PublicController extends Controller
{
    public function login()
    {
        if (isset($_SESSION["user_type"])){
            if ($_SESSION["user_type"]==1){
                $this->redirect("Student/index");
            }else if ($_SESSION["user_type"]==2){
                $this->redirect("Teacher/index");
            }
        }
        $url=I('url');
        if($url){
            $this->assign('url',$url);
        }
        if (isset($_POST["t_mobile"])) {
            $mobile = I("post.t_mobile");
            $passwd = I("post.t_password");
            $chk_isremember = I("post.chk_isremember");
            $identify = I('post.identify');
            if (!checkMobile($mobile)) {
                echo "<script>alert('请输入正确的手机号码');window.history.go(-1);</script>";
                exit;
            } else if ($passwd == "") {
                echo "<script>alert('请输入密码');window.history.go(-1);</script>";
                exit;
            }
            $spasswd = "###" . md5(md5("UewBc27f4YZvbr0e6p" . $passwd));
            $model = new Model();
            if ($identify=="student") {
                $sql = "select * from 365class.class_student_users where mobile=ENCODE('$mobile','1!q2@w') and user_pass='$spasswd'";
                $query = $model->query($sql);
                if ($query != null && count($query) == 1) {
                    $nickname = $query[0]["user_nicename"];
                    $realname =$query[0]['user_realname'];
                    session("user_type",$query[0]["user_type"]);
                    session("nickname", $nickname);
                    session('realname',$realname);
                    session("userid", $query[0]["id"]);
                    //记录cookie
                    $salt = $this->random_str(16);
                    //第二分身标识
                    $identifier = md5($salt . md5($query[0]['id'] . $salt));
                    //永久登录标识
                    $token = md5(uniqid($spasswd, true));
                    //永久登录超时时间(1周)
                    $timeout = time()+3600*24*7;
                    setcookie('_auth',$identifier.':'.$token,$timeout,"/");
                    $login_data = array(
                        'login_id' => $query[0]['id'],
                        'login_type' => $query[0]['user_type'],
                        'login_ip' => get_client_ip(0,true),
                        'login_time' => date("Y-m-d H:i:s"),
                        'login_token' => $token
                    );
                    $r=M('365class.class_login_log')->add($login_data);
                    $where['id'] =$query[0]["id"];
                    $data = array(
                        'last_login_time' => date("Y-m-d H:i:s"),
                        'last_login_ip' => get_client_ip(0,true),
                        'identifier' =>$identifier,
                        'token'=>$token,
                        'timeout'=>$timeout
                    );
                    $users_model=new Model('365class.class_student_users');
                    $users_model->where($where)->save($data);
                    $user_info=$users_model->where($where)->field('user_realname,school_name,class')->find();
                    $complete=false; //学生信息是否完善标识
                    foreach($user_info as $v){
                        if($v==null){$complete=true;}
                    }
                    if (isset($_POST["chk_isremember"])) {
                        setcookie("loginid", $mobile, time() + 864000);//set 10d
                        cookie('_mobile',$mobile);//用于校内学生判断；
                        setcookie("password", $passwd, time() + 864000);
                        setcookie("isremember", "1", time() + 864000);
                        if($complete){
                            $personalset=U('Student/personalset');
                            echo "<script>if(confirm('您的个人信息尚未完善，是否现在完善？')){location.href='$personalset';}</script>";
                            echo "<script>window.history.go(-2);</script>";
                            die;
                        }
                        if($url){
                            echo "<script>alert('登录成功!');location.href='$url';</script>";
                        }
                        echo "<script>alert('登录成功!');window.history.go(-2);</script>";
                    } else {
                        setcookie("loginid", "", time() - 3600);//clean
                        cookie('_mobile',$mobile);//用于校内学生判断；
                        setcookie("password", "", time() - 3600);
                        setcookie("isremember", "", time() - 3600);
                        if($complete){
                            $personalset=U('Student/personalset');
                            echo "<script>if(confirm('您的个人信息尚未完善，是否现在完善？')){location.href='$personalset';}</script>";
                            echo "<script>window.history.go(-2);</script>";
                            die;
                        }
                        if($url){
                            echo "<script>alert('登录成功!');location.href='$url';</script>";
                        }
                        echo "<script>alert('登录成功!');window.history.go(-2);</script>";
                    }
                } else {
                    echo "<script>alert('手机号码或密码错误!');window.history.go(-1);</script>";
                    exit;
                }
            } elseif ($identify=="teacher") {
                $sql = "select * from 365class.class_teacher_users where mobile=ENCODE('$mobile','1!q2@w') and user_pass='$spasswd'";
                $query = $model->query($sql);
                if ($query != null && count($query) == 1) {
                    $nickname = $query[0]["user_nicename"];
                    $realname = $query[0]["usesr_realname"];
                    session("user_type",$query[0]["user_type"]);
                    session("nickname", $nickname);
                    session("realname",$realname);
                    session("userid", $query[0]["id"]);
                    //记录cookie
                    $salt = $this->random_str(16);
                    //第二分身标识
                    $identifier = md5($salt . md5($query[0]['id'] . $salt));
                    //永久登录标识
                    $token = md5(uniqid($passwd, true));
                    //永久登录超时时间(1周)
                    $timeout = time()+3600*24*7;
                    setcookie('_auth',$identifier.':'.$token,$timeout,"/");
                    $login_data = array(
                        'login_id' => $query[0]['id'],
                        'login_type' => $query[0]['user_type'],
                        'login_ip' => get_client_ip(0,true),
                        'login_time' => date("Y-m-d H:i:s"),
                        'login_token' => $token
                    );
                    $r=M('365class.class_login_log')->add($login_data);
                    $where['id'] =$query[0]["id"];
                    $data = array(
                        'last_login_time' => date("Y-m-d H:i:s"),
                        'last_login_ip' => get_client_ip(0,true),
                        'identifier' =>$identifier,
                        'token'=>$token,
                        'timeout'=>$timeout,
                    );
                    $users_model=new Model('365class.class_teacher_users');
                    $users_model->where($where)->save($data);
                    if (isset($_POST["chk_isremember"])) {
                        setcookie("loginid", $mobile, time() + 864000);//set 10d
                        setcookie("password", $passwd, time() + 864000);
                        setcookie("isremember", "1", time() + 864000);
                        echo "<script>alert('登录成功!');window.history.go(-2);</script>";
                    } else {
                        setcookie("loginid", "", time() - 3600);//clean
                        setcookie("password", "", time() - 3600);
                        setcookie("isremember", "", time() - 3600);
                        echo "<script>alert('登录成功!');window.history.go(-2);</script>";
                    }
                } else {
                    echo "<script>alert('手机号码或密码错误！');window.history.go(-1);</script>";
                    exit;
                }
            }else{
                echo "<script>alert('请选择身份');window.history.go(-1);</script>";
                exit;
            }
        }
        $this->display('login');
    }
    public function logout(){
        session_destroy();
        $this->redirect("Index/index");
    }
    public function register(){
        if($_POST){
            $mobile = I("post.t_mobile");
            $user_pass = I("post.t_password");
            $str = I("post.identify");
            $u_name = I("post.s_name");
            $u_class = I("post.s_class");
            if($str =='student'){
                $userMdl = M('365class.class_student_users');
            }else{
                $userMdl = M('365class.class_teacher_users');
            }
            if (!sp_check_mobile_verify_code($_POST['mobile_verify'])) {
                $this->error("手机验证码错误！");
            }
            $ismobile = $userMdl->where("mobile = ENCODE('" .$mobile  . "', '1!q2@w')")->find();
            if ($ismobile) {
                $this->error('手机号已存在！');
            } else {
                if($str =='student'){
                    $areacode=I('post.country');
                    $school=I('post.school');
                    if(is_numeric($school)){
                        $school=M('class_school_users')->where("id='$school'")->getField('school_name');
                    }
                    $find=substr($mobile,3,4);
                    $encode_mobile='用户'.str_replace($find,'****',$mobile);
                    $u_class = I('post.grade') . "-" . I('post.g_class') . "-" . I('post.s_class');
                    $result = $userMdl->add(array(
                        "mobile" =>array(
                            'exp',
                            "ENCODE('" . $mobile . "', '1!q2@w')"),
                        "user_pass" =>"###".md5(md5("UewBc27f4YZvbr0e6p".$user_pass)),
                        'user_realname'=>$u_name,
                        'class'=>$u_class,
                        "create_time"=>date("Y-m-d H:i:s"),
                        'last_login_time' => date("Y-m-d H:i:s"),
                        'create_ip' => get_client_ip(0,true),
                        'last_login_ip' => get_client_ip(0,true),
                        'user_status' => 1,
                        "user_type"=>1,//1学生，2老师 ，3学校，4机构
                        'areacode'=>$areacode,
                        'school_name'=>$school,
                        'user_nicename'=>$encode_mobile
                    ));
                    if($result&&$mobile){
                        //记录cookie
                        $salt = $this->random_str(16);
                        //第二分身标识
                        $identifier = md5($salt . md5($result . $salt));
                        //永久登录标识
                        $token = md5(uniqid($user_pass, true));
                        //永久登录超时时间(1周)
                        $timeout = time()+3600*24*7;
                        setcookie('_auth',$identifier.':'.$token,$timeout,"/");
                        $where['id'] =$result;
                        $data = array(
                            'last_login_time' => date("Y-m-d H:i:s"),
                            'last_login_ip' => get_client_ip(0,true),
                            'identifier' =>$identifier,
                            'token'=>$token,
                            'timeout'=>$timeout,
                        );
                        $userMdl->where($where)->save($data);
                        session("user_type",1);
                        session("nickname", '匿名');
                        session("realname",$u_name);
                        session("userid", $result);
                        cookie('_mobile',$mobile);
                        $this->show("<script>alert('注册成功');location.href='{:U(\'Index/index\')}';</script>");
                    }
                }else{
                    $areacode=I('post.country');
                    $school=I('post.school');
                    if(is_numeric($school)){
                        $school=M('class_school_users')->where("id='$school'")->getField('school_name');
                    }
                    $result = $userMdl->add(array(
                        "mobile" =>array(
                            'exp',
                            "ENCODE('" . $mobile . "', '1!q2@w')"),
                        "user_pass" =>"###".md5(md5("UewBc27f4YZvbr0e6p".$user_pass)),
                        "create_time"=>date("Y-m-d H:i:s"),
                        'last_login_time' => date("Y-m-d H:i:s"),
                        'create_ip' => get_client_ip(0,true),
			'user_realname'=>$u_name,
                        'last_login_ip' => get_client_ip(0,true),
                        'user_status' => 1,
                        "user_type"=>2,//1学生，2老师 ，3学校，4机构
                        'areacode'=>$areacode,
                        'school_name'=>$school
                    ));
                    if($result&&$mobile){
                        //记录cookie
                        $salt = $this->random_str(16);
                        //第二分身标识
                        $identifier = md5($salt . md5($result . $salt));
                        //永久登录标识
                        $token = md5(uniqid($user_pass, true));
                        //永久登录超时时间(1周)
                        $timeout = time()+3600*24*7;
                        setcookie('_auth',$identifier.':'.$token,$timeout,"/");
                        $where['id'] =$result;
                        $data = array(
                            'last_login_time' => date("Y-m-d H:i:s"),
                            'last_login_ip' => get_client_ip(0,true),
                            'identifier' =>$identifier,
                            'token'=>$token,
                            'timeout'=>$timeout,
                        );
                        $userMdl->where($where)->save($data);
                        session("user_type",2);
                        session("nickname", '匿名');
                        session("realname",$u_name);
                        session("userid", $result);
                        cookie('_mobile',$mobile);
                        $this->show("<script>alert('注册成功');location.href='{:U(\'Index/index\')}';</script>");
                    }
                }
            }
        }
        $province_list=M('class_region')->where("level_id = 0")->select();
        $city_list=M('class_region')->where("father_id=36")->select();
        $country_list=M('class_region')->where("father_id=3601")->select();
        $this->assign('province_list',$province_list);
        $this->assign('city_list',$city_list);
        $this->assign('country_list',$country_list);
        $this->display();
    }

    public function region_tree(){
        if(IS_AJAX){
            $code=I('get.region_code');
            $regionMdl=M('class_region');
            if($code<100){
                $regioninfo[]=$regionMdl->where("father_id= '$code'")->select();
                $regioninfo[]=$regionMdl->where("father_id=".$regioninfo[0][0]['region_code'])->select();
                $this->ajaxReturn($regioninfo);
            }
            $regioninfo=$regionMdl->where("father_id= '$code'")->select();
            $this->ajaxReturn($regioninfo);
        }
    }
    public function region_school(){
        if(IS_AJAX){
            $code=I('get.region_code');
            $schoolMdl=M('class_school_users');
            $school_info=$schoolMdl->where("areacode='$code'")->field('school_name,id')->select();
            if(!$school_info){
                $school_info=0;
            }
            $this->ajaxReturn($school_info);
        }
    }



    //忘记密码
    public function forget(){
        if($_POST){
            $mobile=I('post.t_mobile');
            $identify=I('post.identify');
            if(!sp_check_mobile_verify_code(I('post.mobile_verify'))){
                $this->error('手机验证码错误');
            }
            $this->assign('mobile',$mobile);
            $this->assign('identify',$identify);
            $this->display('reset');//加载修改密码页面
            return;
        }
        $this->display();
    }
    public function reset(){
        if($_POST) {
            $password = I('post.password');
            $mobile = I('post.mobile');
            $identify = I('post.identify');
            if ($identify == 'student') {
                $userMdl = M('365class.class_student_users');
            } elseif ($identify == 'teacher') {
                $userMdl = M('365class.class_teacher_users');
            }
            $data = array();
            $data['user_pass'] = "###" . md5(md5("UewBc27f4YZvbr0e6p" . $password));
            if(!($userMdl->where("mobile=ENCODE('".$mobile."','1!q2@w')")->find())){
                $this->ajaxReturn(2);
            }
            $result = $userMdl->where("mobile=ENCODE('$mobile','1!q2@w')")->save($data);
            //修改成功返回受影响行数，失败返回false
            if ($result) {
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(0);
            }
        }
    }
    public function wx_jump(){
        $openid=$_GET['openid'];
        $identify=$_GET['identify'];
        if($identify=='student'){
            $users=M('365class.class_student_users');
        }elseif($identify=='teacher'){
            $users=M('365class.class_teacher_users');
        }
        $result=$users->where(array('openid'=>$openid))->find();
//        dump($result);
        if($result==false){
            $url=U('Public/wx_bind',array('identify'=>$identify,'openid'=>$openid));
            $this->show("<script>alert('请先绑定已注册账号');window.location.href='{$url}';</script>");
        }elseif($result !=false || count($result)==1){
            //记录cookie
            $salt = $this->random_str(16);
            //第二分身标识
            $identifier = md5($salt . md5($result['id'] . $salt));
            //永久登录标识
            $token = md5(uniqid($result['user_pass'], true));
            //永久登录超时时间(1周)
            $timeout = time()+3600*24*7;
            setcookie('_auth',$identifier.':'.$token,$timeout,"/");
            $login_data = array(
                'login_id' => $result['id'],
                'login_type' => $result['user_type'],
                'login_ip' => get_client_ip(0,true),
                'login_time' => date("Y-m-d H:i:s"),
                'login_token' => $token
            );
            $r=M('365class.class_login_log')->add($login_data);
            $where['id'] =$result["id"];
            $data = array(
                'last_login_time' => date("Y-m-d H:i:s"),
                'last_login_ip' => get_client_ip(0,true),
                'identifier' =>$identifier,
                'token'=>$token,
                'timeout'=>$timeout
            );
            $users_model=new Model('365class.class_student_users');
            $users_model->where($where)->save($data);

            session("user_type",$result["user_type"]);
            session("nickname", $result["user_nicename"]);
            session("realname",$result['user_realname']);
            session("userid", $result["id"]);
            $sql="select DECODE(mobile,'1!q2@w') from class_student_users where id=".session('userid');
            $a=new Model();
            $b=$a->query($sql);
            $mobile=$b[0]['DECODE(mobile,\'1!q2@w\')'];
            cookie("_mobile",$mobile);
            $this->redirect($identify.'/index');
        }
    }
    public function wx_login(){
        if(IS_POST){
            $identify=I('post.identify');
            $appid = "wxb2604be2fd82a0b4";
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=http://wxpay.365xuet.com/test/oauth2.php&response_type=code&scope=snsapi_userinfo&state=$identify";
            header("Location:".$url);
        }
        $this->display();
    }
    public function wx_bind(){
        if(IS_POST){
            $openid=I('post.openid');
            $identify=I('post.identify');
            $mobile = I("post.t_mobile");
            $passwd = I("post.t_password");
//            dump($openid);dump($identify);dump($mobile);dump($passwd);
//            die('here');
            if (!checkMobile($mobile)) {
                echo "<script>alert('请输入正确的手机号码');window.history.go(-1);</script>";
                exit;
            } else if ($passwd == "") {
                echo "<script>alert('请输入密码');window.history.go(-1);</script>";
                exit;
            }
            $spasswd = "###" . md5(md5("UewBc27f4YZvbr0e6p" . $passwd));
            switch ($identify){
                case 'student':
                    $users=M('class_student_users');
                    break;
                case 'teacher':
                    $users=M('class_teacher_users');
                    break;
            }
//            dump($user);die;
            $result=$users->where("mobile=ENCODE('$mobile','1!q2@w') and user_pass='$spasswd'")->save(array('openid'=>$openid));
//            dump($result);die('here');
            if($result!=false){
                $userinfo=$users->where("mobile=ENCODE('$mobile','1!q2@w') and user_pass='$spasswd'")->field('user_type,user_nicename,user_realname,id')->find();
                if($userinfo){
                    session('user_type',$userinfo['user_type']);
                    session('nickname',$userinfo['user_nicename']);
                    session('realname',$userinfo['user_realname']);
                    session('userid',$userinfo['id']);
                    $sql="select DECODE(mobile,'1!q2@w') from class_student_users where id=".session('userid');
                    $a=new Model();
                    $b=$a->query($sql);
                    $mobile=$b[0]['DECODE(mobile,\'1!q2@w\')'];
                    cookie("_mobile",$mobile);
                }
                $url=U('Public/login');
                $this->show("<script>alert('绑定成功');window.location.href='{$url}';</script>");
            }else{
                echo "<script>alert('账户信息不正确');window.history.go(-1);</script>";
            }
        }
        $openid=I('get.openid');
        $identify=I('get.identify');
        $this->assign('openid',$openid);
        $this->assign('identify',$identify);
        $this->display();
    }
    //生成随机数,用于生成salt
    public function random_str($length){
        //生成一个包含 大写英文字母, 小写英文字母, 数字 的数组
        $arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $str = '';
        $arr_len = count($arr);
        for ($i = 0; $i < $length; $i++){
            $rand = mt_rand(0, $arr_len-1);
            $str.=$arr[$rand];
        }
        return $str;
    }
    public function test5(){
        $id=3999;
        $sql="select DECODE(mobile,'1!q2@w') from class_student_users where id='$id'";
        $a=new Model();
        $b=$a->query($sql);
        $mobile=$b[0]['DECODE(mobile,\'1!q2@w\')'];
        dump($mobile);die;
        $b=substr($a,7,11);dump($a);
        dump($b);
    }
}