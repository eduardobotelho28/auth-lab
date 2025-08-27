<?php
require_once __DIR__ . '/utils.php';

$email = $_POST['email'] ?? '';
$pass  = $_POST['password'] ?? '';

if ($email !== DEMO_EMAIL || $pass !== DEMO_PASS) {
    flash_set('error', 'Credenciais inválidas.');
    redirect('login.php');
}

start_2fa($email, 120, 5); // 2 minutos, 5 tentativas
redirect('twofa.php');
