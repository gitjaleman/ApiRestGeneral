<?php


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
        $name       = $array['name'];
        $phone      = $array['phone'];
        $email      = $array['email'];
        $user       = $array['user'];
        $pass       = md5($array['pass']);
        $type       = $array['type'];

        $sql1="SELECT * FROM `users` WHERE `document` = '$document'";
        $conn = new Conn;
        $conn->set_charset("utf8");
        $query1 = $conn->query($sql1);
        $num = mysqli_num_rows($query1);

        if ($num>=1) {
          $data['process']  = 'CREATE NEW USER';
          $data['status']   = false;
          $data['message']  = "Document Duplicate";
        }else{

          $sql2 = "INSERT INTO `users` 
          (`id`, `document`, `name`, `phone`, `email`, `user`, `pass`, `type`) VALUES 
          (NULL, '$document', '$name', '$phone', '$email' , '$user', '$pass', '$type');";
          $conn = new Conn;
          $conn->set_charset("utf8");
          $conn->query($sql2);
          $data['process']  = 'CREATE NEW USER';
          $data['status']   = true;

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
    }

    return $data;
  }

  function UPDATE(){

  }

  function UPDATE_ID(){

  }

  function DELETE($id){

    $sql="DELETE FROM users WHERE `users`.`document` = '$id' ";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $query = $conn->query($sql);
    $data['process']  = 'DELETE USER';
    $data['status']   = true;
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
  }

  function DEV_INSERT(){
    $pass = md5(123456);
    $sql = "INSERT INTO `users` 
    (`id`, `document`, `name`, `phone`, `email`, `user`, `pass`, `type`) VALUES 
    (NULL, 123456, 'JAVIER ALEMAN', 123456, 'correo@correo' , 'JALEMAN', '$pass' , 'ADMIN');";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $conn->query($sql);
  }

  function DEV_TRUNCATE(){
    $sql="TRUNCATE TABLE `mecanizados`.`users`";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $conn->query($sql);
  }

  function DEV_DROP(){
    $sql="DROP TABLE `mecanizados`.`users`";
    $conn = new Conn;
    $conn->set_charset("utf8");
    $conn->query($sql);
  }


}



?>