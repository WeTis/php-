<?php
/**
 * 获取管理员列表
 * User: talent
 * Date: 2018/10/17
 * Time: 15:26
 */
require_once "./db.fun.php";
require_once "../configs/dbconfig.php";
require_once './isloginedFn.php';
function getAdminList($phpexcel){
    $db = new db($phpexcel);
    $res = $db->selectAdminUser();

    if(!empty($res)){
        $arr = array(
            "status" => 90000,
            "mes" => "获取成功",
            "params" => $res
        );
    }else{
        $arr = array(
            "status" => 90001,
            "mes" => "获取失败"
        );
    }

    print_r(json_encode($arr));
}


if(isLogined($phpexcel)){
    getAdminList($phpexcel);
}else{
    $arr = array(
        'status' => 90002,
        'mes' => "登录状态有误"
    );
    print_r(json_encode($arr));
}