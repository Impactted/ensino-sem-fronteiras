<?php
include '../config/conexao.php';

if (isset($_GET['id']) && isset($_GET['aluno_id'])) {
    $id = $_GET['id'];
    $aluno_id = $_GET['aluno_id'];

    $stmt = $pdo->prepare("DELETE FROM responsaveis WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: ../views/editar_aluno.php?id=$aluno_id");
    exit();
}
?>
