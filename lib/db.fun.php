<?php
/**
 * Created by PhpStorm.
 * User: talent
 * Date: 2018/10/15
 * Time: 14:10
 */

// 数据库操作

class db{

    public $conn = null;

    /**
     * 数据库操作构造函数.
     * @param $config  链接数据库配置
     */
    public function __construct($config)
    {
        //连接数据库
        $this->conn = mysqli_connect($config['host'],$config['username'],$config['password']) or die(mysqli_error());
        // 判断数据库是否连接成功
        if(mysqli_connect_errno($this->conn)){
            echo "连接数据库失败" . mysqli_connect_error();
        }else{

        }

        // 选择要连接的表
        mysqli_select_db($this->conn,$config['database']) or die (mysqli_error());
        // 设定mysql编码
        mysqli_query($this->conn,"set names utf8");
    }

    /**
     *
     * 根据传入的sql语句查询mysqli结果集
     * @param $sql
     * @return array
     */

    public function getResult($sql){
        // sql语句查询
       $resource = mysqli_query($this->conn,$sql);
       print_r($resource->num_rows);
       if($resource->num_rows > 0){
           $num = mysqli_num_rows($resource);  // 返回查询的函数
           $arr = [];
           for($i = 0; $i < $num; $i++){
               $arr[] = mysqli_fetch_assoc($resource);
           }
       }
       if(!empty($arr)){
           echo '成功';
           return $arr;
       }else{
           echo '失败';
           print_r(mysqli_fetch_assoc($resource));
           return mysqli_fetch_assoc($resource);
       }

    }

    /**
     * 根据$sql语句判断插入是否正确
     * @param $sql
     * @return $isSuccess  布尔值
     */
    function getResultadd($sql){
        $resource = mysqli_query($this->conn,$sql);
        print_r($resource);
        if($resource == true){
           $isSuccess = true;
        }else{
            $isSuccess = false;
        }
        return $isSuccess;
    }

    /**
     * 查询管理员
     * @param null $name   管理员名字 (默认不存在)  如果用户名不存在则是查询管理员列表
     * @param null $password   管理员密码（默认不存在）  如果密码不存在则是判断管理员名字是否已经存在
     * @return array
     */
    public function selectAdminUser($name = null,$password=null){
        if(!$name){
            // 查询管理员列表
            $sql = 'SELECT * FROM user';
        }else if($name && !$password){
            // 判断管理员名字是否重复
            $sql = 'SELECT username FROM user WHERE username= "'.$name.'"';
        }else {
            // 判断管理员名字与密码是否相对应
            $sql = 'SELECT username,password FROM user WHERE username="'.$name.'" AND password="'.md5($password).'"';
        }

        $res = self::getResult($sql);

        return $res;
    }

    public function addAdminUser($name,$pass,$email){
        $sql = 'INSERT INTO user(username,password,emaill) VALUES ("'.$name.'","'.$pass.'","'.$email.'")';
        $res = self::getResultadd($sql);
        return $res;
    }


}
