<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/15
 * Time: 16:49
 */

require_once "./lib/verify.fun.php";
require_once "./lib/db.fun.php";
require_once "./configs/dbconfig.php";
header("Content-Type: text/html;charset=utf-8");

createVerify();
//// 实例化数据库操作类
//$db = new db($phpexcel);
//echo md5('w963852741');
//// 查询所有管理员
//$listAdmin = $db->selectAdminUser();
//var_dump(json_encode($listAdmin));
//
//// 查询名字是否重复
//echo "<br/>";
//$adminName = $db->selectAdminUser('witinw');
//var_dump(json_encode($adminName));
//
//// 查询名字与密码是否相对应
//echo "<br/>";
//$adminPassworAndUsername = $db->selectAdminUser("witin",'w963852741');
//var_dump($adminPassworAndUsername);