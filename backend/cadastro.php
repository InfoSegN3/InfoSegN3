<?php
include("conector.php");

$nome = $_POST["nome"];
$email = $_POST["email"];
$tipoUsuario = $_POST["tipoUsuario"];


switch ($tipoUsuario) {
  case 'admin':
    $senhaTemporaria = gerar_senha(12, true, true, true, true);
    $senhaEncript = md5($senhaTemporaria);

    $sql = $pdo->prepare("INSERT into admins (nome_admin, email_admin, senha_admin) values (?, ?, ?);");

    $sql->bindParam(1, $nome);
    $sql->bindParam(2, $email);
    $sql->bindParam(3, $senhaEncript);

    $executar = $sql->execute();
    break;

  case 'operador':
    $senhaTemporaria = gerar_senha(8, true, true, true, true);
    $senhaEncript = md5($senhaTemporaria);

    $sql = $pdo->prepare("INSERT into operador (nome_operador, email_operador, senha_operador) values (?, ?, ?);");

    $sql->bindParam(1, $nome);
    $sql->bindParam(2, $email);
    $sql->bindParam(3, $senhaEncript);

    $executar = $sql->execute();
    break;
  case 'aluno':
    $senhaTemporaria = gerar_senha(8, true, true, true, true);
    $senhaEncript = md5($senhaTemporaria);

    $sql = $pdo->prepare("INSERT into usuarios (nome, email, senha) values (?, ?, ?);");

    $sql->bindParam(1, $nome);
    $sql->bindParam(2, $email);
    $sql->bindParam(3, $senhaEncript);

    $executar = $sql->execute();
    break;
}


