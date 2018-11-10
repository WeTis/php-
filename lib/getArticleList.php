<?php
/**
 * 查询文章列表 getArticleList
 * User: talent
 * Date: 2018/11/10
 * Time: 17:59
 */
require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

// 需要文章id
function getArticleList($phpexcel) {
    $title = empty($_POST["title"]) != 1 ? $_POST["title"] : null;
    $author = empty($_POST["author"]) != 1 ? $_POST["author"] : null;
    $time = empty($_POST['time']) !=1 ? $_POST['time'] : null;

    $params = array(
        "title" => $title,
        "author" => $author,
        "time" => $time
    );
    // 连接数据库
    $db = new db($phpexcel);
    $res = $db->getArticleList($params);
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

getArticleList($phpexcel);