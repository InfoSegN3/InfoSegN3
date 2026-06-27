<?php
session_start();

if (
    !isset($_SESSION['id']) ||
    !in_array($_SESSION['tipo'], ['aluno', 'professor', 'admin'])
) {
    header("Location: ../login/login.html");
    exit();
}

include('../../../backend/conector.php');

$consulta = $pdo->prepare("
    SELECT
        a.id,
        a.data_agendamento,
        a.horario,
        a.motivo,
        a.status,
        professor.nome_usuario AS professor,
        aluno.nome_usuario AS aluno
    FROM agendamentos a

    INNER JOIN usuarios professor
        ON professor.id_usuario = a.professor_id

    INNER JOIN usuarios aluno
        ON aluno.id_usuario = a.aluno_id

    WHERE " .
    ($_SESSION['tipo'] == 'aluno'
        ? "a.aluno_id = :id"
        : "a.professor_id = :id") . "

    ORDER BY a.data_agendamento DESC, a.horario DESC
");

$consulta->bindValue(":id", $_SESSION['id'], PDO::PARAM_INT);
$consulta->execute();

$agendamentos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Acadêmica</title>

    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="./agendamentos.css">
</head>

<body>
    <div class="agendamentosApp">
        <div class="sidebar">
            <div class="mark">
                <div class="academicCap">
                    <img src="../../icons/academicCap.svg" alt="">
                </div>
                <div class="markTexts">
                    <h2>Agenda Acadêmica</h2>
                    <p>Atendimentos</p>
                </div>
            </div>

            <div class="line"></div>

            <div class="navigation">
                <p>Navegação</p>

                <?php if ($_SESSION['tipo'] === 'aluno' || $_SESSION['tipo'] === 'professor') : ?>
                    <div class="agendamentos">
                        <img src="../../icons/dashboard.svg" alt="">
                        <a href="../agendamentos/agendamentos.php">Meus Agendamentos</a>
                    </div>
                <?php endif; ?>

                <?php if ($_SESSION['tipo'] === 'aluno') : ?>
                    <div class="novoAgendamento">
                        <img src="../../icons/new.svg" alt="">
                        <a href="../novoAgendamento/novoAgendamento.php">Novo Agendamento</a>
                    </div>
                <?php endif; ?>

                <?php if ($_SESSION['tipo'] === 'admin') : ?>
                    <div class="usuarios">
                        <img src="../../icons/users.svg" alt="">
                        <a href="../usuarios/usuarios.php">Usuários</a>
                    </div>
                <?php endif; ?>

                <?php if ($_SESSION['tipo'] === 'admin') : ?>
                    <div class="logs">
                        <img src="../../icons/shield.svg" alt="">
                        <a href="../auditoria/auditoria.php">Logs de Auditoria</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="trocarSenha">
                <img src="../../icons/key.svg" alt="">
                <a href="#" id="abrirTrocaSenha">
                    Trocar senha
                </a>
            </div>
            <div class="line"></div>
            <div class="logout">
                <img src="../../icons/shield.svg" alt="">
                <a href="../../../backend/login/logout.php">Sair</a>
            </div>
        </div>

        <div class="content">
            <h1>Meus Agendamentos</h1>

            <div class="appointmentsContainer">
                <div class="appointmentsHeader">
                    <h2>Histórico</h2>

                    <p>Todos os seus agendamentos recentes.</p>
                </div>

                <table class="appointmentsTable">
                    <thead>
                        <tr>
                            <th>Professor / Aluno</th>
                            <th>Data e hora</th>
                            <th>Motivo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (count($agendamentos) > 0): ?>

                            <?php foreach ($agendamentos as $agendamento): ?>

                                <tr>

                                    <td>
                                        <div class="professor">
                                        <strong>
                                            <?php
                                                if ($_SESSION['tipo'] == 'aluno') {
                                                    echo htmlspecialchars($agendamento['professor']);
                                                } else {
                                                    echo htmlspecialchars($agendamento['aluno']);
                                                }
                                            ?>
                                        </strong>                                        </div>
                                    </td>

                                    <td>
                                        <?= date("d/m/Y", strtotime($agendamento['data_agendamento'])) ?>
                                        às
                                        <?= substr($agendamento['horario'], 0, 5) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($agendamento['motivo']) ?>
                                    </td>

                                    <td>

                                        <span><?= $agendamento['status'] ?></span>                                     |
                                        <a
                                            class="deleteButton"
                                            href="../../../backend/excluirAgendamento.php?id=<?= $agendamento['id'] ?>"
                                            onclick="return confirm('Deseja realmente excluir este agendamento?')">

                                            Excluir

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="4" style="text-align:center;">
                                    Nenhum agendamento encontrado.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <div id="trocaSenhaModal" class="modal">

        <div class="modalContent">

            <h2>Trocar senha</h2>

            <p>Informe sua senha atual e defina uma nova senha.</p>

            <form
                action="../../../backend/trocarSenha.php"
                method="POST"
                class="cadastroForm"
            >

                <div class="formGroup">

                    <label>Senha atual</label>

                    <input
                        type="password"
                        name="senhaAtual"
                        required
                    >

                </div>

                <div class="formGroup">

                    <label>Nova senha</label>

                    <input
                        type="password"
                        name="novaSenha"
                        minlength="8"
                        required
                    >

                </div>

                <div class="formGroup">

                    <label>Confirmar nova senha</label>

                    <input
                        type="password"
                        name="confirmarSenha"
                        minlength="8"
                        required
                    >

                </div>

                <div class="formActions">

                    <button
                        type="button"
                        class="cancelButton"
                        id="cancelarTrocaSenha"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="submitButton"
                    >
                        Alterar senha
                    </button>

                </div>

            </form>

        </div>

    </div>
    <script src="../../scripts/trocarSenha.js"></script>
</body>

</html>