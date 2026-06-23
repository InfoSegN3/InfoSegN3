<?php
session_start();
include("conector.php");
include("gerarSenha.php");

$tipoLogado = $_SESSION['tipo'];
$idLogado = $_SESSION['id'];
$nomeLogado = $_SESSION['nome'];

$nome = $_POST["nome"];
$email = $_POST["email"];
$tipoUsuario = $_POST["tipoUsuario"];

$executar = false;

if ($tipoUsuario === 'admin' && $tipoLogado !== 'admin') {
    die("Você não tem permissão para criar administradores.");
}

switch ($tipoUsuario) {
  case 'admin':

    $senhaTemporaria = gerar_senha(12, true, true, true, true);
    $senhaEncript = md5($senhaTemporaria);
    $sql = $pdo->prepare("INSERT INTO admins (nome_admin, email_admin, senha_admin) VALUES (?, ?, ?)");
    $sql->bindParam(1, $nome);
    $sql->bindParam(2, $email);
    $sql->bindParam(3, $senhaEncript);
    $executar = $sql->execute();
    break;

  case 'operador':
    $senhaTemporaria = gerar_senha(8, true, true, true, true);
    $senhaEncript = md5($senhaTemporaria);
    $sql = $pdo->prepare("INSERT INTO operador (nome_operador, email_operador, senha_operador) VALUES (?, ?, ?)");
    $sql->bindParam(1, $nome);
    $sql->bindParam(2, $email);
    $sql->bindParam(3, $senhaEncript);
    $executar = $sql->execute();
    break;

  case 'aluno':
    $senhaTemporaria = gerar_senha(8, true, true, true, true);
    $senhaEncript = md5($senhaTemporaria);
    $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $sql->bindParam(1, $nome);
    $sql->bindParam(2, $email);
    $sql->bindParam(3, $senhaEncript);
    $executar = $sql->execute();
    break;

  default:
    die("Tipo de usuário inválido.");
}

if ($executar) {
    header('Location: ../frontend/pages/cadastro/cadastro.php?status=sucesso&senha=' . urlencode($senhaTemporaria));
} else {
    header('Location: ../frontend/pages/cadastro/cadastro.html?status=erro');
}
exit();
?>