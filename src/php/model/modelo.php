<?php
    require 'php/config/configDB.php';
    require_once 'conexion.php';
    class Modelo extends Conexion{
       /**
         * Devuelve los datos de todas las actividades.
         *
         * Este método realiza una consulta a la base de datos para obtener todas las
         * filas de la tabla ACT_Actividades y las devuelve como un array asociativo.
         *
         * @return array Un array de arrays asociativos, donde cada array representa una fila de la tabla.
         */
        public function tabla_actividad(){
            $sql = "SELECT * FROM ACT_Actividades";
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
         * Devuelve los datos de todas las actividades que entren en la fecha de hoy.
         *
         * Este método realiza una consulta a la base de datos para obtener todas las
         * actividades cuyos momentos estén comprendidos dentro de la fecha actual.
         *
         * @return array Un array de arrays asociativos, donde cada array representa una fila de la tabla ACT_Actividades.
         */
        public function tabla_actividad_hoy(){
            $fecha = date("Y-m-d");
            $sql = "SELECT ACT_Actividades.* FROM ACT_Actividades
            JOIN ACT_Momentos ON ACT_Actividades.id_momento = ACT_Momentos.id
            WHERE ACT_Momentos.fecha_inicio <= ? AND ACT_Momentos.fecha_fin >= ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ss",$fecha, $fecha);
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
         * Método que devuelve el número de alumnos inscritos por actividad de un Usuarios en específico.
         *
         * Este método realiza una consulta a la base de datos para obtener el número de alumnos inscritos
         * por actividad de un usuario en específico. La consulta agrupa los resultados por el id de la
         * actividad.
         *
         * @param int $Usuarios El ID del usuario.
         * @return array Un array de arrays asociativos, donde cada array representa una fila de la tabla
         *               ACT_Inscripciones agrupada por el id de la actividad.
         */
        public function tabla_alumno_inscripcion($Usuarios){
            $sql = "SELECT Alumnos.nombre AS alumno, Secciones.codSeccion AS clase, ACT_Actividades.nombre AS actividad
                FROM Alumnos
                JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                LEFT JOIN ACT_Inscripciones ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                LEFT JOIN ACT_Actividades ON ACT_Inscripciones.id_actividad = ACT_Actividades.id
                JOIN Usuarios ON Secciones.idTutor = Usuarios.idUsuario
                WHERE Usuarios.idUsuario = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i', $Usuarios);
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
         * Devuelve los datos de la actividad, los alumnos que se pueden inscribir y los alumnos inscritos
         *
         * Esta función realiza una consulta a la tabla ACT_Actividades para obtener los datos de la actividad
         * cuyo id coincida con el parámetro $actividad. Luego, utiliza la función datos_alumnos_por_genero
         * para obtener los alumnos que pueden inscribirse en la actividad según su género. Además, se obtienen
         * los alumnos inscritos en la actividad mediante la función datos_alumnos_inscritos_por_clase.
         *
         * @param int $actividad El id de la actividad a consultar.
         * @param int $Usuarios El id del usuario.
         * @return array Un array con los datos de la actividad, los alumnos que se pueden inscribir y los
         *               alumnos inscritos.
         */
        public function select_alumnos_inscripcion($actividad, $Usuarios){
            $sqlActividad = "SELECT * FROM ACT_Actividades WHERE id = ?";

            $stmtActividad = $this->conexion->prepare($sqlActividad);
            $stmtActividad->bind_param('i', $actividad);
            $stmtActividad->execute();

            $resulActividad = $stmtActividad->get_result();
            $stmtActividad->close();

            $datosActividad = $resulActividad->fetch_assoc();
            $genero = $datosActividad['genero'];
        }
        /**
         * Devueve los alumnos de una Secciones por el genero de la actividad o por del propio genero del Alumnos.
         *
         * @param string $genero El género de la actividad.
         * @param int $Usuarios El id del usuario.
         * @return array Un array con los datos de los alumnos.
         */
        public function datos_alumnos_inscritos_por_clase($actividad, $Usuarios){
            $sql = "SELECT id_alumno FROM ACT_Inscripciones
            JOIN Alumnos ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
            JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
            JOIN Usuarios ON Secciones.idTutor = Usuarios.idUsuario
            WHERE ACT_Inscripciones.id_actividad = ? AND Usuarios.idUsuario=?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii', $actividad,$Usuarios);
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
         * Elimina el Alumnos inscrito en una actividad.
         *
         * @param int $Alumnos El id del Alumno a eliminar.
         * @param int $actividad El id de la actividad a la que pertenece el Alumno.
         */
        public function eliminar_inscrito($Alumnos, $actividad){
            $sql = "DELETE FROM ACT_Inscripciones WHERE id_alumno = ? AND id_actividad = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii', $Alumnos, $actividad);
            $stmt->execute();
        }
        /**
         * Guarda en la base de datos la id del Alumnos, la actividad y la fecha al inscribir.
         *
         * @param int $Alumnos El id del Alumno a inscribir.
         * @param int $actividad El id de la actividad en la que se va a inscribir.
         */
        public function inscribir_alumno($Alumnos, $actividad){
            $fecha = new DateTime();
            $fechaFormateada = $fecha->format('Y-m-d H:i:s');
            $sql = "INSERT INTO ACT_Inscripciones (id_alumno, id_actividad, fecha_hora) VALUES(?,?,?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('iis', $Alumnos, $actividad, $fechaFormateada);
            $stmt->execute();
        }
        /**
         * Devuelve todos los alumnos que están inscritos.
         *
         * @return array Un array de arrays asociativos, donde cada array representa una fila de la tabla ACT_Inscripciones.
         *               El array tiene la siguiente estructura:
         *               - momento: string (nombre del momento)
         *               - actividad: string (nombre de la actividad)
         *               - clase: string (nombre de la sección)
         *               - alumno: array (array de strings con los nombres de los alumnos inscritos) 
         */
        public function tabla_inscripciones() {
            $fecha = date("Y-m-d");
            $sql = "SELECT Alumnos.nombre AS alumno, Secciones.nombre AS clase, ACT_Actividades.nombre AS actividad, ACT_Momentos.nombre AS momento
                    FROM Alumnos
                    JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                    LEFT JOIN ACT_Inscripciones ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                    LEFT JOIN ACT_Actividades ON ACT_Inscripciones.id_actividad = ACT_Actividades.id
                    LEFT JOIN ACT_Momentos ON ACT_Actividades.id_momento = ACT_Momentos.id
                    WHERE ACT_Actividades.nombre IS NOT NULL
                    ORDER BY momento, actividad, alumno;";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute();
        
            $resultado = $stmt->get_result();
            $datos = array();

            $datos = array();
        
            while ($fila = $resultado->fetch_assoc()) {
                $actividad = $fila['actividad'];
                $clase = $fila['clase'];
                $alumno = $fila['alumno'];
                $momento = $fila['momento'];

                $datos[$momento][$actividad][$clase][] = $alumno ?? [];
            }
        
            return $datos;
        }
        /**
         * Devuelve los datos de las inscripciones de los alumnos en un momento específico.
         *
         * Este método realiza una consulta a la base de datos para obtener los nombres de los alumnos,
         * las clases, las actividades y el momento de inscripción en base al ID del momento proporcionado.
         *
         * @param int $id El ID del momento del que se desean obtener las inscripciones.
         * @return array Un array multidimensional organizado por momento, actividad, clase y alumnos inscritos.
         */
        public function tabla_inscripciones_momento($id) {
            $fecha = date("Y-m-d");
            $sql = "SELECT Alumnos.nombre AS alumno, Secciones.nombre AS clase, ACT_Actividades.nombre AS actividad, ACT_Momentos.nombre AS momento
                    FROM Alumnos
                    JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                    LEFT JOIN ACT_Inscripciones ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                    LEFT JOIN ACT_Actividades ON ACT_Inscripciones.id_actividad = ACT_Actividades.id
                    LEFT JOIN ACT_Momentos ON ACT_Actividades.id_momento = ACT_Momentos.id
                    WHERE ACT_Actividades.nombre IS NOT NULL AND ACT_Momentos.id = ?
                    ORDER BY actividad, alumno;";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i",$id);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = array();

            $datos = array();

            while ($fila = $resultado->fetch_assoc()) {
                $actividad = $fila['actividad'];
                $clase = $fila['clase'];
                $alumno = $fila['alumno'];
                $momento = $fila['momento'];

                $datos[$momento][$actividad][$clase][] = $alumno ?? [];
            }
                    
            return $datos;
        }
        
        /**
         * Devuelve los nombres de todas las actividades que tienen al menos una inscripción.
         *
         * Este método realiza una consulta a la base de datos para obtener los nombres de las actividades
         * que tienen al menos una inscripción asociada.
         *
         * @return array Un array de arrays asociativos que contiene los nombres de las actividades.
         */
        public function tabla_actividad_nombre(){
            $sql = "SELECT nombre
                FROM ACT_Actividades
                INNER JOIN ACT_Inscripciones ON ACT_Actividades.id = ACT_Inscripciones.id_actividad
                GROUP BY ACT_Actividades.id;";
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
         * Método para exportar la base de datos a un archivo CSV.
         * 
         * Este método obtiene una lista de todas las tablas en la base de datos y exporta sus datos a un archivo CSV llamado "datos_exportados.csv".
         * Si la base de datos contiene tablas, cada una se escribe en el archivo CSV junto con sus datos.
         */
        public function exportar_bbdd(){
            $sql_tables = "SHOW TABLES";
            $result_tables = $this->conexion->query($sql_tables);
        
            if ($result_tables->num_rows > 0) {

                $csv_file = fopen("datos_exportados.csv", "w");
        
                while ($row_table = $result_tables->fetch_row()) {
                    $table_name = $row_table[0];
        
                    fputcsv($csv_file, array("Tabla: $table_name"));
                    $sql_data = "SELECT * FROM $table_name";
                    $result_data = $this->conexion->query($sql_data);
        
                    if ($result_data->num_rows > 0) {
                        while ($row_data = $result_data->fetch_assoc()) {
                            fputcsv($csv_file, $row_data);
                        }
                    }
                }

                fclose($csv_file);
            }
        }
        /**
         * Método para obtener todos los registros de la tabla Secciones.
         * 
         * Este método recupera todos los registros de la tabla `Secciones` y los retorna en un array.
         * 
         * @return array Retorna un array con todos los registros de la tabla `Secciones`.
         */
        public function todas_clases() {
            $sql = "SELECT * FROM Secciones";
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
         * Método para obtener todos los registros de la tabla ACT_Momentos.
         * 
         * Este método recupera todos los registros de la tabla `ACT_Momentos` y los retorna en un array.
         * 
         * @return array Retorna un array con todos los registros de la tabla `ACT_Momentos`.
         */
        public function momentos() {
            $sql = "SELECT * FROM ACT_Momentos";
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
    }
