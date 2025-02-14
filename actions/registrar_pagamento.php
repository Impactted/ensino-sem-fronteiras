<?php
include '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_id = $_POST['aluno_id'];
    $valor = $_POST['valor'];
    $data_vencimento = $_POST['data_vencimento'];
    $metodo = $_POST['metodo'] ?? null; // Pode ser NULL até o pagamento ser feito

    // Insere um pagamento futuro com status "Pendente"
    $stmt = $pdo->prepare("INSERT INTO pagamentos (aluno_id, valor, data_vencimento, metodo, status) VALUES (?, ?, ?, ?, 'Pendente')");
    $stmt->execute([$aluno_id, $valor, $data_vencimento, $metodo]);

    header("Location: ../views/pagamentos.php");
    exit();
}
?>
