<?php
session_start();
include("../conector.php");

include("../registrarLog.php");
registrarLog($pdo, "Login realizado");

$email = trim($_POST["email"]);
$senha = $_POST["senha"];

// Procura o administrador pelo e-mail
$sql = $pdo->prepare("SELECT * FROM admins WHERE email_admin = ?");
$sql->execute([$email]);

$admin = $sql->fetch(PDO::FETCH_ASSOC);

// Verifica se encontrou o administrador
if (!$admin) {
    echo "
        <script>
            alert('E-mail ou senha incorretos.');
            window.location = '../../frontend/pages/loginAdmin/loginAdmin.html';
        </script>
    ";
    exit();
}

// Verifica se o administrador está ativo
if (!$admin['status_admin']) {
    echo "
        <script>
            alert('Administrador inativo.');
            window.location = '../../frontend/pages/loginAdmin/loginAdmin.html';
        </script>
    ";
    exit();
}

// Verifica a senha
if (!password_verify($senha, $admin['senha_admin'])) {
    echo "
        <script>
            alert('E-mail ou senha incorretos.');
            window.location = '../../frontend/pages/loginAdmin/loginAdmin.html';
        </script>
    ";
    exit();
}

// Cria a sessão
$_SESSION['id'] = $admin['id_admin'];
$_SESSION['nome'] = $admin['nome_admin'];
$_SESSION['tipo'] = 'admin';

// Verifica se é o primeiro login
if ($admin['primeirologin']) {
    header("Location: ../../frontend/pages/trocarSenha/trocarSenha.php");
    exit();
}

// Login normal
header("Location: ../../frontend/pages/usuarios/usuarios.php");
exit();
?>