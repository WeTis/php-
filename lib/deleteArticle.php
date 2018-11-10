<?php
/**
 * 删除文章deleteArticle
 * User: talent
 * Date: 2018/11/10
 * Time: 17:14
 */

require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

// 需要文章id
function deleteArticle($phpexcel) {

    $unmId = $_POST['unmId'];


    $params = array(
        "unmId" => $unmId
    );
    // 连接数据库
    $db = new db($phpexcel);
    $res = $db->deleteArticle($params);
    if($res){
        $arr = array(
            'status' => 90000,
            'mes' => '删除成功'
        );
    }else{
        $arr = array(
            'status' => 90001,
            'mes' => '删除失败'
        );
    }

    print_r(json_encode($arr));
}

deleteArticle($phpexcel);