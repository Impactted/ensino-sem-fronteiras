<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/conexao.php';

// Buscar todos os alunos
$stmt = $pdo->prepare("SELECT * FROM alunos");
$stmt->execute();
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container mt-5">
    <a href="dashboard.php" class="btn btn-primary mb-3">🏠 Início</a>
    <a href="cadastro_aluno.php" class="btn btn-primary mb-3">📚 Cadastrar</a>

    <div class="card p-4 shadow">
        <h2 class="text-center">Lista de Alunos</h2>
        
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Série Escolar</th>
                    <th>Escola</th>
                    <th>Alergias</th>
                    <th>Doenças</th>
                    <th>Autorizado a Ir Sozinho</th>
                    <th>Valor Mensalidade (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno) : ?>
                    <tr>
                        <td><?php echo $aluno['nome_completo']; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($aluno['data_nascimento'])); ?></td>
                        <td><?php echo $aluno['serie_escolar']; ?></td>
                        <td><?php echo $aluno['escola']; ?></td>
                        <td><?php echo !empty($aluno['alergias']) ? $aluno['alergias'] : '-'; ?></td>
                        <td><?php echo !empty($aluno['doencas']) ? $aluno['doencas'] : '-'; ?></td>
                        <td><?php echo $aluno['autorizado_sozinho'] ? 'Sim' : 'Não'; ?></td>
                        <td><?php echo number_format($aluno['valor_mensalidade'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="editar_aluno.php?id=<?php echo $aluno['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="../actions/excluir_aluno.php?id=<?php echo $aluno['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este aluno?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
