
CREATE TABLE CatalogoMovimientosRhParaImss(idMovRhImss INT PRIMARY KEY AUTO_INCREMENT,Desacripcion varchar(50));

select * from CatalogoMovimientosRhParaImss;

1	ALTA
2	CONFIRMACION POR RH
3	RECHAZO POR IMSS
4	REVISION POR RH
	
CREATE TABLE CatalogoRechazosPorImss(idRechazoImss INT PRIMARY KEY AUTO_INCREMENT,Desacripcion varchar(50));

ALTER TABLE CatalogoMovimientosRhParaImss ENGINE=InnoDB;

INSERT INTO `zonagif`.`CatalogoRechazosPorImss` (`idRechazoImss`, `Desacripcion`) VALUES ('1', 'NOMBRE');
INSERT INTO `zonagif`.`CatalogoRechazosPorImss` (`idRechazoImss`, `Desacripcion`) VALUES ('2', 'APELLIDO PATERNO');
INSERT INTO `zonagif`.`CatalogoRechazosPorImss` (`idRechazoImss`, `Desacripcion`) VALUES ('3', 'APELLIDO MATERNO');
INSERT INTO `zonagif`.`CatalogoRechazosPorImss` (`idRechazoImss`, `Desacripcion`) VALUES ('4', 'SEGURO SOCIAL');
INSERT INTO `zonagif`.`CatalogoRechazosPorImss` (`idRechazoImss`, `Desacripcion`) VALUES ('5', 'FOTOGRAFIA');

CREATE TABLE modificacioPorRh(idModRh INT PRIMARY KEY AUTO_INCREMENT,entidadEmpleado varchar(2),consecutivoEmpleado varchar(20),categoriaEmpleado varchar(2),idRechazoPorImss int,Fecha DATETIME,UsuarioEdit varchar(10), 
FOREIGN KEY(entidadEmpleado,consecutivoEmpleado,categoriaEmpleado) REFERENCES empleados(entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId),
FOREIGN KEY(idRechazoPorImss) REFERENCES CatalogoRechazosPorImss(idRechazoImss),
FOREIGN KEY(UsuarioEdit) REFERENCES usuarios(usuario));

select * from modificacioPorRh;

ALTER TABLE datosimss
ADD COLUMN idRechazado INT(11) DEFAULT NULL AFTER rpParaActualizar,
ADD COLUMN FechaConfirmacion DATETIME NULL AFTER idRechazado,
ADD COLUMN UsuarioConfirmacion VARCHAR(10) NULL AFTER FechaConfirmacion,
ADD COLUMN NumeroFirmaConfirmacion VARCHAR(20) NULL AFTER UsuarioConfirmacion,
ADD COLUMN ContraseniaFirmaConfirmacion VARCHAR(50) NULL AFTER NumeroFirmaConfirmacion,
ADD COLUMN FechaRechazoImss DATETIME NULL AFTER ContraseniaFirmaConfirmacion,
ADD COLUMN UsuarioRechazoImss VARCHAR(10) NULL AFTER FechaRechazoImss,
ADD COLUMN FechaRevision DATETIME NULL AFTER UsuarioRechazoImss,
ADD COLUMN UsuarioRevision VARCHAR(10) NULL AFTER FechaRevision,
ADD COLUMN NumeroFirmaRevision VARCHAR(20) NULL AFTER UsuarioRevision,
ADD COLUMN ContraseniaFirmaRevision VARCHAR(50) NULL AFTER NumeroFirmaRevision;

ALTER TABLE datosimss
ADD FOREIGN KEY (idRechazado) REFERENCES CatalogoMovimientosRhParaImss(idMovRhImss);

select * from empleados;

ALTER table empleados
ADD COLUMN FechaEditPorImss DATETIME DEFAULT NULL AFTER noGerenteRegAsignado ;