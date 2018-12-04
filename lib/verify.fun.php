<?php
/**
 * Created by 魏桐.
 * User: talent
 * Date: 2018/10/15
 * Time: 14:11
 */
header("Content-Type: text/html;charset=utf-8");
//header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求

/**
 * 创建验证码图片
 * @param $stringArray         是否传入特定字符 如果传入字符通过半角逗号隔开   null(a-z,A-Z,0-9)
 * @param int $width           验证码图片宽度   100
 * @param int $height          验证码图片高度   50
 * @param array $bgcolor       验证码图片背景色 白色
 * @param int $fontSize        验证码内文字大小 14
 * @param int $verifyLength    验证码长度  4
 * @param int $pixelNum        验证码干扰元素点 默认100 传入0 则不显示
 * @param int $lineNum         验证码干扰线 默认5  传入0 则不显示
 */
function createVerify($stringArray=null,$width = 100,$height = 50,$bgcolor=[255,255,255],$fontSize = 20, $verifyLength = 4,$pixelNum = 100,$lineNum = 5){
    // 创建画布
    // 判断是否传入字符串
    if($stringArray){
        $string = $stringArray;
    }else{
        $string = range("a","z");  // 生成从a-z之间的所有字母的数组集
        $string = array_merge($string,range("A","Z"),range(0,9));  // 合并数组
        $string = join(',',$string);     // 将数据变为字符串
    }
    $string = explode(',',$string); // 字符串变为数组
    shuffle($string);  // 打乱字符串顺序
    session_start();
    $_SESSION['verfiy']=$string[0].$string[1].$string[2].$string[3];
    $img = imagecreatetruecolor($width,$height);
    // 创建颜色
    $colorbg = imagecolorallocate($img,$bgcolor[0],$bgcolor[1],$bgcolor[2]);
    // 填充矩形
    imagefilledrectangle($img,0,0,$width,$height,$colorbg);
    //开始绘画
    $fontY = ($height - $fontSize)/2 + $fontSize;
    $fonX = ($width - 10 - $fontSize*$verifyLength)/5;
    foreach($string as $key => $value) {
        $randColor = imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
        if($key < $verifyLength){
            imagettftext($img,$fontSize,rand(0,60),10+$fonX*($key+1)+$fontSize*$key,$fontY,$randColor,dirname(dirname(__FILE__)).'/fonts/simkai.ttf',$value);
        }
    }
    // 添加干扰元素 点
    for($i = 0; $i < $pixelNum; $i++){
        $randColor = imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
        imagesetpixel($img,rand(0,$width),rand(0,$height),$randColor);
    }
    // 添加干扰元素 线
    for($j = 0; $j < $lineNum; $j++){
        $randColor = imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
        imageline($img,rand(0,$width),rand(0,$height),rand(0,$width),rand(0,$height),$randColor);
    }
    // 告诉浏览器以图片形式显示
    header('content-type:image/png');
    // 保存
    $path = '/assets/verifyImg/'.time().'.png';
    imagejpeg($img);
//    imagejpeg($img,dirname(dirname(__FILE__)).$path);
    // 销毁
    imagedestroy($img);

//    return $path;
//    return str_replace('C:/xampp/htdocs','http://localhost:8080',str_replace('\\','/',dirname(dirname(__FILE__)).$path));
}
//createVerify();

