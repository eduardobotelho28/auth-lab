<?php
// utils.php
if (session_status() === PHP_SESSION_NONE) session_start();

// segredo para assinar o "JWT" simples (HMAC)
const TOKEN_SECRET = 'DEV_ONLY_CHANGE_ME';

// ==== helpers base64url ====
function b64u_encode(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function b64u_decode(string $data): string {
    $remainder = strlen($data) % 4;
    if ($remainder) $data .= str_repeat('=', 4 - $remainder);
    return base64_decode(strtr($data, '-_', '+/'));
}

// ==== mini-JWT (HS256) para o access token ====
function jwt_encode(array $payload, string $secret): string {
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $h = b64u_encode(json_encode($header, JSON_UNESCAPED_SLASHES));
    $p = b64u_encode(json_encode($payload, JSON_UNESCAPED_SLASHES));
    $sig = b64u_encode(hash_hmac('sha256', "$h.$p", $secret, true));
    return "$h.$p.$sig";
}

function jwt_decode_verify(string $jwt, string $secret): array {
    $parts = explode('.', $jwt);
    if (count($parts) !== 3) return ['valid' => false, 'error' => 'format'];
    [$h, $p, $s] = $parts;
    $calc = b64u_encode(hash_hmac('sha256', "$h.$p", $secret, true));
    if (!hash_equals($calc, $s)) return ['valid' => false, 'error' => 'signature'];

    $payload = json_decode(b64u_decode($p), true);
    if (!is_array($payload)) return ['valid' => false, 'error' => 'payload'];
    if (isset($payload['exp']) && time() >= $payload['exp']) {
        return ['valid' => false, 'error' => 'expired', 'payload' => $payload];
    }
    return ['valid' => true, 'payload' => $payload];
}

// ==== geração de tokens ====
function generate_access_token(string $username, int $ttlSeconds = 30): string {
    $now = time();
    $payload = [
        'sub' => $username,
        'iat' => $now,
        'exp' => $now + $ttlSeconds,
        'typ' => 'access'
    ];
    return jwt_encode($payload, TOKEN_SECRET);
}

function generate_refresh_token(): string {
    // string aleatória opaca (não-JWT) para ficar simples
    return bin2hex(random_bytes(32));
}

// guardamos o refresh token "no servidor" via sessão (didático)
function store_refresh_for_user(string $username, string $refresh, int $ttlSeconds = 3600): void {
    $_SESSION['refresh'] = [
        'username' => $username,
        'token'    => $refresh,
        'exp'      => time() + $ttlSeconds
    ];
}

function validate_refresh(string $refresh): array {
    $reg = $_SESSION['refresh'] ?? null;
    if (!$reg) return ['ok' => false, 'reason' => 'no_session'];
    if (!hash_equals($reg['token'], $refresh)) return ['ok' => false, 'reason' => 'mismatch'];
    if (time() >= $reg['exp']) return ['ok' => false, 'reason' => 'expired'];
    return ['ok' => true, 'username' => $reg['username']];
}

// ==== util de resposta JSON ====
function json_response($data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

// ==== pegar bearer token do header (com fallback simples) ====
function get_bearer_token(): ?string {
    $hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$hdr && function_exists('apache_request_headers')) {
        $h = apache_request_headers();
        $hdr = $h['Authorization'] ?? '';
    }
    if (preg_match('/Bearer\s+(.+)/i', $hdr, $m)) return trim($m[1]);

    // fallback: aceitar via ?access_token=... (apenas para demo)
    if (!empty($_GET['access_token'])) return $_GET['access_token'];
    if (!empty($_POST['access_token'])) return $_POST['access_token'];
    return null;
}
