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
        $arr = [];
       if($resource->num_rows > 0){
           $num = mysqli_num_rows($resource);  // 返回查询的函数

           for($i = 0; $i < $num; $i++){
               $arr[] = mysqli_fetch_assoc($resource);
           }
           if(!empty($arr)){
               return $arr;
           }
       }else{
           return $arr;
       }


    }

    /**
     * 根据$sql语句判断插入是否正确
     * @param $sql
     * @return $isSuccess  布尔值
     */
    function getResultadd($sql){
        $resource = mysqli_query($this->conn,$sql);
        if($resource == true){
           $isSuccess = true;
        }else{
            $isSuccess = false;
        }
        return $isSuccess;
    }

    /**
     * 判断sql是否更新成功
     * @param $sql
     * @return bool
     */
    function upDateSql($sql){
        $resource = mysqli_query($this->conn,$sql);
        if(mysqli_affected_rows($this->conn) > 0){
            return true;
        }else{
            return false;
        }
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
            $sql = 'SELECT username,password,freez FROM user WHERE username="'.$name.'" AND password="'.md5($password).'"';
        }

        $res = self::getResult($sql);

        return $res;
    }

    /**
     * 添加管理员（注册）
     * @param $name
     * @param $pass
     * @param $email
     * @return bool
     */
    public function addAdminUser($name,$pass,$email){
        $sql = 'INSERT INTO user(username,password,emaill) VALUES ("'.$name.'","'.$pass.'","'.$email.'")';
        $res = self::getResultadd($sql);
        return $res;
    }

    /**
     * 修改更新用户信息
     * @param $id
     * @param $name
     * @param $pass
     * @param $email
     * @return bool
     */
    public function modifyAdminUser($id,$name,$pass,$email){
        $sql = 'UPDATE user SET username="'.$name.'",password="'.$pass.'",emaill="'.$email.'" WHERE id='.$id;
        $res = self::upDateSql($sql);
        return $res;
    }

    /**
     * 删除用户
     * @param $id
     * @return bool
     */
    public function deleteAdminUser($id){
        $sql = 'DELETE FROM user WHERE id = '.$id;
        $res = self::upDateSql($sql);

        return $res;
    }

    /**
     * 冻结用户
     * @param $id
     * @return bool
     */
    public function freezeAdminUser($id){
        $sql = 'UPDATE user SET freez=2 WHERE id = '.$id;
        $res = self::upDateSql($sql);
        return $res;
    }

    /**
     * 解冻用户
     * @param $id
     * @return bool
     */
    public function unFreezeAdminUser($id){
        $sql = 'UPDATE user SET freez=1 WHERE id = '.$id;
        $res = self::upDateSql($sql);

        return $res;
    }
}
