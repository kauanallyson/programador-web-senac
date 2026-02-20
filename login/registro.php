<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro - Sistema Senac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-sm" style="max-width: 450px; width: 100%;">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Criar Conta</h3>
                <form action="processar_registro.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nome de Usuário</label>
                        <input type="text" name="usuario" class="form-control" required placeholder="ex: joao.silva">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha</label>
                        <input type="password" name="senha" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Usuário</label>
                        <select name="tipo" class="form-select">
                            <option value="comum">Comum</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
                </form>
                <div class="text-center mt-3">
                    <a href="index.php" class="text-decoration-none">Voltar para o Login</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>