-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26/10/2024 às 18:38
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(1, 0, 'Lucas', '073842', '14126735771', 'lucasduarte@feso.edu.br', '202cb962ac59075b964b07152d234b70', NULL, NULL, 1, NULL, NULL, '2024-10-26 17:58:23', NULL, '2024-10-26 17:58:23'),
(2, 0, 'Brucin', '068755', '11122233344', 'brucin@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, 1, NULL, NULL, '2024-10-26 18:07:31', NULL, '2024-10-26 18:07:31');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `problema`
--

INSERT INTO `problema` (`id_problema`, `nome`, `disparador`, `identificacao`, `desc_hda`, `desc_hpp`, `desc_hs`, `desc_hpf`, `arquivo`, `diagnostico`, `cod_status`, `user_created`, `dt_created`, `user_updated`, `dt_updated`) VALUES
(1, '', 'Vocês são um grupo de acadêmicos que estão participando do ambulatório de Atenção Primária e acompanham a consulta de Ricardo, uma criança de 9 anos 5 meses que vem acompanhado da Mãe, com queixa atraso no crescimento, notado “há muito tempo tempo”', 'Sexo masculino, pardo, estudante do ensino fundamental, 9 anos e 5 meses, residente em Belford Roxo, pais evangélicos. Nascimento a termo, pelas vias naturais, sem complicações. \r\nA mãe refere ter realizado acompanhamento pré-natal, tendo utilizado sulfato ferroso e ácido fólico como únicos medicamentos durante a gestação. Aleitamento materno até os 2 anos\r\n', 'Mãe queixa de atraso no crescimento, e alterações dos índices antropométricos, conforme observou na caderneta da criança, o que a fez procurar auxilio na unidade de saúde. A mãe não sabe precisar há quanto notou o retardo no desenvolvimento, mas já havia notado a baixa estatura há aproximadamente um ano. A mãe alega estar preocupada, pois o menino repetiu de ano. Ela diz que teve uma reunião com a professora na qual ela indicou dificuldade na alfabetização do filho.  No contexto da revisão de sistemas, a mãe refere que o filho está com dificuldade de enxergar e apresenta prurido ocular, que não melhora com uso de colírios lubrificantes. A mãe nota que o filho vem apresentando ganho de peso no último ano, apesar da baixa estatura. \r\nIMC: 29,9 kg/m² (acima percentil 97) Peso: 34,9 kg (entre os percentis 50 e 85); Altura: 108 cm (abaixo percentil 3). \r\n', 'Nega doenças crônicas ou uso de medicamentos. nenhum medicamento regular. Nega cirurgias ou internações prévias. Nega cirurgias ou internações prévias. Catapora aos 7 anos. Mãe alega estar com calendário vacinal atualizado. A mãe refere que o Ricardo é seu filho caçula, e ja vem notando a baixa estatura há anosG5P5A0.', 'Alimentação balanceada com todos os grupos alimentares (proteínas, frutas e verduras), mesmo com aumento recente de peso. Mae refere consumo de sal iodado regular e de peixes ocasionalmente. Nega polifagia e consumo de produtos industrializados. A mãe nega tabagismo, etilismo ou uso de drogas ilícitas. Frequenta a escola fundamental, onde realiza educação física como parte da atividade didática. Vive com os pais, e irmãos em casa de alvenaria, com saneamento. ', 'Avó materna com DM tipo 2 e HAS, avô materno falecido de causas desconhecidas. Não sabe informar sobre status de saúde da família do esposo. Mãe  65 Kg  165 cm, pai 84 Kg e 183 cm', NULL, 'Hipertireoidismo', NULL, NULL, '2024-10-26 17:37:14', NULL, '2024-10-26 17:37:14');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
