<?php
/**
 * 添加评论addComment
 * User: talent
 * Date: 2018/11/12
 * Time: 10:08
 */


require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

function addComment($phpexcel) {
//    获取文章标题 作者 内容 概要
    $articleId = $_POST['articleId'];
    $userId = $_POST["userId"];
    $text = $_POST["text"];
    $loveNum = 0;
    $createTime = time();

    $params = array(
        'articleId' => $articleId,
        'userId' => $userId,
        'text' => $text,
        'loveNum' => $loveNum,
        'createTime' => $createTime
    );
    // 连接数据库
    $db = new db($phpexcel);
    $res = $db->addComment($params);
    if($res){
        $arr = array(
            'status' => 90000,
            'mes' => '评论成功'
        );
    }else{
        $arr = array(
            'status' => 90001,
            'mes' => '评论失败'
        );
    }

    print_r(json_encode($arr));
}

addComment($phpexcel);