<?php
session_start();

require_once __DIR__ . '/Auth/Auth.php';

use Login\Auth\Auth;

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    Auth::logout();
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Sistema Senac</span>
            <a href="?action=logout" class="btn btn-outline-light btn-sm">Sair</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3 shadow-sm border">
            <div class="container-fluid py-5 text-center">
                <h1 class="display-5 fw-bold">Olá, <?= htmlspecialchars($_SESSION['usuario']); ?>! 👋</h1>
                <p class="col-md-12 fs-4">Você está acessando como: <strong><?= strtoupper($_SESSION['tipo']); ?></strong></p>
                <hr class="my-4">
                <p>O Singleton do Banco de Dados foi carregado com sucesso e sua sessão está ativa.</p>
            </div>
        </div>
    </div>
</body>

</html>