<?php require_once __DIR__ . '/utils.php'; ?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Login • Access + Refresh</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  *{box-sizing:border-box;font-family:Inter,system-ui,Arial}
  body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f3f5f7}
  .card{width:100%;max-width:420px;background:#fff;padding:28px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
  h1{margin:0 0 8px;font-size:20px;color:#222}
  p{margin:0 0 16px;color:#555}
  label{display:block;margin:10px 0 6px;color:#333;font-weight:600}
  input{width:100%;padding:12px 14px;border:1px solid #dcdfe4;border-radius:10px}
  button{margin-top:14px;width:100%;padding:12px 16px;border:0;border-radius:10px;background:#111;color:#fff;font-weight:700;cursor:pointer}
  .hint{margin-top:14px;font-size:13px;color:#666;background:#f7fafc;padding:10px;border-left:4px solid #48bb78;border-radius:8px}
</style>
</head>
<body>
  <div class="card">
    <h1>Explorando Refresh Token</h1>
    <p>Login chumbado → gera <em>access</em> (30s) + <em>refresh</em> (1h).</p>

    <form id="loginForm">
      <label for="user">Usuário</label>
      <input id="user" name="username" value="admin" autocomplete="username">
      <label for="pass">Senha</label>
      <input id="pass" name="password" type="password" value="123456" autocomplete="current-password">
      <button type="submit">Entrar</button>
    </form>

    <div class="hint">
      <strong>Credenciais:</strong> admin / 123456
    </div>
  </div>


<script>
const form = document.getElementById('loginForm');
    form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(form);
    const r = await fetch('api/token.php', { method:'POST', body: fd });
    const data = await r.json();
    if (!r.ok) { alert(data.error || 'Falha no login'); return; }
    // salva tokens no client (didático; em prod usamos cookie HttpOnly p/ refresh)
    localStorage.setItem('access_token', data.access_token);
    localStorage.setItem('refresh_token', data.refresh_token);
    localStorage.setItem('access_exp', (Date.now()/1000 + data.expires_in).toString());
    location.href = 'dashboard.php';
    });
</script>

</body>
</html>
