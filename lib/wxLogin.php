<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2019/2/20
 * Time: 18:14
 */

$code = $_POST['code'];
//print_r($code);
$json = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx6d408104df0509e4&secret=09fced1f55bd39d0b998a788072dd8bc&js_code='.$code.'&grant_type=authorization_code';
header("Content-Type: application/json");
$hh =  json_decode(file_get_contents($json),true);
var_dump($hh["openid"]);