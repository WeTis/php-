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
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            '主机名'=>$_SERVER['SERVER_NAME'],
            'WEB服务端口'=>$_SERVER['SERVER_PORT'],
            '网站文档目录'=>$_SERVER["DOCUMENT_ROOT"],
            '浏览器信息'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '通信协议'=>$_SERVER['SERVER_PROTOCOL'],
            '请求方法'=>$_SERVER['REQUEST_METHOD'],
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '服务器IP'=>$_SERVER['SERVER_ADDR'],
            '用户的IP地址'=>$_SERVER['REMOTE_ADDR'],
            '剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
            "location" => $src

        );
        print_r(json_encode($resquset));
    }
}

