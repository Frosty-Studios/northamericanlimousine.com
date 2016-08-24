<?php

  $db = new PDO("mysql:host=localhost;dbname=phoneapp", 'root', 'apple360');

  $data = json_decode(file_get_contents("php://input"));
  $password = sha1($data->password);
  $username = $data->username;
  $firstName = $data->firstName;
  $lastName = $data->lastName;

  $userInfo = $db->query("SELECT username FROM users WHERE username='$username' AND password='$password'");
  $userInfo = $userInfo->fetchAll();

  if(count($userInfo) == 1){
    echo json_encode($username);
  } else {
    echo "ERROR";
  }

?>
