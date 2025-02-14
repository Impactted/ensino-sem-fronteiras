<?php
session_start();
include '../config/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM alunos WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['mensagem'] = "Aluno excluído com sucesso!";
}

header("Location: ../views/alunos.php");
exit();
?>
