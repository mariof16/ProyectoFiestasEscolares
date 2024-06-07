<?php
    require_once 'controlador.php';
    require_once 'php/model/mactividad.php';
    require_once 'php/model/mmomento.php';
    require_once 'php/model/modelo.php';

    /**
     * Clase del Controlador que lleva todos los procesos de las actividades.
     */
    class Actividad extends Controlador {
        public $vista;

        /**
         * Constructor de la clase Actividad.
         * Inicializa los modelos necesarios.
         */
        function __construct() {
            $this->Modelo = new Modelo();
            $this->Actividad = new MActividad();
            $this->Momento = new MMomento();
        }

        /**
         * Método para listar las actividades.
         * Si el usuario tiene una sesión iniciada y es administrador, se obtienen las actividades y clases.
         * @return array Datos de las actividades y clases.
         */
        public function vistaListar() {
            $this->vista = 'vistaListarActividades';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    $datos = [
                        'actividades' => $this->Actividad->actividades(),
                    ];
                    return $datos;
                }
            }
        }

        /**
         * Método para mostrar el formulario de creación o modificación de actividades.
         * Si el usuario tiene una sesión iniciada y es administrador, se obtienen los datos necesarios.
         * @return array Datos de los momentos y actividad (si se está modificando).
         */
        public function vistaFormularioActividad() {
            $this->vista = 'vistaCrearActividad';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    if (isset($_POST['id']) && !empty($_POST['id'])) {
                        $this->vista = 'vistaModificarActividad';
                        $id = $_POST['id'];
                        $datos = [
                            'momentos' => $this->Momento->momentos(),
                            'actividad' => $this->Actividad->datos_actividad($id)
                        ];
                    } else {
                        $datos = [
                            'momentos' => $this->Momento->momentos()
                        ];
                    }
                    return $datos;
                }
            }
        }

        /**
         * Método para crear una nueva actividad.
         * Se validan los datos ingresados y se inserta la nueva actividad en la base de datos.
         * @return array|void Datos de la vista y mensajes de validación.
         */
        public function crearActividad() {
            $this->vista = 'vistaListarActividades';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    if ($_POST['nombre'] == '' || $_POST['genero'] == '' || $_POST['descripcion'] == '' || $_POST['fecha_fin'] == '' || $_POST['nMaxAlumnos'] == '' || $_POST['momento'] == '') {
                        $this->vista = 'vistaCrearActividad';
                        $datos = array(
                            'mensaje' => 'Asegurate de escribir todos los datos.',
                            'momentos' => $this->Momento->momentos()
                        );
                        return $datos;
                    }

                    $nombre = $_POST['nombre'];
                    $genero = $_POST['genero'];
                    if ($genero == 'M') {
                        $nombre .= ' Masculino';
                    } elseif ($genero == 'F') {
                        $nombre .= ' Femenino';
                    }
                    $fechaFin = $_POST['fecha_fin'];
                    $descripcion = $_POST['descripcion'];
                    $momento = $_POST['momento'];
                    $id_coordinador = $_SESSION['id'];
                    $nmaxalumn = $_POST['nMaxAlumnos'];

                    $regex_sin_especiales = '/^[a-zA-Z0-9\s]+$/';
                    $mensaje = false;

                    if ($fechas_momento = $this->Momento->momento_especifico($momento)) {
                        if ($fechaFin < $fechas_momento['fecha_inicio'] || $fechaFin > $fechas_momento['fecha_fin']) {
                            $mensaje = 'La fecha de fin debe de estar dentro del momento Inicio: ' . $fechas_momento['fecha_inicio'] . ' Fin: ' . $fechas_momento['fecha_fin'];
                        }
                    } else {
                        $mensaje = 'El momento no es valido';
                    }

                    if (!preg_match($regex_sin_especiales, $nombre) || strlen($nombre) > 50) {
                        $mensaje = 'Nombre inválido. No debe contener caracteres especiales y no debe exceder los 50 caracteres.';
                    }

                    if (!preg_match($regex_sin_especiales, $descripcion) || strlen($descripcion) > 255) {
                        if ($mensaje) {
                            $mensaje .= '<br><br>';
                        }
                        $mensaje .= 'Descripción inválida. No debe contener caracteres especiales y no debe exceder los 255 caracteres.';
                    }

                    if (!in_array($genero, ['M', 'F', 'X'])) {
                        if ($mensaje) {
                            $mensaje .= '<br><br>';
                        }
                        $mensaje .= 'Género inválido. Debe ser Masculino, Femenino, o Mixto.';
                    }

                    if ($nmaxalumn <= 0) {
                        if ($mensaje) {
                            $mensaje .= '<br><br>';
                        }
                        $mensaje .= 'El número de alumnos no puede ser negativo';
                    }

                    if (!$mensaje) {
                        if ($this->Actividad->insertar_actividad($nombre, $genero, $fechaFin, $momento, $descripcion, $nmaxalumn)) {
                            $datos = [
                                'actividades' => $this->Actividad->actividades(),
                                'clases' => $this->Modelo->todas_clases()
                            ];
                            return $datos;
                        }
                    } else {
                        $this->vista = 'vistaCrearActividad';
                        $datos = array(
                            'mensaje' => $mensaje,
                            'momentos' => $this->Momento->momentos()
                        );
                        return $datos;
                    }
                }
            }
        }

        /**
         * Método para modificar una actividad existente.
         * Se validan los datos ingresados y se actualiza la actividad en la base de datos.
         * @return array|void Datos de la vista y mensajes de validación.
         */
        public function modificarActividad() {
            $this->vista = 'vistaListarActividades';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    if ($_POST['nombre'] == '' || $_POST['genero'] == '' || $_POST['descripcion'] == '' || $_POST['fecha_fin'] == '' || $_POST['nMaxAlumnos'] == '' || $_POST['momento'] == '') {
                        $this->vista = 'vistaModificarActividad';
                        $id = $_POST['id'];
                        $datos = [
                            'momentos' => $this->Momento->momentos(),
                            'actividad' => $this->Actividad->datos_actividad($id),
                            'mensaje' => 'Faltan campos'
                        ];
                        return $datos;
                    }
                    $nombre = $_POST['nombre'];
                    $genero = $_POST['genero'];
                    $fechaFin = $_POST['fecha_fin'];
                    $descripcion = $_POST['descripcion'];
                    $nmaxalumn = $_POST['nMaxAlumnos'];
                    $momento = $_POST['momento'];
                    $id = $_POST['id'];

                    $regex_sin_especiales = '/^[a-zA-Z0-9\s]+$/';
                    $mensaje = false;

                    if ($fechas_momento = $this->Momento->momento_especifico($momento)) {
                        if ($fechaFin < $fechas_momento['fecha_inicio'] || $fechaFin > $fechas_momento['fecha_fin']) {
                            $mensaje = 'La fecha de fin debe de estar dentro del momento Inicio: ' . $fechas_momento['fecha_inicio'] . ' Fin: ' . $fechas_momento['fecha_fin'];
                        }
                    } else {
                        $mensaje = 'El momento no es valido';
                    }

                    if (!preg_match($regex_sin_especiales, $nombre) || strlen($nombre) > 50) {
                        $mensaje = 'Nombre inválido. No debe contener caracteres especiales y no debe exceder los 50 caracteres.';
                    }

                    if (!preg_match($regex_sin_especiales, $descripcion) || strlen($descripcion) > 255) {
                        if ($mensaje) {
                            $mensaje .= '<br><br>';
                        }
                        $mensaje .= 'Descripción inválida. No debe contener caracteres especiales y no debe exceder los 255 caracteres.';
                    }

                    if (!in_array($genero, ['M', 'F', 'X'])) {
                        if ($mensaje) {
                            $mensaje .= '<br><br>';
                        }
                        $mensaje .= 'Género inválido. Debe ser Masculino, Femenino, o Mixto.';
                    }

                    if ($nmaxalumn <= 0) {
                        if ($mensaje) {
                            $mensaje .= '<br><br>';
                        }
                        $mensaje .= 'El número de alumnos no puede ser negativo';
                    }

                    if (!$mensaje) {
                        if ($this->Actividad->modificar_actividad($id, $nombre, $genero, $fechaFin, $momento, $descripcion, $nmaxalumn)) {
                            $datos = [
                                'actividades' => $this->Actividad->actividades(),
                                'clases' => $this->Modelo->todas_clases()
                            ];
                            return $datos;
                        }
                    } else {
                        $this->vista = 'vistaModificarActividad';
                        $datos = array(
                            'mensaje' => $mensaje,
                            'momentos' => $this->Momento->momentos(),
                            'actividad' => $this->Actividad->datos_actividad($id)
                        );
                        return $datos;
                    }
                }
            }
        }

        /**
         * Método para borrar una actividad existente.
         * Si el usuario tiene una sesión iniciada y es administrador, se elimina la actividad.
         * @return array Datos de las actividades.
         */
        public function borrarActividad() {
            $this->vista = 'vistaListarActividades';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    $id = $_POST['id'];
                    if ($this->Actividad->borrar_actividad($id))
                        $datos = [
                            'actividades' => $this->Actividad->actividades(),
                            'clases' => $this->Modelo->todas_clases()
                        ];
                    return $datos;
                }
            }
        }

        /**
         * Método para ir a la vista de inscribir a los alumnos a una actividad.
         * Si no hay sesión abierta, manda al usuario a iniciar sesión.
         * @return array|void Datos de los alumnos inscritos.
         */
        public function vistaInscribir() {
            $this->vista = 'vistaInscribir';
            session_start();
            if (isset($_SESSION['id'])) {
                $clase = $_POST['clase'];
                $actividad = $_POST['actividad'];
                return $this->Actividad->select_alumnos_inscripcion($clase, $actividad);
            } else {
                $this->vistaSesion();
            }
        }

        /**
         * Método que contiene toda la programación en el proceso de inscribir.
         * Comprueba que los alumnos del formulario estén ya inscritos y que los alumnos inscritos vengan del formulario.
         * @return array|void Datos de las actividades y clases.
         */
        public function inscribir() {
            $this->vista = 'vistaListarActividades';
            session_start();
            if (isset($_SESSION['id'])) {
                $clase = $_POST['clase'];
                $alumnosSelect = array_unique($_POST['alumnos']);
                $inscritosbd = $this->Actividad->datos_alumnos_inscritos_por_clase($_POST['id'], $clase);
                $alumnosInscritos = array_column($inscritosbd, "id_alumno");

                foreach ($alumnosInscritos as $alumno) {
                    $alumno .= '';
                    if (!in_array($alumno, $alumnosSelect)) {
                        $this->Modelo->eliminar_inscrito($alumno, $_POST['id']);
                    }
                }
                
                foreach ($alumnosSelect as $alumno) {
                    $alumno = (int) $alumno;
                    if ($alumno > 0) {
                        if (!in_array($alumno, $alumnosInscritos)) {
                            $this->Modelo->inscribir_alumno($alumno, $_POST['id']);
                        }
                    }
                }

                $datos = [
                    'actividades' => $this->Actividad->actividades(),
                    'clases' => $this->Modelo->todas_clases()
                ];
                return $datos;
            } else {
                $this->vistaSesion();
            }
        }
    }