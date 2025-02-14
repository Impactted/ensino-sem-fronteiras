<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno - Ensino Sem Fronteiras</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Seu CSS personalizado -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h2 class="text-center">Cadastro de Aluno</h2>
        <form action="../actions/cadastrar_aluno.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nome Completo:</label>
                <input type="text" class="form-control" name="nome_completo" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" name="data_nascimento" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Série Escolar:</label>
                <select class="form-select" name="serie_escolar" required>
                    <option value="">Selecione a Série</option>
                    <optgroup label="Educação Infantil">
                        <option value="Creche">Creche</option>
                        <option value="Pré-Escola">Pré-Escola</option>
                    </optgroup>
                    <optgroup label="Ensino Fundamental - Anos Iniciais">
                        <option value="1º Ano">1º Ano</option>
                        <option value="2º Ano">2º Ano</option>
                        <option value="3º Ano">3º Ano</option>
                        <option value="4º Ano">4º Ano</option>
                        <option value="5º Ano">5º Ano</option>
                    </optgroup>
                    <optgroup label="Ensino Fundamental - Anos Finais">
                        <option value="6º Ano">6º Ano</option>
                        <option value="7º Ano">7º Ano</option>
                        <option value="8º Ano">8º Ano</option>
                        <option value="9º Ano">9º Ano</option>
                    </optgroup>
                    <optgroup label="Ensino Médio">
                        <option value="1º Ano Ensino Médio">1º Ano Ensino Médio</option>
                        <option value="2º Ano Ensino Médio">2º Ano Ensino Médio</option>
                        <option value="3º Ano Ensino Médio">3º Ano Ensino Médio</option>
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Escola:</label>
                <input type="text" class="form-control" name="escola" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Valor da Mensalidade:</label>
                <input type="number" class="form-control" name="valor_mensalidade" step="0.01" required>
            </div>

            <hr>

            <h4>Saúde</h4>
            <div class="mb-3">
                <label class="form-label">Alergias:</label>
                <input type="text" class="form-control" name="alergias" placeholder="Informe possíveis alergias">
            </div>

            <div class="mb-3">
                <label class="form-label">Doenças:</label>
                <input type="text" class="form-control" name="doencas" placeholder="Informe doenças pré-existentes">
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Autorizado a ir embora sozinho?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="autorizado_sozinho" value="Sim" required>
                    <label class="form-check-label">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="autorizado_sozinho" value="Não" required>
                    <label class="form-check-label">Não</label>
                </div>
            </div>

            <hr>

            <h4>Responsáveis</h4>
            <div id="responsaveis">
                <div class="responsavel-item">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="responsavel_nome[]" placeholder="Nome do Responsável" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="responsavel_telefone[]" placeholder="Telefone" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="responsavel_parentesco[]" placeholder="Parentesco (Pai, Mãe, etc.)" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mt-2" onclick="adicionarResponsavel()">
                <i class="fa-solid fa-plus"></i> Adicionar Responsável
            </button>

            <br><br>

            <button type="submit" class="btn btn-primary w-100">Cadastrar Aluno</button>
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
                <div class="col-md-4">
                    <input type="text" class="form-control" name="responsavel_telefone[]" placeholder="Telefone" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="responsavel_parentesco[]" placeholder="Parentesco (Pai, Mãe, etc.)" required>
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        document.getElementById("responsaveis").appendChild(div);
    }
</script>

</body>
</html>
