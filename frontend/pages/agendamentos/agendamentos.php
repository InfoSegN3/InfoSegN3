<?php
  session_start();

  if (
    !isset($_SESSION['id']) ||
    !in_array($_SESSION['tipo'], ['aluno','professor','admin'])
  ) {
    header("Location: ../login/login.html");
    exit();
  }

  // Busca todos os usuários cadastrados
  include("../../../backend/conector.php");
  $sql = $pdo->prepare("SELECT * FROM agendamentos WHERE aluno_id = ?");
  $sql->execute([$_SESSION['id']]);
  $agendamentos = $sql->fetchAll(PDO::FETCH_ASSOC);

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
                            <th>Setor / Atendente</th>
                            <th>Data e hora</th>
                            <th>Motivo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <div class="professor">
                                    <strong>Prof. João Almeida</strong>
                                    <span>Engenharia de Software</span>
                                </div>
                            </td>

                            <td>26/06/2026, 21:19</td>

                            <td>Dúvida sobre o projeto final.</td>

                            <td>
                                <a href="#" class="deleteButton">
                                    Excluir
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="professor">
                                    <strong>Secretaria Acadêmica</strong>
                                    <span>Secretaria</span>
                                </div>
                            </td>

                            <td>22/06/2026, 21:19</td>
    
                            <td>Solicitação de histórico escolar.</td>

                            <td>
                                <a href="#" class="deleteButton">
                                    Excluir
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="professor">
                                    <strong>Prof.ª Ana Ribeiro</strong>
                                    <span>Banco de Dados</span>
                                </div>
                            </td>

                            <td>20/06/2026, 14:00</td>

                            <td>Revisão da prova.</td>

                            <td>
                                <a href="#" class="deleteButton">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>