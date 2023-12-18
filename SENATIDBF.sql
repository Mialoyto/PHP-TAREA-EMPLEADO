CREATE DATABASE SENATIDB;

USE SENATIDB;

# ---------------------------------------------- TABLAS DE LA BASE DE DATOS ----------------------------------------------
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
    
CREATE TABLE tb_sedes(
	idsede		INT AUTO_INCREMENT PRIMARY KEY,
    sede		VARCHAR(100)	NOT NULL,
    
	create_at 	DATETIME 	NOT NULL DEFAULT NOW(),
    inactive_at DATETIME 	NULL,
    update_at	DATETIME 	NULL,
    
    CONSTRAINT uk_sede	UNIQUE(sede)
)
ENGINE = INNODB;

CREATE TABLE tb_empleados(
	idempleado		INT AUTO_INCREMENT PRIMARY KEY,
    idsede			INT			NOT NULL,
    apellidos		VARCHAR(60)	NOT NULL,
    nombres			VARCHAR(60)	NOT NULL,
    nrodoc			CHAR(8)		NOT NULL,
    fechanac		DATE	 	NOT NULL,
    telefono		CHAR(9)		NULL,
    
	create_at 	DATETIME 		NOT NULL DEFAULT NOW(),
    inactive_at DATETIME NULL,
    update_at	DATETIME NULL,

	CONSTRAINT fk_idsede_emp 	FOREIGN KEY (idsede)	REFERENCES tb_sedes(idsede),
    CONSTRAINT uk_nrodoc_emp	UNIQUE(nrodoc)
)
ENGINE = INNODB;
    
 #---------------------------------------------- PROCEDIMIENTOS ALMACENADOS ----------------------------------------------
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
    
CALL spu_vehiculos_buscar ('ABC-111');

 
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
        
        SELECT @@LAST_INSERT_ID 'idvehiculo';
END $$


CALL spu_vehiculos_registrar (5,'Modelo 1','Rojo','DSL',1500,'2023','ABC-116');
CALL spu_vehiculos_registrar (5,'Modelo 2','Azul','GSL',2900,'2024','ABC-117');
CALL spu_vehiculos_registrar (5,'Santa Fe','Negro|','DSL',1500,'2022','ABC-118');
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

    
DELIMITER $$
CREATE PROCEDURE spu_sedes_registrar
(
	IN _sede	VARCHAR(100)
)
BEGIN
INSERT INTO tb_sedes
			(sede) VALUES (_sede);
END $$
CALL spu_sedes_registrar ('CHINCHA ALTA');
CALL spu_sedes_registrar ('CHINCHA BAJA');
CALL spu_sedes_registrar ('GROCIO PRADO');
CALL spu_sedes_registrar ('PUEBLO NUEVO');
    
    
DELIMITER $$
CREATE PROCEDURE spu_sedes_listar ()
BEGIN
	SELECT
		idsede,
		sede
    FROM tb_sedes
	WHERE inactive_at IS NULL
    ORDER BY sede;
END $$
CALL spu_sedes_listar ();
    
    
DELIMITER $$
CREATE PROCEDURE spu_empleados_listar
(
)
BEGIN
	SELECT 
    SED.sede,
    EMP.apellidos,
    EMP.nombres,
    EMP.nrodoc,
    EMP.fechanac,
    EMP.telefono
    
    FROM tb_empleados EMP
    INNER JOIN tb_sedes SED	ON SED.idsede = EMP.idsede
	WHERE (EMP.inactive_at IS NULL);
END $$
CALL spu_empleados_listar;



DELIMITER $$
CREATE PROCEDURE spu_empleados_registrar
(
	IN _idsede			INT,
    IN _apellidos		VARCHAR(60),
    IN _nombres			VARCHAR(60),
    IN _nrodoc			CHAR(8),
    IN _fechanac		DATETIME,
    IN _telefono		CHAR(9)
)
BEGIN
	INSERT INTO tb_empleados
		(idsede,apellidos,nombres,nrodoc,fechanac,telefono)
			VALUES (_idsede,_apellidos,_nombres,_nrodoc,_fechanac,_telefono);
		SELECT @@LAST_INSERT_ID 'idempleado';
END $$
CALL spu_empleados_registrar (1,'LOYOLA TORRES','ALEX','12345678','1999-09-16','123456789');
CALL spu_empleados_registrar (2,'LOYOLA TORRES','MIGUEL','12345677','1999-10-17','123456780');
CALL spu_empleados_registrar (3,'LOYOLA TORRES','JOSE','12345676','1999-11-18','123456781');
  

DELIMITER $$
CREATE PROCEDURE spu_empleados_buscar
(
	IN _nrodoc	CHAR(8)	
)
BEGIN
	SELECT 
    SED.sede,
    EMP.apellidos,
    EMP.nombres,
    EMP.nrodoc,
    EMP.fechanac,
    EMP.telefono
    
    FROM tb_empleados EMP
    INNER JOIN tb_sedes SED	ON SED.idsede = EMP.idsede
	WHERE (EMP.inactive_at IS NULL) AND
	(EMP.nrodoc = _nrodoc);
END $$
CALL spu_empleados_buscar ('12345678');

-- consultas de resumen ( campos redundantes)

DELIMITER $$
CREATE PROCEDURE spu_resumen_tipocombustible()
BEGIN
SELECT
		tipocombustible, count(tipocombustible) AS 'total'
        FROM vehiculos
		GROUP BY tipocombustible
        ORDER BY tipocombustible;
END $$
    


-- ALTER TABLE tb_empleados DROP FOREIGN KEY fk_idsede_emp;
-- DROP TABLE tb_empleados;
-- ALTER TABLE tb_empleados AUTO_INCREMENT 1;



    
SELECT * FROM marcas;
SELECT * FROM vehiculos;
SELECT * FROM tb_empleados;
SELECT * FROM tb_sedes;
CALL spu_empleados_listar


SELECT * FROM tb_empleados INNER JOIN tb_sedes ON  tb_empleados.idsede =tb_sedes.idsede