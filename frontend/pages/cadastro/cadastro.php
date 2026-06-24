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
  <title>Document</title>
</head>

<body>
  <form action="../../../backend/cadastro.php" method="POST">
    <input name="nome" type="text" placeholder="nome">
    <input name="email" type="email" placeholder="email">
    <<select name="tipoUsuario">
      <option value="aluno">Aluno</option>
      <option value="operador">Operador</option>

      <?php if ($_SESSION['tipo'] === 'admin'): ?>
          <option value="admin">Admin</option>
      <?php endif; ?>
    </select>
    <button type="submit">Cadastrar</button>
  </form>

  <!-- Adiciona isso -->
  <div id="resultado" style="display:none; margin-top: 20px;">
    <p id="mensagem"></p>
    <div id="boxSenha" style="display:none;">
      <p>Senha temporária gerada:</p>
      <strong id="senhaGerada"></strong>
      <button onclick="copiarSenha()">Copiar senha</button>
    </div>
  </div>

  <script>
    const params = new URLSearchParams(window.location.search);
    const status = params.get('status');
    const senha = params.get('senha');

    const resultado = document.getElementById('resultado');
    const mensagem = document.getElementById('mensagem');
    const boxSenha = document.getElementById('boxSenha');
    const senhaGerada = document.getElementById('senhaGerada');

    if (status === 'sucesso' && senha) {
      resultado.style.display = 'block';
      mensagem.textContent = 'Usuário cadastrado com sucesso!';
      boxSenha.style.display = 'block';
      senhaGerada.textContent = senha;
    } else if (status === 'erro') {
      resultado.style.display = 'block';
      mensagem.textContent = 'Erro ao cadastrar. Tente novamente.';
    }

    function copiarSenha() {
      navigator.clipboard.writeText(senhaGerada.textContent);
      alert('Senha copiada!');
    }
  </script>
</body>

</html>