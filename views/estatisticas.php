<?php
include '../config/conexao.php';

// Buscar contagem de alunos
$total_alunos = $pdo->query("SELECT COUNT(*) FROM alunos")->fetchColumn() ?: 0;

// Buscar contagem de responsáveis
$total_responsaveis = $pdo->query("SELECT COUNT(*) FROM responsaveis")->fetchColumn() ?: 0;

// Buscar valores das mensalidades
$total_mensalidades = $pdo->query("SELECT SUM(valor) FROM pagamentos")->fetchColumn() ?: 0;
$total_recebido = $pdo->query("SELECT SUM(valor) FROM pagamentos WHERE status = 'Pago'")->fetchColumn() ?: 0;
$total_pendente = $pdo->query("SELECT SUM(valor) FROM pagamentos WHERE status = 'Pendente'")->fetchColumn() ?: 0;
$total_atrasado = $pdo->query("SELECT SUM(valor) FROM pagamentos WHERE status = 'Atrasado'")->fetchColumn() ?: 0;

// Buscar os pagamentos por status
$pagamentos_pendentes = $pdo->query("SELECT * FROM pagamentos WHERE status = 'Pendente' ORDER BY data_vencimento ASC")->fetchAll(PDO::FETCH_ASSOC);
$pagamentos_atrasados = $pdo->query("SELECT * FROM pagamentos WHERE status = 'Atrasado' ORDER BY data_vencimento ASC")->fetchAll(PDO::FETCH_ASSOC);
$pagamentos_pagos = $pdo->query("SELECT * FROM pagamentos WHERE status = 'Pago' ORDER BY data_vencimento DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="p-4">

    <div class="container">
        <h2 class="text-danger fw-bold"><i class="fas fa-chart-bar"></i> Estatísticas</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3">
                    <h5><i class="fas fa-user-graduate"></i> Total de Alunos</h5>
                    <p class="fs-3"><?= $total_alunos ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white p-3">
                    <h5><i class="fas fa-users"></i> Total de Responsáveis</h5>
                    <p class="fs-3"><?= $total_responsaveis ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark p-3">
                    <h5><i class="fas fa-dollar-sign"></i> Mensalidades Pendentes</h5>
                    <p class="fs-3">R$ <?= number_format($total_pendente, 2, ',', '.') ?></p>
                </div>
            </div>
        </div>

        <h3 class="mt-4 text-danger"><i class="fas fa-money-bill-wave"></i> Pagamentos</h3>

        <div class="row">
            <div class="col-md-4">
                <h5 class="text-warning">📅 Pendentes</h5>
                <ul class="list-group">
                    <?php foreach ($pagamentos_pendentes as $pagamento): ?>
                        <li class="list-group-item"><?= $pagamento['data_vencimento'] ?> - R$ <?= number_format($pagamento['valor'], 2, ',', '.') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-4">
                <h5 class="text-danger">⏳ Atrasados</h5>
                <ul class="list-group">
                    <?php foreach ($pagamentos_atrasados as $pagamento): ?>
                        <li class="list-group-item"><?= $pagamento['data_vencimento'] ?> - R$ <?= number_format($pagamento['valor'], 2, ',', '.') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-4">
                <h5 class="text-success">✅ Últimos Pagos</h5>
                <ul class="list-group">
                    <?php foreach ($pagamentos_pagos as $pagamento): ?>
                        <li class="list-group-item"><?= $pagamento['data_vencimento'] ?> - R$ <?= number_format($pagamento['valor'], 2, ',', '.') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        
    </div>



</body>
</html>
