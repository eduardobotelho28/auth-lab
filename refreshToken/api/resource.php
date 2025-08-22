<?php
require_once __DIR__ . '/../utils.php';

$token = get_bearer_token();
if (!$token) json_response(['error' => 'missing_token'], 401);

$ver = jwt_decode_verify($token, TOKEN_SECRET);
if (!$ver['valid']) {
    // devolve 401 para que o client tente refresh
    json_response(['error' => 'invalid_or_expired', 'detail' => $ver['error']], 401);
}

// sucesso
$user = $ver['payload']['sub'] ?? 'user';
json_response([
    'ok' => true,
    'message' => "Secreto para {$user} às " . date('H:i:s'),
    'now' => time()
]);
