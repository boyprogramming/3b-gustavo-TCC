<?php
// view/imc.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $altura = floatval($_POST['altura']); // em cm
    $peso = floatval($_POST['peso']);

    $altura_m = $altura / 100;
    $imc = $peso / ($altura_m * $altura_m);
    $imc = round($imc, 2);

    if ($imc < 18.5) {
        $classificacao = "Abaixo do peso ideal";
    } elseif ($imc >= 18.5 && $imc <= 24.9) {
        $classificacao = "Peso ideal (adequado)";
    } elseif ($imc >= 25 && $imc <= 29.9) {
        $classificacao = "Sobrepeso";
    } elseif ($imc >= 30 && $imc <= 34.9) {
        $classificacao = "Obesidade grau I";
    } elseif ($imc >= 35 && $imc <= 39.9) {
        $classificacao = "Obesidade grau II";
    } else {
        $classificacao = "Obesidade grau III";
    }

    $peso_min_ideal = 18.5 * ($altura_m * $altura_m);
    $peso_max_ideal = 24.9 * ($altura_m * $altura_m);
    $peso_min_ideal = round($peso_min_ideal, 1);
    $peso_max_ideal = round($peso_max_ideal, 1);
}
?>

<div class="container">
  <h2 class="mb-4">Calculadora de IMC</h2>
  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label for="altura" class="form-label">Altura (cm)</label>
      <input type="number" step="0.1" name="altura" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label for="peso" class="form-label">Peso (kg)</label>
      <input type="number" step="0.1" name="peso" class="form-control" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Calcular</button>
    </div>
  </form>

  <?php if (isset($imc)): ?>
    <div class="alert alert-info mt-4">
      <p><strong>IMC:</strong> <?= $imc ?></p>
      <p><strong>Classificação:</strong> <?= $classificacao ?></p>
      <p><strong>Peso ideal para sua altura:</strong> entre <?= $peso_min_ideal ?> kg e <?= $peso_max_ideal ?> kg</p>
    </div>
  <?php endif; ?>
</div>
