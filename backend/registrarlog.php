<?php

function registrarLog(PDO $pdo, string $acao): void {
    $sql = $pdo->prepare("INSERT INTO logs (usuario_id, acao, data_hora) VALUES (?, ?, NOW())");
    $sql->execute([$_SESSION['id'] ?? null, $acao]);
}

?>

include("../registrarLog.php");
registrarLog($pdo, "Login realizado");
registrarLog($pdo, "Usuário cadastrado");
registrarLog($pdo, "Agendamento criado");