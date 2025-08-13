<?php
require_once __DIR__ . '/config.php';

// cria state anti-CSRF
$state = bin2hex(random_bytes(16));
$_SESSION['oauth_state'] = $state ;

// PKCE: gera code_verifier e code_challenge
$code_verifier = generateCodeVerifier();
$_SESSION['oauth_code_verifier'] = $code_verifier;
$code_challenge = generateCodeChallenge($code_verifier);

// monta params de autorização
$params = [
    'response_type'         => 'code',
    'client_id'             => GOOGLE_CLIENT_ID   ,
    'redirect_uri'          => GOOGLE_REDIRECT_URI,
    'scope'                 => GOOGLE_SCOPE       ,
    'state'                 => $state             ,
    'code_challenge'        => $code_challenge    ,
    'code_challenge_method' => 'S256'             ,
    'access_type'           => 'offline'          , 
    'prompt'                => 'consent'  
];

$authUrl = GOOGLE_AUTH_ENDPOINT . '?' . http_build_query($params);
redirect($authUrl);
