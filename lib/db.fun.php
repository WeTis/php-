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

    /**
     * 用户自己修改密码
     * @param $name
     * @param $pass
     * @param $newpass
     * @return bool
     */
    public function modifyPassword($name,$pass,$newpass){
        $sql = 'UPDATE user SET password="'.$newpass.'" WHERE username="'.$name.'" AND password="'.$pass.'"';
        $res = self::upDateSql($sql);
        return $res;
    }

    public function findPassword(){

    }

    /**
     * 添加文章
     * @param $params
     * @return bool
     */
    public function addArticle($params){
        $sql = 'INSERT INTO author( `title`, `authorName`, `abstract`,  `content`, `createTime`,`authorImg`,`articleType`,`audioSrc`,`mainImg`) 
VALUES ("'.$params["title"].'","'.$params["authorName"].'","'.$params["abstract"].'","'.$params["content"].'","'.$params["createTime"].'","'.$params["authorImg"].'",'.$params["articleType"].',"'.$params["audioSrc"].'","'.$params["mainImg"].'")';
//       print_r($sql);
        $res = self::getResultadd($sql);
        return $res;
    }

    /**
     * 更新文章
     * @param $params
     * @return bool
     */
    public function upDateArticle($params) {
        $sql = 'UPDATE author SET title="'.$params["title"].'",authorName="'.$params["authorName"].'",abstract="'.$params["abstract"].'",content="'.$params["content"].'",createTime="'.$params["createTime"].'" WHERE id='.$params["unmId"];
        $res = self::upDateSql($sql);
        return $res;
    }

    /**
     * 删除文章
     * @param $params
     * @return bool
     */
    public function deleteArticle($params){
        $sql = 'DELETE FROM author WHERE id = '.$params["unmId"];
        $res = self::upDateSql($sql);
        return $res;
    }


    /**
     * 根据不同传入的值获取文章列表
     * $name = null,$author=null,$time=null
     * @param $params
     * @return array
     */
    public function getArticleList($params){
        if(empty($params["title"]) == 1 && empty($params["author"]) == 1 && empty($params["time"]) == 1 && empty($params["articleId"])){
            // 查询所有文章
//            $sql = 'SELECT * FROM author LIMIT '.($params["page"]-1 ) * 10 .',10';
             $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM author LIMIT '.($params["page"]-1 ) * 10 .',10';


        }else if($params["title"]){
            // 根据标题查询
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM author WHERE title= "'.$params["title"].'"  LIMIT '.($params["page"]-1 ) * 10 .',10';
        }else if($params["author"]) {
            // 根据作者查询
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM author WHERE authorName="'.$params["author"].'" LIMIT '.($params["page"]-1 ) * 10 .',10';
        }else if($params["time"]){
            // 根据时间查询 > 大于
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM author WHERE createTime ="'.$params["time"].'" OR createTime > "'.$params["time"].'" LIMIT '.($params["page"]-1 ) * 10 .',10';
        }else if($params["articleId"]){
            $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM author WHERE id='.$params["articleId"];
        }
        $res = self::getResult($sql);
        $sql = 'SELECT FOUND_ROWS()';
        $num = mysqli_query($this->conn,$sql);
        if($rs=mysqli_fetch_array($num)){
            $total=$rs[0];
        }else{
            $total=0;
        }
        $arr = array(
            "nums" => $total,
            "res" => $res,
        );
        return $arr;
    }

    /**
     * 添加评论
     * @param $params
     *  @return array
     */
    public function addComment($params){
        $sql = 'INSERT INTO article_comments(`articleId`,`userId`,`text`,`createTime`,`loveNum`) VALUES ('.$params["articleId"].','.$params["userId"].',"'.$params["text"].'",'.$params["createTime"].','.$params["loveNum"].')';
        $res = self::getResultadd($sql);
        return $res;
    }

    /**
     * 获取评论 通过文章id、用户id、 待定
     * @param $params
     *  @return array
     */

    public function getComment($params){
        if(empty($params["articleId"]) != 1){
            $sql = 'SELECT * FROM article_comments WHERE articleId='.$params["articleId"] .' LIMIT '.($params["page"]-1)*10 . ',10';

        }else if(empty($params["userId"]) != 1) {
            $sql = 'SELECT * FROM article_comments WHERE userId=' . $params["userId"] . ' LIMIT ' . ($params["page"] - 1) * 10 . ',10';
        }
        $res = self::getResult($sql);
        return $res;
    }

    /**
     * 删除评论
     * @param $params
     * @return bool
     */
    public function deleteComment($params){
        if(empty($params["articleId"]) != 1 && empty($params["userId"]) != 1 && empty($params['commentId']) != 1){
            $sql = 'DELETE FROM article_comments WHERE articleId='.$params["articleId"].' AND userId='.$params["userId"].' AND id='.$params['commentId'];
        }else{
            $sql = 'DELETE FROM article_comments WHERE userId='.$params["userId"];
        }

        $res = self::upDateSql($sql);
        return $res;
    }

    /**
     * 评论添加点赞数
     * @param $params
     * @return bool
     */
    public function addCommentLikeNum($params){
        $sql = 'UPDATE article_comments SET loveNum='. $params["commentLoveNum"].' WHERE id = '.$params['commentId'];
        $res = self::getResultadd($sql);
        return $res;
    }

    /**
     * 获取单个评论点赞数
     * @param $params
     * @return array
     */
    public function getCommentLikeNum($params) {
        $sql = 'SELECT loveNum FROM article_comments WHERE id='.$params['commentId'];
        $res = self::getResult($sql);
        return $res;
    }
    /**
     * 评论点赞的用户，文章，评论相关信息
     * @param $params
     * @return bool
     */
    public function addCommentLikeUser($params) {
        $sql = 'INSERT INTO comment_like_user(`commentId`,`userId`,`articleId`) VALUES ('.$params["commentId"].','.$params["userId"].','.$params["articleId"].')';
        $res = self::getResultadd($sql);
        return $res;
    }

    /**
     * 根据用户id 以及评论id 判断此评论用户是否已经点赞
     * @param $params
     * @return array
     */
    public function findCommentByUserIdAndCommentId($params){
       $sql = 'SELECT * FROM comment_like_user WHERE commentId='.$params["commentId"].' AND userId='.$params["userId"];
       $res = self::getResult($sql);
       return $res;
    }
}
