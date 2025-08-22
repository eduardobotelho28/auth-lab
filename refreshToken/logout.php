<?php
require_once __DIR__ . '/utils.php';
session_unset();
session_destroy();
header('Location: login.php');
exit;
