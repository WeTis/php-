<?php
/**
 * 删除评论
 * User: talent
 * Date: 2018/11/12
 * Time: 11:12
 */

require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

function deleteComment($phpexcel) {
//    删除文章评论
    $articleId = empty($_POST['articleId']) != 1 ? $_POST["articleId"] : null;
    $userId = empty($_POST["userId"]) != 1 ? $_POST["userId"] : null;
    $commentId = empty($_POST["commentId"]) != 1 ? $_POST["commentId"] : null;

    $params = array(
        'articleId' => $articleId,
        'userId' => $userId,
        'commentId' => $commentId
    );
    // 连接数据库
    $db = new db($phpexcel);
    $res = $db->deleteComment($params);
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

deleteComment($phpexcel);