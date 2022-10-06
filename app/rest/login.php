<?php 
  require "header.php";
  require APP_MODELS."login.php";

  $login = new Login;
  $login -> GET(1,3);

?>