<?php
session_start();

include("conector.php");

if (
    !isset($_SESSION["id"]) ||
    $_SESSION["tipo"] !== "admin"
) {
    die("Acesso negado.");
}

if (!isset($_GET["id"])) {
    die("ID do usuário não informado.");
}

$id = (int) $_GET["id"];

$sql = $pdo->prepare("
    UPDATE usuarios
    SET ativo_usuario = 0
    WHERE id_usuario = ?
");

if ($sql->execute([$id])) {

    header("Location: ../frontend/pages/usuarios/usuarios.php?status=desativado");

} else {

    header("Location: ../frontend/pages/usuarios/usuarios.php?status=erro");

}

exit();