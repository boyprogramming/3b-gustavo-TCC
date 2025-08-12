<?php
require_once __DIR__ . '/../model/Usuario.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao']) && $_POST['acao'] === 'login') {
        $usuario = Usuario::autenticar($_POST['email'], $_POST['senha']);
        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            header('Location: ../index.php');
            exit;
        } else {
            $_SESSION['erro'] = "Credenciais inválidas.";
            header('Location: ../index.php?pagina=login');
            exit;
        }
    }

    if (isset($_POST['acao']) && $_POST['acao'] === 'cadastro') {
        if (Usuario::cadastrar($_POST['nome'], $_POST['email'], $_POST['senha'])) {
            $_SESSION['sucesso'] = "Cadastro realizado com sucesso. Faça login.";
            header('Location: ../index.php?pagina=login');
            exit;
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar usuário.";
            header('Location: ../index.php?pagina=cadastro');
            exit;
        }
    }
}
