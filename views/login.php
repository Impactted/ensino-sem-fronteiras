<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ensino Sem Fronteiras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> <!-- Importando o CSS personalizado -->
</head>
<body class="login-body">

<?php
session_start();
if (isset($_SESSION['erro_login'])) {
    echo '<div class="alert alert-danger text-center">' . $_SESSION['erro_login'] . '</div>';
    unset($_SESSION['erro_login']); // Remove a mensagem após exibir
}
?>

    <div class="login-container">
        <h2 class="text-center login-title">Ensino Sem Fronteiras</h2>
        <p class="text-center login-subtitle">Acesse seu painel administrativo</p>
        
        <form action="../actions/login_action.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" name="senha" required>
            </div>
            <button type="submit" class="btn btn-light w-100 login-btn">Entrar</button>
        </form>
    </div>

</body>
</html>
