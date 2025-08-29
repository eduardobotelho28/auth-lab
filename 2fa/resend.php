<?php
require_once __DIR__ . '/utils.php';

if (empty($_SESSION['user']['email'])) redirect('login.php');
start_2fa($_SESSION['user']['email'], 120, 5);
flash_set('error', 'Novo código gerado (prazo reiniciado).');
redirect('twofa.php');
