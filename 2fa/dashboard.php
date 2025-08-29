<?php
require_once __DIR__ . '/utils.php';
require_auth();
$email = $_SESSION['user']['email'] ?? 'usuário';
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Dashboard • 2FA Demo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  *{box-sizing:border-box;font-family:Inter,system-ui,Arial}
  body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f0f2f5}
  .card{width:100%;max-width:520px;background:#fff;padding:28px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.08);text-align:center}
  h1{margin:0 0 8px}
  p{color:#555}
  a.btn{display:inline-block;margin-top:14px;text-decoration:none;padding:12px 16px;border-radius:10px;background:#e11d48;color:#fff}
</style>
</head>
<body>
  <div class="card">
    <h1>Bem-vindo!</h1>
    <p>Autenticação concluída (2 fatores).<br>Email: <strong><?= htmlspecialchars($email) ?></strong></p>
    <a class="btn" href="logout.php">Sair</a>
  </div>
</body>
</html>
