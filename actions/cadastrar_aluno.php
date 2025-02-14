<?php
include '../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo->beginTransaction();

        // Inserir Aluno
        $stmt = $pdo->prepare("INSERT INTO alunos (nome_completo, data_nascimento, serie_escolar, escola, valor_mensalidade, alergias, doencas, autorizado_sozinho) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nome_completo'],
            $_POST['data_nascimento'],
            $_POST['serie_escolar'],
            $_POST['escola'],
            $_POST['valor_mensalidade'],
            $_POST['alergias'],
            $_POST['doencas'],
            $_POST['autorizado_sozinho']
        ]);

        $aluno_id = $pdo->lastInsertId();

        // Inserir Responsáveis e criar vínculo
        foreach ($_POST['responsavel_nome'] as $index => $nome) {
            $telefone = $_POST['responsavel_telefone'][$index];
            $parentesco = $_POST['responsavel_parentesco'][$index];

            // Verifica se o responsável já existe
            $stmt = $pdo->prepare("SELECT id FROM responsaveis WHERE nome = ? AND telefone = ?");
            $stmt->execute([$nome, $telefone]);
            $responsavel = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($responsavel) {
                $responsavel_id = $responsavel['id'];
            } else {
                // Insere novo responsável
                $stmt = $pdo->prepare("INSERT INTO responsaveis (nome, telefone, parentesco) VALUES (?, ?, ?)");
                $stmt->execute([$nome, $telefone, $parentesco]);
                $responsavel_id = $pdo->lastInsertId();
            }

            // Criar relação entre aluno e responsável
            $stmt = $pdo->prepare("INSERT INTO aluno_responsavel (aluno_id, responsavel_id) VALUES (?, ?)");
            $stmt->execute([$aluno_id, $responsavel_id]);
        }

        $pdo->commit();
        header("Location: ../views/alunos.php?sucesso=1");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erro ao cadastrar aluno: " . $e->getMessage());
    }
}
?>
