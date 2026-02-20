<?php
session_start();
require_once 'Database/DBConnection.php';
require_once 'Repository/UsuarioRepository.php';
require_once 'Auth/Auth.php';

use Login\Database\DBConnection;
use Login\Repository\UsuarioRepository;
use Login\Auth\Auth;

$db = DBConnection::getConnection();
$auth = new Auth(new UsuarioRepository($db));

$resultado = $auth->registrar($_POST['usuario'], $_POST['senha'], $_POST['tipo']);

if ($resultado === true) {
    header("Location: index.php?sucesso=1");
} else {
    $_SESSION['erro'] = is_string($resultado) ? $resultado : "Erro ao cadastrar.";
    header("Location: registro.php");
}
