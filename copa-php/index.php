<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>COPA PHP - Cadastro</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
  <main class="container">
    <article>
      <header>
        <h2>Cadastro de Piloto</h2>
      </header>

      <?php if (!empty($_SESSION['erros'])): ?>
        <div style="background: #d81b60; color: white; padding: 1rem; margin-bottom: 1rem; border-radius: 5px;">
          <?php foreach ($_SESSION['erros'] as $erro) echo "<li>$erro</li>";
          unset($_SESSION['erros']); ?>
        </div>
      <?php endif; ?>

      <form action="script.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="grid">
          <input type="text" name="nomePiloto" placeholder="Nome Completo" required>
          <input type="text" name="sigla" pattern="[A-Za-z]{3}" maxlength="3" placeholder="Sigla (ex: BOR)" required>
        </div>
        <div class="grid">
          <input type="text" name="nacionalidade" placeholder="Nacionalidade" required>
          <input type="date" name="nascimento" required>
        </div>
        <div class="grid">
          <select name="equipe" required>
            <option value="" disabled selected>Selecione a Equipe</option>
            <option value="1">Ferrari</option>
            <option value="2">McLaren</option>
            <option value="3">Red Bull Racing</option>
            <option value="4">Mercedes</option>
            <option value="5">Aston Martin</option>
            <option value="6">Audi (Sauber)</option>
            <option value="7">Alpine</option>
            <option value="8">Williams</option>
            <option value="9">Haas</option>
            <option value="10">Racing Bulls</option>
            <option value="11">Cadillac (Andretti)</option>
          </select>
          <select name="licenca" required>
            <option value="Titular">Super Licença A (Titular)</option>
            <option value="Reserva">Super Licença B (Reserva)</option>
          </select>
        </div>
        <div class="grid">
          <div>
            <label for="numero">Número do Carro (1-99)</label>
            <input type="number" name="numero" id="numero" min="1" max="99" required placeholder="00">
          </div>
          <div>
            <label for="titulos">
              Títulos Mundiais
              <small>(Histórico na carreira)</small>
            </label>
            <input type="number" name="titulos" id="titulos" min="0" value="0">
          </div>
        </div>
        <textarea name="bio" placeholder="Biografia..."></textarea>
        <button type="submit">Confirmar no Grid</button>
      </form>
    </article>
  </main>
</body>

</html>