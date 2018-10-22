<?php
/**
 * 修改密码
 * User: talent
 * Date: 2018/10/22
 * Time: 16:26
 */

require_once '../configs/dbconfig.php';
require_once './db.fun.php';

function modifyPassword($phpexcel,$name,$pass,$newpass){
    $db = new db($phpexcel);
    $pass = md5($pass);
    $newpass = md5($newpass);
    $res = $db->modifyPassword($name,$pass,$newpass);
    if($res){
        $arr = array(
            "status" => 90000,
            "mes" => "修改成功"
        );
    }else{
        $arr = array(
            "status" => 90001,
            "mes" => "修改失败"
        );
    }
    print_r(json_encode($arr));
}
modifyPassword($phpexcel,$_POST['name'],$_POST['password'],$_POST['newPassword']);