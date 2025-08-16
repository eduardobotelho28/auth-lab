<?php
require_once __DIR__ . '/../utils.php';

// credenciais chumbadas
$USER = 'admin';
$PASS = '123456';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username !== $USER || $password !== $PASS) {
    json_response(['error' => 'invalid_credentials'], 401);
}

// gera tokens
$access = generate_access_token($username, 30);   // 30s
$refresh = generate_refresh_token();              // aleatório
store_refresh_for_user($username, $refresh, 3600);// 1h

json_response([
    'token_type'    => 'Bearer',
    'access_token'  => $access,
    'expires_in'    => 30,
    'refresh_token' => $refresh,
    'refresh_expires_in' => 3600
]);
