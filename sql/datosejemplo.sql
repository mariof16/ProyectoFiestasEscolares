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

--TODAS LAS CONTRASEÑAS DE LAS CUENTAS SON 1234 COMO EJEMPLO

-- Volcando datos para la tabla proyectosevg_BD1-06.ACT_Actividades: ~4 rows (aproximadamente)
INSERT INTO `ACT_Actividades` (`id`, `nombre`, `genero`, `descripcion`, `fecha_fin`, `nMaxAlumnos`, `id_momento`) VALUES
	(29, 'Villancicos', 'X', 'Actividad para cantar villancicos', '2024-06-07', 3, 21),
	(30, 'Postal', 'X', 'Postal de navidad', '2024-06-07', 5, 21),
	(31, 'Futbol Masculino', 'M', 'Futbol', '2024-06-27', 7, 22),
	(32, 'Futbol Femenino', 'F', 'Futbol', '2024-06-20', 7, 22);

-- Volcando datos para la tabla proyectosevg_BD1-06.ACT_Inscripciones: ~24 rows (aproximadamente)
INSERT INTO `ACT_Inscripciones` (`id`, `id_alumno`, `id_actividad`, `fecha_hora`) VALUES
	(61, 3, 29, '2024-06-06 16:25:56'),
	(62, 50, 29, '2024-06-06 16:25:56'),
	(63, 53, 29, '2024-06-06 16:25:56'),
	(64, 3, 30, '2024-06-06 16:26:03'),
	(65, 50, 30, '2024-06-06 16:26:03'),
	(66, 53, 30, '2024-06-06 16:26:03'),
	(67, 65, 30, '2024-06-06 16:26:14'),
	(68, 62, 30, '2024-06-06 16:26:14'),
	(69, 3, 31, '2024-06-06 16:26:24'),
	(70, 53, 31, '2024-06-06 16:26:24'),
	(71, 59, 31, '2024-06-06 16:26:24'),
	(72, 65, 31, '2024-06-06 16:26:24'),
	(73, 50, 32, '2024-06-06 16:26:30'),
	(74, 62, 32, '2024-06-06 16:26:30'),
	(75, 56, 32, '2024-06-06 16:26:30'),
	(76, 1, 29, '2024-06-06 16:26:48'),
	(77, 54, 29, '2024-06-06 16:26:48'),
	(78, 63, 29, '2024-06-06 16:26:49'),
	(79, 51, 30, '2024-06-06 16:26:53'),
	(80, 1, 31, '2024-06-06 16:27:01'),
	(81, 4, 31, '2024-06-06 16:27:01'),
	(82, 63, 31, '2024-06-06 16:27:01'),
	(83, 57, 31, '2024-06-06 16:27:01'),
	(84, 60, 32, '2024-06-06 16:27:07');

