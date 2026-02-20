<?php
require_once 'db.php';
require_once 'Piloto.php';
session_start();

if (isset($_GET['limpar']) && isset($_GET['token']) && $_GET['token'] === $_SESSION['csrf_token']) {
    try {
        $pdo->exec("DELETE FROM pilotos");
        $_SESSION['sucesso'] = "Grid limpo com sucesso!";
    } catch (PDOException $e) {
        $_SESSION['erros'] = ["Erro ao limpar grid: " . $e->getMessage()];
    }
    header("Location: grid.php");
    exit;
}

try {
    $query = "SELECT p.*, e.nome_equipe 
              FROM pilotos p 
              JOIN equipes e ON p.id_equipe = e.id 
              ORDER BY p.id_carro ASC";

    $stmt = $pdo->query($query);
    $dadosPilotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar o grid: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>F1 2026 - Grid de Largada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <main class="container">
        <header>
            <hgroup>
                <h1>Grid de Largada</h1>
                <p>Lista oficial de pilotos - Temporada 2026</p>
            </hgroup>
            <nav>
                <ul>
                    <li><a href="index.php" class="outline">Novo Cadastro</a></li>
                    <li>
                        <a href="?limpar=1&token=<?= $_SESSION['csrf_token'] ?>"
                            class="secondary"
                            onclick="return confirm('Isso excluirá TODOS os pilotos do banco de dados. Confirmar?')">
                            Limpar Banco
                        </a>
                    </li>
                </ul>
            </nav>
        </header>

        <article>
            <?php if (count($dadosPilotos) > 0): ?>
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
                            <?php foreach ($dadosPilotos as $d):
                                $p = new Piloto($d['nome'], $d['sigla'], $d['nacionalidade'], (int)$d['id_equipe'], $d['licenca'], $d['bio'] ?? '', $d['data_nascimento'], (int)$d['id_carro'], (int)$d['num_titulos']);
                            ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($p->numeroCarro) ?></strong></td>
                                    <td>
                                        <strong><?= htmlspecialchars($p->nome) ?></strong><br>
                                        <small>
                                            <mark><?= htmlspecialchars($p->sigla) ?></mark> |
                                            <?= htmlspecialchars($p->nacionalidade) ?>
                                        </small>
                                    </td>
                                    <td><?= htmlspecialchars($d['nome_equipe']) ?></td>
                                    <td><?= $p->getIdade() ?> anos</td>
                                    <td><?= $p->titulos ?></td>
                                    <td><u><?= htmlspecialchars($p->licenca) ?></u></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 2rem;">
                    <p>Nenhum piloto cadastrado no banco de dados.</p>
                    <a href="index.php" class="button">Cadastrar Primeiro Piloto</a>
                </div>
            <?php endif; ?>
        </article>
    </main>
</body>

</html>