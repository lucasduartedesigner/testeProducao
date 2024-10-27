-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 27/10/2024 às 03:38
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `testeproducao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id_avaliacao` int NOT NULL AUTO_INCREMENT,
  `id_problema` int NOT NULL,
  `codcurso` int NOT NULL,
  `periodo` int NOT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `data_inicio` timestamp NULL DEFAULT NULL,
  `data_fim` timestamp NULL DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_professor` int DEFAULT NULL,
  PRIMARY KEY (`id_avaliacao`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `avaliacao`
--

INSERT INTO `avaliacao` (`id_avaliacao`, `id_problema`, `codcurso`, `periodo`, `semestre`, `codturma`, `data_inicio`, `data_fim`, `descricao`, `status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`, `id_professor`) VALUES
(2, 1, 13, 5, '2024/2', 'MED05', '2024-10-26 03:00:00', '2024-10-27 03:00:00', NULL, 1, NULL, '2024-10-27 01:29:13', NULL, '2024-10-27 03:34:29', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao_problema`
--

DROP TABLE IF EXISTS `avaliacao_problema`;
CREATE TABLE IF NOT EXISTS `avaliacao_problema` (
  `id_avaliacao_problema` int NOT NULL AUTO_INCREMENT,
  `id_problema` int NOT NULL,
  `id_avaliacao` int NOT NULL,
  `id_pessoa` int NOT NULL,
  `codcurso` int NOT NULL,
  `periodo` int NOT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `subturma` varchar(20) DEFAULT NULL,
  `diagnostico` varchar(5000) DEFAULT NULL,
  `qtd_perguntas` int DEFAULT NULL,
  `qtd_exames_fisico` int DEFAULT NULL,
  `qtd_exames_laboratorial` int DEFAULT NULL,
  `assertividade` int DEFAULT NULL,
  `tempo_avaliacao` int DEFAULT NULL,
  `cod_status` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_avaliacao_problema`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `avaliacao_problema`
--

INSERT INTO `avaliacao_problema` (`id_avaliacao_problema`, `id_problema`, `id_avaliacao`, `id_pessoa`, `codcurso`, `periodo`, `semestre`, `codturma`, `subturma`, `diagnostico`, `qtd_perguntas`, `qtd_exames_fisico`, `qtd_exames_laboratorial`, `assertividade`, `tempo_avaliacao`, `cod_status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(1, 2, 2, 1, 13, 7, '2024/2', 'MED01', 'GRUPO A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-26 22:03:50', NULL, '2024-10-26 22:03:50'),
(2, 3, 2, 583, 13, 5, '2024/2', 'MED05', 'GRUPO G', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2024-10-27 01:58:05', NULL, '2024-10-27 03:17:40'),
(3, 3, 2, 583, 13, 5, '2024/2', 'MED05', 'GRUPO G', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2024-10-27 01:58:06', NULL, '2024-10-27 03:17:30'),
(4, 3, 2, 583, 13, 5, '2024/2', 'MED05', 'GRUPO G', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2024-10-27 01:58:25', NULL, '2024-10-27 03:17:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao_subturma`
--

DROP TABLE IF EXISTS `avaliacao_subturma`;
CREATE TABLE IF NOT EXISTS `avaliacao_subturma` (
  `id_avaliacao_subturma` int NOT NULL AUTO_INCREMENT,
  `id_avaliacao` int NOT NULL,
  `subturma` varchar(20) NOT NULL,
  PRIMARY KEY (`id_avaliacao_subturma`),
  KEY `id_avaliacao` (`id_avaliacao`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `avaliacao_subturma`
--

INSERT INTO `avaliacao_subturma` (`id_avaliacao_subturma`, `id_avaliacao`, `subturma`) VALUES
(1, 1, 'GRUPO G'),
(7, 2, 'GRUPO G'),
(6, 2, 'GRUPO F'),
(8, 2, 'GRUPO H');

-- --------------------------------------------------------

--
-- Estrutura para tabela `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id_config` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `site` varchar(200) DEFAULT NULL,
  `description` varchar(155) DEFAULT NULL,
  `logo` varchar(155) DEFAULT NULL,
  `icone` varchar(155) DEFAULT NULL,
  `host` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `senha` varchar(500) DEFAULT NULL,
  `smtp` char(3) DEFAULT NULL,
  `api_instance` varchar(255) DEFAULT NULL,
  `id_instance` varchar(50) DEFAULT NULL,
  `token_instance` varchar(50) DEFAULT NULL,
  `token_security` varchar(50) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_config`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `config`
--

INSERT INTO `config` (`id_config`, `name`, `site`, `description`, `logo`, `icone`, `host`, `email`, `senha`, `smtp`, `api_instance`, `id_instance`, `token_instance`, `token_security`, `status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(1, 'Caso Clinico', 'http://localhost/testeProducao', 'Desenvolvimento e Resolução de Situações Problemas', 'app-assets/images/logo/casoclinico.png', 'app-assets/images/ico/icone.png', '', '', '', 'ssl', NULL, NULL, NULL, NULL, 1, NULL, '2024-07-10 05:55:45', NULL, '2024-07-14 17:24:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `config_exame_fisico`
--

DROP TABLE IF EXISTS `config_exame_fisico`;
CREATE TABLE IF NOT EXISTS `config_exame_fisico` (
  `id_config_exame_fisico` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `status` int DEFAULT NULL,
  `top_position` float(10,2) DEFAULT NULL,
  `left_position` float(10,2) DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_config_exame_fisico`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estudante`
--

DROP TABLE IF EXISTS `estudante`;
CREATE TABLE IF NOT EXISTS `estudante` (
  `id_estudante` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `codcurso` int DEFAULT NULL,
  `periodo` int DEFAULT NULL,
  `semestre` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codturma` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subturma` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estilo` int DEFAULT '1',
  `reset` int DEFAULT NULL,
  `foto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_estudante`)
) ENGINE=MyISAM AUTO_INCREMENT=585 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `estudante`
--

INSERT INTO `estudante` (`id_estudante`, `nome`, `matricula`, `cpf`, `email`, `senha`, `status`, `codcurso`, `periodo`, `semestre`, `codturma`, `subturma`, `user_created`, `dt_created`, `user_updated`, `dt_updated`, `estilo`, `reset`, `foto`) VALUES
(583, 'Rafael Sequeira', '06002151', '12312312311', 'rafael@unifeso.edu.br', '202cb962ac59075b964b07152d234b70', 1, 13, 5, '2024/2', 'MED05', 'GRUPO G', NULL, '2024-09-17 17:53:55', NULL, '2024-10-27 03:34:16', 1, NULL, NULL),
(584, 'Hugo Verissimo', '06004445', '12312312312', 'hugo@gmail.com', 'e6db1baa29d3df1eb307ff6a12c778da', 1, 13, 5, '2024/2', 'MED05', 'GRUPO A', NULL, '2024-10-27 03:28:48', NULL, '2024-10-27 03:31:03', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estudante_turma`
--

DROP TABLE IF EXISTS `estudante_turma`;
CREATE TABLE IF NOT EXISTS `estudante_turma` (
  `id_pessoa_turma` int NOT NULL AUTO_INCREMENT,
  `id_pessoa` int NOT NULL,
  `cod_status` int DEFAULT NULL,
  `codcurso` int DEFAULT NULL,
  `periodo` int DEFAULT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `subturma` varchar(20) DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pessoa_turma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `exame_fisico`
--

DROP TABLE IF EXISTS `exame_fisico`;
CREATE TABLE IF NOT EXISTS `exame_fisico` (
  `id_exame_fisico` int NOT NULL AUTO_INCREMENT,
  `id_problema` int NOT NULL,
  `descricao` varchar(5000) DEFAULT NULL,
  `cod_status` int DEFAULT NULL,
  `gabarito` int DEFAULT NULL,
  `cod_tipo` int DEFAULT NULL,
  `ordem` int DEFAULT NULL,
  `top_position` float(10,2) DEFAULT NULL,
  `left_position` float(10,2) DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_fisico`),
  KEY `FK_pergunta_problema` (`id_problema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `exame_fisico_problema`
--

DROP TABLE IF EXISTS `exame_fisico_problema`;
CREATE TABLE IF NOT EXISTS `exame_fisico_problema` (
  `id_exame_fisico_problema` int NOT NULL AUTO_INCREMENT,
  `id_problema` int NOT NULL,
  `id_avaliacao` int NOT NULL,
  `id_pessoa` int DEFAULT NULL,
  `codcurso` int DEFAULT NULL,
  `periodo` int DEFAULT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `subturma` varchar(20) DEFAULT NULL,
  `cod_status` int DEFAULT NULL,
  `id_exame_fisico` int NOT NULL,
  `interpretacao` varchar(1000) DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_fisico_problema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `exame_laboratorial`
--

DROP TABLE IF EXISTS `exame_laboratorial`;
CREATE TABLE IF NOT EXISTS `exame_laboratorial` (
  `id_exame_laboratorial` int NOT NULL AUTO_INCREMENT,
  `id_problema` int NOT NULL,
  `descricao` varchar(5000) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `gabarito` int DEFAULT NULL,
  `tipo` int DEFAULT NULL,
  `valor` float(10,2) DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_laboratorial`),
  KEY `FK_pergunta_problema` (`id_problema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `exame_laboratorial_problema`
--

DROP TABLE IF EXISTS `exame_laboratorial_problema`;
CREATE TABLE IF NOT EXISTS `exame_laboratorial_problema` (
  `id_exame_laboratorial_problema` int NOT NULL AUTO_INCREMENT,
  `id_problema` int NOT NULL,
  `id_avaliacao` int NOT NULL,
  `id_pessoa` int DEFAULT NULL,
  `codcurso` int DEFAULT NULL,
  `periodo` int DEFAULT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `subturma` varchar(20) DEFAULT NULL,
  `cod_status` int DEFAULT NULL,
  `id_exame_laboratorial` int NOT NULL,
  `pergunta` varchar(1000) DEFAULT NULL,
  `resposta` varchar(1000) DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_laboratorial_problema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_acesso`
--

DROP TABLE IF EXISTS `log_acesso`;
CREATE TABLE IF NOT EXISTS `log_acesso` (
  `id_log_acesso` int NOT NULL AUTO_INCREMENT,
  `id_pessoa` int NOT NULL,
  `navegador` varchar(100) DEFAULT NULL,
  `sistema` varchar(100) DEFAULT NULL,
  `dispositivo` varchar(100) DEFAULT NULL,
  `ip_acesso` varchar(45) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log_acesso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_acesso_estudante`
--

DROP TABLE IF EXISTS `log_acesso_estudante`;
CREATE TABLE IF NOT EXISTS `log_acesso_estudante` (
  `id_log_acesso_estudante` int NOT NULL AUTO_INCREMENT,
  `id_estudante` int NOT NULL,
  `navegador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sistema` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispositivo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_acesso` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log_acesso_estudante`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `log_acesso_estudante`
--

INSERT INTO `log_acesso_estudante` (`id_log_acesso_estudante`, `id_estudante`, `navegador`, `sistema`, `dispositivo`, `ip_acesso`, `dt_created`) VALUES
(1, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:14:00'),
(2, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:15:00'),
(3, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:15:40'),
(4, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:16:08'),
(5, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:31:23'),
(6, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 02:42:50'),
(7, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:11:49'),
(8, 583, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:17:50'),
(9, 584, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:29:08'),
(10, 584, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:29:19'),
(11, 584, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:31:15'),
(12, 584, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:31:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_acesso_professor`
--

DROP TABLE IF EXISTS `log_acesso_professor`;
CREATE TABLE IF NOT EXISTS `log_acesso_professor` (
  `id_log_acesso` int NOT NULL AUTO_INCREMENT,
  `id_professor` int NOT NULL,
  `navegador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sistema` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispositivo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_acesso` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log_acesso`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `log_acesso_professor`
--

INSERT INTO `log_acesso_professor` (`id_log_acesso`, `id_professor`, `navegador`, `sistema`, `dispositivo`, `ip_acesso`, `dt_created`) VALUES
(1, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:11:55'),
(2, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:13:18'),
(3, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:13:27'),
(4, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:14:16'),
(5, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:15:30'),
(6, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 01:19:35'),
(7, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 02:42:40'),
(8, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:10:56'),
(9, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:23:46'),
(10, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:29:26'),
(11, 1, 'Chrome', 'Windows 10', 'Desktop', '::1', '2024-10-27 03:31:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` varchar(5000) DEFAULT NULL,
  `ordem` int DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `icone` varchar(100) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `menu`
--

INSERT INTO `menu` (`id_menu`, `nome`, `descricao`, `ordem`, `link`, `icone`, `status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(1, 'Dashboard', NULL, 1, 'dashboard.php', '<i data-feather=\"home\"></i>', 1, 1, '2024-07-10 05:26:10', NULL, '2024-07-10 06:42:38'),
(2, 'Caso clínico', NULL, 2, 'problema.php', '<i data-feather=\"file-text\"></i>', 1, 1, '2024-07-10 06:43:42', NULL, '2024-07-30 00:28:26'),
(3, 'Estudante', NULL, 3, 'estudante.php', '<i data-feather=\"users\"></i>', 1, 1, '2024-07-10 06:44:44', NULL, '2024-07-30 00:30:08'),
(4, 'Nivel acesso', NULL, 7, 'acesso.php', '<i data-feather=\'shield\'></i>', 1, 1, '2024-07-10 06:46:41', NULL, '2024-07-30 00:30:26'),
(5, 'Resultado', NULL, 6, 'resultado.php', '<i data-feather=\'award\'></i>', 1, 1, '2024-07-10 06:48:44', NULL, '2024-07-30 00:30:22'),
(6, 'Professor', NULL, 4, 'professor.php', '<i data-feather=\"user\"></i>', 1, 1, '2024-07-11 06:04:45', NULL, '2024-07-11 06:06:45'),
(7, 'Avaliação', NULL, 5, 'avaliacao.php', '<i data-feather=\"calendar\"></i>', 1, 1, '2024-07-30 00:24:13', NULL, '2024-07-30 00:30:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `menu_acesso`
--

DROP TABLE IF EXISTS `menu_acesso`;
CREATE TABLE IF NOT EXISTS `menu_acesso` (
  `id_menu_acesso` int NOT NULL AUTO_INCREMENT,
  `id_nivel_acesso` int NOT NULL,
  `id_menu` int NOT NULL,
  `leitura` int DEFAULT NULL,
  `editar` int DEFAULT NULL,
  `deletar` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_menu_acesso`),
  KEY `fk_menu_acesso_nivel_acesso` (`id_nivel_acesso`),
  KEY `fk_menu_acesso_menu` (`id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `menu_acesso`
--

INSERT INTO `menu_acesso` (`id_menu_acesso`, `id_nivel_acesso`, `id_menu`, `leitura`, `editar`, `deletar`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(1, 1, 1, 1, 1, 1, NULL, '2024-10-26 19:20:34', NULL, '2024-10-26 19:20:34'),
(2, 1, 2, 1, 1, 1, NULL, '2024-10-26 19:20:34', NULL, '2024-10-26 19:20:34'),
(3, 1, 3, 1, 1, 1, 1, '2024-10-26 19:23:58', NULL, '2024-10-26 19:23:58'),
(4, 1, 4, 1, 1, 1, NULL, '2024-10-26 19:23:58', NULL, '2024-10-26 19:23:58'),
(5, 1, 5, 1, 1, 1, NULL, '2024-10-26 19:24:27', NULL, '2024-10-26 19:24:27'),
(6, 1, 6, 1, 1, 1, NULL, '2024-10-26 19:24:27', NULL, '2024-10-26 19:24:27'),
(7, 1, 7, 1, 1, 1, NULL, '2024-10-26 19:28:06', NULL, '2024-10-26 19:28:06'),
(8, 2, 1, 1, 0, 0, NULL, '2024-10-27 00:58:27', NULL, '2024-10-27 00:58:43'),
(9, 2, 2, 1, 1, NULL, NULL, '2024-10-27 00:58:38', NULL, '2024-10-27 00:58:45'),
(10, 2, 3, 1, 1, NULL, NULL, '2024-10-27 00:58:39', NULL, '2024-10-27 00:58:46'),
(11, 2, 6, 1, 1, NULL, NULL, '2024-10-27 00:58:40', NULL, '2024-10-27 00:58:48'),
(12, 2, 7, 1, 1, NULL, NULL, '2024-10-27 00:58:40', NULL, '2024-10-27 00:58:49'),
(13, 2, 5, 1, 0, NULL, NULL, '2024-10-27 00:58:41', NULL, '2024-10-27 03:25:24'),
(14, 2, 4, 1, 0, NULL, NULL, '2024-10-27 00:58:42', NULL, '2024-10-27 03:25:24');

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivel_acesso`
--

DROP TABLE IF EXISTS `nivel_acesso`;
CREATE TABLE IF NOT EXISTS `nivel_acesso` (
  `id_nivel_acesso` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_nivel_acesso`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `nivel_acesso`
--

INSERT INTO `nivel_acesso` (`id_nivel_acesso`, `nome`, `status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(1, 'Administrador', 1, NULL, '2024-10-26 19:19:50', NULL, '2024-10-26 19:19:50'),
(2, 'Professor', 1, NULL, '2024-10-27 00:58:22', NULL, '2024-10-27 00:58:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacao`
--

DROP TABLE IF EXISTS `notificacao`;
CREATE TABLE IF NOT EXISTS `notificacao` (
  `id_notificacao` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `id_pessoa` int NOT NULL,
  `user_created` int NOT NULL,
  `type_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notificacao`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pergunta_problema`
--

DROP TABLE IF EXISTS `pergunta_problema`;
CREATE TABLE IF NOT EXISTS `pergunta_problema` (
  `id_pergunta_problema` int NOT NULL AUTO_INCREMENT,
  `id_avaliacao_problema` int DEFAULT NULL,
  `cod_status` int DEFAULT NULL,
  `pergunta` varchar(1000) DEFAULT NULL,
  `resposta` varchar(1000) DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pergunta_problema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `id_pessoa` int NOT NULL AUTO_INCREMENT,
  `id_nivel_acesso` int NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `matricula` varchar(10) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `senha` varchar(150) DEFAULT NULL,
  `cod_status` int DEFAULT NULL,
  `cod_tipo` int DEFAULT NULL,
  `estilo` int DEFAULT '1',
  `reset` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pessoa`),
  KEY `fk_professor_nivel_acesso` (`id_nivel_acesso`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `id_nivel_acesso`, `nome`, `matricula`, `cpf`, `email`, `senha`, `cod_status`, `cod_tipo`, `estilo`, `reset`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(1, 1, 'Lucas', '073842', '14126735771', 'lucasduarte@feso.edu.br', '202cb962ac59075b964b07152d234b70', 1, 1, 2, NULL, NULL, '2024-10-26 17:58:23', NULL, '2024-10-27 00:48:31'),
(2, 1, 'Brucin', '068755', '11122233344', 'brucin@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1, 1, NULL, NULL, '2024-10-26 18:07:31', NULL, '2024-10-26 22:33:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `problema`
--

DROP TABLE IF EXISTS `problema`;
CREATE TABLE IF NOT EXISTS `problema` (
  `id_problema` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `disparador` varchar(2000) DEFAULT NULL,
  `identificacao` varchar(2000) DEFAULT NULL,
  `desc_hda` varchar(2000) DEFAULT NULL,
  `desc_hpp` varchar(2000) DEFAULT NULL,
  `desc_hs` varchar(2000) DEFAULT NULL,
  `desc_hpf` varchar(2000) DEFAULT NULL,
  `arquivo` varchar(150) DEFAULT NULL,
  `diagnostico` varchar(1000) DEFAULT NULL,
  `cod_status` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_problema`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `problema`
--

INSERT INTO `problema` (`id_problema`, `nome`, `disparador`, `identificacao`, `desc_hda`, `desc_hpp`, `desc_hs`, `desc_hpf`, `arquivo`, `diagnostico`, `cod_status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(2, 'Teste Anamnese I.A', NULL, 'Sr. João, 52 anos, engenheiro civil, residente de Belo Horizonte, MG.', 'Paciente relata que nos últimos seis meses sentiu episódios recorrentes de dor de cabeça, principalmente na região occipital, associada a tonturas e zumbido nos ouvidos. Ao aferir a pressão arterial em uma farmácia local, notou que estava acima do normal, com valores em torno de 150/100 mmHg. Os sintomas se intensificam no período da manhã e após esforço físico ou situações de stress, mas não apresenta alívio mesmo em repouso. Não relata qualquer episódio de perda de consciência, alterações visuais ou dor torácica.', 'Paciente é sedentário e possui histórico de tabagismo, fumando cerca de 20 cigarros por dia há 30 anos. Relata consumo moderado de álcool, principalmente nos finais de semana. Não tem histórico de diabetes, doenças cardíacas ou renais. Faz uso esporádico de analgésicos para aliviar as dores de cabeça.', 'Dieta rica em sal e gorduras, pouca atividade física e alto nível de stress devido ao trabalho. Dorme em média 5 horas por noite durante a semana.', 'Pai falecido aos 60 anos por infarto agudo do miocárdio. Mãe viva, 78 anos, hipertensa e diabética. Dois irmãos, um com histórico de hipertensão e outro saudável. Este caso clínico destaca a importância da anamnese na identificação de fatores de risco e sinais sugestivos de hipertensão arterial, uma condição comum, mas muitas vezes negligenciada, que pode levar a complicações graves quando não tratada adequadamente.', NULL, 'Hipertensão', 1, NULL, '2024-10-26 23:19:42', NULL, '2024-10-27 01:24:46'),
(1, 'Hipertireoidismo', 'Vocês são um grupo de acadêmicos que estão participando do ambulatório de Atenção Primária e acompanham a consulta de Ricardo, uma criança de 9 anos 5 meses que vem acompanhado da Mãe, com queixa atraso no crescimento, notado “há muito tempo tempo”', 'Sexo masculino, pardo, estudante do ensino fundamental, 9 anos e 5 meses, residente em Belford Roxo, pais evangélicos. Nascimento a termo, pelas vias naturais, sem complicações. \r\nA mãe refere ter realizado acompanhamento pré-natal, tendo utilizado sulfato ferroso e ácido fólico como únicos medicamentos durante a gestação. Aleitamento materno até os 2 anos\r\n', 'Mãe queixa de atraso no crescimento, e alterações dos índices antropométricos, conforme observou na caderneta da criança, o que a fez procurar auxilio na unidade de saúde. A mãe não sabe precisar há quanto notou o retardo no desenvolvimento, mas já havia notado a baixa estatura há aproximadamente um ano. A mãe alega estar preocupada, pois o menino repetiu de ano. Ela diz que teve uma reunião com a professora na qual ela indicou dificuldade na alfabetização do filho.  No contexto da revisão de sistemas, a mãe refere que o filho está com dificuldade de enxergar e apresenta prurido ocular, que não melhora com uso de colírios lubrificantes. A mãe nota que o filho vem apresentando ganho de peso no último ano, apesar da baixa estatura. \r\nIMC: 29,9 kg/m² (acima percentil 97) Peso: 34,9 kg (entre os percentis 50 e 85); Altura: 108 cm (abaixo percentil 3). \r\n', 'Nega doenças crônicas ou uso de medicamentos. nenhum medicamento regular. Nega cirurgias ou internações prévias. Nega cirurgias ou internações prévias. Catapora aos 7 anos. Mãe alega estar com calendário vacinal atualizado. A mãe refere que o Ricardo é seu filho caçula, e ja vem notando a baixa estatura há anosG5P5A0.', 'Alimentação balanceada com todos os grupos alimentares (proteínas, frutas e verduras), mesmo com aumento recente de peso. Mae refere consumo de sal iodado regular e de peixes ocasionalmente. Nega polifagia e consumo de produtos industrializados. A mãe nega tabagismo, etilismo ou uso de drogas ilícitas. Frequenta a escola fundamental, onde realiza educação física como parte da atividade didática. Vive com os pais, e irmãos em casa de alvenaria, com saneamento. ', 'Avó materna com DM tipo 2 e HAS, avô materno falecido de causas desconhecidas. Não sabe informar sobre status de saúde da família do esposo. Mãe  65 Kg  165 cm, pai 84 Kg e 183 cm', NULL, 'Hipertireoidismo', 1, NULL, '2024-10-26 20:39:17', NULL, '2024-10-27 01:25:15'),
(3, 'teste i.a - diabete', 'testando essa porra', 'Paciente J.S., 52 anos, pedreiro, residente de São Paulo.', 'Paciente relata que há aproximadamente 3 meses vem se sentindo bastante cansado, com fraqueza generalizada e perda de peso de cerca de 10 kg no período. Relata também aumento da sede e da frequência urinária, especialmente à noite. Menciona que as feridas estão demorando mais a cicatrizar do que o habitual, citando um corte na mão que ocorreu há duas semanas e ainda está em processo de cicatrização.', 'Paciente já foi diagnosticado com hipertensão há 5 anos, tratada com uso contínuo de Losartana 50mg. Informa que não possui alergias conhecidas.', 'Paciente é fumante, consome cerca de 1 maço de cigarros por dia há 30 anos. Bebe cerveja socialmente nos finais de semana. Relata uma alimentação desbalanceada, rica em carboidratos e gorduras, com pouca ingestão de frutas e vegetais. Não realiza atividades físicas regularmente.', 'Pai falecido em decorrência de infarto agudo do miocárdio aos 60 anos e mãe viva, diagnosticada com diabetes tipo 2 aos 50 anos. Tem um irmão, 45 anos, saudável. A anamnese exposta acima fornece informações relevantes para o entendimento do diagnóstico de diabetes, ponderando fatores como sintomas, histórico de saúde pessoal e familiar, além de hábitos de vida do paciente.', NULL, 'Diabetes', 1, NULL, '2024-10-27 03:08:25', NULL, '2024-10-27 03:18:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

DROP TABLE IF EXISTS `professor`;
CREATE TABLE IF NOT EXISTS `professor` (
  `id_professor` int NOT NULL AUTO_INCREMENT,
  `id_nivel_acesso` int NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `user_created` int DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estilo` int DEFAULT '1',
  `reset` int DEFAULT NULL,
  PRIMARY KEY (`id_professor`),
  KEY `fk_professor_nivel_acesso` (`id_nivel_acesso`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id_professor`, `id_nivel_acesso`, `nome`, `matricula`, `cpf`, `email`, `senha`, `status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`, `estilo`, `reset`) VALUES
(1, 1, 'Lucas Duarte', '073842', '14126735771', 'lucas.duarte.designer@gmail.com', 'cddedd99cbe88a173cd2efd609de84c9', 1, 1, '2024-07-10 05:28:13', NULL, '2024-10-27 03:32:47', 2, 1),
(2, 1, 'Rafael Sequeira', '068755', '12312312311', 'rafaelsequeira@feso.edu.br', '2255be0951400e260832c85c5d191247', 1, NULL, '2024-10-27 03:34:03', NULL, '2024-10-27 03:34:03', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `prompts`
--

DROP TABLE IF EXISTS `prompts`;
CREATE TABLE IF NOT EXISTS `prompts` (
  `id_prompts` int NOT NULL AUTO_INCREMENT,
  `prompt_type` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prompt_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_prompts`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `prompts`
--

INSERT INTO `prompts` (`id_prompts`, `prompt_type`, `description`, `prompt_text`, `created_at`, `updated_at`) VALUES
(1, 'paciente', 'Pre Prompt para interação médico x paciente', 'Você está simulando um paciente em um ambiente de ensino médico. Siga as instruções abaixo com precisão para criar uma experiência realista para o estudante: 1. Adote a personalidade do paciente descrita: Baseie-se nas informações do caso clínico para responder. Mesmo que detalhes pessoais como “Qual seu time?” ou “Qual o nome da sua mãe?” não estejam especificados no caso clínico, responda a essas perguntas de maneira consistente com o perfil do paciente. Por exemplo, uma pessoa simples pode responder com \"Ah, eu torço pro time local mesmo.\" 2. Seja exato e consistente: Ao responder perguntas sobre sintomas, seja firme e claro. Por exemplo, se o estudante perguntar “Teve febre?” e o caso clínico indicar que sim, responda de forma direta, como \"Sim, tive febre.\" Se não houver febre descrita, responda com naturalidade, como \"Não que eu tenha percebido, Doutor.\" Evite mudar de resposta ou demonstrar dúvidas desnecessárias, mantendo uma linha de resposta coerente com o que foi previamente descrito. 3. Não sugira diagnósticos ou tratamentos: Limite-se a responder às perguntas e nunca proponha diagnósticos ou tratamentos. Esse papel cabe ao estudante. 4. Não faça perguntas adicionais: Responda apenas à pergunta feita pelo estudante. Não faça perguntas de volta e mantenha a interação focada nas perguntas que o estudante fizer. 5. Mantenha-se fiel ao contexto: Responda conforme a história clínica e personalidade descritas. Evite respostas fora do contexto do paciente, mantendo sempre a naturalidade e os detalhes consistentes com o cenário do caso clínico. 6. Siga o tom apropriado: Seja calmo e cooperativo, evitando sarcasmo ou respostas muito técnicas. Responda como um paciente normal responderia, expressando seus sintomas e emoções conforme descrito no caso clínico. Essas diretrizes ajudam a simular um paciente realista e coerente para o estudante. Em qualquer caso de dúvida sobre informações não descritas, use respostas genéricas que correspondam à personalidade do paciente.7. Responder conforme o acompanhante responsável quando o paciente for menor de idade: Em casos clínicos de pacientes que não têm idade para responder por si mesmos, como crianças pequenas, responda às perguntas como se o responsável pelo paciente estivesse falando (neste caso, a mãe). Em perguntas que envolvem informações pessoais do paciente, como \"Qual o seu nome?\", o acompanhante deve responder em terceira pessoa, por exemplo: \"Ele se chama Ricardo.\" Mantenha o foco na perspectiva e nas observações feitas pelo responsável, respeitando as informações do caso clínico. Responda no estilo de uma mãe preocupada e atenta, conforme descrito, sem assumir o papel direto do paciente.', '2024-10-26 18:30:34', '2024-10-26 21:35:04'),
(2, 'anamnese', 'Pre Prompt para criação de anamneses', 'Você está elaborando uma anamnese educativa para um caso clínico. Com base no diagnóstico inicial dado pelo professor, crie uma anamnese realista e concisa com no máximo 400 tokens, respeitando a estrutura Identificação; HDA; HPP; HS; HPF. Inclua informações essenciais e contextuais relevantes para o aprendizado dos estudantes, observando as diretrizes abaixo:\r\n1.Introdução breve e completa: Apresente o paciente com informações básicas (idade, profissão, cidade, etc.), permitindo um entendimento inicial do caso.\r\n2.Sintomas principais detalhados: Descreva os sintomas de forma precisa e coesa, com ênfase na duração e evolução no histórico da doença atual (HDA).\r\n3.Informações prévias essenciais: Inclua histórico médico (HPP), hábitos de vida (HS) e histórico familiar (HPF) de forma objetiva, destacando apenas o que for relevante ao caso.\r\n4.Evite sugestões de tratamento: Forneça dados para análise, sem oferecer soluções ou tratamentos.\r\n5.Linguagem médica acessível e concisa: Mantenha um tom educativo, claro e adequado para estudantes em fase inicial, facilitando a interpretação.\r\nElabore uma anamnese que seja completa e instrutiva, respeitando o limite de 400 tokens para garantir concisão e coesão.', '2024-10-26 19:07:48', '2024-10-26 22:31:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
