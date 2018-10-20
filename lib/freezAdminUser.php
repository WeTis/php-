<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/20
 * Time: 11:50
 */

require_once '../configs/dbconfig.php';
require_once './db.fun.php';

function free($phpexcel,$id){
    $db = new db($phpexcel);
    $res = $db->freezeAdminUser($id);
    if($res){
        $arr = array(
            "status" => 90000,
            "mes" => "冻结成功"
        );
    }else{
        $arr = array(
            "status" => 90001,
            "mes" => "冻结失败"
        );
    }
    print_r(json_encode($arr));
}

free($phpexcel,$_POST['id']);