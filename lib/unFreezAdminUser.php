<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/20
 * Time: 11:59
 */
require_once '../configs/dbconfig.php';
require_once './db.fun.php';

function unfreez($phpexcel,$id){
    $db = new db($phpexcel);
    $res = $db->unFreezeAdminUser($id);
    if($res){
        $arr = array(
            "status" => 90000,
            "mes" => "解冻成功"
        );
    }else{
        $arr = array(
            "status" => 90001,
            "mes" => "解冻失败"
        );
    }

    print_r(json_encode($arr));
}
unfreez($phpexcel,$_POST['id']);