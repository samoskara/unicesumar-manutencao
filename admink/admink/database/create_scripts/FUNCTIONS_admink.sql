-- FUNCTIONS

SET GLOBAL log_bin_trust_function_creators = 1;
USE admink;

DROP FUNCTION IF EXISTS `fn_valida_email`;
DELIMITER $$
	CREATE FUNCTION `fn_valida_email` (email VARCHAR(100)) RETURNS TINYINT
    BEGIN
		DECLARE retorno_email TINYINT DEFAULT 0;
        IF (email REGEXP '(^[a-z0-9._%-]+@[a-z0-9.-]+\.[a-z]{2,4}$)')
			THEN SET retorno_email  = 1;
        END IF;
        RETURN retorno_email;
    END$$
DELIMITER ;

DROP FUNCTION IF EXISTS `fn_valida_data_nascimento`;
DELIMITER $$
	CREATE FUNCTION `fn_valida_data_nascimento` (data_nascimento DATE) RETURNS TINYINT
    BEGIN
		DECLARE retorno_data_nascimento TINYINT DEFAULT 0;
        DECLARE idade INT;
        SET idade = YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(data_nascimento)));
        IF YEAR (data_nascimento) > 1900 AND idade >= 16
			THEN SET retorno_data_nascimento  = 1;
        END IF;
        RETURN retorno_data_nascimento;
    END$$
DELIMITER ;
