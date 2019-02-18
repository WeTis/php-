<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/17
 * Time: 10:27
 */

//header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
require_once "./db.fun.php";
require_once '../configs/dbconfig.php';

//session_start();
// 判断验证码是否正确
//var_dump($_SESSION);

function login($username,$password,$verfiy,$phpexcel){

//    echo $_SESSION['verfiy'];
    if(!strcasecmp($_SESSION['verfiy'],$verfiy)){
        // 判断输入的用户名和密码是否正确
        $db = new db($phpexcel);
        $adminPassworAndUsername = $db->selectAdminUser($username,$password);
        if(!empty($adminPassworAndUsername)){
             $freez = $adminPassworAndUsername[0]["freez"];
             if($freez == 1){
                // 缓存一个令牌确定登录成功 设置cookie
                setcookie('username',$username,0);
                $token = md5($username.'imooc');
                setcookie("tokenimooc",$token,0);
                $str = array(
                    'status'=>90000,
                    'mes' => "登录成功"
                );

             }else if( $freez == 2){
                 $str = array(
                     'status'=>90001,
                     'mes' => "账号已被冻结"
                 );
             }
        }else{
            $str = array(
                'status'=>90001,
                'mes' => "登录失败，用户名或密码错误"
            );
        }
    }else{
        $str = array(
            'status'=>90001,
            'mes' => "验证码错误",
            'mm' => $_SESSION['verfiy'],
            'input' => $verfiy
        );
    }

    print_r(json_encode($str));
}

login($_POST['username'],$_POST['password'],$_POST['verfiy'],$phpexcel);