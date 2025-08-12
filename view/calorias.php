<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../model/Calculo.php';
require_once __DIR__ . '/../bd/conexao.php';

if (!isset($_SESSION['usuario'])) {
    echo "<div class='alert alert-danger'>Você precisa estar logado para acessar esta funcionalidade.</div>";
    exit;
}

// Cria pasta uploads se não existir
$uploadDir = __DIR__ . '/../uploads/';
if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>GrowSync - Calorias Manuais</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <main class="container my-5 p-4 bg-white rounded shadow">
    <h2 class="mb-4">Adicionar Alimento Manualmente</h2>

    <form method="post" enctype="multipart/form-data" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Alimento</label>
        <input type="text" name="alimento" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Quantidade (g ou ml)</label>
        <input type="number" step="0.01" name="quantidade" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Calorias</label>
        <input type="number" step="0.01" name="calorias" class="form-control">
      </div>
      <div class="col-md-3">
        <label class="form-label">Carboidratos</label>
        <input type="number" step="0.01" name="carboidratos" class="form-control">
      </div>
      <div class="col-md-3">
        <label class="form-label">Proteínas</label>
        <input type="number" step="0.01" name="proteinas" class="form-control">
      </div>
      <div class="col-md-3">
        <label class="form-label">Lipídios</label>
        <input type="number" step="0.01" name="lipidios" class="form-control">
      </div>
      <div class="col-md-12">
        <label class="form-label">Observação</label>
        <input type="text" name="observacao" class="form-control">
      </div>
      <div class="col-md-12">
        <label class="form-label">Imagem do alimento (opcional)</label>
        <input type="file" name="imagem" class="form-control" accept="image/*">
      </div>
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuarioId = $_SESSION['usuario']['id'];

        // Upload da imagem
        $imagemPath = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid('img_') . "." . $extensao;
            $destino = $uploadDir . $nomeArquivo;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $imagemPath = 'uploads/' . $nomeArquivo;
            }
        }

        $entrada = [
            'alimento' => trim($_POST['alimento']),
            'quantidade' => floatval($_POST['quantidade']),
            'calorias' => floatval($_POST['calorias']),
            'carboidratos' => floatval($_POST['carboidratos']),
            'proteinas' => floatval($_POST['proteinas']),
            'lipidios' => floatval($_POST['lipidios']),
            'observacao' => trim($_POST['observacao']),
            'imagem' => $imagemPath
        ];

        $resultado = [
            'calorias' => $entrada['calorias'],
            'carboidratos' => $entrada['carboidratos'],
            'proteinas' => $entrada['proteinas'],
            'lipidios' => $entrada['lipidios']
        ];

        Calculo::salvarHistorico($usuarioId, 'CALORIAS', $entrada, $resultado);

        echo "<div class='alert alert-success mt-3'>Alimento salvo com sucesso!</div>";
    }
    ?>
  </main>
</body>
</html>
