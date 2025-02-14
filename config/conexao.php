<?php
$host = "localhost";
$dbname = "reforco_escolar"; // Nome do banco de dados
$usuario = "esf141531"; // Usuário padrão do XAMPP
$senha = "Huv3OUsqI2U(hpZK"; // Senha padrão é vazia no XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
