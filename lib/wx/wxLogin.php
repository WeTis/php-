<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2019/2/20
 * Time: 18:14
 */


include_once "wxBizDataCrypt.php";
//session_start();

if(isset($_SESSION['wxsision'])){
    getData($_SESSION['wxsision']);
}else{
    $code = $_POST["code"];
    $json = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx6d408104df0509e4&secret=09fced1f55bd39d0b998a788072dd8bc&js_code='.$code.'&grant_type=authorization_code';
    header("Content-Type: application/json");
    $hh =  json_decode(file_get_contents($json),true);
    $_SESSION['wxsision'] = $hh["session_key"];
    // 获取步数
    getData( $hh["session_key"]);
}


function getData($sessionKey){
    $pc = new WXBizDataCrypt("wx6d408104df0509e4", $sessionKey);

    $errCode = $pc->decryptData($_POST['encryptedData'], $_POST['iv'], $data );
    if ($errCode == 0) {
        print($data . "\n");
    } else {
        print($errCode . "\n");
    }
}



