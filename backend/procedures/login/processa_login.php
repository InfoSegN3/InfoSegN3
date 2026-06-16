<?php

require_once 'config/database.php';
require_once 'config/jwt.php';

use Firebase\JWT\JWT;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Método inválido");
}

$email = trim($_POST['email']);
$senha = $_POST['senha'];

$sql = "
SELECT
    id,
    name,
    email,
    role_id,
    password_hash
FROM users
WHERE email = ?
LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuário não encontrado.");
}

if (!password_verify($senha, $usuario['password_hash'])) {
    die("Senha inválida.");
}

$payload = [
    "iss" => "agenda-academica",
    "iat" => time(),
    "exp" => time() + 3600,

    "user" => [
        "id" => $usuario['id'],
        "nome" => $usuario['name'],
        "email" => $usuario['email'],
        "role_id" => $usuario['role_id']
    ]
];

$token = JWT::encode(
    $payload,
    $jwt_secret,
    'HS256'
);

setcookie(
    "token",
    $token,
    [
        "expires" => time() + 3600,
        "path" => "/",
        "httponly" => true,
        "secure" => false,
        "samesite" => "Strict"
    ]
);

header("Location: dashboard.php");
exit;