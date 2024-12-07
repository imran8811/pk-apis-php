<?php
  $dsn = "mysql:host=localhost;dbname=pkapparel_retail";
  $username = 'root';
  $password = 'Dubai!@#45';

  try {
    $db = new PDO($dsn, $username, $password);
  } catch(PDOException $e){
    $error = 'DB Error';
    $error .= $e->getMessage();
    exit();
  }

