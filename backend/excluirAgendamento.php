<?php
session_start();


if (!isset($_SESSION['id'])) {
    header("Location: ../../frontend/pages/login/login.html");
    exit();
}

require_once("conector.php");

$idAgendamento = $_GET['id'] ?? null;

if (!$idAgendamento || !is_numeric($idAgendamento)) {
    die("Agendamento inválido.");
}

try {

    if ($_SESSION['tipo'] == 'aluno') {

        $sql = $pdo->prepare("
            DELETE FROM agendamentos
            WHERE id = :id
            AND aluno_id = :usuario
        ");

        $sql->bindValue(":usuario", $_SESSION['id'], PDO::PARAM_INT);

    } elseif ($_SESSION['tipo'] == 'professor') {

        $sql = $pdo->prepare("
            DELETE FROM agendamentos
            WHERE id = :id
            AND professor_id = :usuario
        ");

        $sql->bindValue(":usuario", $_SESSION['id'], PDO::PARAM_INT);

    } else { // admin

        $sql = $pdo->prepare("
            DELETE FROM agendamentos
            WHERE id = :id
        ");

    }

    $sql->bindValue(":id", $idAgendamento, PDO::PARAM_INT);

    $sql->execute();

    header("Location: ../frontend/pages/agendamentos/agendamentos.php?excluido=1");
    exit();

} catch (PDOException $e) {

    die("Erro ao excluir o agendamento: " . $e->getMessage());

}