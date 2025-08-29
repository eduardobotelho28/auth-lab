<?php
require_once __DIR__ . '/configs.php';
require_once __DIR__ . '/functions.php';
if (empty($_SESSION['user'])) redirect('index.php');

$user = $_SESSION['user'];

// Preparar avatar
$avatarUrl = $user['picture'] ?? '';
if ($avatarUrl) {
    // força HTTPS
    $avatarUrl = preg_replace('/^http:/i', 'https:', $avatarUrl);
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            width: 350px;
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
        }
        h2 {
            margin: 10px 0;
            color: #333;
        }
        p {
            color: #555;
            margin: 5px 0;
        }
        .btn-logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #4285F4;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn-logout:hover {
            background: #357ae8;
        }
    </style>
</head>
<body>

<div class="card">
    <img src="<?= htmlspecialchars($avatarUrl) ?>" 
         alt="avatar" 
         class="avatar"
    >

    <h2>Bem vindo, <?= htmlspecialchars($user['name'] ?? $user['email'] ?? 'Usuário') ?></h2>
    <p>Email: <?= htmlspecialchars($user['email'] ?? '-') ?></p>

    <a href="logout.php" class="btn-logout">Sair</a>
</div>

</body>
</html>
