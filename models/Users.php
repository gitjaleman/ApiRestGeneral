<?php

error_reporting(0);

class Users{

  function GET(){
    $sql="SELECT * FROM `users`";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $query = $conn->query($sql);
    $num = mysqli_num_rows($query);
    $data['num'] = $num;
    if ($num >= 1) {
      while ($d = mysqli_fetch_assoc($query)) {
        $data['data'][] = $d;
      }
    } else {
      $data['data'] = FALSE;
    }
    http_response_code(200);
    return $data;
  }

  function GET_ID($id){
    $sql="SELECT * FROM `users` WHERE `document` = '$id'";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $query = $conn->query($sql);
    $num = mysqli_num_rows($query);
    $data['num'] = $num;
    if ($num >= 1) {
      while ($d = mysqli_fetch_assoc($query)) {
        $data['data'][] = $d;
      }
    } else {
      $data['data'] = FALSE;
    }
    http_response_code(200);
    return $data;
  }

  function POST($array){
    $data = null;
    if (
      array_key_exists('document' ,$array) &&
      array_key_exists('name'     ,$array) &&
      array_key_exists('phone'    ,$array) &&
      array_key_exists('email'    ,$array) && 
      array_key_exists('user'     ,$array) && 
      array_key_exists('pass'     ,$array) &&
      array_key_exists('type'     ,$array)
      ){
        $document   = $array['document'];
        $name       = mb_strtoupper($array['name']);
        $phone      = mb_strtoupper($array['phone']);
        $email      = mb_strtoupper($array['email']);
        $user       = mb_strtoupper($array['user']);
        $pass       = md5($array['pass']);
        $type       = mb_strtoupper($array['type']);
        $sql1="SELECT * FROM `users` WHERE `document` = '$document'";
        $conn = new Conn;
        $conn->set_charset("utf8");
        $query1 = $conn->query($sql1);
        $num = mysqli_num_rows($query1);
        if ($num>=1) {
          $data['process']  = 'CREATE NEW USER';
          $data['status']   = false;
          $data['message']  = "Document Duplicate";
          http_response_code(202);
        }else{
          $sql2 = "INSERT INTO `users` 
          (`id`, `document`, `name`, `phone`, `email`, `user`, `pass`, `type`) VALUES 
          (NULL, '$document', '$name', '$phone', '$email' , '$user', '$pass', '$type');";
          $conn = new Conn;
          $conn->set_charset("utf8");
          $conn->query($sql2);
          $data['process']  = 'CREATE NEW USER';
          $data['status']   = true;
          http_response_code(200);
        }
    }else{
      $data['status']=false;
      $data['message'] = "error in  the operation ";
      $data['require'] =  array(
        'document' => 'number', 
        'name' => 'text', 
        'phone' => 'text',
        'email' => 'text',
        'user' => 'text',
        'pass' => 'text',
        'type' => 'text', 
      );
      http_response_code(202);
    }
    return $data;
  }

  

  function UPDATE($id,$array){
    $data = null;
    $conn = new Conn;
    $conn->set_charset("utf8");
    $sql1="UPDATE `users` SET ";
    $sql2="WHERE `users`.`document` = '$id' ";
    if(array_key_exists('name' ,$array)){
      $sql = $sql1." `name` = "."'".mb_strtoupper($array['name'])."' ".$sql2;
      $query = $conn->query($sql);
      if ($query) {
        $data['UPDATE']['name']['status']=true;
      }else{
        $data['UPDATE']['name']['status']=false;
        $data['UPDATE']['name']['sql']=$sql;
      }
    }
    if(array_key_exists('phone' ,$array)){
      $sql = $sql1." `phone` = "."'".mb_strtoupper($array['phone'])."' ".$sql2;
      $query = $conn->query($sql);
      if ($query) {
        $data['UPDATE']['phone']['status']=true;
      }else{
        $data['UPDATE']['phone']['status']=false;
        $data['UPDATE']['phone']['sql']=$sql;
      }
    }
    if(array_key_exists('email' ,$array)){
      $sql = $sql1." `email` = "."'".mb_strtoupper($array['email'])."' ".$sql2;
      $query = $conn->query($sql);
      if ($query) {
        $data['UPDATE']['email']['status']=true;
      }else{
        $data['UPDATE']['email']['status']=false;
        $data['UPDATE']['email']['sql']=$sql;
      }
    }
    if(array_key_exists('user' ,$array)){
      $sql = $sql1." `user` = "."'".mb_strtoupper($array['user'])."' ".$sql2;
      $query = $conn->query($sql);
      if ($query) {
        $data['UPDATE']['user']['status']=true;
      }else{
        $data['UPDATE']['user']['status']=false;
        $data['UPDATE']['user']['sql']=$sql;
      }
    }
    if(array_key_exists('pass' ,$array)){
      $sql = $sql1." `pass` = "."'".md5($array['pass'])."' ".$sql2;
      $query = $conn->query($sql);
      if ($query) {
        $data['UPDATE']['pass']['status']=true;
      }else{
        $data['UPDATE']['pass']['status']=false;
        $data['UPDATE']['pass']['sql']=$sql;
      }
    }
    if(array_key_exists('type' ,$array)){
      $sql = $sql1." `type` = "."'".mb_strtoupper($array['type'])."' ".$sql2;
      $query = $conn->query($sql);
      if ($query) {
        $data['UPDATE']['type']['status']=true;
      }else{
        $data['UPDATE']['type']['status']=false;
        $data['UPDATE']['type']['sql']=$sql;
      }
    }
    $data['process']  = 'UPDATE USER';

    if($data['UPDATE']){
      $result['status'] = true;
    }else{
      $result['status'] = false;
      $result['message'] = "check the sent JSON";
    }
    http_response_code(202);
    return $data;
  }


  function DELETE($id){
    $sql="DELETE FROM users WHERE `users`.`document` = '$id' ";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $query = $conn->query($sql);
    $data['process']  = 'DELETE USER';
    $data['status']   = true;
    http_response_code(200);
    return $data;
  }



  /* DEV */
  function DEV_CREATE(){
    $sql = "CREATE table Users(
      id int(10) primary key AUTO_INCREMENT,
      document bigint(30),
      name  varchar(40),
      phone varchar(20),
      email varchar(60),
      user  varchar(20),
      pass  varchar(20),
      type  varchar(10)
    )";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $conn->query($sql);
    http_response_code(200);
  }

  function DEV_INSERT(){
    $pass = md5(123456);
    $sql = "INSERT INTO `users` 
    (`id`, `document`, `name`, `phone`, `email`, `user`, `pass`, `type`) VALUES 
    (NULL, 123456, 'JAVIER ALEMAN', 123456, 'correo@correo' , 'JALEMAN', '$pass' , 'ADMIN');";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $conn->query($sql);
    http_response_code(200);
  }

  function DEV_TRUNCATE(){
    $sql="TRUNCATE TABLE `mecanizados`.`users`";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $conn->query($sql);
    http_response_code(205);
  }

  function DEV_DROP(){
    $sql="DROP TABLE `mecanizados`.`users`";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $conn->query($sql);
    http_response_code(205);
  }


}



?>