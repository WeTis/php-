<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2019/1/28
 * Time: 18:25
 */

/**
 * 编写上传图片到自己服务器
 * 编写上传图片到阿里ioss图片管理服务器
 */


header('content-type:text/html;charset=utf-8');
require_once "./db.fun.php";
require_once "../configs/dbconfig.php";
require_once './isloginedFn.php';
require_once 'upload.class.php';


if(isLogined($phpexcel)){
    uploadImg();
}else{
    $arr = array(
        'status' => 90002,
        'mes' => "登录状态有误"
    );
    print_r(json_encode($arr));
}

function uploadImg(){

    foreach($_FILES as $arr){
        $upload = new uploadImg($arr,'imooc');
        $dest = $upload->uploadFile();
        $past =  $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
        $src = 'http://'.str_replace($_SERVER["DOCUMENT_ROOT"],$past,str_replace('\\','/',__DIR__)).'/'.$dest;
        $resquset = array(
            'status' => 90000,
            'mes' => "上传成功",
            "location" => $src

        );
        print_r(json_encode($resquset));
    }
}

