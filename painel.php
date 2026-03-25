<?php
require_once 'config.php';

$busca = trim($_GET['q'] ?? '');
$plano_filtro = $_GET['plano'] ?? '';
$por_pagina = 10;
$pagina_atual = max(1, (int)($_GET['p'] ?? 1));

$where = [];
$params = [];

if ($busca !== '') {
  $where[] = "(nome LIKE :b1 OR sobrenome LIKE :b2 OR email LIKE :b3 OR celular LIKE :b4)";
  
  $params[':b1'] = "%$busca%";
  $params[':b2'] = "%$busca%";
  $params[':b3'] = "%$busca%";
  $params[':b4'] = "%$busca%";
}


$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM usuarios $whereSql");
$stmtCount->execute($params);
$total_filtrado = $stmtCount->fetchColumn();

$total_paginas = max(1, (int)ceil($total_filtrado / $por_pagina));
$pagina_atual = min($pagina_atual, $total_paginas);
$offset = ($pagina_atual - 1) * $por_pagina;

$sqlData = "SELECT * FROM usuarios $whereSql ORDER BY id DESC LIMIT $por_pagina OFFSET $offset";
$stmtData = $pdo->prepare($sqlData);
$stmtData->execute($params);
$pagina_itens = $stmtData->fetchAll(PDO::FETCH_ASSOC);


