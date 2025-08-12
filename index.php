<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GrowSync - Nutrição Inteligente</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #e0f2fe, #c7d2fe);
      display: flex;
      flex-direction: column;
    }

    .content-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem 1rem;
    }

    .content-box {
      width: 100%;
      max-width: 900px;
      background: white;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    footer {
      background: linear-gradient(90deg, #0d6efd, #6610f2);
      color: white;
      padding: 1rem 0;
      text-align: center;
      font-weight: 500;
      box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1);
    }

    footer a {
      color: #ffffffcc;
      text-decoration: none;
    }

    footer a:hover {
      color: white;
      text-decoration: underline;
    }
 
  </style>
</head>

<body>
<?php session_start(); ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">GrowSync</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center me-3">
        <?php if (!isset($_SESSION['usuario'])): ?>
          <li class="nav-item">
            <a class="nav-link <?= ($_GET['pagina'] ?? '') === 'login' ? 'active' : '' ?>" href="index.php?pagina=login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($_GET['pagina'] ?? '') === 'cadastro' ? 'active' : '' ?>" href="index.php?pagina=cadastro">Cadastro</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?= ($_GET['pagina'] ?? '') === 'imc' ? 'active' : '' ?>" href="index.php?pagina=imc">Calcular IMC</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($_GET['pagina'] ?? '') === 'calorias' ? 'active' : '' ?>" href="index.php?pagina=calorias">Calorias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($_GET['pagina'] ?? '') === 'historico' ? 'active' : '' ?>" href="index.php?pagina=historico">Histórico</a>
          </li>
        <?php endif; ?>
      </ul>

      <?php if (isset($_SESSION['usuario'])): ?>
        <span class="navbar-text text-white me-3">
          Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>!
        </span>
        <a href="index.php?pagina=logout" class="btn btn-outline-light btn-sm">Sair</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Conteúdo Principal -->
<div class="content-wrapper">
  <div class="content-box">
    <?php
      $pagina = $_GET['pagina'] ?? (isset($_SESSION['usuario']) ? 'imc' : 'login');

      switch ($pagina) {
        case 'login': include 'view/login.php'; break;
        case 'cadastro': include 'view/cadastro.php'; break;
        case 'imc':
        case 'calorias':
        case 'historico':
          if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?pagina=login');
            exit;
          }
          include "view/{$pagina}.php";
          break;
        case 'logout':
          session_destroy();
          header('Location: index.php?pagina=login');
          exit;
        default:
          echo "<h2 class='text-center'>Página não encontrada</h2>";
      }
    ?>
  </div>
</div>

<!-- Rodapé -->
<footer>
  <div class="container">
    <p class="mb-1">GrowSync © <?= date('Y') ?> - Todos os direitos reservados.</p>
    <p class="mb-0">
      Desenvolvido com 💙 por <a href="#">GrowSync</a> | 
      <a href="#">Política de Privacidade</a>
    </p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
