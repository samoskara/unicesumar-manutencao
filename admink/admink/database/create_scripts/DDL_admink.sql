CREATE DATABASE IF NOT EXISTS admink;
USE admink;

CREATE TABLE IF NOT EXISTS admink.estudio (
    `id_estudio` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(60) NOT NULL,
    `endereco` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.users (
    `id` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.estudio_users (
    `id_estudio_users` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ativo` BOOLEAN NOT NULL DEFAULT TRUE,
    `data_inicio` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `data_fim` DATE NULL DEFAULT NULL,
    `fk_users_id_users` INTEGER  NOT NULL,
    `fk_estudio_id_estudio` INTEGER NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `FK_id_users` FOREIGN KEY (`fk_users_id_users`) REFERENCES `users` (`id`),
    CONSTRAINT `FK_id_estudio` FOREIGN KEY (`fk_estudio_id_estudio`) REFERENCES `estudio` (`id_estudio`)
);

CREATE TABLE IF NOT EXISTS admink.estacao (
    `id_estacao` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `identificacao` VARCHAR(20) NOT NULL,
    `ativa` BOOLEAN NOT NULL DEFAULT TRUE,
    `fk_estudio_id_estudio` INTEGER NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `FK_id_estudio2` FOREIGN KEY (`fk_estudio_id_estudio`) REFERENCES `estudio` (`id_estudio`)
);

CREATE TABLE IF NOT EXISTS admink.artista (
    `id_artista` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(60) NOT NULL,
    `apelido` VARCHAR(60) NOT NULL,
    `email` VARCHAR(60) NOT NULL UNIQUE,
    `telefone` VARCHAR(15) NOT NULL,
    `data_nascimento` DATE NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.artista_estudio (
    `id_artista_estudio` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `data_inicio` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `data_fim` DATE NULL DEFAULT NULL,
    `ativo` BOOLEAN NOT NULL DEFAULT TRUE,
    `visitante` BOOLEAN NOT NULL DEFAULT FALSE,
    `fk_estudio_id_estudio` INTEGER NOT NULL,
    `fk_artista_id_artista` INTEGER NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `FK_id_estudio3` FOREIGN KEY (`fk_estudio_id_estudio`) REFERENCES `estudio` (`id_estudio`),
    CONSTRAINT `FK_id_artista` FOREIGN KEY (`fk_artista_id_artista`) REFERENCES `artista` (`id_artista`)
);

CREATE TABLE IF NOT EXISTS admink.cliente (
    `id_cliente` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(60) NOT NULL,
    `email` VARCHAR(60) NOT NULL UNIQUE,
    `telefone` VARCHAR(15) NOT NULL,
    `apelido` VARCHAR(60) NULL DEFAULT NULL,
    `data_nascimento` DATE NULL DEFAULT NULL,
    `observacao` VARCHAR(255) NULL DEFAULT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.cliente_estudio (
    `id_cliente_estudio` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,  
    `ativo` BOOLEAN NOT NULL DEFAULT TRUE,
    `fk_estudio_id_estudio` INTEGER NOT NULL,
    `fk_cliente_id_cliente` INTEGER NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `FK_id_estudio4` FOREIGN KEY (`fk_estudio_id_estudio`) REFERENCES `estudio` (`id_estudio`),
    CONSTRAINT `FK_id_cliente2` FOREIGN KEY (`fk_cliente_id_cliente`) REFERENCES `cliente` (`id_cliente`)
);

CREATE TABLE IF NOT EXISTS admink.agendamento_status (
    `id_agendamento_status` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `status` VARCHAR(60) NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.uso_materiais (
    `id_uso_materiais` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nivel` VARCHAR(20) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.complexidade (
    `id_complexidade` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nivel` VARCHAR(20) NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.orcamento_status (
    `id_orcamento_status` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `status` VARCHAR(60) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS admink.orcamento (
    `id_orcamento` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tatuagem_nome` VARCHAR(60) NOT NULL,
    `tatuagem_local` VARCHAR(60) NOT NULL,
    `tatuagem_comprimento` DECIMAL(5,2)  NOT NULL,
    `tatuagem_largura` DECIMAL(5,2)   NOT NULL,
    `tatuagem_descricao` VARCHAR(255) NOT NULL,
    `tatuagem_referencias` TEXT NULL DEFAULT NULL,
    `tatuagem_colorida` BOOLEAN NOT NULL DEFAULT FALSE,
    `tatuagem_autoral` BOOLEAN NOT NULL DEFAULT FALSE,
    `valor` DECIMAL(7, 2)  NULL DEFAULT NULL,
    `tempo_estimado` TIME NULL DEFAULT NULL,
    `canal_contato` VARCHAR(20) NULL DEFAULT NULL,
    `observacao` VARCHAR(255) NULL DEFAULT NULL,
    `aceite_termo` BOOLEAN NOT NULL DEFAULT FALSE,
    `fk_cliente_id_cliente` INTEGER NOT NULL,
    `fk_artista_id_artista` INTEGER NOT NULL,
    `fk_estudio_id_estudio` INTEGER NOT NULL,
    `fk_orcamento_status_id_orcamento_status` INTEGER NOT NULL,
    `fk_uso_materiais_id_uso_materiais` INTEGER NULL DEFAULT NULL,
    `fk_complexidade_id_complexidade` INTEGER NULL DEFAULT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `FK_id_cliente` FOREIGN KEY (`fk_cliente_id_cliente`) REFERENCES `cliente` (`id_cliente`),
    CONSTRAINT `FK_id_artista2` FOREIGN KEY (`fk_artista_id_artista`) REFERENCES `artista` (`id_artista`),
    CONSTRAINT `FK_id_estudio5` FOREIGN KEY (`fk_estudio_id_estudio`) REFERENCES `estudio` (`id_estudio`),
    CONSTRAINT `FK_id_uso_materiais` FOREIGN KEY (`fk_uso_materiais_id_uso_materiais`) REFERENCES `uso_materiais` (`id_uso_materiais`),
    CONSTRAINT `FK_id_complexidade` FOREIGN KEY (`fk_complexidade_id_complexidade`) REFERENCES `complexidade` (`id_complexidade`),
    CONSTRAINT `FK_id_orcamento_status` FOREIGN KEY (`fk_orcamento_status_id_orcamento_status`) REFERENCES `orcamento_status` (`id_orcamento_status`)
);

CREATE TABLE IF NOT EXISTS admink.agendamento (
    `id_agendamento` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `fk_orcamento_id_orcamento` INTEGER NOT NULL,
    `fk_estacao_id_estacao` INTEGER NOT NULL,
    `data_horario_inicio` DATETIME NOT NULL,
    `data_horario_fim` DATETIME NOT NULL,
    `observacao` VARCHAR(255) NULL DEFAULT NULL,
    `fk_agendamento_status_id_agendamento_status` INTEGER NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `FK_id_orcamento` FOREIGN KEY (`fk_orcamento_id_orcamento`) REFERENCES `orcamento` (`id_orcamento`),
    CONSTRAINT `FK_id_estacao` FOREIGN KEY (`fk_estacao_id_estacao`) REFERENCES `estacao` (`id_estacao`),
    CONSTRAINT `FK_id_agendamento_status` FOREIGN KEY (`fk_agendamento_status_id_agendamento_status`) REFERENCES `agendamento_status` (`id_agendamento_status`)
);

INSERT INTO `agendamento_status` (`status`)
VALUES ('Pendente');

INSERT INTO `agendamento_status` (`status`)
VALUES ('Finalizado');

INSERT INTO `agendamento_status` (`status`)
VALUES ('Cancelado');

INSERT INTO `orcamento_status` (`status`)
VALUES ('Aguardando resposta do artista');

INSERT INTO `orcamento_status` (`status`)
VALUES ('Aguardando resposta do cliente');

INSERT INTO `orcamento_status` (`status`)
VALUES ('Cliente agendou');

INSERT INTO `orcamento_status` (`status`)
VALUES ('Cliente recusou');

INSERT INTO `uso_materiais` (`nivel`)
VALUES ('Baixo');

INSERT INTO `uso_materiais` (`nivel`)
VALUES ('Médio');

INSERT INTO `uso_materiais` (`nivel`)
VALUES ('Alto');

INSERT INTO `complexidade` (`nivel`)
VALUES ('Baixo');

INSERT INTO `complexidade` (`nivel`)
VALUES ('Médio');

INSERT INTO `complexidade` (`nivel`)
VALUES ('Alto');