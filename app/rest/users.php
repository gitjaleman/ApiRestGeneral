<?php 
  require "header.php";
  require APP_MODELS."Users.php";
  
  $response = null;
  switch ($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $response = PROCESS_GET();
      break;
    case 'POST':
        $response = PROCESS_POST();
      break;
    case 'PUT':
        $response = PROCESS_PUT();
      break;
    case 'DELETE':
            echo "delete"; 
      break;
    case 'OPTIONS':
        OPTIONS_DEV();
      break;
  }


  function PROCESS_GET(){
    $Users = new Users;
    $result = null;
    if (isset($_GET['id'])) {
      $result = $Users->GET_ID($_GET['id']);
    } else {
      $result = $Users->GET();
    }
    return $result;
  }


  function PROCESS_POST(){
    $Users = new Users;
    $result = null;
    $data = json_decode(file_get_contents("php://input"), true);
    $result = $Users->POST($data);
    return $result;
  }


  function PROCESS_PUT(){
    $Users = new Users;
    $result = null;
    if (isset($_GET['id'])) {
      $data = json_decode(file_get_contents("php://input"), true);
      $result = $Users->UPDATE($_GET['id'],$data);
    } else {
      $result['status'] = false;
      $result['require'] = "id is required in the url";
    }
    return $result;
  }














  function OPTIONS_DEV(){
    /* {"dev": "JALEMAN","opera":"INSERT"} */
    $data = json_decode(file_get_contents("php://input"), true);
    $Users = new Users;
    if ($data['dev']==='JALEMAN') {
      switch ($data['opera']){
        case 'CREATE':
          $Users->DEV_CREATE();
          break;
        case 'INSERT':
          $Users->DEV_INSERT();
          break;
        case 'TRUNCATE':
          $Users->DEV_TRUNCATE();
          break;
        case 'DROP':
          $Users->DEV_DROP(); 
          break;
        case 'RESET':
          $Users->DEV_DROP(); 
          $Users->DEV_CREATE();
          $Users->DEV_INSERT();
          break;
      }
    }
  }

  echo json_encode($response);
?>