-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/06/2026 às 03:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `meu_banco`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `nome_admin` varchar(255) DEFAULT NULL,
  `email_admin` varchar(255) DEFAULT NULL,
  `senha_admin` varchar(255) DEFAULT NULL,
  `status_admin` varchar(50) DEFAULT '1',
  `primeirologin` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id_admin`, `nome_admin`, `email_admin`, `senha_admin`, `status_admin`, `primeirologin`) VALUES
(1, 'Otavio', 'otavio@admin.edu.com', '$2y$10$.utNmBNTSM.4vzRWPU1H2u4HxSxNK./OULhMLrasaXALbkZ4xRP2C', '1', 0),
(2, 'Hosmar', 'henrique@admin.com', '$2y$10$FiyiliMiFLtV5RSZoX4XvOwAz6/DYlbWuTEFT3MxLRGgjd/QMAeRe', '1', 0),
(3, 'Admin', 'admin@admin.com', '$2y$10$Y0CsdDbJKDd37ixBI6E4SOolDYiDCrbeJZD6aXi8rODusEAk95K2e', '1', 0),
(4, 'Administrador 1', 'adm@admin.com', '$2y$10$XTDTeLvRssrc6GyhKNFAku/glk7JD36of//LRyJBB60hUKWaoriJe', '1', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) DEFAULT NULL,
  `professor_id` int(11) NOT NULL,
  `data_agendamento` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `status` enum('Pendente','Aprovado','Rejeitado','Concluido','Cancelado') DEFAULT 'Pendente',
  `motivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `aluno_id`, `professor_id`, `data_agendamento`, `horario`, `status`, `motivo`) VALUES
(2, 2, 1, '2026-06-27', '20:00:00', 'Pendente', 'Pilates'),
(3, 2, 1, '2026-06-26', '15:00:00', 'Pendente', 'Teste'),
(6, 10, 3, '2026-06-29', '14:00:00', 'Pendente', 'Aula de banco de dados');

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `acao` varchar(255) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `logs`
--

INSERT INTO `logs` (`id`, `usuario_id`, `acao`, `data_hora`) VALUES
(1, NULL, 'Login realizado', '2026-06-26 21:43:01'),
(2, 1, 'Usuário cadastrado', '2026-06-26 21:45:57'),
(3, 1, 'Usuário cadastrado', '2026-06-26 21:46:26'),
(4, 1, 'Usuário cadastrado', '2026-06-26 21:46:49'),
(5, 10, 'Agendamento criado', '2026-06-26 21:50:40'),
(6, 10, 'Agendamento criado', '2026-06-26 21:50:48'),
(7, 10, 'Agendamento criado', '2026-06-26 21:51:19'),
(8, NULL, 'Login realizado', '2026-06-26 22:04:20'),
(9, 1, 'Usuário cadastrado', '2026-06-26 22:26:31'),
(10, 1, 'Usuário cadastrado: adm@admin.com (tipo: admin)', '2026-06-26 22:30:32'),
(11, NULL, 'Login realizado', '2026-06-26 22:31:40'),
(12, NULL, 'Login realizado', '2026-06-26 22:32:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(80) DEFAULT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `ativo_usuario` tinyint(1) NOT NULL DEFAULT 1,
  `primeiro_acesso` tinyint(1) NOT NULL DEFAULT 1,
  `tipo_usuario` enum('professor','aluno') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `ativo_usuario`, `primeiro_acesso`, `tipo_usuario`) VALUES
(1, 'Marcos', 'marcos@aluno.com', '$2y$10$svadcTYvOJz9LUWG7hTXQuAH9jWs6aWKMcmy1vkKqHBvrU/Zmcd.q', 0, 0, 'professor'),
(2, 'otavio', 'otavio@aluno.com', '$2y$10$FiyiliMiFLtV5RSZoX4XvOwAz6/DYlbWuTEFT3MxLRGgjd/QMAeRe', 1, 0, 'aluno'),
(3, 'Edicarcia', 'edicarsia@professor.com', '$2y$10$bLJ76UyRux8mFQQCzeXxTOoodNR/oPleVUYPdS2vcUQm8gqj38jRG', 1, 0, 'professor'),
(4, 'Diego', 'diego@professor.com', '$2y$10$rjm.tDylJrxVbpn84NSJHutIqon6qdb/Oq8pyuAhPDywApmybyOAu', 0, 0, 'professor'),
(5, 'Augusto', 'augusto@aluno.com', '$2y$10$SSTETYYjkQm0GtglBTqKOOkpnbWU6fvI15izvRtduWpO9s9fc3lMm', 0, 0, 'aluno'),
(6, 'Adilson', 'adilson@professor.com', '$2y$10$5gf.ieMNkSWyjFsMMK9NLuphm.k6yq2s7fhwtWhM8685tGcuVScjS', 0, 0, 'professor'),
(7, 'Leonor', 'leonor@aluno.com', '$2y$10$.6sbs6d1QbJePLEiBLNFVuz7tz1sihyEmaRCqSvm9GnKfMZRModki', 0, 0, 'aluno'),
(8, 'Davi Bornelli', 'davib@professor.com', '$2y$10$MqPaVpTbGyooMC9JoSA4EOaiXiGu6.gZBF.KYITpIMBlu8jCsiw/2', 1, 0, 'professor'),
(9, 'Pedro Vaz', 'pedrov@aluno.com', '$2y$10$KpqA75gfJhyIDAypmLDSD.lOZrA9xbQvGKFhTchdVLVBPKsIE/76K', 0, 0, 'aluno'),
(10, 'Pedro Alvares', 'pedroa@aluno.com', '$2y$10$5CWaTKdXjQaMFs7G58WEaeIRvJ9IbN9sIegUE4GFnKK8enUzUzETS', 1, 0, 'aluno');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agendamento_professor` (`professor_id`),
  ADD KEY `fk_agendamento_aluno` (`aluno_id`);

--
-- Índices de tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_agendamento_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_agendamento_professor` FOREIGN KEY (`professor_id`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
