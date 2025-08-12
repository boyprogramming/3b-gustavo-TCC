<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../model/Calculo.php';

if (!isset($_SESSION['usuario'])) {
    echo "<div class='alert alert-danger'>Você precisa estar logado para ver o histórico.</div>";
    exit;
}

if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    if (Calculo::excluir($id, $_SESSION['usuario']['id'])) {
        $_SESSION['mensagem_sucesso'] = "Registro excluído com sucesso.";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao excluir o registro.";
    }
    header("Location: index.php?pagina=historico");
    exit;
}

$historico = Calculo::listarPorUsuario($_SESSION['usuario']['id']);

// Agrupar por data
$agrupadoPorData = [];
foreach ($historico as $registro) {
    $data = date('Y-m-d', strtotime($registro['data_calculo']));
    $agrupadoPorData[$data][] = $registro;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Histórico de Cálculos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h2 class="mb-4">Histórico de Cálculos</h2>

    <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
      <div class="alert alert-success"><?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensagem_erro'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?></div>
    <?php endif; ?>

    <?php if (empty($historico)): ?>
      <div class="alert alert-info">Nenhum registro encontrado.</div>
    <?php else: ?>
      <?php foreach ($agrupadoPorData as $data => $registros): 
        $totalCaloriasDia = 0;
      ?>
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">
            <?= date('d/m/Y', strtotime($data)) ?>
          </div>
          <ul class="list-group list-group-flush">
            <?php foreach ($registros as $registro):
              $entrada = json_decode($registro['dados_entrada'], true);
              $resultado = json_decode($registro['resultado'], true);
              $hora = date('H:i', strtotime($registro['data_calculo']));
              $totalCaloriasDia += $resultado['calorias'] ?? 0;
            ?>
              <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                  <div>
                    <strong><?= htmlspecialchars($registro['tipo_calculo']) ?></strong> — 
                    <?php if ($registro['tipo_calculo'] === 'CALORIAS'): ?>
                      Alimento: <?= htmlspecialchars($entrada['alimento']) ?>,
                      Quantidade: <?= htmlspecialchars($entrada['quantidade']) ?>g,
                      Calorias: <?= $resultado['calorias'] ?> kcal
                      <br>
                      <?php if (!empty($entrada['imagem'])): ?>
                        <img src="<?= htmlspecialchars($entrada['imagem']) ?>" alt="Alimento" style="max-width:120px; max-height:120px;" class="img-thumbnail mt-2">
                      <?php endif; ?>
                      <br><small class="text-muted">Registrado às <?= $hora ?></small>
                    <?php endif; ?>
                  </div>
                  <a href="index.php?pagina=historico&excluir=<?= $registro['id'] ?>" class="btn btn-sm btn-outline-danger mt-2"
                     onclick="return confirm('Deseja realmente excluir este registro?');">Excluir</a>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="card-footer text-end fw-bold">
            Total de calorias no dia: <?= number_format($totalCaloriasDia, 2) ?> kcal
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
