<?php
// utils.php
if (session_status() === PHP_SESSION_NONE) session_start();

/** Credenciais chumbadas (demo) */
const DEMO_EMAIL = 'user@example.com';
const DEMO_PASS  = '123456';

/** Redireciona e finaliza */
function redirect(string $to): void {
    header("Location: $to");
    exit;
}

/** Mascarar email para exibição */
function mask_email(string $email): string {
    if (!str_contains($email, '@')) return $email;
    [$u, $d] = explode('@', $email, 2);
    $mask = substr($u, 0, 1) . str_repeat('*', max(1, strlen($u)-2)) . substr($u, -1);
    return $mask . '@' . $d;
}

/** Gera código 2FA de N dígitos */
function generate_2fa_code(int $digits = 6): string {
    $max = (10 ** $digits) - 1;
    return str_pad((string)random_int(0, $max), $digits, '0', STR_PAD_LEFT);
}

/** Inicia fluxo 2FA: gera código, expiração e zera tentativas */
function start_2fa(string $email, int $ttlSeconds = 120, int $maxAttempts = 5): void {
    $_SESSION['user'] = ['email' => $email];
    $_SESSION['auth'] = ['first_factor_ok' => true, 'fully' => false];
    $_SESSION['2fa']  = [
        'code'       => generate_2fa_code(6),
        'expires_at' => time() + $ttlSeconds,
        'attempts'   => 0,
        'max'        => $maxAttempts,
    ];
}

/** Verifica código 2FA. Retorna array com status e motivo */
function check_2fa_code(string $input): array {
    if (empty($_SESSION['auth']['first_factor_ok']) || empty($_SESSION['2fa'])) {
        return ['ok' => false, 'reason' => 'no_flow'];
    }
    $data = &$_SESSION['2fa'];

    if (time() > $data['expires_at']) {
        return ['ok' => false, 'reason' => 'expired'];
    }
    if ($data['attempts'] >= $data['max']) {
        return ['ok' => false, 'reason' => 'too_many_attempts'];
    }

    $data['attempts']++;
    if (!hash_equals($data['code'], trim($input))) {
        return ['ok' => false, 'reason' => 'mismatch', 'left' => $data['max'] - $data['attempts']];
    }

    // Sucesso: autenticação completa
    $_SESSION['auth']['fully'] = true;
    unset($_SESSION['2fa']); // limpa desafio
    return ['ok' => true];
}

/** Exige auth completa (pós-2FA) */
function require_auth(): void {
    if (empty($_SESSION['auth']['fully'])) {
        redirect('login.php');
    }
}

/** Lê/consome uma flash message simples */
function flash_get(string $key): ?string {
    $val = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $val;
}
function flash_set(string $key, string $msg): void {
    $_SESSION['flash'][$key] = $msg;
}
