<?php
session_start();
include("conector.php");
include("gerarSenha.php");

include("registrarLog.php");
registrarLog($pdo, "Usuário cadastrado");

if (!isset($_SESSION['tipo'])) {
  die("Acesso negado.");
}

$tipoLogado = $_SESSION['tipo'];

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$tipoUsuario = $_POST['tipoUsuario'];

// Apenas administradores podem cadastrar usuários
if ($tipoLogado !== "admin") {
  die("Você não possui permissão.");
}

// Validação do e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die("E-mail inválido.");
}

// Gera senha temporária
$tamanhoSenha = ($tipoUsuario == "admin") ? 12 : 8;

$senhaTemporaria = gerar_senha($tamanhoSenha, true, true, true, true);

$senhaHash = password_hash($senhaTemporaria, PASSWORD_DEFAULT);

switch ($tipoUsuario) {

  case "admin":

    // Verifica se o e-mail já existe
    $sql = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email_admin = ?");
    $sql->execute([$email]);

    if ($sql->fetchColumn() > 0) {
      die("Este e-mail já está cadastrado.");
    }

    $sql = $pdo->prepare("
        INSERT INTO admins
        (nome_admin, email_admin, senha_admin, ativo_admin)
        VALUES (?, ?, ?, 1)
    ");

    $executar = $sql->execute([
      $nome,
      $email,
      $senhaHash
    ]);

    break;

  case "professor":

  case "aluno":

    $sql = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email_usuario = ?");
    $sql->execute([$email]);

    if ($sql->fetchColumn() > 0) {
      die("Este e-mail já está cadastrado.");
    }

    $sql = $pdo->prepare("
        INSERT INTO usuarios
        (nome_usuario, email_usuario, senha_usuario, tipo_usuario, ativo_usuario)
        VALUES (?, ?, ?, ?, 1)
    ");

    $executar = $sql->execute([
      $nome,
      $email,
      $senhaHash,
      $tipoUsuario
    ]);

    break;

  default:
    die("Tipo de usuário inválido.");
}

if ($executar) {
  header(
    "Location: ../frontend/pages/cadastro/cadastro.php?status=sucesso&senha=" .
    urlencode($senhaTemporaria)
  );
} else {
  header("Location: ../frontend/pages/cadastro/cadastro.php?status=erro");
}

exit();
