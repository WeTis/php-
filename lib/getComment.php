<?php
/**
 * 获取评论getComment
 * User: talent
 * Date: 2018/11/12
 * Time: 10:34
 */

require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

// 需要文章id
function getComment($phpexcel) {
//    $title = empty($_POST["title"]) != 1 ? $_POST["title"] : null;
//    $author = empty($_POST["author"]) != 1 ? $_POST["author"] : null;
//    $time = empty($_POST['time']) !=1 ? $_POST['time'] : null;
    $page = empty($_POST['page']) != 1 ? $_POST['page'] : 1;
    $articleId = empty($_POST['articleId']) != 1 ? $_POST['articleId'] : null;
    $userId = empty($_POST['userId']) != 1 ? $_POST['userId'] : null;

    $params = array(
       "articleId" => $articleId,
        "userId" => $userId,
        "page" => $page
    );
    // 连接数据库
    $db = new db($phpexcel);
    $res = $db->getComment($params);
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

getComment($phpexcel);