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

if ($auth->login($_POST['usuario'], $_POST['senha'])) {
    header("Location: dashboard.php");
} else {
    $_SESSION['erro'] = "Credenciais inválidas.";
    header("Location: index.php");
}
