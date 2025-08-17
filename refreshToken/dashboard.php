<?php require_once __DIR__ . '/utils.php'; ?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Dashboard • Access + Refresh</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
  *{box-sizing:border-box;font-family:Inter,system-ui,Arial}
  body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#eef2f7}
  .wrap{width:100%;max-width:840px;display:grid;gap:18px;grid-template-columns:1.2fr .8fr;align-items:start;padding:22px}
  .card{background:#fff;padding:22px;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.06)}
  h2{margin:0 0 8px}
  pre{background:#0f172a;color:#e2e8f0;padding:12px;border-radius:10px;overflow:auto}
  button{padding:10px 14px;border:0;border-radius:10px;background:#111;color:#fff;font-weight:700;cursor:pointer}
  .muted{color:#666}
  .row{display:flex;gap:10px;flex-wrap:wrap}
</style>

</head>
<body>
<div class="wrap">
  <div class="card">
    <h2>Recurso protegido</h2>
    <p class="muted">Chama <code>api/resource.php</code> com <em>access token</em>. Se 401 por expiração, tenta <code>api/refresh.php</code> e repete a chamada.</p>
    <div class="row" style="margin:10px 0 14px">
      <button id="btnCall">Chamar API</button>
      <button id="btnLogout" style="background:#e11d48">Sair</button>
    </div>
    <pre id="out">Pronto para testar…</pre>
  </div>

  <div class="card">
    <h2>Tokens no client (demo)</h2>
    <p class="muted">Em produção: <strong>refresh</strong> em cookie HttpOnly.</p>
    <pre id="tokDump"></pre>
  </div>
</div>

<script>
function getTok() {
  return {
    access: localStorage.getItem('access_token'),
    refresh: localStorage.getItem('refresh_token'),
    accessExp: Number(localStorage.getItem('access_exp') || '0')
  };
}
function dump() {
  const t = getTok();
  const now = Math.floor(Date.now()/1000);
  const secs = t.accessExp ? (t.accessExp - now) : 0;
  document.getElementById('tokDump').textContent = JSON.stringify({
    access_token: t.access?.slice(0,40)+'…',
    access_expires_in: secs+'s',
    refresh_token: t.refresh?.slice(0,16)+'…'
  }, null, 2);
}
dump();

async function callApiWithAutoRefresh() {
  const out = document.getElementById('out');
  const t = getTok();
  if (!t.access || !t.refresh) { out.textContent = 'Sem tokens. Faça login novamente.'; return; }

  // 1ª tentativa com access token atual
  let r = await fetch('api/resource.php', {
    headers: { Authorization: 'Bearer ' + t.access }
  });
  if (r.status === 200) {
    out.textContent = await r.text();
    return;
  }
  // Se 401 – tenta refresh
  if (r.status === 401) {
    const rf = await fetch('api/refresh.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ refresh_token: t.refresh })
    });
    const data = await rf.json();
    if (!rf.ok) {
      out.textContent = 'Refresh falhou: ' + (data.error || rf.status);
      return;
    }
    // Atualiza access token e exp
    localStorage.setItem('access_token', data.access_token);
    localStorage.setItem('access_exp', (Date.now()/1000 + data.expires_in).toString());
    dump();

    // Tenta recurso novamente
    r = await fetch('api/resource.php', {
      headers: { Authorization: 'Bearer ' + data.access_token }
    });
    out.textContent = await r.text();
    return;
  }
  out.textContent = 'Erro inesperado: ' + r.status;
}

document.getElementById('btnCall').addEventListener('click', callApiWithAutoRefresh);
document.getElementById('btnLogout').addEventListener('click', () => {
  localStorage.clear();
  location.href = 'logout.php';
});
</script>
</body>
</html>
