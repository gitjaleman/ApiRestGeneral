<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
http_response_code(200);

$return=null;

switch ($_SERVER['REQUEST_METHOD']){
  case 'GET':
      $return = SELECT_ROLES();
    break;
  case 'POST':
      $return = INSERT_ROLES();
    break;
  case 'DELETE':
      $return = DELETE_ROLES();
    break;
}




////////////////////////////////
//                           //
//          SELECT           //
//                           //
///////////////////////////////
function SELECT_ROLES(){
  $obj = new conn;
  $sql = "SELECT * FROM `roles`";
  $con = $obj->query($sql);
  $num = mysqli_num_rows($con);
  $data['num'] = $num;
  if ($num >= 1) {
    while ($d = mysqli_fetch_assoc($con)) {
      $data['data'][] = $d;
    }
  } else {
    $data['data'] = FALSE;
    $data['sql'] = $sql;
  }
  return $data;
}




////////////////////////////////
//                           //
//          INSERT           //
//                           //
///////////////////////////////
function INSERT_ROLES(){
  $rol    = mb_strtoupper($_POST['r']);
  $obj=new conn;
  $sql="INSERT INTO `roles` (`rol`)   VALUES ('$rol');";
  $result=$obj->query($sql);
  $data['sql']=$sql;
  $data['result']=$result;
  return $data;
}



////////////////////////////////
//                           //
//          DELETE           //
//                           //
///////////////////////////////
function DELETE_ROLES(){
  $id  = $_GET['id'];
  $obj=new conn;
  $sql="DELETE FROM `roles` WHERE `roles`.`id` = '$id' ";
  $result=$obj->query($sql);
  $data['sql']=$sql;
  $data['result']=$result;
  return $data;
}




echo json_encode($return);