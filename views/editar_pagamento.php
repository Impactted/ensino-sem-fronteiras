<?php
include '../config/conexao.php';

// Obtendo o pagamento para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM pagamentos WHERE id = ?");
    $stmt->execute([$id]);
    $pagamento = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$pagamento) {
    echo "Pagamento não encontrado!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center text-warning">Editar Pagamento</h3>

        <form action="../actions/atualizar_pagamentos.php" method="POST">
            <input type="hidden" name="id" value="<?= $pagamento['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Valor do Pagamento (R$):</label>
                <input type="number" class="form-control" name="valor" step="0.01" value="<?= $pagamento['valor'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Vencimento:</label>
                <input type="date" class="form-control" name="data_vencimento" value="<?= $pagamento['data_vencimento'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status do Pagamento:</label>
                <select class="form-control" name="status" required>
                    <option value="Pendente" <?= ($pagamento['status'] == 'Pendente') ? 'selected' : '' ?>>Pendente</option>
                    <option value="Pago" <?= ($pagamento['status'] == 'Pago') ? 'selected' : '' ?>>Pago</option>
                    <option value="Atrasado" <?= ($pagamento['status'] == 'Atrasado') ? 'selected' : '' ?>>Atrasado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning w-100">Salvar Alterações</button>
        </form>

        <a href="../views/pagamentos.php" class="btn btn-secondary w-100 mt-2">Voltar</a>
    </div>
</body>
</html>
