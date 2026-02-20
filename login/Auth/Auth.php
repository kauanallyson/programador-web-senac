<?php

namespace Login\Auth;

use Login\Repository\UsuarioRepository;

class Auth
{
    private $repo;

    public function __construct(UsuarioRepository $repo)
    {
        $this->repo = $repo;
    }

    public function login($usuario, $senha): bool
    {
        $user = $this->repo->buscarPorUsuario($usuario);
        if ($user && password_verify($senha, $user->senha)) {
            $_SESSION["usuario"] = $user->usuario;
            $_SESSION["tipo"] = $user->tipo_usuario;
            return true;
        }
        return false;
    }

    public function registrar($usuario, $senha, $tipo)
    {
        if ($this->repo->usuarioExiste($usuario)) {
            return "Este usuário já existe.";
        }
        return $this->repo->salvar($usuario, $senha, $tipo);
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        header("Location: index.php");
    }
}
