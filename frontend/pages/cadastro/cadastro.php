<?php
    session_start();

    if (
        !isset($_SESSION['id']) ||
        !in_array($_SESSION['tipo'], ['admin'])
    ) {
        header("Location: ../loginAdmin/loginAdmin.html");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Acadêmica</title>

    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="./cadastro.css">
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
        </div>

        <div class="content">
            <h1>Cadastro de Usuários</h1>

            <div class="cadastroContainer">
                <div class="cadastroHeader">
                    <h2>Novo usuário</h2>
                    <p> Preencha os dados abaixo para cadastrar um novo usuário no sistema. </p>
                </div>

                <form
                    action="../../../backend/cadastro.php"
                    method="POST"
                    class="cadastroForm"
                >
                    <div class="formGroup">
                        <label for="nome"> Nome completo *</label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            placeholder="Digite o nome completo"
                            required
                        >
                    </div>

                    <div class="formGroup">
                        <label for="email">
                            E-mail *
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Digite o e-mail"
                            required
                        >
                    </div>

                    <div class="formGroup">
                        <label for="tipoUsuario">
                            Perfil *
                        </label>

                        <select
                            id="tipoUsuario"
                            name="tipoUsuario"
                            required
                        >
                            <option value="">
                                Selecione...
                            </option>

                            <option value="aluno">
                                Aluno
                            </option>

                            <option value="professor">
                                Professor
                            </option>

                            <?php if ($_SESSION['tipo'] === 'admin'): ?>
                                <option value="admin">
                                    Administrador
                                </option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="formActions">
                        <button type="reset" class="cancelButton">
                            Limpar
                        </button>

                        <button type="submit" class="submitButton">
                            Cadastrar usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="resultModal" class="modal">
        <div class="modalContent">
            <h2 id="modalTitulo"></h2>

            <p id="modalMensagem"></p>

            <div id="senhaContainer" class="senhaContainer">
                <span> Senha temporária gerada </span>

                <strong id="senhaGerada"></strong>

                <button type="button" id="copyPassword" class="copyButton">
                    Copiar senha
                </button>
            </div>

            <button type="button" id="closeModal" class="submitButton">
                Fechar
            </button>
        </div>
    </div>

    <script src="./cadastro.js"></script>
</body>
</html>