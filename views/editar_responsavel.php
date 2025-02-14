<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/conexao.php';

if (!isset($_GET['id'])) {
    header("Location: responsaveis.php");
    exit();
}

$id = $_GET['id'];

// Buscar responsável
$stmt = $pdo->prepare("SELECT * FROM responsaveis WHERE id = ?");
$stmt->execute([$id]);
$responsavel = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar todos os alunos para vinculação
$stmt = $pdo->prepare("SELECT * FROM alunos");
$stmt->execute();
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar alunos já vinculados a este responsável
$stmt = $pdo->prepare("
    SELECT aluno_id FROM aluno_responsavel WHERE responsavel_id = ?
");
$stmt->execute([$id]);
$vinculados = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Responsável</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<a href="dashboard.php" class="btn btn-primary mb-3">
    🏠 Início
</a>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center">Editar Responsável</h2>
        <form action="../actions/atualizar_responsavel.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $responsavel['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $responsavel['nome']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Telefone:</label>
                <input type="text" class="form-control" name="telefone" value="<?php echo $responsavel['telefone']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Parentesco:</label>
                <input type="text" class="form-control" name="parentesco" value="<?php echo $responsavel['parentesco']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $responsavel['email']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">CPF:</label>
                <input type="text" class="form-control" name="cpf" value="<?php echo $responsavel['cpf']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Endereço:</label>
                <input type="text" class="form-control" name="endereco" value="<?php echo $responsavel['endereco']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Cidade:</label>
                <input type="text" class="form-control" name="cidade" value="<?php echo $responsavel['cidade']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Estado:</label>
                <input type="text" class="form-control" name="estado" value="<?php echo $responsavel['estado']; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">CEP:</label>
                <input type="text" class="form-control" name="cep" value="<?php echo $responsavel['cep']; ?>">
            </div>

            <h4>Vincular Alunos</h4>
            <?php foreach ($alunos as $aluno) : ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="aluno_ids[]" value="<?php echo $aluno['id']; ?>"
                        <?php echo in_array($aluno['id'], $vinculados) ? 'checked' : ''; ?>>
                    <label class="form-check-label"><?php echo $aluno['nome_completo']; ?></label>
                </div>
            <?php endforeach; ?>

            <br>
            <button type="submit" class="btn btn-success w-100">Salvar Alterações</button>
        </form>
    </div>
</div>

</body>
</html>
