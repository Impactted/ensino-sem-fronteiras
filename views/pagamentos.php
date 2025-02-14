<?php
include '../config/conexao.php';

// Buscar pagamentos
$query = "SELECT pagamentos.id, alunos.nome_completo AS aluno, pagamentos.valor, pagamentos.data_vencimento, pagamentos.metodo, pagamentos.status
          FROM pagamentos
          JOIN alunos ON pagamentos.aluno_id = alunos.id
          ORDER BY pagamentos.data_vencimento DESC";

$pagamentos = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Pagamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="p-4">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-home"></i> 🏠 Início</a>
            <h2 class="text-danger fw-bold">Controle de Pagamentos</h2>
            <a href="cadastrar_pagamento.php" class="btn btn-primary">➕ Criar Pagamento</a>
        </div>

        <table class="table table-striped">
            <thead class="table-danger">
                <tr>
                    <th>Aluno</th>
                    <th>Valor</th>
                    <th>Data de Vencimento</th>
                    <th>Método</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagamentos as $pagamento): ?>
                <tr>
                    <td><?= htmlspecialchars($pagamento['aluno']) ?></td>
                    <td>R$ <?= number_format($pagamento['valor'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($pagamento['data_vencimento'])) ?></td>
                    <td><?= $pagamento['metodo'] ?: 'N/A' ?></td>
                    <td>
                        <?php if ($pagamento['status'] == 'Pendente'): ?>
                            <span class="badge bg-warning text-dark">Pendente</span>
                        <?php elseif ($pagamento['status'] == 'Atrasado'): ?>
                            <span class="badge bg-danger">Atrasado</span>
                        <?php elseif ($pagamento['status'] == 'Pago'): ?>
                            <span class="badge bg-success">Pago</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editar_pagamento.php?id=<?= $pagamento['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <button class="btn btn-success btn-sm alterar-status" data-id="<?= $pagamento['id'] ?>" data-status="Pago">Pago</button>
                        <button class="btn btn-secondary btn-sm alterar-status" data-id="<?= $pagamento['id'] ?>" data-status="Pendente">Pendente</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.alterar-status').forEach(button => {
            button.addEventListener('click', function() {
                let pagamentoId = this.getAttribute('data-id');
                let novoStatus = this.getAttribute('data-status');

                fetch('../actions/atualizar_status_pagamento.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${pagamentoId}&status=${novoStatus}`
                }).then(response => response.text())
                  .then(result => location.reload());
            });
        });
    </script>
</body>
</html>
