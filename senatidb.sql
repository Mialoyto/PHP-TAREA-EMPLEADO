CREATE DATABASE SENATIDB;

USE SENATIDB;


CREATE TABLE marcas
(
	idmarca 	INT AUTO_INCREMENT PRIMARY KEY,
    marca		VARCHAR(30)		NOT NULL,
    
    create_at 	DATETIME 		NOT NULL DEFAULT NOW(),
    inactive_at DATETIME NULL,
    update_at	DATETIME NULL,
    
    CONSTRAINT uk_marca_mar UNIQUE (marca)
)
ENGINE = INNODB;

INSERT INTO marcas (marca)	
	VALUES
		('Toyota'),
		('Nissan'),
		('Volvo'),
		('Hyundai'),
		('KIA');
    
    
-- DELETE FROM vehiculos;
-- ALTER TABLE vehiculos auto_increment 1;
-- ALTER TABLE vehiculos ADD CONSTRAINT uk_placa_veh UNIQUE (placa);
CREATE TABLE vehiculos
(
	idvehiculo 		INT AUTO_INCREMENT PRIMARY KEY,
    idmarca 		INT				NOT NULL,
    modelo			VARCHAR(50)		NOT NULL,
    color			VARCHAR (30)	NOT NULL,
    tipocombustible	CHAR(3)			NOT NULL,
    peso			SMALLINT		NOT NULL,
    afabricacion	CHAR(4)			NOT NULL,
    placa			CHAR(7)			NOT NULL,
    
	create_at 	DATETIME 		NOT NULL DEFAULT NOW(),
    inactive_at DATETIME NULL,
    update_at	DATETIME NULL,
    
    CONSTRAINT fk_idmarca_vek	FOREIGN KEY (idmarca) REFERENCES marcas(idmarca),
    CONSTRAINT ck_tipocombustible_veh	CHECK (tipocombustible IN ('GSL','DSL','GNV')),
    CONSTRAINT ck_peso_veh	CHECK (peso > 0),
    CONSTRAINT uk_placa_veh UNIQUE (placa)
)
ENGINE = INNODB;
    
INSERT INTO vehiculos
	(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
	VALUES
		(1,'Hilux','blanco','DSL','1800','2020','ABC-111'),
		(2,'Sentra','gris','GSL','1200','2021','ABC-112'),
		(3,'EX30','negro','GNV','1350','2023','ABC-113'),
		(4,'Tucson','rojo','GSL','1800','2022','ABC-114'),
		(5,'Sportage','azul','DSL','1500','2012','ABC-115');
    
DELIMITER $$
    
CREATE PROCEDURE spu_vehiculos_buscar (IN _placa CHAR(7))
    BEGIN
    SELECT
		VEH.idvehiculo,
        MAR.marca,
        VEH.modelo,
        VEH.color,
        VEH.tipocombustible,
        VEH.peso,
        VEH.afabricacion,
        VEH.placa
        FROM vehiculos VEH
        INNER JOIN marcas MAR ON MAR.idmarca = VEH.idmarca
        WHERE (VEH.inactive_at IS NULL) AND
        (VEH.placa = _placa);
END $$
    
CALL spu_vehiculos_buscar;
    
    
    
    
    
DELIMITER $$
CREATE PROCEDURE spu_vehiculos_registrar(
IN _idmarca				INT,
IN _modelo				VARCHAR(50)	,
IN _color				VARCHAR (30),
IN _tipocombustible	  	CHAR(3)	,
IN _peso				SMALLINT,
IN _afabricacion		CHAR(4),
IN _placa				CHAR(7)	
)
BEGIN
	INSERT INTO vehiculos
		(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
        VALUES (_idmarca,_modelo,_color,_tipocombustible,_peso,_afabricacion,_placa);
        
        SELECT @@last_insert_id 'idvehiculo';
END $$



CAll spu_vehiculos_registrar (5,'Modelo 1','Rojo','DSL',1500,'2023','ABC-116');
CAll spu_vehiculos_registrar (5,'Santa Fe','Negro|','DSL',1500,'2022','ABC-118');

SELECT * FROM vehiculos;

DELIMITER $$
CREATE PROCEDURE spu_marcas_listar()
BEGIN
	SELECT
    idmarca,
    marca
	FROM marcas
    WHERE inactive_at IS NULL
    ORDER BY marca;
    
END $$

    
  
    

    
    


    
SELECT * FROM marcas;
select * from vehiculos;