<?php require_once __DIR__ . '/utils.php'; ?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login • 2FA Demo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  *{box-sizing:border-box;font-family:Inter,system-ui,Arial}
  body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f3f5f7}
  .card{width:100%;max-width:420px;background:#fff;padding:28px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
  h1{margin:0 0 8px;font-size:22px;color:#222}
  p{margin:0 0 16px;color:#555}
  label{display:block;margin:10px 0 6px;color:#333;font-weight:600}
  input{width:100%;padding:12px 14px;border:1px solid #dcdfe4;border-radius:10px}
  button{margin-top:14px;width:100%;padding:12px 16px;border:0;border-radius:10px;background:#111;color:#fff;font-weight:700;cursor:pointer}
  .hint{margin-top:14px;font-size:13px;color:#444;background:#f7fafc;padding:10px;border-left:4px solid #48bb78;border-radius:8px}
  .err{background:#fff1f2;color:#b91c1c;border-left:4px solid #ef4444}
</style>
</head>
<body>
  <div class="card">
    <h1>Autenticação (1º fator)</h1>
    <p>Entre com email e senha. Depois pediremos um <strong>código 2FA</strong>.</p>

    <?php if ($msg = flash_get('error')): ?>
      <div class="hint err" style="margin-bottom:10px"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form action="do_login.php" method="post" autocomplete="on">
      <label for="email">Email</label>
      <input id="email" name="email" value="<?= htmlspecialchars(DEMO_EMAIL) ?>" autocomplete="username" required>

      <label for="pass">Senha</label>
      <input id="pass" name="password" type="password" value="<?= htmlspecialchars(DEMO_PASS) ?>" autocomplete="current-password" required>

      <button type="submit">Entrar</button>
    </form>

    <div class="hint" style="margin-top:14px">
      <strong>Demo:</strong> <?= htmlspecialchars(DEMO_EMAIL) ?> / <?= htmlspecialchars(DEMO_PASS) ?>
    </div>
  </div>
</body>
</html>
