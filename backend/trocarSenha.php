<?php
session_start();
include("conector.php");

if (!isset($_SESSION["id"]) || !isset($_SESSION["tipo"])) {
    header("Location: ../frontend/pages/login/login.html");
    exit();
}

$id = $_SESSION["id"];
$tipo = $_SESSION["tipo"];

$senhaAtual = $_POST["senhaAtual"] ?? "";
$novaSenha = $_POST["novaSenha"] ?? "";
$confirmarSenha = $_POST["confirmarSenha"] ?? "";

// Validação
if (
    empty($senhaAtual) ||
    empty($novaSenha) ||
    empty($confirmarSenha)
) {
    die("Preencha todos os campos.");
}

if ($novaSenha !== $confirmarSenha) {
    die("As novas senhas não coincidem.");
}

if (strlen($novaSenha) < 8) {
    die("A nova senha deve possuir pelo menos 8 caracteres.");
}


if ($tipo === "admin") {

    $sql = $pdo->prepare("
        SELECT senha_admin
        FROM admins
        WHERE id_admin = ?
    ");

    $sql->execute([$id]);

    $admin = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        die("Administrador não encontrado.");
    }

    if (!password_verify($senhaAtual, $admin["senha_admin"])) {
        die("Senha atual incorreta.");
    }

    $novaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    $sql = $pdo->prepare("
        UPDATE admins
        SET senha_admin = ?
        WHERE id_admin = ?
    ");

    $sql->execute([
        $novaHash,
        $id
    ]);

}


else {

    $sql = $pdo->prepare("
        SELECT senha_usuario
        FROM usuarios
        WHERE id_usuario = ?
    ");

    $sql->execute([$id]);

    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuário não encontrado.");
    }

    if (!password_verify($senhaAtual, $usuario["senha_usuario"])) {
        die("Senha atual incorreta.");
    }

    $novaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    $sql = $pdo->prepare("
        UPDATE usuarios
        SET senha_usuario = ?
        WHERE id_usuario = ?
    ");

    $sql->execute([
        $novaHash,
        $id
    ]);

}

header("Location: ../frontend/pages/usuarios/usuarios.php?status=senhaAlterada");
exit();