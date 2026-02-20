<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Senac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-sm" style="max-width: 400px; width: 100%;">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Acessar Sistema</h3>

                <?php session_start();
                if (isset($_SESSION['erro'])): ?>
                    <div class="alert alert-danger p-2 small">
                        <?= $_SESSION['erro'];
                        unset($_SESSION['erro']); ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Usuário (E-mail)</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                <hr>
                <p class="text-center mb-0">Não tem conta? <a href="registro.php">Registre-se</a></p>
            </div>
        </div>
    </div>
</body>

</html>