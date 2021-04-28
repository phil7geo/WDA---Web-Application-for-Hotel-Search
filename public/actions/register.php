<?php


use Hotel\User;

//Boot application
require_once __DIR__.'/../../boot/boot.php';

//Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
  header('Location: /');

  return;
}

//Create new user
$user = new User();
$user->insert($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);

//Return to login page
header('Location: /public/login.php');
