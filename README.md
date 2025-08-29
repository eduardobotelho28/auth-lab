# Auth Lab

Este repositório foi criado com o intuito de **explorar diferentes formas de autenticação e autorização**, com foco em entender o funcionamento e comportamento básico de cada uma.  
Os exemplos são **simples e chumbados**, sem banco de dados ou grandes estruturas, apenas para fins de estudo.

---

## Estrutura do Projeto

### `jwt/`
Neste projeto é feito um **login básico com usuário e senha**, mas a autorização é realizada via **JWT**, construído **"na mão"** (sem bibliotecas externas), para compreender detalhadamente como cada parte do token JWT é formada e validada.

### `oauth/`
Aqui exploramos um pouco do protocolo **OAuth**, utilizando o **Google OAuth 2.0** com **Authorization Code Flow + PKCE**, para realizar a troca segura de tokens e acessar informações do usuário.

### `refreshToken/`
Nesta pasta temos um fluxo de login em que a API retorna não apenas um **Access Token**, mas também um **Refresh Token**.  
A ideia é simular a expiração rápida do Access Token e o uso do Refresh Token para gerar um novo, aumentando a segurança.

### `2fa/`
Simulação de um fluxo de **autenticação em dois fatores (2FA)**.  
Foi feito um login simples com usuário e senha e, em seguida, um segundo fator baseado em **código enviado por e-mail** (simulado, apenas chumbado). Utiliza **sessões PHP** para guardar o código temporário.

---

## Como rodar

1. Clone este repositório:
   ```bash
   git clone https://github.com/eduardobotelho28/auth-lab.git
   ```

2. Coloque o projeto no seu servidor local (ex: htdocs no XAMPP ou www no Laragon).

3. Acesse via navegador em:
   ```
   http://localhost/auth-lab
   ```

### Importante para `oauth/`

Para executar o exemplo de OAuth com Google, você precisará criar um projeto no Google Cloud Console, habilitar OAuth 2.0 e configurar um Client ID e Client Secret.

Depois crie um arquivo chamado `.configs` dentro da pasta `oauth/` com o seguinte conteúdo (substitua pelas suas credenciais):

```php
<?php
// CONFIGS
define('GOOGLE_CLIENT_ID'    , 'SUA_CLIENT_ID.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'SUA_CLIENT_SECRET');
define('GOOGLE_REDIRECT_URI' , 'http://localhost/auth-lab/oauth/callback.php');

// ENDPOINTS E SCOPES
define('GOOGLE_AUTH_ENDPOINT'     , 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_ENDPOINT'    , 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_ENDPOINT' , 'https://openidconnect.googleapis.com/v1/userinfo');
define('GOOGLE_SCOPE'             , 'openid email profile');
?>
```

---

## Auth Lab (English)

This repository was created with the goal of **exploring different forms of authentication and authorization**, focusing on understanding the basic mechanisms of each one.  
The examples are **simple and hardcoded**, without databases or complex structures, just for study purposes.

### Project Structure

#### `jwt/`
A basic login with username and password, but authorization is done via **JWT**, built entirely **by hand** (no libraries), in order to understand how each part of the JWT is created and validated.

#### `oauth/`
An exploration of the **OAuth protocol**, using **Google OAuth 2.0** with **Authorization Code Flow + PKCE**, for secure token exchange and user info retrieval.

#### `refreshToken/`
A login flow where the API returns not only an **Access Token** but also a **Refresh Token**.  
This simulates short-lived Access Tokens and the use of Refresh Tokens to get new ones, increasing security.

#### `2fa/`
A simulation of **Two-Factor Authentication (2FA)**.  
It starts with a basic username/password login and then requires a second factor with a **code sent via email** (simulated, hardcoded). It uses **PHP sessions** to store the temporary code.

### How to Run

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/auth-lab.git
   ```

2. Place the project in your local server directory (e.g., htdocs in XAMPP or www in Laragon).

3. Access in your browser:
   ```
   http://localhost/auth-lab
   ```

#### Important for `oauth/`

To run the Google OAuth example, you need to create a project in Google Cloud Console, enable OAuth 2.0, and set up a Client ID and Client Secret.

Then, create a `.configs` file inside the `oauth/` folder with the following content (replace with your credentials):

```php
<?php
// CONFIGS
define('GOOGLE_CLIENT_ID'    , 'YOUR_CLIENT_ID.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'YOUR_CLIENT_SECRET');
define('GOOGLE_REDIRECT_URI' , 'http://localhost/auth-lab/oauth/callback.php');

// ENDPOINTS AND SCOPES
define('GOOGLE_AUTH_ENDPOINT'     , 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_ENDPOINT'    , 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_ENDPOINT' , 'https://openidconnect.googleapis.com/v1/userinfo');
define('GOOGLE_SCOPE'             , 'openid email profile');
?>
```
