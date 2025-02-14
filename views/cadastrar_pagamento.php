<?php
include '../config/conexao.php';

// Obtendo a lista de alunos para o select
$stmt = $pdo->query("SELECT id, nome_completo FROM alunos ORDER BY nome_completo ASC");
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <a href="dashboard.php" class="btn btn-primary mb-3">
    🏠 Início
</a>
<div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center text-primary">Cadastrar Pagamento</h3>

        <form action="../actions/registrar_pagamento.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Aluno:</label>
                <select class="form-control" name="aluno_id" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?= $aluno['id'] ?>"><?= $aluno['nome_completo'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Valor do Pagamento (R$):</label>
                <input type="number" class="form-control" name="valor" step="0.01" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Vencimento:</label>
                <input type="date" class="form-control" name="data_vencimento" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status do Pagamento:</label>
                <select class="form-control" name="status" required>
                    <option value="Pendente">Pendente</option>
                    <option value="Pago">Pago</option>
                    <option value="Atrasado">Atrasado</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Método de Pagamento:</label>
                <select class="form-control" name="metodo">
                    <option value="">Selecionar</option>
                    <option value="PIX">PIX</option>
                    <option value="Dinheiro">Dinheiro</option>
                    <option value="Cartão">Cartão</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrar Pagamento</button>
        </form>
        
        <a href="../views/pagamentos.php" class="btn btn-secondary w-100 mt-2">Voltar</a>
    </div>
</body>
</html>
