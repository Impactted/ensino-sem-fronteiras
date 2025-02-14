<?php
include '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE pagamentos SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    echo "Status atualizado com sucesso!";
}
?>
