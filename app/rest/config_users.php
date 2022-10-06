<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
http_response_code(200);

$return=null;

switch ($_SERVER['REQUEST_METHOD']){
  case 'GET':
      $return = SELECT_USERS();
    break;
  case 'POST':
      $return = PROCESS_USERS();
    break;
  case 'DELETE':
      $return = DELETE_USER();
    break;
}

function SELECT_USERS(){
  $select = $_GET['s'];
  switch ($select){
    case 'all':
        $return = SELECT_USERS_ALL();
      break;
    case 'id':
        $return = SELECT_USERS_ID();
      break;
  }
  return $return;
}

function PROCESS_USERS(){
  $process = $_POST['s'];
  switch ($process){
    case 'insert':
        $return = INSERT_USER();
      break;
    case 'update':
        $return = UPDATE_USER();
      break;
  }
  return $return;
}






////////////////////////////////
//                           //
//          SELECT           //
//                           //
///////////////////////////////
function SELECT_USERS_ALL(){
  $obj = new conn;
  $sql = "SELECT * FROM `ciudades`";
  $con = $obj->query($sql);
  $num = mysqli_num_rows($con);
  $data['num'] = $num;
  if ($num >= 1) {
    while ($d = mysqli_fetch_assoc($con)) {
      $data['data'][] = $d;
    }
  } else {
    $data['data'] = FALSE;
  }
  return $data;
}

function SELECT_USERS_ID(){
  $obj = new conn;
  $sql = "SELECT * FROM `ciudades`";
  $con = $obj->query($sql);
  $num = mysqli_num_rows($con);
  $data['num'] = $num;
  if ($num >= 1) {
    while ($d = mysqli_fetch_assoc($con)) {
      $data['data'][] = $d;
    }
  } else {
    $data['data'] = FALSE;
  }
  return $data;
}







////////////////////////////////
//                           //
//          PROCESS          //
//                           //
///////////////////////////////
function INSERT_USER(){
  $obj = new conn;
  $sql = "SELECT * FROM `ciudades`";
  $con = $obj->query($sql);
  $num = mysqli_num_rows($con);
  $data['num'] = $num;
  if ($num >= 1) {
    while ($d = mysqli_fetch_assoc($con)) {
      $data['data'][] = $d;
    }
  } else {
    $data['data'] = FALSE;
  }
  return $data;
}

function UPDATE_USER(){
  $obj = new conn;
  $sql = "SELECT * FROM `ciudades`";
  $con = $obj->query($sql);
  $num = mysqli_num_rows($con);
  $data['num'] = $num;
  if ($num >= 1) {
    while ($d = mysqli_fetch_assoc($con)) {
      $data['data'][] = $d;
    }
  } else {
    $data['data'] = FALSE;
  }
  return $data;
}








///////////////////////////////
//                           //
//          DELETE           //
//                           //
///////////////////////////////
function DELETE_USER(){
  $obj = new conn;
  $sql = "SELECT * FROM `ciudades`";
  $con = $obj->query($sql);
  $num = mysqli_num_rows($con);
  $data['num'] = $num;
  if ($num >= 1) {
    while ($d = mysqli_fetch_assoc($con)) {
      $data['data'][] = $d;
    }
  } else {
    $data['data'] = FALSE;
  }
  return $data;
}








echo json_encode($return);