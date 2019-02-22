<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2019/2/20
 * Time: 18:14
 */

require_once "./db.fun.php";
require_once '../configs/dbconfig.php';


$db = new db($phpexcel);

function wxLogin($db){

    $code = $_POST["code"];
    $userName = empty($_POST["userName"]) != 1 ? $_POST["userName"] : null;
    $userImg = empty($_POST["userImg]"]) != 1 ? $_POST["userImg"] : null;
    if(empty($code) != 1){


        $wxInfo = getWXUserAppId($code);

        if(empty($userName) != 1 && empty($userImg) != 1){
            $params = array(
                "openId" => $wxInfo["openid"],
                "userName" => $userName,
                "userImg" => $userImg
            );
        }else{
            $params = array(
                "openId" => $wxInfo["openid"]
            );
        }
        // 判断用户是否存在
        $isExit = IsExitUser($db,$wxInfo["openid"]);
//        print_r(empty($isExit));
        if(empty($isExit) != 1 ){
            $arr = array(
                'status' => 90000,
                'mes' => '用户已经存在'
            );
            // 用户存在
            if($isExit[0]["hasInfo"] == 1){
                // 有用户信息
            }elseif ($isExit[0]["hasInfo"] == 2){
                // 没有用户信息
            }
        }else{
            // 用户不存在
            $res = $db->addAppUser($params);
            if($res){
                $arr = array(
                    'status' => 90000,
                    'mes' => '注册成功'
                );
            }else{
                $arr = array(
                    'status' => 90001,
                    'mes' => '获取失败'
                );
            }
        }
        print_r(json_encode($arr));
//        $addWXuser = $db->updateAppUser($params);
//        if($addWXuser){
//            //
//        }
    }




}
// 判断用户是否存在
function IsExitUser($db,$openid) {

    $isExit = $db->isHasUser($openid);
//    print_r($isExit);
    return $isExit;
}

/**
 * 获取用户微信登录信息 openId
 * @param $code
 * @return mixed
 */
function getWXUserAppId($code) {
    $json = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx6d408104df0509e4&secret=09fced1f55bd39d0b998a788072dd8bc&js_code='.$code.'&grant_type=authorization_code';
    header("Content-Type: application/json");
    $hh =  json_decode(file_get_contents($json),true);
//    var_dump($hh["openid"]);
    return $hh;
}

function generateToken() {

}

/**
 * 生成随机字符串
 * @param $length
 * @return null|string
 */
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}
wxLogin($db);
