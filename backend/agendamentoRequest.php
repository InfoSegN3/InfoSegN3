<?php
session_start();
include("conector.php");

include("registrarLog.php");
registrarLog($pdo, "Agendamento criado");

if (
    !isset($_SESSION['id']) ||
    $_SESSION['tipo'] !== 'aluno'
) {
    header("Location: ../../frontend/pages/login/login.html");
    exit();
}


$alunoId = $_SESSION['id'];

$professorId = $_POST['professor'] ?? '';
$data = $_POST['data'] ?? '';
$horario = $_POST['horario'] ?? '';
$motivo = trim($_POST['motivo'] ?? '');

// Validação básica
if (
    empty($professorId) ||
    empty($data) ||
    empty($horario) ||
    empty($motivo)
) {
    die("Todos os campos são obrigatórios.");
}

try {

    $sql = $pdo->prepare("
        INSERT INTO agendamentos (
            aluno_id,
            professor_id,
            data_agendamento,
            horario,
            motivo,
            status
        )
        VALUES (
            :aluno,
            :professor,
            :data,
            :horario,
            :motivo,
            'Pendente'
        )
    ");

    $sql->bindValue(':aluno', $alunoId, PDO::PARAM_INT);
    $sql->bindValue(':professor', $professorId, PDO::PARAM_INT);
    $sql->bindValue(':data', $data);
    $sql->bindValue(':horario', $horario);
    $sql->bindValue(':motivo', $motivo);

    $sql->execute();

    header("Location: ../frontend/pages/agendamentos/agendamentos.php?sucesso=1");
    exit();

} catch (PDOException $e) {

    die("Erro ao salvar agendamento: " . $e->getMessage());

}