-- ============================================================
-- BANCO DE DADOS RECUPERADO
-- Gerado automaticamente a partir dos arquivos .frm e .ibd
-- Charset: utf8mb4 / Collation: utf8mb4_general_ci
-- ============================================================

CREATE DATABASE IF NOT EXISTS `meu_banco`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `meu_banco`;

-- ------------------------------------------------------------
-- Tabela: admins
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id_admin` INT NOT NULL AUTO_INCREMENT,
  `nome_admin` VARCHAR(255) DEFAULT NULL,
  `email_admin` VARCHAR(255) DEFAULT NULL,
  `senha_admin` VARCHAR(255) DEFAULT NULL,
  `status_admin` VARCHAR(50) DEFAULT NULL,
  `primeirologin` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins` (`nome_admin`, `email_admin`, `senha_admin`) VALUES
('Otavio', 'otavio@admin.edu.com', 'adc3ba9d85a03e6f78304dd77d17d04a');

-- ------------------------------------------------------------
-- Tabela: usuarios
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `senha` VARCHAR(255) DEFAULT NULL,
  `primeiro_login` TINYINT(1) DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`nome`, `email`, `senha`) VALUES
('Otavio',         'otavio@email.com',   '0198e654fbd6c0e1794ea461368881cf'),
('Lucas',          'lucas@email.com',    'c5e7a3821ce156ab34592d3dfbae78c9'),
('Osmar',          'osmar@email.com',    'd194ac2157f689623ca630a88c443aba'),
('Pedro Henrique', 'pedro.h@edu.com',    '8c7a8175df4ea2761e54e7ae477d4385'),
('Davi Peres',     'd.peres@edu.com',    '7ca8693c6c77532a8f064068585175e1');

-- ------------------------------------------------------------
-- Tabela: operador
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `operador` (
  `id_operador` INT NOT NULL AUTO_INCREMENT,
  `nome_operador` VARCHAR(255) DEFAULT NULL,
  `email_operador` VARCHAR(255) DEFAULT NULL,
  `senha_operador` VARCHAR(255) DEFAULT NULL,
  `status_operador` VARCHAR(50) DEFAULT NULL,
  `primeirologin` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`id_operador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Nenhum dado recuperado desta tabela (estava vazia ou não legível)

-- ------------------------------------------------------------
-- Tabela: agendamentos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `agendamentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `aluno_id` INT DEFAULT NULL,
  `data_agendamento` DATE DEFAULT NULL,
  `horario` TIME DEFAULT NULL,
  `status` ENUM('Pendente','Aprovado','Rejeitado','Concluido','Cancelado') DEFAULT 'Pendente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Nenhum dado recuperado desta tabela (estava vazia ou não legível)

-- ------------------------------------------------------------
-- Tabela: logs
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `logs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT DEFAULT NULL,
  `acao` VARCHAR(255) DEFAULT NULL,
  `data_hora` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Nenhum dado recuperado desta tabela (estava vazia ou não legível)
