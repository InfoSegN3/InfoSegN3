<?php
  session_start();
  if (
    !isset($_SESSION['id']) ||
    !in_array($_SESSION['tipo'], ['aluno','professor','admin'])
  ) {
    header("Location: ../login/login.html");
    exit();
  }

  // Ajuste o caminho/nome do arquivo de conexão conforme o seu projeto.
  // Esse arquivo deve criar a variável $conn (mysqli).
    include("../../../backend/conector.php");

$consulta = $pdo->prepare("
    SELECT
        logs.*,
        usuarios.nome_usuario AS usuario_nome
    FROM logs
    LEFT JOIN usuarios
        ON logs.usuario_id = usuarios.id_usuario
    ORDER BY logs.data_hora DESC
");
$consulta->execute();

$logs = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Acadêmica</title>
    
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="./auditoria.css">
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
            <h1>Logs de Auditoria</h1>
            <div class="auditoriaContainer">
                <div class="auditoriaHeader">
                    <h2>Eventos registrados</h2>
                    <p>
                        Registros de ações realizadas no sistema.
                    </p>
                </div>
                <div class="searchContainer">
                    <input
                        type="text"
                        id="filtroAuditoria"
                        placeholder="Filtrar por usuário ou ação..."
                    >
                </div>
                <table class="auditoriaTable">
                    <thead>
                        <tr>
                            <th>Data/Hora</th>
                            <th>Usuário</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($logs) > 0) : ?>
                            <?php foreach ($logs as $log) : ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars(date('d/m/Y H:i:s', strtotime($log['data_hora']))) ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($log['usuario_nome'])) : ?>
                                            <?= htmlspecialchars($log['usuario_nome']) ?>
                                        <?php elseif (!empty($log['usuario_id'])) : ?>
                                            Usuário #<?= htmlspecialchars($log['usuario_id']) ?>
                                        <?php else : ?>
                                            Sistema
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge action">
                                            <?php
                                                $acao = $log['acao'];

                                                if (empty($log['usuario_id']) && stripos($acao, 'login realizado') !== false) {
                                                    $acao = 'Tentativa de login';
                                                }

                                                echo htmlspecialchars($acao);
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3">Nenhum log encontrado.</td>
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