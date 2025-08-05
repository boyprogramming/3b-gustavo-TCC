<?php
if (isset($_SESSION['erro'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['erro'] . "</div>";
    unset($_SESSION['erro']);
}
?>

<h2>Cadastro</h2>
<form method="post" action="controller/AuthController.php">
  <input type="hidden" name="acao" value="cadastro">
  <div class="mb-3">
    <label>Nome:</label>
    <input type="text" name="nome" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Senha:</label>
    <input type="password" name="senha" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-success">Cadastrar</button>
</form>
