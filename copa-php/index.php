<?php
session_start();
// Gera um token CSRF se não existir
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>F1 - Cadastro</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
  <main class="container">
    <article>
      <header>
        <h2>Cadastro de Piloto F1 2026</h2>
      </header>

      <?php if (!empty($_SESSION['erros'])): ?>
        <div style="background-color: #d81b60; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
          <ul>
            <?php foreach ($_SESSION['erros'] as $erro): ?>
              <li><?= htmlspecialchars($erro) ?></li>
            <?php endforeach;
            unset($_SESSION['erros']); ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="script.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div class="grid">
          <div>
            <label for="nomePiloto">Nome Completo</label>
            <input type="text" name="nomePiloto" id="nomePiloto" required>
          </div>
          <div>
            <label for="sigla">Sigla (3 letras)</label>
            <input type="text" name="sigla" id="sigla" pattern="[A-Za-z]{3}" maxlength="3" required style="text-transform: uppercase;">
          </div>
        </div>

        <button type="submit" class="contrast">Finalizar Cadastro</button>
      </form>
    </article>
  </main>
</body>

</html>