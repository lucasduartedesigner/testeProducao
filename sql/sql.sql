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
 `id_pessoa_turma` int(11) NOT NULL AUTO_INCREMENT,
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
 PRIMARY KEY (`id_pessoa_turma`)
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
 `disparador` varchar(2000) DEFAULT NULL,
 `identificacao` varchar(2000) DEFAULT NULL,
 `desc_hda` varchar(2000) DEFAULT NULL,
 `desc_hpp` varchar(2000) DEFAULT NULL,
 `desc_hs` varchar(2000) DEFAULT NULL,
 `desc_hpf` varchar(2000) DEFAULT NULL,
 `arquivo` varchar(150) DEFAULT NULL,
 `diagnostico` varchar(1000) DEFAULT NULL,
 `cod_status` int(11) DEFAULT NULL,
 `user_created` int(11) DEFAULT NULL,
 `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `user_updated` int(11) DEFAULT NULL,
 `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id_problema`)
);

-- Tabela criada para configurar Exame fisico padrão 
CREATE TABLE `config_exame_fisico` (
  `id_config_exame_fisico` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255)  NOT NULL,
  `status` int(11) DEFAULT NULL,
  `top_position` float(10,2) DEFAULT NULL,
  `left_position` float(10,2) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_config_exame_fisico`)
);

-- Tabela criada para exames fisicos dentro da situacao problema
CREATE TABLE `exame_fisico` (
  `id_exame_fisico` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL,
  `descricao` varchar(5000) DEFAULT NULL,
  `cod_status` int(11) DEFAULT NULL,
  `gabarito` int(11) DEFAULT NULL,
  `cod_tipo` int(11) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `top_position` float(10,2) DEFAULT NULL,
  `left_position` float(10,2) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_fisico`),
  KEY `FK_pergunta_problema` (`id_problema`)
);

-- Tabela criada para exames laboratorias dentro da situacao problema
CREATE TABLE `exame_laboratorial` (
  `id_exame_laboratorial` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL,
  `descricao` varchar(5000) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `gabarito` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `valor` float(10,2) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_laboratorial`),
  KEY `FK_pergunta_problema` (`id_problema`)
);

-- Tabela criada para agendar avaliacao da turma
CREATE TABLE `avaliacao` (
  `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL,
  `codcurso` int(11) NOT NULL,
  `periodo` int(11) NOT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `data_inicio` timestamp NULL DEFAULT NULL,
  `data_fim` timestamp NULL DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_professor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_avaliacao`)
);

-- Tabela criada para guardar a turma que esta fazendo a avaliação
CREATE TABLE `avaliacao_subturma` (
  `id_avaliacao_subturma` int(11) NOT NULL AUTO_INCREMENT,
  `id_avaliacao` int(11) NOT NULL,
  `subturma` varchar(20) NOT NULL,
  PRIMARY KEY (`id_avaliacao_subturma`),
  KEY `id_avaliacao` (`id_avaliacao`)
);

-- Tabela criada para guardar as notificações
CREATE TABLE `notificacao` (
  `id_notificacao` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_pessoa` int(11) NOT NULL,
  `user_created` int(11) NOT NULL,
  `type_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notificacao`)
);

-- Tabela criada para guardar diagnostico e status do estudante na avaliação
CREATE TABLE `avaliacao_problema` (
  `id_avaliacao_problema` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL,
  `id_avaliacao` int(11) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `codcurso` int(11) NOT NULL,
  `periodo` int(11) NOT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `subturma` varchar(20) DEFAULT NULL,
  `diagnostico` varchar(5000) DEFAULT NULL,
  `qtd_perguntas` int(11) DEFAULT NULL,
  `qtd_exames_fisico` int(11) DEFAULT NULL,
  `qtd_exames_laboratorial` int(11) DEFAULT NULL,
  `assertividade` int(11) DEFAULT NULL,
  `tempo_avaliacao` int(11) DEFAULT NULL,
  `cod_status` int(11) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (`id_avaliacao_problema`)
);

-- Tabela criada para guardar pergunta do estudante dentro da avaliacao e a resposta da IA
CREATE TABLE `pergunta_problema` (
  `id_pergunta_problema` int(11) NOT NULL AUTO_INCREMENT,
  `id_avaliacao_problema` int(11) DEFAULT NULL,
  `cod_status` int(11) DEFAULT NULL,
  `pergunta` varchar(1000) DEFAULT NULL,
  `resposta` varchar(1000) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pergunta_problema`)
);

-- Tabela criada para guardar exame fisico selecionado pelo estudante
CREATE TABLE `exame_fisico_problema` (
  `id_exame_fisico_problema` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL,
  `id_avaliacao` int(11) NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  `codcurso` int(11) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `subturma` varchar(20) DEFAULT NULL,
  `cod_status` int(11) DEFAULT NULL,
  `id_exame_fisico` int(11) NOT NULL,
  `interpretacao` varchar(1000) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_fisico_problema`)
);


-- Tabela criada para guardar exames laboratoriais selecionado pelo estudante
CREATE TABLE `exame_laboratorial_problema` (
  `id_exame_laboratorial_problema` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL,
  `id_avaliacao` int(11) NOT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  `codcurso` int(11) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `semestre` varchar(6) DEFAULT NULL,
  `codturma` varchar(20) DEFAULT NULL,
  `subturma` varchar(20) DEFAULT NULL,
  `cod_status` int(11) DEFAULT NULL,
  `id_exame_laboratorial` int(11) NOT NULL, -- se existir retorna resultado do exame cadastrado pelo professor
  `pergunta` varchar(1000) DEFAULT NULL,
  `resposta` varchar(1000) DEFAULT NULL, -- se não existir id_exame_laboratorial retorna resposta aleatoria padrão
  `user_created` int(11) DEFAULT NULL,
  `dt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` int(11) DEFAULT NULL,
  `dt_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_exame_laboratorial_problema`)
);

-- Tabela para criação dos prompts que vão ser utilizadas na IA
CREATE TABLE `prompts` (
  `id_prompts` INT PRIMARY KEY AUTO_INCREMENT,
  `prompt_type` VARCHAR(50) NOT NULL,
  `description` VARCHAR(255),
  `prompt_text` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);