<?php
require_once 'conexion.php';

/**
 * Clase MActividad que extiende la clase Conexion para manejar las actividades en la base de datos.
 */
class MActividad extends Conexion {
    
    /**
     * Método para obtener todas las actividades.
     * @return array Un array de todas las actividades y sus momentos asociados.
     */
    public function actividades() {  
        $sql = "SELECT ACT_Actividades.*, ACT_Momentos.nombre AS momento FROM ACT_Actividades
                LEFT JOIN ACT_Momentos ON ACT_Actividades.id_momento = ACT_Momentos.id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            array_push($datos, $fila);
        }

        $stmt->close();
        return $datos;
    }

    /**
     * Método para obtener los datos de una actividad específica.
     * @param int $id El ID de la actividad.
     * @return array Un array con los datos de la actividad.
     */
    public function datos_actividad($id) {
        $sql = "SELECT * FROM ACT_Actividades WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();

        $stmt->close();
        return $datos;
    }

    /**
     * Método para borrar una actividad.
     * @param int $id El ID de la actividad a borrar.
     * @return bool True si se borra correctamente, False en caso contrario.
     */
    public function borrar_actividad($id) {
        $sql = "DELETE FROM ACT_Actividades WHERE id = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Método para insertar una nueva actividad.
     * @param string $nombre El nombre de la actividad.
     * @param string $genero El género de la actividad.
     * @param string $fechaFin La fecha de finalización de la actividad.
     * @param int $momento El ID del momento asociado (puede ser null).
     * @param string $descripcion La descripción de la actividad.
     * @param int $nmaxalumnos El número máximo de alumnos.
     * @return bool True si se inserta correctamente, False en caso de error.
     */
    public function insertar_actividad($nombre, $genero, $fechaFin, $momento, $descripcion, $nmaxalumnos) {
        $sql = "INSERT INTO ACT_Actividades (nombre, genero, fecha_fin, descripcion, nMaxAlumnos";
        if ($momento == 'null') {
            $sql .= ") VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssssi', $nombre, $genero, $fechaFin, $descripcion, $nmaxalumnos);
        } else {
            $sql .= ", id_momento) VALUES (?, ?, ?, ?, ?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssssii', $nombre, $genero, $fechaFin, $descripcion, $nmaxalumnos, $momento);
        }

        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                return false;
            } else {
                return false;
            }
        }
    }

    /**
     * Método para modificar una actividad existente.
     * @param int $id El ID de la actividad a modificar.
     * @param string $nombre El nombre de la actividad.
     * @param string $genero El género de la actividad.
     * @param string $fechaFin La fecha de finalización de la actividad.
     * @param int $momento El ID del momento asociado (puede ser null).
     * @param string $descripcion La descripción de la actividad.
     * @param int $nmaxalumnos El número máximo de alumnos.
     * @return bool True si se modifica correctamente, False en caso de error.
     */
    public function modificar_actividad($id, $nombre, $genero, $fechaFin, $momento, $descripcion, $nmaxalumnos) {
        $sql = "UPDATE ACT_Actividades SET nombre = ?, genero = ?, fecha_fin = ?, descripcion = ?, nMaxAlumnos = ?";
        if ($momento == 'null') {
            $sql .= " WHERE id = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssssis', $nombre, $genero, $fechaFin, $descripcion, $nmaxalumnos, $id);
        } else {
            $sql .= ", id_momento = ? WHERE id = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssssiii', $nombre, $genero, $fechaFin, $descripcion, $nmaxalumnos, $momento, $id);
        }

        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    /**
     * Devuelve los datos de la actividad, los alumnos que se pueden inscribir y los alumnos inscritos.
     * @param int $clase El ID de la clase.
     * @param int $actividad El ID de la actividad.
     * @return array Un array con los datos de la actividad y los alumnos.
     */
    public function select_alumnos_inscripcion($clase, $actividad) {
        $sqlActividad = "SELECT * FROM ACT_Actividades WHERE id = ?";

        $stmtActividad = $this->conexion->prepare($sqlActividad);
        $stmtActividad->bind_param('i', $actividad);
        $stmtActividad->execute();

        $resulActividad = $stmtActividad->get_result();
        $stmtActividad->close();

        $datosActividad = $resulActividad->fetch_assoc();
        $genero = $datosActividad['genero'];

        $datos = [
            "id" => $datosActividad['id'],
            "actividad" => $datosActividad['nombre'],
            "max_alumnos" => $datosActividad['nMaxAlumnos'],
            "alumnos" => $this->datos_alumnos_por_genero($genero, $clase),
            "alumnos_inscritos" => $this->datos_alumnos_inscritos_por_clase($actividad, $clase),
            "clase" => $this->seccion($clase),
            "rutaForm" => [
                'controlador' => "Actividad",
                'metodo' => "inscribir"
            ],
            "rutaVolver" => [
                'controlador' => "Actividad",
                'metodo' => "vistaListar"
            ]
        ];
        $this->conexion->close();

        return $datos;
    }

    /**
     * Devuelve los alumnos de una sección por el género de la actividad o del propio género de los alumnos.
     * @param string $genero El género de la actividad.
     * @param int $clase El ID de la clase.
     * @return array Un array con los datos de los alumnos.
     */
    public function datos_alumnos_por_genero($genero, $clase) {
        $stmtAlumno = null;
        $sqlAlumno = "SELECT Alumnos.idAlumno AS id, Alumnos.nombre AS nombre
                      FROM Alumnos
                      JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                      WHERE Secciones.idSeccion = ?";
        if (strcasecmp($genero, 'x') == 0) {
            $stmtAlumno = $this->conexion->prepare($sqlAlumno);
            $stmtAlumno->bind_param('i', $clase);
        } else {
            $sqlAlumno .= " AND Alumnos.sexo = ?";
            $stmtAlumno = $this->conexion->prepare($sqlAlumno);
            $stmtAlumno->bind_param('is', $clase, $genero);
        }
        $stmtAlumno->execute();

        $resulAlumno = $stmtAlumno->get_result();
        $stmtAlumno->close();

        $alumnos = array();
        while ($fila = $resulAlumno->fetch_assoc()) {
            array_push($alumnos, $fila);
        }
        return $alumnos;
    }

    /**
     * Devuelve los alumnos inscritos en una actividad en una sección.
     * @param int $actividad El ID de la actividad.
     * @param int $clase El ID de la clase.
     * @return array Un array con los datos de los alumnos inscritos.
     */
    public function datos_alumnos_inscritos_por_clase($actividad, $clase) {
        $sql = "SELECT id_alumno FROM ACT_Inscripciones
                JOIN Alumnos ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                WHERE ACT_Inscripciones.id_actividad = ? AND Secciones.idSeccion = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ii', $actividad, $clase);
        $stmt->execute();

        $resul = $stmt->get_result();
        $stmt->close();

        $alumnos_inscritos = array();
        while ($fila = $resul->fetch_assoc()) {
            array_push($alumnos_inscritos, $fila);
        }
        return $alumnos_inscritos;
    }

    /**
     * Método que devuelve el número de alumnos inscritos por actividad de un usuario en específico.
     * @param int $clase El ID de la clase.
     * @return array Un array con el número de alumnos inscritos por actividad.
     */
    public function numero_alumnos_inscritos_por_actividad($clase) {
        $sql = "SELECT COUNT(ACT_Inscripciones.id_alumno) AS numero_alumnos_inscritos, ACT_Inscripciones.id_actividad AS actividad
                FROM ACT_Inscripciones
                JOIN Alumnos ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                WHERE Secciones.idSeccion = ?
                GROUP BY ACT_Inscripciones.id_actividad;";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $clase);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            array_push($datos, $fila);
        }

        $stmt->close();
        return $datos;
    }

    /**
     * Devuelve los datos de los alumnos inscritos en alguna actividad.
     * @param int $clase El ID de la clase.
     * @return array Un array con los datos de los alumnos inscritos.
     */
    public function tabla_alumno_inscripcion($clase) {
        $sql = "SELECT Alumnos.nombre AS alumno, Secciones.codSeccion AS clase, ACT_Actividades.nombre AS actividad
                FROM Alumnos
                JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                LEFT JOIN ACT_Inscripciones ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                LEFT JOIN ACT_Actividades ON ACT_Inscripciones.id_actividad = ACT_Actividades.id
                WHERE Secciones.idSeccion = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $clase);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            array_push($datos, $fila);
        }

        $stmt->close();
        $this->conexion->close();
        return $datos;
    }

    /**
     * Devuelve los datos de una sección específica.
     * @param int $clase El ID de la sección.
     * @return array Un array con los datos de la sección.
     */
    public function seccion($clase) {
        $sql = "SELECT * FROM Secciones WHERE Secciones.idSeccion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $clase);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();

        $stmt->close();
        return $datos;
    }
}