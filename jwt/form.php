<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login JWT</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #2ECC71, #27AE60);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #2ECC71;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2ECC71;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #27AE60;
        }

        .hint {
            margin-top: 20px;
            background: #f4f4f4;
            padding: 10px;
            border-left: 4px solid #2ECC71;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Explorando Login com JWT</h2>
        <form action="valid_login.php" method="post">
            <label for="username">Usuário</label>
            <input type="text" id="username" name="username" placeholder="Digite seu usuário">

            <label for="password">Senha</label>
            <input type="password" id="password" name="password" placeholder="Digite sua senha">

            <button type="submit" name="sendLogin">Entrar</button>
        </form>

        <div class="hint">
            <strong>Dica de acesso:</strong><br>
            Usuário: <code>test</code><br>
            Senha: <code>test123</code>
        </div>
    </div>
</body>
</html>