-- Volcando datos para la tabla proyectosevg_BD1-06.ACT_Momentos: ~3 rows (aproximadamente)
INSERT INTO `ACT_Momentos` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`) VALUES
	(21, 'Navidad', '2024-06-01', '2024-06-16'),
	(22, 'Fiestas Escolares', '2024-06-20', '2024-06-28'),
	(23, 'Semana Ignaciana', '2024-07-06', '2024-07-20');

-- Volcando datos para la tabla proyectosevg_BD1-06.Alumnos: ~23 rows (aproximadamente)
INSERT INTO `Alumnos` (`idAlumno`, `NIA`, `nombre`, `DNI`, `idSeccion`, `correo`, `sexo`, `telefono`, `telefonoUrgencia`, `fechaNacimiento`, `created_at`, `updated_at`) VALUES
	(1, 1001, 'Luis Fernández', '12345678A', 1, 'luis.fernandez@example.com', 'M', '600111222', '600333444', '2005-04-23', '2024-05-25 15:50:12', '2024-05-25 15:50:36'),
	(2, 1002, 'Ana Martín', '23456789B', 2, 'ana.martin@example.com', 'F', '600555666', '600777888', '2004-11-15', '2024-05-25 15:50:12', '2024-05-25 15:50:37'),
	(3, 1003, 'Pedro Fuentes', '34567890C', 3, 'pedro.sanchez@example.com', 'M', '600999000', '600111333', '2003-07-30', '2024-05-25 15:50:12', '2024-05-29 07:17:55'),
	(4, 1004, 'Mario Sánchez', '34567890C', 1, 'pedro.sanchez@example.com', 'M', '600999000', '600111333', '2003-07-30', '2024-05-25 15:50:12', '2024-05-29 07:18:06'),
	(48, 1011, 'Elena Rodríguez', '12345678K', 1, 'elena.rodriguez@example.com', 'F', '600111222', '600333444', '2005-06-12', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(49, 1012, 'Javier García', '23456789L', 2, 'javier.garcia@example.com', 'M', '600444555', '600666777', '2003-10-25', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(50, 1013, 'Marina López', '34567890M', 3, 'marina.lopez@example.com', 'F', '600777888', '600999000', '2004-07-05', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(51, 1014, 'Pablo Martínez', '45678901N', 1, 'pablo.martinez@example.com', 'M', '600222333', '600444555', '2005-02-18', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(52, 1015, 'Lucía Fernández', '56789012O', 2, 'lucia.fernandez@example.com', 'F', '600555666', '600777888', '2003-04-30', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(53, 1016, 'Diego Pérez', '67890123P', 3, 'diego.perez@example.com', 'M', '600888999', '600111222', '2004-09-22', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(54, 1017, 'Sara Martín', '78901234Q', 1, 'sara.martin@example.com', 'F', '600333444', '600555666', '2005-11-08', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(55, 1018, 'Carlos Sánchez', '89012345R', 2, 'carlos.sanchez@example.com', 'M', '600666777', '600888999', '2003-08-14', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(56, 1019, 'Paula Gómez', '90123456S', 3, 'paula.gomez@example.com', 'F', '600999000', '600111222', '2004-01-03', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(57, 1020, 'Juan López', '01234567T', 1, 'juan.lopez@example.com', 'M', '600444555', '600666777', '2005-07-17', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(58, 1021, 'Ana Rodríguez', '12345678U', 2, 'ana.rodriguez@example.com', 'F', '600777888', '600999000', '2003-12-29', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(59, 1022, 'Pedro García', '23456789V', 3, 'pedro.garcia@example.com', 'M', '600111222', '600333444', '2004-04-14', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(60, 1023, 'Eva Martínez', '34567890W', 1, 'eva.martinez@example.com', 'F', '600555666', '600777888', '2005-09-03', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(61, 1024, 'Miguel Sánchez', '45678901X', 2, 'miguel.sanchez@example.com', 'M', '600888999', '600111222', '2003-02-08', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(62, 1025, 'Carmen Gómez', '56789012Y', 3, 'carmen.gomez@example.com', 'F', '600333444', '600555666', '2004-06-25', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(63, 1026, 'Antonio López', '67890123Z', 1, 'antonio.lopez@example.com', 'M', '600777888', '600999000', '2005-01-11', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(64, 1027, 'Sandra Rodríguez', '78901234A', 2, 'sandra.rodriguez@example.com', 'F', '600111222', '600333444', '2003-07-20', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(65, 1028, 'Luis García', '89012345A', 3, 'luis.garcia@example.com', 'M', '600444555', '600666777', '2004-05-07', '2024-06-01 17:51:40', '2024-06-01 17:51:40'),
	(66, 1029, 'María Martínez', '90123456A', 1, 'maria.martinez@example.com', 'F', '600777888', '600999000', '2005-10-14', '2024-06-01 17:51:40', '2024-06-01 17:51:40');

-- Volcando datos para la tabla proyectosevg_BD1-06.Cursos: ~3 rows (aproximadamente)
INSERT INTO `Cursos` (`idCurso`, `codCurso`, `idCursoColegio`, `nombre`, `idEtapa`, `created_at`, `updated_at`) VALUES
	(1, '1ESO', '1E1', '1º de ESO', 2, '2024-05-25 15:44:27', '2024-05-25 15:44:27'),
	(2, '2ESO', '2E1', '2º de ESO', 2, '2024-05-25 15:44:27', '2024-05-25 15:44:27'),
	(3, '3CFGS', '3C1', '3º de CFGS', 1, '2024-05-25 15:44:27', '2024-05-25 15:44:27');

-- Volcando datos para la tabla proyectosevg_BD1-06.Etapas: ~2 rows (aproximadamente)
INSERT INTO `Etapas` (`idEtapa`, `codEtapa`, `nombre`, `idCoordinador`, `created_at`, `updated_at`) VALUES
	(1, 'CFGS', 'Ciclo Formativo de Grado Superior', 1, '2024-05-25 15:44:27', '2024-05-25 15:44:27'),
	(2, 'ESO', 'Educación Secundaria Obligatoria', 1, '2024-05-25 15:44:27', '2024-05-25 15:44:27');

-- Volcando datos para la tabla proyectosevg_BD1-06.Perfiles: ~3 rows (aproximadamente)
INSERT INTO `Perfiles` (`idPerfil`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
	(1, 'Coordinador', 'Perfil con acceso total', '2024-05-25 15:43:45', '2024-05-25 15:43:45'),
	(2, 'Tutor', 'Perfil con acceso a su clase', '2024-05-25 15:43:45', '2024-05-25 15:43:45'),
	(3, 'Profesor', 'Perfil con acceso al listado', '2024-05-25 15:43:45', '2024-05-25 15:43:45');

-- Volcando datos para la tabla proyectosevg_BD1-06.Perfiles_Usuarios: ~4 rows (aproximadamente)
INSERT INTO `Perfiles_Usuarios` (`idPerfil`, `idUsuario`, `created_at`, `updated_at`) VALUES
	(1, 1, '2024-05-25 15:44:26', '2024-05-25 15:44:26'),
	(2, 2, '2024-05-25 15:44:26', '2024-05-25 15:44:26'),
	(2, 3, '2024-05-25 15:44:26', '2024-05-25 15:48:15'),
	(2, 4, '2024-05-25 15:44:26', '2024-05-25 15:48:15'),
	(3, 5, '2024-05-25 15:44:26', '2024-05-25 15:48:15');

-- Volcando datos para la tabla proyectosevg_BD1-06.Secciones: ~3 rows (aproximadamente)
INSERT INTO `Secciones` (`idSeccion`, `codSeccion`, `idSeccionColegio`, `nombre`, `idTutor`, `idCurso`, `created_at`, `updated_at`) VALUES
	(1, '1ESOA', '1E1A', '1º ESO Sección A', 2, 1, '2024-05-25 15:49:33', '2024-05-25 15:53:00'),
	(2, '2ESOB', '2E1B', '2º ESO Sección B', 3, 2, '2024-05-25 15:49:33', '2024-05-25 15:53:02'),
	(3, '3CFGS', '3C1', '3º CFGS Sección Única', 4, 3, '2024-05-25 15:49:33', '2024-05-25 15:53:04');

-- Volcando datos para la tabla proyectosevg_BD1-06.Usuarios: ~5 rows (aproximadamente)
INSERT INTO `Usuarios` (`idUsuario`, `nombre`, `correo`, `bajaTemporal`, `created_at`, `updated_at`, `contrasenia`) VALUES
	(1, 'Juan Pérez', 'juan.perez@example.com', b'0', '2024-05-25 15:43:46', '2024-06-06 20:13:04', '$2y$10$wF8z3eR/p7AB.OPmTgnKIerLqxmAfJCVUhx.ocVvGRfvcuu82kmmu'),
	(2, 'María López', 'maria.lopez@example.com', b'0', '2024-05-25 15:43:46', '2024-06-06 20:13:05', '$2y$10$wF8z3eR/p7AB.OPmTgnKIerLqxmAfJCVUhx.ocVvGRfvcuu82kmmu'),
	(3, 'Carlos García', 'carlos.garcia@example.com', b'0', '2024-05-25 15:43:46', '2024-06-06 20:13:06', '$2y$10$wF8z3eR/p7AB.OPmTgnKIerLqxmAfJCVUhx.ocVvGRfvcuu82kmmu'),
	(4, 'Mario Fuentes', 'mario.fuentes@example.com', b'0', '2024-05-25 15:44:26', '2024-06-06 20:13:06', '$2y$10$wF8z3eR/p7AB.OPmTgnKIerLqxmAfJCVUhx.ocVvGRfvcuu82kmmu'),
	(5, 'Mario Fuentes2', 'mario.fuentes2@example.com', b'0', '2024-05-25 15:44:26', '2024-06-06 20:13:07', '$2y$10$wF8z3eR/p7AB.OPmTgnKIerLqxmAfJCVUhx.ocVvGRfvcuu82kmmu');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
