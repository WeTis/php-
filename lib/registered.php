<?php
/**
 * 注册管理员
 * User: talent
 * Date: 2018/10/19
 * Time: 11:46
 */

require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

function registered($phpexcel) {
    // 获取用户名 密码 邮箱

    $name = $_GET['username'];
    $pass = md5($_GET['password']);
    $email = $_GET['email'];


    // 连接数据库
    $db = new db($phpexcel);
    // 判断用户名是否已经存在
    $adminPassworAndUsername = $db->selectAdminUser($name);
    print_r($adminPassworAndUsername);
//    if(!empty($adminPassworAndUsername)){
//        // 已经存在
//        $arr = array(
//          'status' => 90001,
//            'mes' => '用户名已经存在'
//        );
//    }else{
//        // 不存在
//       $res = $db->addAdminUser($name,$pass,$email);
//       if(!empty($res)){
//           print_r($res);
//       }
//
//    }
    print_r(json_encode($arr));
}

registered($phpexcel);