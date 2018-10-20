<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/20
 * Time: 11:19
 */

require_once '../configs/dbconfig.php';
require_once './db.fun.php';

function detele($phpexcel,$id){
    $db = new db($phpexcel);
    $res = $db->deleteAdminUser($id);
    if($res){
        $arr = array(
            'status' => 90000,
            'mes' => "删除成功"
        );
    }else{
        $arr = array(
            'status' => 90001,
            'mes' => "删除失败"
        );
    }

    print_r(json_encode($arr));
}
detele($phpexcel,$_POST['id']);
