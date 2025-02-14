<?php
include '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $data_pagamento = ($status == 'Pago') ? date('Y-m-d') : null;

    $stmt = $pdo->prepare("UPDATE pagamentos SET status = ?, data_pagamento = ? WHERE id = ?");
    $stmt->execute([$status, $data_pagamento, $id]);

    header("Location: ../views/pagamentos.php");
    exit();
}
?>
