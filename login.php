<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Netflix – Entrar</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --red: #e50914;
      --red-dark: #b20710;
      --black: #141414;
      --dark-card: rgba(0,0,0,.75);
      --border: #555;
      --border-focus: #e5e5e5;
      --input-bg: #333;
      --gray: #8c8c8c;
      --white: #fff;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--black);
      color: var(--white);
      min-height: 100vh;
    }

    .page-bg {
      position: fixed;
      inset: 0;
      z-index: 0;
      background-image: url('img/fundonetflix.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .bg-overlay {
      position: fixed;
      inset: 0;
      background: linear-gradient(to bottom, rgba(80, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.95) 100%);
      z-index: 1;
    }

    nav {
      position: relative;
      z-index: 10;
      padding: 20px 60px;
    }

    .logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.4rem;
      color: var(--red);
      letter-spacing: 2px;
      text-shadow: 0 0 30px rgba(229,9,20,.4);
      text-decoration: none;
      display: inline-block;
    }

    .card-wrapper {
      position: relative;
      z-index: 10;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 20px 20px 60px;
      min-height: calc(100vh - 90px);
    }

    .card {
      background: var(--dark-card);
      backdrop-filter: blur(10px);
      border-radius: 8px;
      padding: 60px 68px 50px;
      width: 100%;
      max-width: 460px;
      animation: fadeUp .5s ease both;
    }

    .card h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.2rem;
      letter-spacing: 1px;
      margin-bottom: 28px;
    }

    .alert {
      background: rgba(229,9,20,.15);
      border: 1px solid var(--red);
      color: #ffb3b3;
      border-radius: 6px;
      padding: 12px 16px;
      font-size: .88rem;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    .alert-success {
      background: rgba(34,197,94,.15);
      border-color: #22c55e;
      color: #86efac;
    }

    .form-group {
      position: relative;
      margin-bottom: 16px;
    }

    .form-group input {
      width: 100%;
      padding: 18px 16px 6px;
      font-size: .98rem;
      font-family: 'DM Sans', sans-serif;
      background: var(--input-bg);
      border: 1px solid var(--border);
      border-radius: 4px;
      color: var(--white);
      outline: none;
      transition: border-color .2s, background .2s;
    }

    .form-group input:focus {
      border-color: var(--border-focus);
      background: #454545;
    }

    .form-group label {
      position: absolute;
      top: 50%;
      left: 16px;
      transform: translateY(-50%);
      color: var(--gray);
      font-size: .95rem;
      pointer-events: none;
      transition: all .2s;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: 10px;
      transform: none;
      font-size: .72rem;
    }

    .btn-primary {
      width: 100%;
      padding: 16px;
      background: var(--red);
      color: var(--white);
      border: none;
      border-radius: 4px;
      font-family: 'DM Sans', sans-serif;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      margin-top: 8px;
      margin-bottom: 16px;
      transition: background .2s, transform .1s;
    }
    .btn-primary:hover { background: var(--red-dark); transform: scale(1.01); }

    .or-divider {
      text-align: center;
      color: var(--gray);
      font-size: .85rem;
      margin: 4px 0 16px;
      position: relative;
    }
    .or-divider::before, .or-divider::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 42%;
      height: 1px;
      background: #444;
    }
    .or-divider::before { left: 0; }
    .or-divider::after { right: 0; }

    .btn-secondary {
      width: 100%;
      padding: 14px;
      background: #555;
      color: var(--white);
      border: none;
      border-radius: 4px;
      font-family: 'DM Sans', sans-serif;
      font-size: .95rem;
      font-weight: 700;
      cursor: pointer;
      margin-bottom: 16px;
      transition: background .2s;
    }
    .btn-secondary:hover { background: #666; }

    .forgot-link {
      display: block;
      text-align: center;
      color: var(--white);
      font-size: .9rem;
      text-decoration: underline;
      margin-bottom: 20px;
      cursor: pointer;
    }

    .remember-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
      font-size: .9rem;
      color: var(--gray);
    }

    .remember-row input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--red);
      cursor: pointer;
    }

    .signup-row {
      font-size: .9rem;
      color: var(--gray);
      margin-bottom: 16px;
    }
    .signup-row a {
      color: var(--white);
      font-weight: 700;
      text-decoration: none;
    }
    .signup-row a:hover { text-decoration: underline; }

    .recaptcha-note {
      font-size: .75rem;
      color: #666;
      line-height: 1.5;
    }
    .recaptcha-note a { color: #1e7abb; }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <div class="page-bg" aria-hidden="true"></div>
  <div class="bg-overlay"></div>

  <nav>
    <a href="index.html" class="logo">Netflix</a>
  </nav>

  <div class="card-wrapper">
    <div class="card">
      <h1>Entrar</h1>

      <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok'): ?>
        <div class="alert alert-success">
          Cadastro realizado com sucesso! Faça login para continuar.
        </div>
      <?php endif; ?>

      <?php
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $email = trim($_POST['email'] ?? '');
          $senha = $_POST['senha'] ?? '';

          if (empty($email) || empty($senha)) {
            $erro = 'Por favor, preencha todos os campos.';
          } else {
            // Verifica credenciais no arquivo de usuários
            $usuarios = [];
            if (file_exists('usuarios.json')) {
              $usuarios = json_decode(file_get_contents('usuarios.json'), true) ?? [];
            }

            $encontrado = false;
            foreach ($usuarios as $u) {
              if ($u['email'] === $email && password_verify($senha, $u['senha'])) {
                $encontrado = true;
                break;
              }
            }

            if ($encontrado) {
              session_start();
              $_SESSION['usuario'] = $email;
              header('Location: painel.php');
              exit;
            } else {
              $erro = 'Email ou senha incorretos. Tente novamente ou <a href="#">redefina sua senha</a>.';
            }
          }
        }
      ?>

      <?php if ($erro): ?>
        <div class="alert"><?= $erro ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <input type="text" name="email" id="email" placeholder=" " value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
          <label for="email">Email ou número de celular</label>
        </div>

        <div class="form-group">
          <input type="password" name="senha" id="senha" placeholder=" " required>
          <label for="senha">Senha</label>
        </div>

        <button type="submit" class="btn-primary">Entrar</button>
      </form>

      <div class="or-divider">OU</div>

      <button class="btn-secondary">Usar um código de acesso</button>

      <a class="forgot-link" href="#">Esqueceu a senha?</a>

      <div class="remember-row">
        <input type="checkbox" id="remember" checked>
        <label for="remember">Lembre-se de mim</label>
      </div>

      <div class="signup-row">
        Primeira vez aqui? <a href="cadastro.php">Assine agora.</a>
      </div>

      <p class="recaptcha-note">
        Esta página é protegida pelo Google reCAPTCHA para garantir que você não é um robô.
        <a href="#">Saiba mais.</a>
      </p>
    </div>
  </div>

</body>
</html>