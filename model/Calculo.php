<?php
require_once __DIR__ . '/../bd/conexao.php';

class Calculo {

    // Salva um novo registro no histórico
    public static function salvarHistorico($usuarioId, $tipo, $entrada, $resultado) {
        global $pdo;

        if (!$pdo) {
            require __DIR__ . '/../bd/conexao.php';
        }

        $sql = "INSERT INTO historico_calculos (usuario_id, tipo_calculo, dados_entrada, resultado) 
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $usuarioId,
            $tipo,
            json_encode($entrada, JSON_UNESCAPED_UNICODE),
            json_encode($resultado, JSON_UNESCAPED_UNICODE)
        ]);
    }

    // Lista todos os registros de um usuário
    public static function listarPorUsuario($usuarioId) {
        global $pdo;

        if (!$pdo) {
            require __DIR__ . '/../bd/conexao.php';
        }

        $sql = "SELECT * FROM historico_calculos 
                WHERE usuario_id = ? 
                ORDER BY data_calculo DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Exclui um registro, se pertencer ao usuário
    public static function excluir($id, $usuarioId) {
        global $pdo;

        if (!$pdo) {
            require __DIR__ . '/../bd/conexao.php';
        }

        $sql = "DELETE FROM historico_calculos 
                WHERE id = ? AND usuario_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id, $usuarioId]);
    }
}
