<?php
session_start();
include("../conector.php");

$email = $_POST["email"];
$senha = md5($_POST["senha"]);

$validar = $pdo->prepare("SELECT * FROM admins WHERE email_admin = :email AND senha_admin = :senha");
$validar->bindParam(':email', $email);
$validar->bindParam(':senha', $senha);
$validar->execute();

if ($validar->rowCount() == 0) {
    echo "
        <script type='text/javascript'>
            alert('Email ou senha incorretos');
            window.location = '../../frontend/pages/login/login.html';
        </script>
    ";
} else {
    $admin = $validar->fetch(PDO::FETCH_ASSOC);

    $_SESSION['id']    = $admin['id_admin'];
    $_SESSION['nome']  = $admin['nome_admin'];
    $_SESSION['tipo']  = 'admin';

    header('Location: ../../frontend/pages/cadastro/cadastro.html');
    exit();
}
?>