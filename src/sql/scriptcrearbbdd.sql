-- --------------------------------------------------------
-- Host:                         proyectos.esvirgua.com
-- Versión del servidor:         8.0.37 - MySQL Community Server - GPL
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla proyectosevg_BD1-06.ACT_Actividades
CREATE TABLE IF NOT EXISTS `ACT_Actividades` (
  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `genero` char(1) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_fin` date NOT NULL,
  `nMaxAlumnos` tinyint unsigned NOT NULL,
  `id_momento` tinyint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ACT_Actividades_ibfk_1` (`id_momento`),
  CONSTRAINT `ACT_Actividades_ibfk_1` FOREIGN KEY (`id_momento`) REFERENCES `ACT_Momentos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.ACT_Inscripciones
CREATE TABLE IF NOT EXISTS `ACT_Inscripciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_alumno` int unsigned NOT NULL,
  `id_actividad` smallint unsigned NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_alumno_id_actividad` (`id_alumno`,`id_actividad`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_actividad` (`id_actividad`),
  CONSTRAINT `ACT_Inscripciones_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `Alumnos` (`idAlumno`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ACT_Inscripciones_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `ACT_Actividades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.ACT_Momentos
CREATE TABLE IF NOT EXISTS `ACT_Momentos` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.Alumnos
CREATE TABLE IF NOT EXISTS `Alumnos` (
  `idAlumno` int unsigned NOT NULL AUTO_INCREMENT,
  `NIA` int unsigned NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `DNI` char(9) DEFAULT NULL,
  `idSeccion` smallint unsigned NOT NULL,
  `correo` varchar(60) DEFAULT NULL,
  `sexo` enum('M','F','NB') NOT NULL,
  `telefono` char(9) DEFAULT NULL,
  `telefonoUrgencia` char(9) DEFAULT NULL,
  `fechaNacimiento` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAlumno`),
  UNIQUE KEY `NIA` (`NIA`),
  KEY `idSeccion` (`idSeccion`),
  CONSTRAINT `Alumnos_ibfk_1` FOREIGN KEY (`idSeccion`) REFERENCES `Secciones` (`idSeccion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.Cursos
CREATE TABLE IF NOT EXISTS `Cursos` (
  `idCurso` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `codCurso` char(5) NOT NULL,
  `idCursoColegio` char(5) DEFAULT NULL,
  `nombre` varchar(70) DEFAULT NULL,
  `idEtapa` tinyint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCurso`),
  UNIQUE KEY `codCurso` (`codCurso`),
  KEY `idEtapa` (`idEtapa`),
  CONSTRAINT `Cursos_ibfk_1` FOREIGN KEY (`idEtapa`) REFERENCES `Etapas` (`idEtapa`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.Etapas
CREATE TABLE IF NOT EXISTS `Etapas` (
  `idEtapa` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `codEtapa` char(5) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `idCoordinador` smallint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idEtapa`),
  UNIQUE KEY `codEtapa` (`codEtapa`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `idCoordinador` (`idCoordinador`),
  CONSTRAINT `Etapas_ibfk_1` FOREIGN KEY (`idCoordinador`) REFERENCES `Usuarios` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.Perfiles
CREATE TABLE IF NOT EXISTS `Perfiles` (
  `idPerfil` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.Perfiles_Usuarios
CREATE TABLE IF NOT EXISTS `Perfiles_Usuarios` (
  `idPerfil` tinyint unsigned NOT NULL,
  `idUsuario` smallint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPerfil`,`idUsuario`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `Perfiles_Usuarios_ibfk_1` FOREIGN KEY (`idPerfil`) REFERENCES `Perfiles` (`idPerfil`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Perfiles_Usuarios_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.Secciones
CREATE TABLE IF NOT EXISTS `Secciones` (
  `idSeccion` smallint unsigned NOT NULL AUTO_INCREMENT,
  `codSeccion` char(8) NOT NULL,
  `idSeccionColegio` char(8) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `idTutor` smallint unsigned DEFAULT NULL,
  `idCurso` tinyint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idSeccion`),
  UNIQUE KEY `codSeccion` (`codSeccion`),
  KEY `idTutor` (`idTutor`),
  KEY `idCurso` (`idCurso`),
  CONSTRAINT `Secciones_ibfk_1` FOREIGN KEY (`idTutor`) REFERENCES `Usuarios` (`idUsuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `Secciones_ibfk_2` FOREIGN KEY (`idCurso`) REFERENCES `Cursos` (`idCurso`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proyectosevg_BD1-06.Usuarios
CREATE TABLE IF NOT EXISTS `Usuarios` (
  `idUsuario` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `bajaTemporal` bit(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `contrasenia` varchar(255) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
