<?php
require_once 'Piloto.php';
session_start();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Erro de validação de segurança (CSRF).");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    $nome = trim($_POST['nomePiloto'] ?? '');
    $sigla = strtoupper(trim($_POST['sigla'] ?? ''));
    $nacionalidade = trim($_POST['nacionalidade'] ?? '');
    $equipe = $_POST['equipe'] ?? '';
    $licenca = $_POST['licenca'] ?? '';
    $bio = trim($_POST['bio'] ?? '');
    $nascimento = $_POST['nascimento'] ?? '';

    if (strlen($sigla) !== 3) $erros[] = "A sigla deve ter exatamente 3 letras.";

    $numeroCarro = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
    if ($numeroCarro === false || $numeroCarro < 1 || $numeroCarro > 99) {
        $erros[] = "Número do carro inválido (1-99).";
    }

    $titulos = filter_input(INPUT_POST, 'titulos', FILTER_VALIDATE_INT);
    if ($titulos === false) $titulos = 0;

    $equipesValidas = ['alpine', 'aston_martin', 'audi', 'cadillac', 'ferrari', 'haas', 'mclaren', 'mercedes', 'racing_bulls', 'red_bull', 'williams'];
    if (!in_array($equipe, $equipesValidas)) {
        $erros[] = "Equipe selecionada é inválida.";
    }

    if (empty($erros)) {
        $novoPiloto = new Piloto(
            $nome,
            $sigla,
            $nacionalidade,
            $equipe,
            $licenca,
            $bio,
            $nascimento,
            $numeroCarro,
            $titulos
        );

        $_SESSION['pilotos'][] = $novoPiloto;

        session_regenerate_id(true);

        header("Location: grid.php");
        exit;
    } else {
        $_SESSION['erros'] = $erros;
        header("Location: index.php");
        exit;
    }
}
