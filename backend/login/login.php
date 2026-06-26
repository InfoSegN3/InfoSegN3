<?php
session_start();
include("../conector.php");

$email = trim($_POST["email"]);
$senha = $_POST["senha"];

// Procura o usuário pelo e-mail
$sql = $pdo->prepare("SELECT * FROM usuarios WHERE email_usuario = ?");
$sql->execute([$email]);

$usuario = $sql->fetch(PDO::FETCH_ASSOC);

// Verifica se encontrou o usuário
if (!$usuario) {
    echo "
        <script>
            alert('E-mail.');
            window.location = '../../frontend/pages/login/login.html';
        </script>
    ";
    exit();
}

// Verifica se o usuário está ativo
if (!$usuario['ativo_usuario']) {
    echo "
        <script>
            alert('Usuário inativo.');
            window.location = '../../frontend/pages/login/login.html';
        </script>
    ";
    exit();
}

// Verifica a senha
if (!password_verify($senha, $usuario['senha_usuario'])) {
    echo "
        <script>
            alert('E-mail ou senha incorretos.');
            window.location = '../../frontend/pages/login/login.html';
        </script>
    ";
    exit();
}

// Cria a sessão
$_SESSION['id_usuario'] = $usuario['id_usuario'];
$_SESSION['nome_usuario'] = $usuario['nome_usuario'];
$_SESSION['tipo'] = 'aluno';

// Verifica se é o primeiro login
if ($usuario['primeiro_acesso']) {
    header("Location: ../../frontend/pages/trocarSenha/trocarSenha.php");
    exit();
}

// Login normal
header("Location: ../../frontend/pages/agendamentos/agendamentos.php");
exit();
?>