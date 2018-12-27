<?php
/**
 * 生成html
 * User: talent
 * Date: 2018/12/27
 * Time: 16:00
 */
function dd($content){
    $fp=fopen("model.html","r"); //只读打开模板
    $str = fread($fp,filesize("model.html"));//读取模板中内容
//    $str=str_replace("{title}",$title,$str);
    $str=str_replace("{content}",$content,$str);//替换内容
    fclose($fp);

    $handle=fopen('./nn.html',"w"); //写入方式打开新闻路径
    fwrite($handle,$str); //把刚才替换的内容写进生成的HTML文件
    fclose($handle);

    $str = array(
        'status'=>90000,
        'src' => 'http://192.168.0.179:8080/imooc/lib/nn.html'
    );
    print_r(json_encode($str));
};

dd($_POST['content']);