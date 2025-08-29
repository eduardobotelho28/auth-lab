<?php

if (session_status() === PHP_SESSION_NONE) session_start();

function redirect(string $url) {
    header("Location: $url");
    exit;
}

function curl_post(string $url, string $postFields, array $headers = []) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $resp = curl_exec($ch);
    if (curl_errno($ch)) {
        $err = curl_error($ch);
        curl_close($ch);
        throw new Exception("CURL error: $err");
    }
    curl_close($ch);
    return $resp;
}

// --- PKCE helpers ---
function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generateCodeVerifier() {
    // devolve string URL-safe entre 43 e 128 chars
    return base64UrlEncode(random_bytes(64));
}

function generateCodeChallenge(string $verifier) {
    return base64UrlEncode(hash('sha256', $verifier, true));
}