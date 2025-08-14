<?php
require_once __DIR__ . '/configs.php';
session_unset();
session_destroy();
redirect('index.php');
