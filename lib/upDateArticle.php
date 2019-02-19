<?php
/**
 * 更新文章
 * User: talent
 * Date: 2018/10/30
 * Time: 18:55
 */
require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

// 需要文章的 作者 标题 内容 概要 文章id
function upDateArticle($phpexcel) {
//    获取文章标题 作者 内容 概要
    $createTime = time();

    $authorName = $_POST['authorName'];
    $title = $_POST["title"];
    $abstract = $_POST["abstract"];
    $unmId = $_POST['unmId'];
    $content =     preg_replace('/\"/', "'weitin", $_POST['content']);


    $authorImg = $_POST['authorImg'];
    $articleType = $_POST['articleType'];
    $audioSrc = $_POST['audioSrc'];
    $mainImg = $_POST['mainImg'];

    $params = array(
        'authorName' => $authorName,
        'title' => $title,
        'abstract' => $abstract,
        'content' => $content,
        'authorImg' => $authorImg,
        'articleType' => $articleType,
        'audioSrc' => $audioSrc,
        'mainImg' => $mainImg,
        'createTime' => $createTime,
        "unmId" => $unmId
    );
    // 连接数据库
    $db = new db($phpexcel);
    $res = $db->upDateArticle($params);
    if($res){
        $arr = array(
            'status' => 90000,
            'mes' => '修改成功'
        );
    }else{
        $arr = array(
            'status' => 90001,
            'mes' => '修改失败'
        );
    }

    print_r(json_encode($arr));
}

upDateArticle($phpexcel);