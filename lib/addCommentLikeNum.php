<?php
/**
 * 添加点赞 addCommentLikeNum
 * User: talent
 * Date: 2018/11/12
 * Time: 11:43
 */

require_once "../configs/dbconfig.php";
require_once  './db.fun.php';

function addCommentLikeNum($phpexcel) {
//    添加点赞
    $articleId = $_POST['articleId'];
    $userId = $_POST["userId"];
    $commentId = $_POST["commentId"];
    $params = array(
      "articleId" => $articleId,
        "userId" => $userId,
        "commentId" => $commentId
    );
    // 连接数据库
    $db = new db($phpexcel);
    $num = $db->getCommentLikeNum($params);
    if($num){
        print_r($num[0]);
        $commentLoveNum = $num[0]["loveNum"]+1;
        $paramsA = array(
            "commentLoveNum" => $commentLoveNum,
            "commentId" => $commentId
        );
        $res = $db->addCommentLikeNum($paramsA);
        if($res){
            $resA = $db->addCommentLikeUser($params);
            if($resA){
                $arr = array(
                    'status' => 90000,
                    'mes' => '点赞成功'
                );
            }else{
                $arr = array(
                    'status' => 90001,
                    'mes' => '点赞失败'
                );
            }

        }else{
            $arr = array(
                'status' => 90001,
                'mes' => '点赞失败'
            );
        }
    }else{
        $arr = array(
            'status' => 90000,
            'mes' => '点赞失败'
        );
    }


    print_r(json_encode($arr));
}

addCommentLikeNum($phpexcel);