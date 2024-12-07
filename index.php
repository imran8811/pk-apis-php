<?php
$request_method = $_SERVER['REQUEST_METHOD'];

if(!$request_method){
  exit();
} else {
  echo 'Invalid Path';
  exit();
}