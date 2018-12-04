<?php
/**
 * 判断用户是否已经登录
 * User: talent
 * Date: 2018/10/17
 * Time: 12:50
 */

require_once "./db.fun.php";
require_once '../configs/dbconfig.php';
function isLogined($phpexcel){
    //获取cookie

    if(isset($_COOKIE['username'])&& isset($_COOKIE['tokenimooc']) ){
        // 判断cookie是否正确
        $username = $_COOKIE['username'];
        $token = $_COOKIE['tokenimooc'];
        // 连接数据库获取数据
        $db = new db($phpexcel);
        $res = $db->selectAdminUser($username);
        if(!empty($res)){
            //存在 判断token是否正确
            $tokenstr = md5($res[0]['username'].'imooc');
            if($token == $tokenstr){
                // 已经登录
                return true;
            }else{
                return false;

            }
        }else{
            return false;

        }
    }else{
        return false;

    }
}

//isLogined($phpexcel);