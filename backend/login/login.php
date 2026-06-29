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
            alert('E-mail ou senha inválidos.');
            window.location = '../../frontend/pages/login/login.html';
        </script>
    ";
    exit();
}

// Verifica se o usuário está ativo
if (!$usuario['ativo_usuario']) {
    echo "
        <script>
            alert('Usuário bloqueado/inativo.');
            window.location = '../../frontend/pages/login/login.html';
        </script>
    ";
    exit();
}

// Verifica a senha
if (!password_verify($senha, $usuario['senha_usuario'])) {
    echo "
        <script>
            alert('E-mail ou senha inválidos.');
            window.location = '../../frontend/pages/login/login.html';
        </script>
    ";
    exit();
}

// Cria a sessão (mesmo padrão do loginAdmin)
$_SESSION['id'] = $usuario['id_usuario'];
$_SESSION['nome'] = $usuario['nome_usuario'];
$_SESSION['tipo'] = $usuario['tipo_usuario']; // 'aluno' ou 'professor', vindo do banco

// Verifica se é o primeiro login
if ($usuario['primeiro_acesso']) {
    header("Location: ../../frontend/pages/agendamentos/agendamentos.php");
    exit();
}

// Login normal
header("Location: ../../frontend/pages/agendamentos/agendamentos.php");
exit();
?>