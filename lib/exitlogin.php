<?php
/**
 * 退出登录
 * User: talent
 * Date: 2018/10/17
 * Time: 15:11
 */

function exitLogin( ){
    // 退出 清空cookie
    setcookie("username", "", time()-3600);
    setcookie("tokenimooc", "", time()-3600);
    $arr = array(
        "status" => 90000,
        "mes" => "退出成功"
    );
    print_r(json_encode($arr));
}

exitLogin();