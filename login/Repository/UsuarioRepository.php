<?php

namespace Login\Repository;

use mysqli;

class UsuarioRepository
{
    private $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function buscarPorUsuario($usuario)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public function salvar($usuario, $senha, $tipo)
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (usuario, senha, tipo_usuario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $usuario, $senhaHash, $tipo);
        return $stmt->execute();
    }

    public function usuarioExiste($usuario)
    {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
