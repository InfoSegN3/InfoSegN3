<?php
session_start();
include("conector.php");

if (
    !isset($_SESSION["id"]) ||
    $_SESSION["tipo"] !== "admin"
) {
    die("Acesso negado.");
}

$id = (int)$_POST["id"];

$novaSenha = $_POST["novaSenha"];
$confirmarSenha = $_POST["confirmarSenha"];

if ($novaSenha !== $confirmarSenha) {
    die("As senhas não coincidem.");
}

$hash = password_hash($novaSenha, PASSWORD_DEFAULT);

$sql = $pdo->prepare("
    UPDATE usuarios
    SET senha_usuario = ?
    WHERE id_usuario = ?
");

$sql->execute([
    $hash,
    $id
]);

header("Location: ../frontend/pages/usuarios/usuarios.php?status=senhaAlterada");
exit();