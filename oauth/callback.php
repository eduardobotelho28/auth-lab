<?php
require_once __DIR__ . '/configs.php';
require_once __DIR__ . '/functions.php';

// se Google retornou erro
if (isset($_GET['error'])) {
    echo "Erro do provedor: " . htmlspecialchars($_GET['error']);
    exit;
}

if (!isset($_GET['code'], $_GET['state'])) {
    echo "Parâmetros faltando.";
    exit;
}

// valida state
if (!isset($_SESSION['oauth_state']) || !hash_equals($_SESSION['oauth_state'], $_GET['state'])) {
    echo "State inválido.";
    exit;
}
unset($_SESSION['oauth_state']); // usa só uma vez

$code = $_GET['code'];
$code_verifier = $_SESSION['oauth_code_verifier'] ?? null;
unset($_SESSION['oauth_code_verifier']); // também remove

// troca code por token
$post = http_build_query([
    'code'          => $code               ,
    'client_id'     => GOOGLE_CLIENT_ID    ,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri'  => GOOGLE_REDIRECT_URI ,
    'grant_type'    => 'authorization_code',
    'code_verifier' => $code_verifier      ,
]);

try {
    $resp = curl_post(GOOGLE_TOKEN_ENDPOINT, $post, ['Content-Type: application/x-www-form-urlencoded']);
    $token = json_decode($resp, true);
    if (isset($token['error'])) throw new Exception($token['error_description'] ?? $token['error']);

    // tokens retornados: access_token, id_token (JWT), refresh_token (opcional)
    $accessToken  = $token['access_token']  ?? null;
    $idToken      = $token['id_token']      ?? null;
    $refreshToken = $token['refresh_token'] ?? null;

    if (!$accessToken) throw new Exception('Nenhum access_token recebido.');

    // buscar userinfo
    $ch = curl_init(GOOGLE_USERINFO_ENDPOINT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $accessToken"]);
    $userinfoRaw = curl_exec($ch);
    if (curl_errno($ch)) throw new Exception(curl_error($ch));
    curl_close($ch);

    $userinfo = json_decode($userinfoRaw, true);

    // salva na sessão (apenas para demo/estudo)
    $_SESSION['user']          = $userinfo;
    $_SESSION['access_token']  = $accessToken;
    $_SESSION['refresh_token'] = $refreshToken;
    $_SESSION['id_token']      = $idToken;

    redirect('dashboard.php');

} catch (Exception $e) {
    echo "Erro: " . htmlspecialchars($e->getMessage());
    exit;
}
