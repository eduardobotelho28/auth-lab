
<?php

echo '<pre>' ; print_r($_POST);

if(!isset($_POST['sendLogin']) OR $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location:form.php');
    exit();
}

require 'vars.php';

echo '<pre>' ; print_r($_POST);