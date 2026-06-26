<?php
  session_start();

  if (
    !isset($_SESSION['id']) ||
    !in_array($_SESSION['tipo'], ['aluno','professor','admin'])
  ) {
    header("Location: ../login/login.html");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Acadêmica</title>
    
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="./novoAgendamento.css">
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
            <h1>Novo Agendamento</h1>

            <div class="agendamentoContainer">
                <div class="agendamentoHeader">
                    <h2>Detalhes do atendimento</h2>
                    <p>
                        Preencha as informações abaixo para enviar sua solicitação.
                    </p>
                </div>

                <form class="agendamentoForm">

                    <div class="formGroup">
                        <label for="professor">
                            Setor / Professor *
                        </label>

                        <select id="professor" name="professor">
                            <option value="">Selecione...</option>

                            <option value="joao">
                                Prof. João Almeida - Sistemas de Informação
                            </option>

                            <option value="ana">
                                Prof.ª Ana Ribeiro - Engenharia de Software
                            </option>

                            <option value="carlos">
                                Prof. Carlos Souza - Banco de Dados
                            </option>

                            <option value="fernanda">
                                Prof.ª Fernanda Lima - Redes
                            </option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="formGroup">
                            <label for="data">Data *</label>

                            <input
                                type="date"
                                id="data"
                                name="data"
                            >
                        </div>

                        <div class="formGroup">
                            <label for="horario">Horário *</label>

                            <input
                                type="time"
                                id="horario"
                                name="horario"
                            >
                        </div>
                    </div>

                    <div class="formGroup">
                        <label for="motivo">
                            Motivo do atendimento *
                        </label>

                        <textarea
                            id="motivo"
                            name="motivo"
                            rows="6"
                            placeholder="Descreva brevemente o assunto do atendimento..."
                        ></textarea>
                    </div>

                    <div class="formActions">
                        <button
                            type="button"
                            class="cancelButton"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="submitButton"
                        >
                            Solicitar agendamento
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>