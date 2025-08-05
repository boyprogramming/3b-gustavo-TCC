<?php
require_once __DIR__ . '/../bd/conexao.php';

class Usuario {
    public static function autenticar($email, $senha) {
        global $pdo;
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public static function cadastrar($nome, $email, $senha) {
        global $pdo;
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        return $stmt->execute([$nome, $email, $senhaHash]);
    }
}
