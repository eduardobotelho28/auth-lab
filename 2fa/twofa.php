<?php
    require_once __DIR__ . '/utils.php';
    if (empty($_SESSION['auth']['first_factor_ok']) || empty($_SESSION['2fa'])) redirect('login.php');

    $userEmail = $_SESSION['user']['email'] ?? '';
    $mask = mask_email($userEmail);
    $twofa = $_SESSION['2fa'];
    $expiresIn = max(0, $twofa['expires_at'] - time());
    $codeDemo  = $twofa['code']; // só para fins didáticos
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Verificação • 2FA Demo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  *{box-sizing:border-box;font-family:Inter,system-ui,Arial}
  body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#eef2f7}
  .card{width:100%;max-width:480px;background:#fff;padding:28px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
  h1{margin:0 0 8px;font-size:22px;color:#222}
  p{margin:0 0 12px;color:#555}
  .note{background:#f7fafc;padding:10px;border-left:4px solid #3b82f6;border-radius:8px;margin:10px 0}
  .demo{background:#fff7ed;border-left:4px solid #f59e0b}
  label{display:block;margin:10px 0 6px;color:#333;font-weight:600}
  input{width:100%;padding:12px 14px;border:1px solid #dcdfe4;border-radius:10px;font-size:18px;letter-spacing:2px;text-align:center}
  button{margin-top:14px;width:100%;padding:12px 16px;border:0;border-radius:10px;background:#111;color:#fff;font-weight:700;cursor:pointer}
  a.btn{display:inline-block;margin-top:10px;text-decoration:none;padding:10px 12px;border-radius:10px;background:#0ea5e9;color:#fff}
  .err{background:#fff1f2;color:#b91c1c;border-left:4px solid #ef4444}
</style>
</head>
<body>
  <div class="card">
    <h1>Verificação (2º fator)</h1>
    <p>Enviamos um código de 6 dígitos para <strong><?= htmlspecialchars($mask) ?></strong>.</p>
    <div class="note">Tempo restante: <span id="count"><?= (int)$expiresIn ?></span>s</div>

    <?php if ($msg = flash_get('error')): ?>
      <div class="note err"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form action="verify.php" method="post">
      <label for="code">Código</label>
      <input id="code" name="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" required>
      <button type="submit">Validar código</button>
    </form>

    <a class="btn" href="resend.php">Reenviar código</a>

    <div class="note demo" style="margin-top:14px">
      <strong>Demo:</strong> código atual é <code><?= htmlspecialchars($codeDemo) ?></code>
    </div>
  </div>

<script>
  let sec = <?= (int)$expiresIn ?>;
  const span = document.getElementById('count');
  const t = setInterval(() => {
    sec = Math.max(0, sec - 1);
    span.textContent = sec;
    if (sec === 0) clearInterval(t);
  }, 1000);
</script>
</body>
</html>
