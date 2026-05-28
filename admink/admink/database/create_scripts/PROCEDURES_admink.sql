-- PROCEDURES
USE admink;

DROP PROCEDURE IF EXISTS `prc_valida_pessoa`;

DELIMITER $$
	CREATE PROCEDURE `prc_valida_pessoa`(email VARCHAR(60), data_nascimento DATE)
    BEGIN
		IF fn_valida_email(email) = 0
			THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'E-mail inválido';
        END IF;
        IF data_nascimento IS NOT NULL
			THEN IF fn_valida_data_nascimento(data_nascimento) = 0
					THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Data de nascimento inválida: Idade deve ser maior que 16 anos.';
				END IF;
		END IF;
    END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS `prc_valida_usuario`;

DELIMITER $$
	CREATE PROCEDURE `prc_valida_usuario`(email VARCHAR(60))
    BEGIN
        IF fn_valida_email(email) = 0
			THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'E-mail inválido';
        END IF;
    END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS prc_valida_agendamento;

DELIMITER $$
	CREATE PROCEDURE `prc_valida_agendamento` (p_data_horario_inicio DATETIME, p_data_horario_fim DATETIME, p_id_orcamento INT, p_id_estacao INT, p_id_agendamento_status INT, p_old_id_agendamento_status INT)
    BEGIN
		DECLARE v_conflitos INT DEFAULT 0; # Contador de conflitos
		DECLARE v_id_artista INT;  # Variável para id do artista
        DECLARE v_id_estudio INT;  # Variável para id do estudio
        DECLARE estacao_ativa INT DEFAULT 0; # Variável para id da estacao
		DECLARE agendamento_status_valido INT DEFAULT 0; # Variável para verificar se status do agendamento é valido

        # Alocar id do artista do orçamento na variável v_id_artista
        SELECT o.fk_artista_id_artista INTO v_id_artista FROM orcamento AS o
        WHERE o.id_orcamento = p_id_orcamento;

        # Alocar id do estudio do orcamento na variavel v_id_estudio
        SELECT o.fk_estudio_id_estudio INTO v_id_estudio FROM orcamento AS o
        WHERE o.id_orcamento = p_id_orcamento;

        # Conferir na tabela estacao se a estacao do agendamento existe, está ativa e é do mesmo estúdio do orçamento
		SELECT e.ativa INTO estacao_ativa FROM estacao AS e
        WHERE e.id_estacao = p_id_estacao
        AND e.deleted_at IS NULL
        AND e.fk_estudio_id_estudio = v_id_estudio;

        # Conferir na tabela agendamento_status se o status do agendamento existe
		SELECT COUNT(*) INTO agendamento_status_valido FROM agendamento_status AS a
        WHERE  a.id_agendamento_status = p_id_agendamento_status
        AND deleted_at IS NULL;

        # Conferir se horário do agendamento está disponível para aquele artista e para aquela estação
        SELECT COUNT(*) INTO v_conflitos FROM agendamento AS a
        INNER JOIN orcamento AS o
        ON (a.fk_orcamento_id_orcamento = o.id_orcamento)
        WHERE (p_id_estacao = fk_estacao_id_estacao OR v_id_artista = fk_artista_id_artista)
        AND (data_horario_fim >= p_data_horario_inicio AND data_horario_inicio <= p_data_horario_fim)
        AND a.fk_agendamento_status_id_agendamento_status = 1
        AND a.deleted_at IS NULL;

        # Retorna mensagem de erro conforme as verificações do agendamento realizadas
        IF estacao_ativa != 1
            THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A estação de trabalho deve ser uma estação ativa do estúdio.';
			ELSEIF agendamento_status_valido != 1
				THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O status do agendamento deve ser um status de agendamento ativo do estúdio.';
				ELSEIF  (p_old_id_agendamento_status = 2 AND p_id_agendamento_status != 2) OR (p_old_id_agendamento_status = 3 AND p_id_agendamento_status != 3)
					THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Não é possível editar o status de um agendamento cancelado ou finalizado.';
					ELSEIF TIMESTAMPDIFF(SECOND, p_data_horario_inicio, p_data_horario_fim) <= 0
						THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A data e horário de fim deve ser maior que a data e horário de início.';
						ELSEIF DATEDIFF(p_data_horario_fim, p_data_horario_inicio) != 0
							THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O início e fim do agendamento devem ser na mesma data.';
							ELSEIF v_conflitos > 0
								THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Horário indisponível na data informada.';
		END IF;
    END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `prc_valida_orcamento`;

