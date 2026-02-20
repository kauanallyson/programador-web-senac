<?php
require_once 'db.php';
require_once 'Piloto.php';
session_start();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Erro de segurança: Token inválido.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erros = [];

    $nome          = trim($_POST['nomePiloto'] ?? '');
    $sigla         = strtoupper(trim($_POST['sigla'] ?? ''));
    $nacionalidade = trim($_POST['nacionalidade'] ?? '');
    $id_equipe     = filter_input(INPUT_POST, 'equipe', FILTER_VALIDATE_INT);
    $licenca       = $_POST['licenca'] ?? '';
    $bio           = trim($_POST['bio'] ?? '');
    $nascimento    = $_POST['nascimento'] ?? '';
    $numeroCarro   = filter_input(INPUT_POST, 'numero', FILTER_VALIDATE_INT);
    $titulos       = filter_input(INPUT_POST, 'titulos', FILTER_VALIDATE_INT) ?? 0;

    if (strlen($sigla) !== 3) $erros[] = "A sigla deve ter 3 letras.";
    if (!$id_equipe || $id_equipe < 1 || $id_equipe > 11) $erros[] = "Equipe inválida.";
    if (!$numeroCarro || $numeroCarro < 1 || $numeroCarro > 99) $erros[] = "Número do carro inválido.";

    if (empty($erros)) {
        try {
            $novoPiloto = new Piloto($nome, $sigla, $nacionalidade, $id_equipe, $licenca, $bio, $nascimento, $numeroCarro, $titulos);

            $sql = "INSERT INTO pilotos (nome, sigla, nacionalidade, id_equipe, licenca, bio, data_nascimento, id_carro, num_titulos) 
                    VALUES (:nome, :sigla, :nac, :equipe, :lic, :bio, :nasc, :carro, :tit)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome'   => $novoPiloto->nome,
                ':sigla'  => $novoPiloto->sigla,
                ':nac'    => $novoPiloto->nacionalidade,
                ':equipe' => $novoPiloto->id_equipe,
                ':lic'    => $novoPiloto->licenca,
                ':bio'    => $novoPiloto->bio,
                ':nasc'   => $novoPiloto->nascimento,
                ':carro'  => $novoPiloto->numeroCarro,
                ':tit'    => $novoPiloto->titulos
            ]);

            $_SESSION['sucesso'] = "Piloto cadastrado com sucesso!";
            header("Location: grid.php");
            exit;
        } catch (PDOException $e) {
            $_SESSION['erros'] = ["Erro no banco: " . $e->getMessage()];
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION['erros'] = $erros;
        header("Location: index.php");
        exit;
    }
}
