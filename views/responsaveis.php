<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/conexao.php';

// Buscar todos os responsáveis
$stmt = $pdo->prepare("SELECT * FROM responsaveis");
$stmt->execute();
$responsaveis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsáveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container mt-5">
        <a href="dashboard.php" class="btn btn-primary mb-3">🏠 Início</a>
    <div class="card p-4 shadow">

        <h2 class="text-center">Lista de Responsáveis</h2>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Parentesco</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($responsaveis as $resp) : ?>
                    <tr>
                        <td><?php echo $resp['id']; ?></td>
                        <td><?php echo $resp['nome']; ?></td>
                        <td><?php echo $resp['telefone']; ?></td>
                        <td><?php echo $resp['parentesco']; ?></td>
                        <td><?php echo $resp['email'] ? $resp['email'] : '-'; ?></td>
                        <td>
                            <a href="editar_responsavel.php?id=<?php echo $resp['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="../actions/excluir_responsavel.php?id=<?php echo $resp['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este responsável?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
