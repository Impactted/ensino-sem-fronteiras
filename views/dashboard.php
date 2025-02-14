<?php
include '../config/conexao.php';

// Contagens gerais
$total_alunos = $pdo->query("SELECT COUNT(*) FROM alunos")->fetchColumn();
$total_responsaveis = $pdo->query("SELECT COUNT(*) FROM responsaveis")->fetchColumn();

// Mensalidades
$total_mensalidades = $pdo->query("SELECT SUM(valor) FROM pagamentos")->fetchColumn() ?: 0;
$total_recebido = $pdo->query("SELECT SUM(valor) FROM pagamentos WHERE status = 'Pago'")->fetchColumn() ?: 0;
$total_pendente = $total_mensalidades - $total_recebido;

// Últimos alunos
$ultimos_alunos = $pdo->query("SELECT nome_completo, serie_escolar FROM alunos ORDER BY id DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Pagamentos organizados
$pagamentos_pendentes = $pdo->query("SELECT valor, data_vencimento FROM pagamentos WHERE status = 'Pendente' ORDER BY data_vencimento ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
$pagamentos_atrasados = $pdo->query("SELECT valor, data_vencimento FROM pagamentos WHERE status = 'Atrasado' ORDER BY data_vencimento ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
$pagamentos_pagos = $pdo->query("SELECT valor, data_vencimento FROM pagamentos WHERE status = 'Pago' ORDER BY data_vencimento DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ensino Sem Fronteiras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #ff3366;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }
        .content {
            margin-left: 250px;
            padding: 40px;
            width: calc(100% - 250px);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-center fw-bold">Ensino Sem Fronteiras</h2>
        <a href="#" class="menu-link" data-page="alunos.php">📚 Alunos</a>
        <a href="#" class="menu-link" data-page="responsaveis.php">👨‍👩‍👧‍👦 Responsáveis</a>
        <a href="#" class="menu-link" data-page="pagamentos.php">💰 Pagamentos</a>
        <a href="#" class="menu-link" data-page="estatisticas.php">📊 Estatísticas</a>
        <a href="logout.php" class="text-danger fw-bold">🚪 Sair</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <h1 class="text-danger fw-bold">📌 Dashboard</h1>

        <!-- Seção de carregamento dinâmico -->
        <div id="conteudo-dinamico">
            <p class="text-center text-muted">Selecione uma opção no menu lateral para gerenciar o sistema.</p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".menu-link").click(function(e) {
                e.preventDefault();
                let pagina = $(this).data("page");

                $("#conteudo-dinamico").html("<p class='text-center'>Carregando...</p>").load(pagina);
            });
        });
    </script>

</body>
</html>
