<?php
require_once 'Piloto.php';
session_start();

// Proteção contra CSRF básico no logout/limpar
if (isset($_GET['limpar']) && isset($_GET['token']) && $_GET['token'] === $_SESSION['csrf_token']) {
    unset($_SESSION['pilotos']);
    header("Location: grid.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Grid de Pilotos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <main class="container">
        <header>
            <hgroup>
                <h1>Grid de Largada</h1>
                <p>Lista oficial de pilotos na Copa PHP</p>
            </hgroup>
            <nav>
                <ul>
                    <li><a href="index.php" class="outline">Novo Cadastro</a></li>
                    <li><a href="?limpar=1&token=<?= $_SESSION['csrf_token'] ?? '' ?>"
                            class="secondary"
                            onclick="return confirm('Apagar todos os dados?')">Limpar</a></li>
                </ul>
            </nav>
        </header>

        <article>
            <?php if (!empty($_SESSION['pilotos'])): ?>
                <div class="overflow-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Piloto</th>
                                <th>Equipe</th>
                                <th>Idade</th>
                                <th>Títulos</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['pilotos'] as $p): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($p->numeroCarro) ?></strong></td>
                                    <td>
                                        <strong><?= htmlspecialchars($p->nome) ?></strong><br>
                                        <small>
                                            <mark><?= htmlspecialchars($p->sigla) ?></mark> |
                                            <?= htmlspecialchars($p->nacionalidade) ?>
                                        </small>
                                    </td>
                                    <td><?= htmlspecialchars($p->getEquipeFormatada()) ?></td>
                                    <td><?= (int)$p->getIdade() ?> anos</td>
                                    <td><?= (int)$p->titulos ?></td>
                                    <td><u><?= htmlspecialchars(ucfirst($p->licenca)) ?></u></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>O grid está vazio. Pilotos não encontrados.</p>
            <?php endif; ?>
        </article>
    </main>
</body>

</html>