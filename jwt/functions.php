<?php

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generateToken($username) {
    $secret = 'FHEIEIHFIEHFIEI';

    // HEADER
    $header = [
        'alg' => 'HS256',
        'typ' => 'JWT'
    ];
    $headerEncoded = base64UrlEncode(json_encode($header));

    // PAYLOAD
    $payload = [
        'exp' => time() + (60 * 60 * 24 * 7), // 7 dias
        'username' => $username
    ];
    $payloadEncoded = base64UrlEncode(json_encode($payload));

    // SIGNATURE
    $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $secret, true);
    $signatureEncoded = base64UrlEncode($signature);

    //JWT
    $jwt = "$headerEncoded.$payloadEncoded.$signatureEncoded";

    return $jwt;
}

function validateToken () {
    
    $key   = 'FHEIEIHFIEHFIEI';
    $token = $_COOKIE['token'];
    
    $tokenArray = explode('.', $token);

    $header    = $tokenArray[0];
    $payload   = $tokenArray[1];
    $signature = $tokenArray[2];

    $validSignature = hash_hmac('sha256', "$header.$payload", $key, true);
    $validSignature = base64UrlEncode($validSignature);

    if($signature != $validSignature) 
        return false;

    $tokenData = json_decode(base64_decode($payload));

    if($tokenData->exp < time()) 
        return false;
        
    return true;

}
