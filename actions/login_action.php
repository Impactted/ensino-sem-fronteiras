<?php
session_start();
include '../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Validação simples
    if (empty($email) || empty($senha)) {
        $_SESSION['erro_login'] = "Preencha todos os campos!";
        header("Location: ../views/login.php");
        exit();
    }

    // Consulta ao banco de dados
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verifica se o usuário existe e se a senha está correta
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        header("Location: ../views/dashboard.php");
        exit();
    } else {
        $_SESSION['erro_login'] = "E-mail ou senha incorretos!";
        header("Location: ../views/login.php");
        exit();
    }
}
?>
