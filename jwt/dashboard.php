<?php

require ('functions.php');

if(!validateToken()){
    header('Location: form.php');
    exit();
}


echo "welcome, you have a jwt!";