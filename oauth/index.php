<?php require_once __DIR__ . '/configs.php'; ?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Explorando OAuth (Google)</title>
  <style>
        * {
            box-sizing:border-box;
            font-family:Inter,system-ui,Arial;
        }
        body {
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0;
            background:linear-gradient(135deg,#f0fff4,#e4f7ec);
            padding:24px;
        }
        .card {
            width:100%;
            max-width:420px;
            background:#fff;
            padding:28px;
            border-radius:12px;
            box-shadow:0 12px 30px rgba(0,0,0,.08);
            text-align:center;
        }
        h1{
            margin:0 0 12px;
            color:#1b5e20;
        }
        p.lead{
            color:#555;
            margin-bottom:20px;
        }
        .google-btn{
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding:12px 18px;
            border-radius:10px;
            border:1px solid #ddd;
            text-decoration:none;
            color:#222;
            font-weight:700;
            cursor:pointer;
        }
        .hint{
            margin-top:18px;
            background:#f6f9f6;
            padding:10px;
            border-left:4px solid #2ECC71;
            color:#333;
            border-radius:6px;
            font-size:14px;
            text-align:left;
        }
  </style>
</head>

<body>
  <div class="card">
    <h1>Explorando login com OAuth (Google)</h1>
    <p class="lead">Fluxo Authorization Code + PKCE — PHP puro.</p>

    <a class="google-btn" href="login.php">
      <!-- ícone simples inline -->
      <svg width="20" height="20" viewBox="0 0 48 48" style="vertical-align:middle">
        <path fill="#EA4335" d="M24 9.5c3.5 0 6.3 1.2 8.2 2.2l6.1-6.1C34.8 3 29.8 1.5 24 1.5 14.9 1.5 7.3 6.8 3.7 14.3l7.1 5.5C12.9 14.1 18 9.5 24 9.5z"/>
        <path fill="#4285F4" d="M46.5 24.1c0-1.6-.2-2.9-.6-4.2H24v8.1h12.8c-.6 3.3-2.6 6.1-5.5 8l8.6 6.6C44.2 36.7 46.5 30.9 46.5 24.1z"/>
        <path fill="#FBBC05" d="M10.8 29.9C9.9 27.7 9.9 25.3 9.9 24c0-1.3 0-3.7 0-5.9L2.8 12.6C.9 16.2 0 20 0 24c0 4 .9 7.8 2.8 11.4l8 -5.5z"/>
        <path fill="#034A38" d="M24 46.5c6.2 0 11.5-2.1 15.3-5.7l-7.4-5.6c-2 1.4-4.7 2.4-7.9 2.4-6.1 0-11.2-4.6-12.9-10.8L3.7 33.7C7.3 41.2 14.9 46.5 24 46.5z"/>
      </svg>
      Entrar com Google
    </a>

    <div class="hint">
      <strong>Nota:</strong> Clique para iniciar o fluxo OAuth. Confirme que o redirect URI cadastrado no Google Cloud é <code><?= htmlspecialchars(GOOGLE_REDIRECT_URI) ?></code>.
    </div>
  </div>
</body>
</html>
