<?php
function registrarLog(PDO $pdo, string $acao): void {
    $usuario_id = $_SESSION['id'] ?? null;
    $data_hora  = date('Y-m-d H:i:s');
 
    $sql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, data_hora) VALUES (?, ?, ?)");
    $sql->execute([$usuario_id, $acao, $data_hora]);
}

?>