DELIMITER $$
	CREATE PROCEDURE `prc_valida_orcamento` (p_id_orcamento INT, p_tempo_estimado DATETIME, p_id_estudio INT, p_id_cliente INT, p_id_artista INT, p_id_uso_materiais INT, p_id_complexidade INT, p_id_orcamento_status INT)
    BEGIN
    
        DECLARE cliente_do_estudio INT DEFAULT 0;
        DECLARE artista_do_estudio INT DEFAULT 0;
        DECLARE uso_materiais_valido INT DEFAULT 0;
        DECLARE complexidade_valida INT DEFAULT 0;
        DECLARE orcamento_status_valido INT DEFAULT 0;
        DECLARE agendamento_finalizado INT DEFAULT 0;

        # Verifica se o cliente está cadastrado no estúdio na tabela cliente_estudio
        SELECT COUNT(*) INTO cliente_do_estudio FROM cliente_estudio
        WHERE ativo = 1
        AND deleted_at IS NULL
        AND fk_estudio_id_estudio = p_id_estudio
        AND fk_cliente_id_cliente = p_id_cliente;

        # Verifica se o artista está cadastrado no estúdio na tabela artista_estudio
        SELECT COUNT(*) INTO artista_do_estudio FROM artista_estudio
        WHERE ativo = 1
        AND deleted_at IS NULL
        AND fk_estudio_id_estudio = p_id_estudio
        AND fk_artista_id_artista = p_id_artista;

        # Verifica se o uso de materiais está cadastrado na tabela uso_materiais
        SELECT COUNT(*) INTO uso_materiais_valido FROM uso_materiais
        WHERE deleted_at IS NULL
        AND p_id_uso_materiais  = id_uso_materiais;

        # Verifica se a complexidade está cadastrada na tabela complexidade
        SELECT COUNT(*) INTO complexidade_valida FROM complexidade
        WHERE deleted_at IS NULL
        AND p_id_complexidade  = id_complexidade;

        #verifica se o status do orcamento está cadastrado na tabela orcamento_status
        SELECT COUNT(*) INTO orcamento_status_valido FROM orcamento_status
        WHERE deleted_at IS NULL
        AND p_id_orcamento_status = id_orcamento_status;
        
        
        SELECT COUNT(*) INTO agendamento_finalizado FROM agendamento a
        WHERE a.fk_orcamento_id_orcamento = p_id_orcamento
        AND a.fk_agendamento_status_id_agendamento_status = 2;
        

        # Retorna mensagem de erro conforme as verificações do orçamento realizadas
        IF p_id_orcamento_status = 3 AND p_tempo_estimado IS NULL
            THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O campo tempo estimado não pode ser nulo para orçamento agendado.';
        END IF;
        IF cliente_do_estudio != 1 
            THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O cliente deve ser cliente ativo do estúdio.';
			ELSEIF artista_do_estudio != 1
				THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O artista deve ser artista ativo do estúdio.';
				ELSEIF p_id_uso_materiais IS NOT NULL AND uso_materiais_valido != 1
					THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O uso de materiais deve ser uso ativo do estúdio.';
					ELSEIF p_id_complexidade IS NOT NULL AND complexidade_valida != 1
						THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A complexidade deve ser complexidade ativa do estúdio.';
						ELSEIF orcamento_status_valido != 1
							THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'O status do orcamento deve ser status ativo do estúdio.';
                            ELSEIF p_id_orcamento_status = 4  AND agendamento_finalizado != 0
								THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Não é possível cancelar um orçamento que possui agendamentos finalizados.';
		END IF;
    END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `prc_valida_data_artista_estudio`;

DELIMITER $$
	CREATE PROCEDURE `prc_valida_data_artista_estudio`(data_inicio DATE, data_fim DATE)
    BEGIN
        IF data_fim IS NOT NULL
			THEN IF data_fim < data_inicio
					THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A data de fim do artista deve ser maior ou igual a data de início.';
                    ELSEIF data_fim > CURRENT_DATE()
                    THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A data de fim do artista deve ser menor ou igual a data atual.';
                        ELSEIF data_inicio < '2017-01-01'
                         THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'A data de início do artista deve ser superior a data de criação do estúdio.';
				END IF;
                
		END IF;
    END $$
DELIMITER ;
