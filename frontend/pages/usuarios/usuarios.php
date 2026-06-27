<?php
session_start();

if (
    !isset($_SESSION['id']) ||
    !in_array($_SESSION['tipo'], ['aluno', 'professor', 'admin'])
) {
    header("Location: ../login/login.html");
    exit();
}

include("../../../backend/conector.php");

$sql = $pdo->prepare("
    SELECT
        id_usuario,
        nome_usuario,
        email_usuario,
        tipo_usuario,
        ativo_usuario
    FROM usuarios
");

$sql->execute();
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Acadêmica</title>

    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="./usuarios.css">
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
            <h1>Usuários</h1>

            <div class="usersContainer">
                <div class="usersHeader">
                    <h2>Usuários cadastrados</h2>
                    <p>Total: <?= count($usuarios) ?></p>
                </div>
                <div class="tableActions">
                    <a href="../cadastro/cadastro.php" class="addButton">
                        <span>+</span>
                        Adicionar Usuário
                    </a>
                </div>

                <table class="usersTable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Tipo</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['nome_usuario']) ?></td>

                                <td><?= htmlspecialchars($usuario['email_usuario']) ?></td>

                                <td>
                                    <span class="badge perfil">
                                        <?= htmlspecialchars($usuario['tipo_usuario']) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge <?= $usuario['ativo_usuario'] == 1 ? 'ativo' : 'inativo' ?>">
                                        <?= $usuario['ativo_usuario'] == 1 ? 'Ativo' : 'Inativo' ?>
                                    </span>
                                </td>

                                <td class="actionsColumn">

                                    <a href="#" class="editButton">
                                        Editar
                                    </a>

                                    <a
                                        href="../../../backend/mudarStatusUsuario.php?id=<?= $usuario['id_usuario'] ?>"
                                        class="deleteButton"
                                        onclick="return confirm('Deseja realmente desativar este usuário?');">
                                        Excluir
                                    </a>

                                </td>

                            </tr>
                        <?php endforeach; ?>
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
                class="cadastroForm">

                <div class="formGroup">

                    <label>Senha atual</label>

                    <input
                        type="password"
                        name="senhaAtual"
                        required>

                </div>

                <div class="formGroup">

                    <label>Nova senha</label>

                    <input
                        type="password"
                        name="novaSenha"
                        minlength="8"
                        required>

                </div>

                <div class="formGroup">

                    <label>Confirmar nova senha</label>

                    <input
                        type="password"
                        name="confirmarSenha"
                        minlength="8"
                        required>

                </div>

                <div class="formActions">

                    <button
                        type="button"
                        class="cancelButton"
                        id="cancelarTrocaSenha">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="submitButton">
                        Alterar senha
                    </button>

                </div>

            </form>

        </div>

    </div>
    <script src="../../scripts/trocarSenha.js"></script>
    <script src="./usuarios.js"></script>

</body>

</html>