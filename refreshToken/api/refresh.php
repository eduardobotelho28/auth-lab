<?php
require_once __DIR__ . '/../utils.php';

// aceita JSON ou x-www-form-urlencoded
$input = file_get_contents('php://input');
$data = json_decode($input, true);
$refresh = $data['refresh_token'] ?? ($_POST['refresh_token'] ?? '');

if (!$refresh) json_response(['error' => 'missing_refresh'], 400);

$chk = validate_refresh($refresh);
if (!$chk['ok']) {
    json_response(['error' => 'refresh_invalid', 'reason' => $chk['reason']], 401);
}

// válido -> emite novo access (sem rotação nesta 1ª versão)
$username = $chk['username'];
$access = generate_access_token($username, 30);

json_response([
    'token_type'   => 'Bearer',
    'access_token' => $access,
    'expires_in'   => 30
]);
