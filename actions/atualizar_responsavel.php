<?php
session_start();
include '../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $parentesco = $_POST['parentesco'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $cpf = $_POST['cpf'];

    // Atualizar os dados do responsável
    $stmt = $pdo->prepare("
        UPDATE responsaveis SET 
            nome = ?, telefone = ?, parentesco = ?, email = ?, endereco = ?, cidade = ?, estado = ?, cep = ?, cpf = ?
        WHERE id = ?
    ");
    $stmt->execute([$nome, $telefone, $parentesco, $email, $endereco, $cidade, $estado, $cep, $cpf, $id]);

    // Atualizar vinculação de alunos
    $stmt = $pdo->prepare("DELETE FROM aluno_responsavel WHERE responsavel_id = ?");
    $stmt->execute([$id]);

    if (!empty($_POST['aluno_ids'])) {
        foreach ($_POST['aluno_ids'] as $aluno_id) {
            $stmt = $pdo->prepare("INSERT INTO aluno_responsavel (aluno_id, responsavel_id) VALUES (?, ?)");
            $stmt->execute([$aluno_id, $id]);
        }
    }

    header("Location: ../views/responsaveis.php?success=1");
    exit();
}
?>
