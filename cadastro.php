<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Netflix – Criar Conta</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --red: #e50914;
      --red-dark: #b20710;
      --black: #141414;
      --dark-card: rgba(0,0,0,.78);
      --border: #555;
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

    nav { position: relative; z-index: 10; padding: 20px 60px; }
    .logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.4rem; color: var(--red);
      letter-spacing: 2px; text-decoration: none;
      text-shadow: 0 0 30px rgba(229,9,20,.4);
      display: inline-block;
    }

    .card-wrapper {
      position: relative; z-index: 10;
      display: flex; justify-content: center;
      padding: 10px 20px 60px;
    }

    .card {
      background: var(--dark-card);
      backdrop-filter: blur(10px);
      border-radius: 8px;
      padding: 50px 68px;
      width: 100%; max-width: 500px;
      animation: fadeUp .5s ease both;
    }

    .card h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2rem; letter-spacing: 1px;
      margin-bottom: 6px;
    }

    .card .subtitle {
      color: var(--gray); font-size: .9rem;
      margin-bottom: 28px; line-height: 1.5;
    }

    .steps {
      display: flex; align-items: center;
      gap: 8px; margin-bottom: 28px;
    }

    .step {
      flex: 1; height: 4px;
      background: #444; border-radius: 2px;
      overflow: hidden;
    }

    .step-fill {
      height: 100%; background: var(--red);
      border-radius: 2px;
      transition: width .4s ease;
    }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .form-group {
      position: relative; margin-bottom: 14px;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 18px 16px 6px;
      font-size: .95rem;
      font-family: 'DM Sans', sans-serif;
      background: var(--input-bg);
      border: 1px solid var(--border);
      border-radius: 4px;
      color: var(--white);
      outline: none;
      transition: border-color .2s, background .2s;
      appearance: none;
    }

    .form-group select option { background: #333; }

    .form-group input:focus,
    .form-group select:focus {
      border-color: #e5e5e5; background: #454545;
    }

    .form-group.error input,
    .form-group.error select { border-color: var(--red); }

    .form-group label {
      position: absolute;
      top: 50%; left: 16px;
      transform: translateY(-50%);
      color: var(--gray); font-size: .92rem;
      pointer-events: none; transition: all .2s;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label,
    .form-group select:focus + label,
    .form-group select.has-value + label {
      top: 10px; transform: none; font-size: .7rem;
    }

    .field-error {
      color: #ff7070; font-size: .75rem;
      margin-top: 4px; display: block;
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
      border-color: #22c55e; color: #86efac;
    }

    /* Senha*/
    .pwd-strength { margin-top: 6px; }
    .pwd-strength-bar {
      height: 4px; background: #444;
      border-radius: 2px; overflow: hidden; margin-bottom: 4px;
    }
    .pwd-strength-fill {
      height: 100%; width: 0%;
      border-radius: 2px;
      transition: width .3s, background .3s;
    }
    .pwd-strength-label { font-size: .72rem; color: var(--gray); }

    /* termo */
    .terms-row {
      display: flex; align-items: flex-start;
      gap: 10px; margin: 16px 0;
      font-size: .84rem; color: var(--gray);
      line-height: 1.5;
    }
    .terms-row input[type="checkbox"] {
      width: 16px; height: 16px; flex-shrink: 0;
      margin-top: 2px; accent-color: var(--red); cursor: pointer;
    }
    .terms-row a { color: #1e7abb; text-decoration: underline; }

    .btn-primary {
      width: 100%; padding: 16px;
      background: var(--red); color: var(--white);
      border: none; border-radius: 4px;
      font-family: 'DM Sans', sans-serif;
      font-size: 1rem; font-weight: 700;
      cursor: pointer; margin-top: 4px;
      transition: background .2s, transform .1s;
    }
    .btn-primary:hover { background: var(--red-dark); transform: scale(1.01); }
    .btn-primary:disabled { background: #666; cursor: not-allowed; transform: none; }

    .login-row {
      text-align: center; margin-top: 20px;
      font-size: .9rem; color: var(--gray);
    }
    .login-row a { color: var(--white); font-weight: 700; text-decoration: none; }
    .login-row a:hover { text-decoration: underline; }

    .success-box {
      text-align: center; padding: 20px 0;
    }
    .success-icon {
      font-size: 4rem; margin-bottom: 16px;
    }
    .success-box h2 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.8rem; margin-bottom: 10px;
    }
    .success-box p { color: var(--gray); margin-bottom: 24px; line-height: 1.6; }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<?php
require_once 'config.php';

$sucesso = false;
$erros = [];
$dados = [];

$email_preenchido = isset($_POST['email']) ? $_POST['email'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) { 
    $nome       = trim($_POST['nome'] ?? '');
    $sobrenome  = trim($_POST['sobrenome'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $celular    = trim($_POST['celular'] ?? '');
    $nascimento = $_POST['nascimento'] ?? '';
    $plano      = $_POST['plano'] ?? '';
    $senha      = $_POST['senha'] ?? ''; 
    

    $dados = $_POST;
    
    if (empty($email)) $erros['email'] = "E-mail obrigatório.";
    if (strlen($senha) < 6) $erros['senha'] = "Senha muito curta.";

    if (empty($erros)) {
        try {

            $sql = "INSERT INTO usuarios (nome, sobrenome, email, celular, nascimento, plano, senha) 
                    VALUES (:nome, :sobrenome, :email, :celular, :nascimento, :plano, :senha)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome'       => $nome,
                ':sobrenome'  => $sobrenome,
                ':email'      => $email,
                ':celular'    => $celular,
                ':nascimento' => $nascimento,
                ':plano'      => $plano,
                ':senha'      => $senha 
            ]);

            $sucesso = true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $erros['email'] = "Este e-mail já foi cadastrado anteriormente.";
            } else {
                $erros['geral'] = "Erro no banco: " . $e->getMessage();
            }
        }
    }
}
?>

  <div class="page-bg" aria-hidden="true"></div>
  <div class="bg-overlay"></div>

  <nav><a href="index.html" class="logo">Netflix</a></nav>

  <div class="card-wrapper">
    <div class="card">

      <?php if ($sucesso): ?>
        <div class="success-box">
          <h2>Conta Criada!</h2>
          <p>Bem-vindo(a), <strong><?= htmlspecialchars($dados['nome'] ?? '') ?></strong>!<br>
              Sua conta foi criada com sucesso. Faça login para começar a assistir.</p>
          <a href="login.php" style="
            display:inline-block; background:var(--red); color:#fff;
            padding: 14px 40px; border-radius:4px; font-weight:700;
            text-decoration:none; font-size:1rem;
          ">Fazer Login</a>
        </div>

      <?php else: ?>

        <h1>Criar Conta</h1>
        <p class="subtitle">Preencha seus dados para começar a assistir agora mesmo.</p>

        <div class="steps">
          <div class="step"><div class="step-fill" style="width:100%"></div></div>
          <div class="step"><div class="step-fill" style="width:100%"></div></div>
          <div class="step"><div class="step-fill" style="width:30%"></div></div>
        </div>

        <?php if (!empty($erros)): ?>
          <div class="alert"> Por favor, corrija os erros abaixo antes de continuar.
            <?php if(isset($erros['geral'])) echo "<br><small>".$erros['geral']."</small>"; ?>
          </div>
        <?php endif; ?>

        <form method="POST" id="regForm">

          <div class="form-row">
            <div class="form-group <?= isset($erros['nome']) ? 'error' : '' ?>">
              <input type="text" name="nome" id="nome" placeholder=" "
                value="<?= htmlspecialchars($dados['nome'] ?? '') ?>" required>
              <label for="nome">Nome</label>
              <?php if (isset($erros['nome'])): ?>
                <span class="field-error"><?= $erros['nome'] ?></span>
              <?php endif; ?>
            </div>
            <div class="form-group <?= isset($erros['sobrenome']) ? 'error' : '' ?>">
              <input type="text" name="sobrenome" id="sobrenome" placeholder=" "
                value="<?= htmlspecialchars($dados['sobrenome'] ?? '') ?>" required>
              <label for="sobrenome">Sobrenome</label>
              <?php if (isset($erros['sobrenome'])): ?>
                <span class="field-error"><?= $erros['sobrenome'] ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="form-group <?= isset($erros['email']) ? 'error' : '' ?>">
            <input type="email" name="email" id="reg_email" placeholder=" "
              value="<?= htmlspecialchars($dados['email'] ?? $email_preenchido) ?>" required>
            <label for="reg_email">Email</label>
            <?php if (isset($erros['email'])): ?>
              <span class="field-error"><?= $erros['email'] ?></span>
            <?php endif; ?>
          </div>

          <div class="form-row">
            <div class="form-group <?= isset($erros['celular']) ? 'error' : '' ?>">
              <input type="tel" name="celular" id="celular" placeholder=" "
                value="<?= htmlspecialchars($dados['celular'] ?? '') ?>">
              <label for="celular">Celular</label>
              <?php if (isset($erros['celular'])): ?>
                <span class="field-error"><?= $erros['celular'] ?></span>
              <?php endif; ?>
            </div>
            <div class="form-group <?= isset($erros['nascimento']) ? 'error' : '' ?>">
              <input type="date" name="nascimento" id="nascimento" placeholder=" "
                value="<?= htmlspecialchars($dados['nascimento'] ?? '') ?>" required>
              <label for="nascimento">Nascimento</label>
              <?php if (isset($erros['nascimento'])): ?>
                <span class="field-error"><?= $erros['nascimento'] ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="form-group <?= isset($erros['plano']) ? 'error' : '' ?>">
            <select name="plano" id="plano" class="<?= !empty($dados['plano'] ?? '') ? 'has-value' : '' ?>" required>
              <option value=""></option>
              <option value="Padrão com anúncios" <?= ($dados['plano'] ?? '') === 'Padrão com anúncios' ? 'selected' : '' ?>>
                Padrão com anúncios – R$ 20,90/mês
              </option>
              <option value="Padrão" <?= ($dados['plano'] ?? '') === 'Padrão' ? 'selected' : '' ?>>
                Padrão – R$ 34,90/mês
              </option>
              <option value="Premium" <?= ($dados['plano'] ?? '') === 'Premium' ? 'selected' : '' ?>>
                Premium – R$ 45,90/mês
              </option>
            </select>
            <label for="plano">Plano</label>
            <?php if (isset($erros['plano'])): ?>
              <span class="field-error"><?= $erros['plano'] ?></span>
            <?php endif; ?>
          </div>

          <div class="form-group <?= isset($erros['senha']) ? 'error' : '' ?>">
            <input type="password" name="senha" id="senha" placeholder=" " required oninput="checkStrength(this.value)">
            <label for="senha">Senha</label>
            <?php if (isset($erros['senha'])): ?>
              <span class="field-error"><?= $erros['senha'] ?></span>
            <?php endif; ?>
            <div class="pwd-strength">
              <div class="pwd-strength-bar">
                <div class="pwd-strength-fill" id="pwdBar"></div>
              </div>
              <span class="pwd-strength-label" id="pwdLabel">Mínimo 6 caracteres</span>
            </div>
          </div>

          <div class="form-group <?= isset($erros['confirmar_senha']) ? 'error' : '' ?>">
            <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder=" " required>
            <label for="confirmar_senha">Confirmar Senha</label>
            <?php if (isset($erros['confirmar_senha'])): ?>
              <span class="field-error"><?= $erros['confirmar_senha'] ?></span>
            <?php endif; ?>
          </div>

          <div class="terms-row">
            <input type="checkbox" name="termos" id="termos" required <?= isset($_POST['termos']) ? 'checked' : '' ?>>
            <label for="termos">
              Concordo com os <a href="#">Termos de Uso</a> e a
              <a href="#">Política de Privacidade</a> da Netflix.
            </label>
          </div>
          <?php if (isset($erros['termos'])): ?>
            <span class="field-error" style="margin-top:-10px;display:block;margin-bottom:10px">
              <?= $erros['termos'] ?>
            </span>
          <?php endif; ?>

          <button type="submit" class="btn-primary">Criar Conta &rsaquo;</button>
        </form>

        <div class="login-row">
          Já tem conta? <a href="login.php">Faça login</a>
        </div>

      <?php endif; ?>
    </div>
  </div>

  <script>
    //verificar senha
    function checkStrength(val) {
      const bar = document.getElementById('pwdBar');
      const lbl = document.getElementById('pwdLabel');
      let score = 0;
      if (val.length >= 6) score++;
      if (val.length >= 10) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[0-9]/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;

      const map = [
        { w: '0%',   c: '#e50914', t: 'Mínimo 6 caracteres' },
        { w: '25%',  c: '#e50914', t: 'Fraca' },
        { w: '50%',  c: '#f59e0b', t: 'Regular' },
        { w: '75%',  c: '#3b82f6', t: 'Boa' },
        { w: '90%',  c: '#22c55e', t: 'Forte' },
        { w: '100%', c: '#16a34a', t: 'Muito forte' },
      ];

      bar.style.width      = map[score].w;
      bar.style.background = map[score].c;
      lbl.textContent      = map[score].t;
      lbl.style.color      = map[score].c;
    }

    document.getElementById('plano').addEventListener('change', function() {
      this.classList.toggle('has-value', !!this.value);
    });
  </script>

</body>
</html>