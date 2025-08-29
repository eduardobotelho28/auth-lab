<?php
require_once __DIR__ . '/utils.php';

$code = $_POST['code'] ?? '';
$res  = check_2fa_code($code);

if (!$res['ok']) {
    switch ($res['reason'] ?? '') {
        case 'expired':
            flash_set('error', 'Código expirou. Clique em "Reenviar código".');
            break;
        case 'too_many_attempts':
            // invalida fluxo e exige novo login
            session_unset(); session_destroy();
            session_start();
            flash_set('error', 'Muitas tentativas. Faça login novamente.');
            redirect('login.php');
            break;
        case 'mismatch':
            $left = $res['left'] ?? 0;
            flash_set('error', "Código incorreto. Tentativas restantes: {$left}.");
            break;
        default:
            flash_set('error', 'Fluxo inválido. Faça login novamente.');
            redirect('login.php');
    }
    redirect('twofa.php');
}

redirect('dashboard.php');
