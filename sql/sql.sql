CREATE TABLE IF NOT EXISTS `config` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icone` varchar(155) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_instance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_instance` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_instance` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_security` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_config`)
);

CREATE TABLE IF NOT EXISTS `pessoa` (
  `id_pessoa` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel_acesso` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricula` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `senha` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_status` int(11) DEFAULT NULL,
  `cod_tipo` int(11) DEFAULT NULL,
  `estilo` int(11) DEFAULT '1',
  `reset` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pessoa`),
  KEY `fk_professor_nivel_acesso` (`id_nivel_acesso`)
);

CREATE TABLE IF NOT EXISTS `estudante_turma` (
  `id_estudante_turma` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `codcurso` int(11) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `semestre` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codturma` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subturma` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_estudante_turma`)
);
