<?php
if (isset($_SESSION['erro'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['erro'] . "</div>";
    unset($_SESSION['erro']);
}

if (isset($_SESSION['sucesso'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['sucesso'] . "</div>";
    unset($_SESSION['sucesso']);
}
?>
<h2 class="login">Login</h2>
<form method="post" action="controller/AuthController.php">
  <input type="hidden" name="acao" value="login">
  <div class="mb-3">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Senha:</label>
    <input type="password" name="senha" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary">Entrar</button>
</form>