$total = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Netflix – Painel de Usuários</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --red: #e50914;
      --black: #141414;
      --dark: #1a1a1a;
      --card: #1e1e1e;
      --border: #2a2a2a;
      --gray: #888;
      --white: #fff;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--black);
      color: var(--white);
      min-height: 100vh;
    }

    nav {
      background: rgba(20, 20, 20, .97);
      border-bottom: 1px solid var(--border);
      padding: 16px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2rem;
      color: var(--red);
      letter-spacing: 2px;
      text-decoration: none;
    }

    .nav-right {
      display: flex;
      gap: 14px;
      align-items: center;
    }

    .badge {
      background: var(--red);
      color: #fff;
      font-size: .72rem;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .btn-sm {
      background: #2a2a2a;
      color: var(--white);
      border: 1px solid #444;
      padding: 8px 16px;
      border-radius: 4px;
      font-family: 'DM Sans', sans-serif;
      font-size: .84rem;
      cursor: pointer;
      text-decoration: none;
      transition: background .2s;
    }

    .btn-sm:hover {
      background: #333;
    }

    main {
      padding: 40px;
      max-width: 1300px;
      margin: 0 auto;
    }

    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 32px;
      flex-wrap: wrap;
      gap: 16px;
    }

    .page-header h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2rem;
      letter-spacing: 1px;
    }

    .page-header p {
      color: var(--gray);
      font-size: .9rem;
      margin-top: 4px;
    }

    .stats-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 16px;
      margin-bottom: 32px;
    }

    .stat-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 22px 24px;
    }

    .stat-card .stat-label {
      font-size: .78rem;
      color: var(--gray);
      text-transform: uppercase;
      letter-spacing: .8px;
      margin-bottom: 8px;
    }

    .stat-card .stat-value {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.2rem;
      line-height: 1;
    }

    .stat-card .stat-sub {
      font-size: .78rem;
      color: var(--gray);
      margin-top: 4px;
    }

    .toolbar {
      display: flex;
      gap: 14px;
      margin-bottom: 20px;
      flex-wrap: wrap;
      align-items: center;
    }

    .search-box {
      flex: 1;
      min-width: 200px;
      position: relative;
    }

    .search-box input {
      width: 100%;
      padding: 10px 16px 10px 40px;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 6px;
      color: var(--white);
      font-family: 'DM Sans', sans-serif;
      font-size: .9rem;
      outline: none;
      transition: border-color .2s;
    }

    .search-box input:focus {
      border-color: #555;
    }

    .search-box::before {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      font-size: .85rem;
    }

    .filter-select {
      padding: 10px 16px;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 6px;
      color: var(--white);
      font-family: 'DM Sans', sans-serif;
      font-size: .9rem;
      outline: none;
      cursor: pointer;
    }

    .filter-select option {
      background: #1e1e1e;
    }

    .table-wrap {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead tr {
      background: #252525;
      border-bottom: 1px solid var(--border);
    }

    thead th {
      padding: 14px 18px;
      font-size: .75rem;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: var(--gray);
      font-weight: 600;
      text-align: left;
      white-space: nowrap;
    }

    tbody tr {
      border-bottom: 1px solid #222;
      transition: background .15s;
    }

    tbody tr:last-child {
      border-bottom: none;
    }

    tbody tr:hover {
      background: #242424;
    }

    tbody td {
      padding: 14px 18px;
      font-size: .88rem;
      vertical-align: middle;
    }

    .avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: var(--red);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: .85rem;
      text-transform: uppercase;
      flex-shrink: 0;
    }

    .user-cell {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-name {
      font-weight: 500;
    }

    .user-email {
      font-size: .78rem;
      color: var(--gray);
    }

    .plan-badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: .75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .plan-Premium {
      background: rgba(245, 158, 11, .15);
      color: #fbbf24;
    }

    .plan-Padrão {
      background: rgba(59, 130, 246, .15);
      color: #60a5fa;
    }

    .plan-Anúncios {
      background: rgba(34, 197, 94, .15);
      color: #4ade80;
    }

    .plan-default {
      background: #333;
      color: #ccc;
    }

    .pwd-text {
      font-family: monospace;
      color: #fbbf24;
      background: rgba(0, 0, 0, 0.5);
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 1rem;
    }

    .date-cell {
      color: var(--gray);
      font-size: .82rem;
    }

    .empty-state {
      padding: 60px 20px;
      text-align: center;
      color: var(--gray);
    }

    .empty-state .empty-icon {
      font-size: 3rem;
      margin-bottom: 12px;
    }

    .empty-state p {
      font-size: .95rem;
    }

    .pagination {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .page-link {
      padding: 8px 14px;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 4px;
      font-family: 'DM Sans', sans-serif;
      font-size: .85rem;
      color: var(--white);
      text-decoration: none;
      transition: background .2s;
    }

    .page-link:hover {
      background: #2a2a2a;
    }

    .page-link.active {
      background: var(--red);
      border-color: var(--red);
    }

    .export-btn {
      background: #27272a;
      color: var(--white);
      border: 1px solid #3f3f46;
      padding: 10px 18px;
      border-radius: 6px;
      font-family: 'DM Sans', sans-serif;
      font-size: .85rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
      transition: background .2s;
    }

    .export-btn:hover {
      background: #333;
    }
  </style>
</head>

<body>

  <nav>
    <a href="index.html" class="logo">Netflix</a>
    <div class="nav-right">
      <span class="badge">Administrador</span>
      <a href="index.html" class="btn-sm">Início</a>
    </div>
  </nav>

  <main>
    <div class="page-header">
      <div>
        <h1>Painel de Usuários</h1>
        <p><?= $total_filtrado ?> usuário(s) encontrado(s) · <?= $total ?> total cadastrado(s)</p>
      </div>
    </div>

    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-label">Total de Usuários</div>
        <div class="stat-value"><?= $total ?></div>
        <div class="stat-sub">cadastrados no banco</div>
      </div>
    </div>

    <div class="toolbar">
      <div class="search-box">
        <form method="GET">
          <input type="text" name="q" placeholder="Buscar por nome, email ou celular..."
            value="<?= htmlspecialchars($busca) ?>">
          <input type="hidden" name="plano" value="<?= htmlspecialchars($plano_filtro) ?>">
        </form>
      </div>
      <form method="GET">
        <input type="hidden" name="q" value="<?= htmlspecialchars($busca) ?>">
        <select name="plano" class="filter-select" onchange="this.form.submit()">
          <option value="">Todos os planos</option>
          <option value="Premium" <?= $plano_filtro === 'Premium' ? 'selected' : '' ?>>Premium</option>
          <option value="Padrão" <?= $plano_filtro === 'Padrão' ? 'selected' : '' ?>>Padrão</option>
          <option value="Padrão com anúncios" <?= $plano_filtro === 'Padrão com anúncios' ? 'selected' : '' ?>>Com anúncios</option>
        </select>
      </form>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Celular</th>
            <th>Nascimento</th>
            <th>Plano</th>
            <th>Senha Salva</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($pagina_itens)): ?>
            <tr>
              <td colspan="6">
                <div class="empty-state">
                  <p>Nenhum usuário encontrado<?= $busca ? ' para "' . htmlspecialchars($busca) . '"' : '' ?>.</p>
                </div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($pagina_itens as $u): ?>
              <tr>
                <td style="color:var(--gray);font-size:.8rem">#<?= htmlspecialchars($u['id']) ?></td>
                <td>
                  <div class="user-cell">
                    <div class="avatar"><?= strtoupper(substr($u['nome'] ?? 'U', 0, 1)) ?></div>
                    <div>
                      <div class="user-name"><?= htmlspecialchars(($u['nome'] ?? '') . ' ' . ($u['sobrenome'] ?? '')) ?></div>
                      <div class="user-email"><?= htmlspecialchars($u['email'] ?? '') ?></div>
                    </div>
                  </div>
                </td>
                <td><?= htmlspecialchars($u['celular'] ?: '—') ?></td>
                <td class="date-cell">
                  <?php
                  if (!empty($u['nascimento'])) {
                    $data = new DateTime($u['nascimento']);
                    echo $data->format('d/m/Y');
                  } else {
                    echo '—';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $p = $u['plano'] ?? '';
                  $cls = 'plan-default';
                  if (strpos($p, 'Premium') !== false) $cls = 'plan-Premium';
                  elseif (strpos($p, 'anúncios') !== false) $cls = 'plan-Anúncios';
                  elseif (strpos($p, 'Padrão') !== false) $cls = 'plan-Padrão';
                  ?>
                  <span class="plan-badge <?= $cls ?>"><?= htmlspecialchars($p) ?></span>
                </td>
                <td><span class="pwd-text"><?= htmlspecialchars($u['senha'] ?? '') ?></span></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if ($total_paginas > 1): ?>
      <div class="pagination">
        <?php if ($pagina_atual > 1): ?>
          <a href="?q=<?= urlencode($busca) ?>&plano=<?= urlencode($plano_filtro) ?>&p=<?= $pagina_atual - 1 ?>"
            class="page-link">← Anterior</a>
        <?php endif; ?>

        <?php for ($pp = 1; $pp <= $total_paginas; $pp++): ?>
          <a href="?q=<?= urlencode($busca) ?>&plano=<?= urlencode($plano_filtro) ?>&p=<?= $pp ?>"
            class="page-link <?= $pp === $pagina_atual ? 'active' : '' ?>"><?= $pp ?></a>
        <?php endfor; ?>

        <?php if ($pagina_atual < $total_paginas): ?>
          <a href="?q=<?= urlencode($busca) ?>&plano=<?= urlencode($plano_filtro) ?>&p=<?= $pagina_atual + 1 ?>"
            class="page-link">Próxima →</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </main>

</body>

</html>