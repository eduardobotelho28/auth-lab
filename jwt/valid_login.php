
<?php

if(!isset($_POST['sendLogin']) OR $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location:form.php');
    exit();
}

require 'vars.php'     ;
require 'functions.php';

if($_POST['username'] !== USERNAME OR $_POST['password'] !== PASSWORD) {
    header('Location:form.php');
    exit();
}

$jwtToken = generateToken($_POST['username']);

setcookie('token', $jwtToken, (time() + (60 * 60 * 24 * 7)));

header('Location: dashboard.php');