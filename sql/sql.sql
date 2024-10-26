-- Tabela criada para configuração do sistema
CREATE TABLE IF NOT EXISTS `config` (
 `id_config` int(11) NOT NULL AUTO_INCREMENT,
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
 `status` int(11) DEFAULT NULL,
 `user_created` int(11) DEFAULT NULL,
 `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `user_updated` int(11) DEFAULT NULL,
 `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_config`)
);

-- Tabela para criação de niveis de acesso
CREATE TABLE IF NOT EXISTS `nivel_acesso` (
 `id_nivel_acesso` int(11) NOT NULL AUTO_INCREMENT,
 `nome` varchar(100) DEFAULT NULL,
 `status` int(11) DEFAULT NULL,
 `user_created` int(11) DEFAULT NULL,
 `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `user_updated` int(11) DEFAULT NULL,
 `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_nivel_acesso`)
);

-- Tabela criada para cadastro de pessoas 
CREATE TABLE IF NOT EXISTS `pessoa` (
 `id_pessoa` int(11) NOT NULL AUTO_INCREMENT,
 `id_nivel_acesso` int(11) NOT NULL,
 `nome` varchar(100) DEFAULT NULL,
 `matricula` varchar(10) DEFAULT NULL,
 `cpf` varchar(14) DEFAULT NULL,
 `email` varchar(150) DEFAULT NULL,
 `senha` varchar(150) DEFAULT NULL,
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

-- Tabela criada para vincular pessoa/estudante a uma turma
CREATE TABLE IF NOT EXISTS `estudante_turma` (
 `id_estudante_turma` int(11) NOT NULL AUTO_INCREMENT,
 `id_pessoa` int(11) NOT NULL,
 `cod_status` int(11) DEFAULT NULL,
 `codcurso` int(11) DEFAULT NULL,
 `periodo` int(11) DEFAULT NULL,
 `semestre` varchar(6) DEFAULT NULL,
 `codturma` varchar(20) DEFAULT NULL,
 `subturma` varchar(20) DEFAULT NULL,
 `user_created` int(11) DEFAULT NULL,
 `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `user_updated` int(11) DEFAULT NULL,
 `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_estudante_turma`)
);

-- Tabela criada para montagem do menu
CREATE TABLE IF NOT EXISTS `menu` (
 `id_menu` int(11) NOT NULL AUTO_INCREMENT,
 `nome` varchar(100) DEFAULT NULL,
 `descricao` varchar(5000) DEFAULT NULL,
 `ordem` int(11) DEFAULT NULL,
 `link` varchar(150) DEFAULT NULL,
 `icone` varchar(100) DEFAULT NULL,
 `status` int(11) DEFAULT NULL,
 `user_created` int(11) DEFAULT NULL,
 `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `user_updated` int(11) DEFAULT NULL,
 `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_menu`)
);

-- Tabela criada para vincular nivel de acesso e permissão aos menus e paginas
CREATE TABLE IF NOT EXISTS `menu_acesso` (
 `id_menu_acesso` int(11) NOT NULL AUTO_INCREMENT,
 `id_nivel_acesso` int(11) NOT NULL,
 `id_menu` int(11) NOT NULL,
 `leitura` int(11) DEFAULT NULL,
 `editar` int(11) DEFAULT NULL,
 `deletar` int(11) DEFAULT NULL,
 `user_created` int(11) DEFAULT NULL,
 `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `user_updated` int(11) DEFAULT NULL,
 `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_menu_acesso`),
 KEY `fk_menu_acesso_nivel_acesso` (`id_nivel_acesso`),
 KEY `fk_menu_acesso_menu` (`id_menu`)
);

-- Tabela criada para criacao da situacao problema
CREATE TABLE IF NOT EXISTS `problema` (
 `id_problema` int(11) NOT NULL AUTO_INCREMENT,
 `nome` varchar(255) NOT NULL,
 `disparador` varchar(5000) DEFAULT NULL,
 `identificacao` varchar(5000) DEFAULT NULL,
 `desc_hda` varchar(5000) DEFAULT NULL,
 `desc_hpp` varchar(5000) DEFAULT NULL,
 `desc_hs` varchar(5000) DEFAULT NULL,
 `desc_hpf` varchar(5000) DEFAULT NULL,
 `arquivo` varchar(150) DEFAULT NULL,
 `diagnostico` varchar(1000) DEFAULT NULL,
 `cod_status` int(11) DEFAULT NULL,
 `user_created` int(11) DEFAULT NULL,
 `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `user_updated` int(11) DEFAULT NULL,
 `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_problema`)
);