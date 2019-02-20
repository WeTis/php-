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
    $page = empty($_POST['page']) != 1 ? $_POST['page'] : 1;
    $articleId = empty($_POST['articleId']) != 1 ? $_POST["articleId"] : null;
    $userId = empty($_POST['userId']) != 1 ? $_POST["userId"] : null;
    $params = array(
        "title" => $title,
        "author" => $author,
        "time" => $time,
        "page" => $page,
        "articleId" => $articleId,
        "userId" => $userId
    );
    // 连接数据库
    $db = new db($phpexcel);
    $res = $db->getArticleList($params);
//    echo $res;
    if(!empty($res['res'])){

        if($articleId){
            $resComment = $db->getComment($params);
            if(!empty($resComment)){


                for($i = 0; $i < sizeof($resComment); $i++){
//                    print_r($resComment[$i]["id"]);
                    // 查询该评论是否已经被当前用户点赞
                    $paramsC = array(
                        "commentId" => $resComment[$i]["id"],
                        "userId" => $userId
                    );
//                    $resNu = $db ->findCommentByUserIdAndCommentId($paramsC);
//                    print_r($resNu);
//                    if($resNu){
//                        $resComment[$i]["loved"] = true;
//                    }
                }
                $arr = array(
                    "status" => 90000,
                    "mes" => "获取成功",
                    "params" => $res,
                    "comments" => $resComment
                );
            }else{
                $arr = array(
                    "status" => 90000,
                    "mes" => "获取成功",
                    "params" => $res,
                    "comments" => null
                );
            }

        }else{

            for($j = 0; $j < sizeof($res['res']); $j++){
                $pa = array(
                    "articleId" => $res['res'][$j]['id'],
                );
                $resComment = $db->getCommentAll($pa);
                $res['res'][$j]["commonnn"] = $resComment;
            }
            $arr = array(
                "status" => 90000,
                "mes" => "获取成功",
                "params" => $res['res'],
                'nums' => $res['nums']
            );
        }
    }else{
        $arr = array(
            "status" => 90001,
            "mes" => "获取失败"
        );
    }

    print_r(json_encode($arr));
}

getArticleList($phpexcel);