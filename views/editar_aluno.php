<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include '../config/conexao.php';

if (!isset($_GET['id'])) {
    header("Location: alunos.php");
    exit();
}

$id = $_GET['id'];

// Buscar aluno
$stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$stmt->execute([$id]);
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    echo "<script>alert('Aluno não encontrado!'); window.location.href='alunos.php';</script>";
    exit();
}

// Buscar responsáveis vinculados ao aluno
$stmt = $pdo->prepare("
    SELECT r.* FROM responsaveis r
    INNER JOIN aluno_responsavel ar ON r.id = ar.responsavel_id
    WHERE ar.aluno_id = ?
");
$stmt->execute([$id]);
$responsaveis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center">Editar Aluno</h2>
        <form action="../actions/atualizar_aluno.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $aluno['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Nome Completo:</label>
                <input type="text" class="form-control" name="nome_completo" value="<?php echo $aluno['nome_completo']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" name="data_nascimento" value="<?php echo $aluno['data_nascimento']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Série Escolar:</label>
                <select class="form-control" name="serie_escolar" required>
                    <option value="">Selecione a Série</option>
                    <optgroup label="Educação Infantil">
                        <option value="Creche" <?php if ($aluno['serie_escolar'] == 'Creche') echo 'selected'; ?>>Creche</option>
                        <option value="Pré-Escola" <?php if ($aluno['serie_escolar'] == 'Pré-Escola') echo 'selected'; ?>>Pré-Escola</option>
                    </optgroup>
                    <optgroup label="Ensino Fundamental - Anos Iniciais">
                        <option value="1º Ano" <?php if ($aluno['serie_escolar'] == '1º Ano') echo 'selected'; ?>>1º Ano</option>
                        <option value="2º Ano" <?php if ($aluno['serie_escolar'] == '2º Ano') echo 'selected'; ?>>2º Ano</option>
                        <option value="3º Ano" <?php if ($aluno['serie_escolar'] == '3º Ano') echo 'selected'; ?>>3º Ano</option>
                        <option value="4º Ano" <?php if ($aluno['serie_escolar'] == '4º Ano') echo 'selected'; ?>>4º Ano</option>
                        <option value="5º Ano" <?php if ($aluno['serie_escolar'] == '5º Ano') echo 'selected'; ?>>5º Ano</option>
                    </optgroup>
                    <optgroup label="Ensino Fundamental - Anos Finais">
                        <option value="6º Ano" <?php if ($aluno['serie_escolar'] == '6º Ano') echo 'selected'; ?>>6º Ano</option>
                        <option value="7º Ano" <?php if ($aluno['serie_escolar'] == '7º Ano') echo 'selected'; ?>>7º Ano</option>
                        <option value="8º Ano" <?php if ($aluno['serie_escolar'] == '8º Ano') echo 'selected'; ?>>8º Ano</option>
                        <option value="9º Ano" <?php if ($aluno['serie_escolar'] == '9º Ano') echo 'selected'; ?>>9º Ano</option>
                    </optgroup>
                    <optgroup label="Ensino Médio">
                        <option value="1º Ano Ensino Médio" <?php if ($aluno['serie_escolar'] == '1º Ano Ensino Médio') echo 'selected'; ?>>1º Ano Ensino Médio</option>
                        <option value="2º Ano Ensino Médio" <?php if ($aluno['serie_escolar'] == '2º Ano Ensino Médio') echo 'selected'; ?>>2º Ano Ensino Médio</option>
                        <option value="3º Ano Ensino Médio" <?php if ($aluno['serie_escolar'] == '3º Ano Ensino Médio') echo 'selected'; ?>>3º Ano Ensino Médio</option>
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Escola:</label>
                <input type="text" class="form-control" name="escola" value="<?php echo $aluno['escola']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Valor da Mensalidade:</label>
                <input type="number" class="form-control" name="valor_mensalidade" step="0.01" value="<?php echo $aluno['valor_mensalidade']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alergias:</label>
                <textarea class="form-control" name="alergias"><?php echo $aluno['alergias']; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Doenças:</label>
                <textarea class="form-control" name="doencas"><?php echo $aluno['doencas']; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Autorizado a ir embora sozinho?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="autorizado_sozinho" value="Sim" 
                        <?php if ($aluno['autorizado_sozinho'] == 'Sim') echo 'checked'; ?> required>
                    <label class="form-check-label">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="autorizado_sozinho" value="Não" 
                        <?php if ($aluno['autorizado_sozinho'] == 'Não') echo 'checked'; ?> required>
                    <label class="form-check-label">Não</label>
                </div>
            </div>

            <hr>

            <h4>Responsáveis</h4>
            <div id="responsaveis">
                <?php foreach ($responsaveis as $resp) : ?>
                    <div class="responsavel-item">
                        <input type="hidden" name="responsavel_id[]" value="<?php echo $resp['id']; ?>">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="responsavel_nome[]" value="<?php echo $resp['nome']; ?>" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="responsavel_telefone[]" value="<?php echo $resp['telefone']; ?>" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="responsavel_parentesco[]" value="<?php echo $resp['parentesco']; ?>" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <a href="../actions/excluir_responsavel.php?id=<?php echo $resp['id']; ?>&aluno_id=<?php echo $aluno['id']; ?>" class="btn btn-danger btn-sm">
                                    Remover
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="button" class="btn btn-secondary mt-2" onclick="adicionarResponsavel()">
                Adicionar Responsável
            </button>

            <br><br>
            <button type="submit" class="btn btn-success w-100">Salvar Alterações</button>
        </form>
    </div>
</div>
<script>
    function adicionarResponsavel() {
        let div = document.createElement("div");
        div.classList.add("responsavel-item");

        div.innerHTML = `
            <div class="row g-2 mt-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="responsavel_nome[]" placeholder="Nome do Responsável" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="responsavel_telefone[]" placeholder="Telefone" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="responsavel_parentesco[]" placeholder="Parentesco" required>
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">
                        Remover
                    </button>
                </div>
            </div>
        `;

        document.getElementById("responsaveis").appendChild(div);
    }
</script>


</body>
</html>
