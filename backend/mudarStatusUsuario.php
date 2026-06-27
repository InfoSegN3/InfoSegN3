<?php
session_start();
include("conector.php");

if (
    !isset($_SESSION["id"]) ||
    $_SESSION["tipo"] !== "admin"
) {
    die("Acesso negado.");
}

if (!isset($_GET["id"]) || !isset($_GET["status"])) {
    die("Parâmetros inválidos.");
}

$id = (int) $_GET["id"];

$status = ($_GET["status"] == 1) ? 1 : 0;

$sql = $pdo->prepare("
    UPDATE usuarios
    SET ativo_usuario = ?
    WHERE id_usuario = ?
");

$sql->execute([
    $status,
    $id
]);

header("Location: ../frontend/pages/usuarios/usuarios.php");
exit();