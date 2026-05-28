-- TRIGGERS

USE admink;

DROP TRIGGER IF EXISTS `tg_insert_artista`;

DELIMITER $$
	CREATE TRIGGER `tg_insert_artista` BEFORE INSERT ON artista
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_pessoa(NEW.email, NEW.data_nascimento);
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_update_artista`;

DELIMITER $$
	CREATE TRIGGER `tg_update_artista` BEFORE UPDATE ON artista
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_pessoa(NEW.email, NEW.data_nascimento);
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_insert_cliente`;

DELIMITER $$
	CREATE TRIGGER `tg_insert_cliente` BEFORE INSERT ON cliente
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_pessoa(NEW.email, NEW.data_nascimento);
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_update_cliente`;

DELIMITER $$
	CREATE TRIGGER `tg_update_cliente` BEFORE UPDATE ON cliente
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_pessoa(NEW.email, NEW.data_nascimento);
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_insert_users`;

DELIMITER $$
	CREATE TRIGGER `tg_insert_users` BEFORE INSERT ON users
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_usuario(NEW.email);
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_update_users`;

DELIMITER $$
	CREATE TRIGGER `tg_update_users` BEFORE UPDATE ON users
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_usuario(NEW.email);
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_insert_agendamento`;

DELIMITER $$
	CREATE TRIGGER `tg_insert_agendamento` BEFORE INSERT ON agendamento
    FOR EACH ROW 
    BEGIN
    IF  NEW.fk_agendamento_status_id_agendamento_status = 1
		  THEN CALL prc_valida_agendamento(NEW.data_horario_inicio, NEW.data_horario_fim, NEW.fk_orcamento_id_orcamento, NEW.fk_estacao_id_estacao, NEW.fk_agendamento_status_id_agendamento_status, NEW.fk_agendamento_status_id_agendamento_status);
    END IF;
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_update_agendamento`;

DELIMITER $$
	CREATE TRIGGER `tg_update_agendamento` BEFORE UPDATE ON agendamento
    FOR EACH ROW 
    BEGIN
    IF NEW.deleted_at IS NULL AND NEW.fk_agendamento_status_id_agendamento_status = 1
      THEN CALL prc_valida_agendamento(NEW.data_horario_inicio, NEW.data_horario_fim, NEW.fk_orcamento_id_orcamento, NEW.fk_estacao_id_estacao, NEW.fk_agendamento_status_id_agendamento_status, OLD.fk_agendamento_status_id_agendamento_status);
    END IF;
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_insert_orcamento`;

DELIMITER $$
	CREATE TRIGGER `tg_insert_orcamento` BEFORE INSERT ON orcamento
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_orcamento(NEW.id_orcamento, NEW.tempo_estimado, NEW.fk_estudio_id_estudio, NEW.fk_cliente_id_cliente, NEW.fk_artista_id_artista, NEW.fk_uso_materiais_id_uso_materiais, NEW.fk_complexidade_id_complexidade, NEW.fk_orcamento_status_id_orcamento_status);
		IF (NEW.fk_orcamento_status_id_orcamento_status != 4 AND NEW.fk_orcamento_status_id_orcamento_status != 3 AND NEW.valor IS NOT NULL AND NEW.tempo_estimado IS NOT NULL)
			THEN SET NEW.fk_orcamento_status_id_orcamento_status = 2;
		END IF;
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_update_orcamento`;

DELIMITER $$
	CREATE TRIGGER `tg_update_orcamento` BEFORE UPDATE ON orcamento
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_orcamento(NEW.id_orcamento, NEW.tempo_estimado, NEW.fk_estudio_id_estudio, NEW.fk_cliente_id_cliente, NEW.fk_artista_id_artista, NEW.fk_uso_materiais_id_uso_materiais, NEW.fk_complexidade_id_complexidade, NEW.fk_orcamento_status_id_orcamento_status);
		IF (NEW.fk_orcamento_status_id_orcamento_status != 4 AND NEW.fk_orcamento_status_id_orcamento_status != 3 AND NEW.valor IS NOT NULL AND NEW.tempo_estimado IS NOT NULL)
			THEN SET NEW.fk_orcamento_status_id_orcamento_status = 2;
		END IF;
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_insert_artista_estudio`;

DELIMITER $$
	CREATE TRIGGER `tg_insert_artista_estudio` BEFORE INSERT ON artista_estudio
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_data_artista_estudio(NEW.data_inicio, NEW.data_fim);
    END $$
DELIMITER ;

DROP TRIGGER IF EXISTS `tg_update_artista_estudio`;

DELIMITER $$
	CREATE TRIGGER `tg_update_artista_estudio` BEFORE UPDATE ON artista_estudio
    FOR EACH ROW 
    BEGIN
		CALL prc_valida_data_artista_estudio(NEW.data_inicio, NEW.data_fim);
    END $$
DELIMITER ;

