<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/20
 * Time: 9:45
 */
require_once '../configs/dbconfig.php';
require_once './db.fun.php';
require_once './isloginedFn.php';
function Modify($phpexcel,$id,$name,$pass,$email){
    $db = new db($phpexcel);
    $res = $db->modifyAdminUser($id,$name,md5($pass),$email);
    if($res){
        $arr = array(
          'status' => 90000,
          'mes' => "更新成功"
        );
    }else{
        $arr = array(
          'status' => 90001,
          'mes' => "更新失败"
        );
    }
    print_r(json_encode($arr));
}

if(isLogined($phpexcel)){
    Modify($phpexcel,$_POST['id'],$_POST['name'],$_POST['pass'],$_POST['email']);
}else{
    $arr = array(
        'status' => 90002,
        'mes' => "登录状态有误"
    );
    print_r(json_encode($arr));
}
