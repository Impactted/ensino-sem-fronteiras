<?php
include '../config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome_completo = $_POST['nome_completo'];
    $data_nascimento = $_POST['data_nascimento'];
    $serie_escolar = $_POST['serie_escolar'];
    $escola = $_POST['escola'];
    $valor_mensalidade = $_POST['valor_mensalidade'];
    $alergias = $_POST['alergias'];
    $doencas = $_POST['doencas'];
    $autorizado_sozinho = isset($_POST['autorizado_sozinho']) ? $_POST['autorizado_sozinho'] : 'Não'; // Define "Não" caso esteja vazio

    $stmt = $pdo->prepare("UPDATE alunos SET nome_completo = ?, data_nascimento = ?, serie_escolar = ?, escola = ?, valor_mensalidade = ?, alergias = ?, doencas = ?, autorizado_sozinho = ? WHERE id = ?");
    $stmt->execute([$nome_completo, $data_nascimento, $serie_escolar, $escola, $valor_mensalidade, $alergias, $doencas, $autorizado_sozinho, $id]);

    header("Location: ../views/alunos.php?sucesso=1");
    exit();
}
?>
