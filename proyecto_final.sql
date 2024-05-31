-- elimina la base de datos "secondChance" si existe
DROP DATABASE IF EXISTS secondchance;

-- crea la nueva base de datos "secondChance"
CREATE DATABASE secondchance 
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- usa la base de datos "secondChance"
USE secondchance;

-- tabla users
-- podéis crear los campos adicionales que necesitéis.
CREATE TABLE users(
	id INT NOT NULL PRIMARY KEY auto_increment,
	displayname VARCHAR(32) NOT NULL,
	email VARCHAR(128) NOT NULL UNIQUE KEY,
	phone VARCHAR(32) NOT NULL UNIQUE KEY,
    poblacion VARCHAR(128) NOT NULL ,
    cp VARCHAR(14) NOT NULL ,
	password VARCHAR(32) NOT NULL,
	roles JSON NOT NULL DEFAULT '["ROLE_USER"]',
	picture VARCHAR(256) DEFAULT NULL,
	blocked_at TIMESTAMP NULL DEFAULT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- creación de la tabla "anuncios"
CREATE TABLE anuncios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  iduser INT NOT NULL,
  anyo INT NOT NULL COMMENT 'Año de adquisición',
  foto VARCHAR(256) NULL DEFAULT NULL COMMENT 'Nombre del fichero con la foto del anuncio',
  precio FLOAT NOT NULL DEFAULT 0 COMMENT 'precio de venta',
  estado VARCHAR(256) DEFAULT NULL COMMENT 'Como nuevo, reparable, Vintage', 
  
  FOREIGN KEY (iduser) REFERENCES users(id) 
		ON UPDATE CASCADE ON DELETE CASCADE
);

-- algunos usuarios para las pruebas, podéis crear tantos como necesitéis
INSERT INTO users(displayname, email, phone, poblacion, cp, password, roles) VALUES 
	('admin', 'admin@fastlight.com', '666666666','Manresa','08241', md5('1234'), 
		'["ROLE_USER", "ROLE_ADMIN"]'),
	('vendedo', 'vendor@fastlight.com', '666666665','Manresa','08241', md5('1234'), 
		'["ROLE_USER", "ROLE_VENDOR"]');

-- tabla errors
-- por si queremos registrar los errores en base de datos.
CREATE TABLE errors(
	id INT NOT NULL PRIMARY KEY auto_increment,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level VARCHAR(32) NOT NULL DEFAULT 'ERROR',
    url VARCHAR(256) NOT NULL,
	message VARCHAR(256) NOT NULL,
	user VARCHAR(128) DEFAULT NULL,
	ip CHAR(15) NOT NULL
);

