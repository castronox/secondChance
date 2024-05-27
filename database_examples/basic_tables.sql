-- Base de datos limpia para fastlight

-- se incluye:
--  la tabla para usuarios, con algunos usuarios para pruebas.
--  la tabla errores, permite registrar los errores de la aplicación en BDD.

DROP DATABASE IF EXISTS fastlight;

CREATE DATABASE fastlight DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE fastlight;

-- tabla users
-- podéis crear los campos adicionales que necesitéis.
CREATE TABLE users(
	id INT PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(128) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
	password VARCHAR(32) NOT NULL,
	roles JSON NOT NULL,
	picture VARCHAR(256) DEFAULT NULL,
	blocked_at TIMESTAMP NULL DEFAULT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);


-- usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(displayname, email, phone, password, roles) VALUES 
	('admin', 'admin@fastlight.com', '666666666', md5('1234'), '["ROLE_USER", "ROLE_ADMIN"]'),
	('editor', 'editor@fastlight.com', '666666665', md5('1234'), '["ROLE_USER", "ROLE_EDITOR"]'),
	('user', 'user@fastlight.com', '666666664', md5('1234'), '["ROLE_USER"]'),
	('test', 'test@fastlight.com', '666666663', md5('1234'), '["ROLE_USER"]'),
	('api', 'api@fastlight.com', '666666662', md5('1234'), '["ROLE_API"]')
;


-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(256) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
);


