<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/17
 * Time: 10:27
 */
require_once "./db.fun.php";
require_once '../configs/dbconfig.php';
function login($username,$password,$verfiy,$phpexcel){
    session_start();
    // 判断验证码是否正确
    if(!strcasecmp($_SESSION['verfiy'],$verfiy)){
        // 判断输入的用户名和密码是否正确
        $db = new db($phpexcel);
        $adminPassworAndUsername = $db->selectAdminUser($username,$password);
        if(!empty($adminPassworAndUsername)){

            // 缓存一个令牌确定登录成功 设置cookie
            setcookie('username',$username,0);
            $token = md5($username.'imooc');
            setcookie("tokenimooc",$token,0);
            $str = array(
                'status'=>90000,
                'mes' => "登录成功"
            );
        }else{
            $str = array(
                'status'=>90001,
                'mes' => "登录失败，用户名或密码错误"
            );
        }
    }else{
        $str = array(
            'status'=>90001,
            'mes' => "验证码错误".$_SESSION['verfiy']
        );
    }



    print_r(json_encode($str));
}

login($_GET['username'],$_GET['password'],$_GET['verfiy'],$phpexcel);