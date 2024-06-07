<?php
    require_once 'php/config/config.php';
    require_once 'php/model/modelo.php';
    require_once 'TCPDF-main/tcpdf.php';
    require_once 'php/model/mmomento.php';

    /**
     * Clase Controlador que maneja la lógica principal de la aplicación.
     */
    class Controlador {
        protected $Modelo;
        protected $Momento;
        public $vista;
        public $mensaje;

        /**
         * Constructor de la clase Controlador.
         * Inicializa los modelos necesarios.
         */
        function __construct() {
            $this->Modelo = new Modelo();
            $this->Momento = new MMomento();
        }

        /**
         * Método por defecto, comprueba que existe una cookie de recordar la sesión.
         * Si la cookie existe, inicia la sesión con los datos guardados en la cookie.
         * Si no hay cookie, muestra la vista del listado.
         * @return array Datos de las inscripciones.
         */
        public function iniciarAplicacion() {
            $this->vista = 'vistaClase';
            session_start();
            if (isset($_COOKIE['sesion'])) {
                $_SESSION['id'] = explode('/', $_COOKIE['sesion'])[0];
                $_SESSION['nombre'] = explode('/', $_COOKIE['sesion'])[1];

                $alumnos = $this->Modelo->tabla_alumno_inscripcion($_SESSION['id']);
                if (!empty($alumnos)) {
                    return $alumnos;
                } else {
                    $this->vista = 'vistaCrearClase';
                }
            } else {
                return $this->vistaListado();
            }
        }

        /**
         * Método para ir a la vista donde se muestran los alumnos inscritos de la clase de un tutor.
         * Si no hay sesión abierta, manda al usuario a iniciar sesión.
         * @return array|null Datos de las actividades y alumnos inscritos.
         */
        public function vistaClase() {
            $this->vista = 'vistaClase';
            session_start();
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
                $datos = [
                    'actividades' => [
                        "actividad" => $this->Modelo->tabla_actividad_hoy(),
                        "alumnos" => $this->Modelo->numero_alumnos_inscritos_por_actividad($id)
                    ],
                    'alumnos' => $this->Modelo->tabla_alumno_inscripcion($id)
                ];
                return $datos;
            } else {
                $this->vistaSesion();
                return null;
            }
        }

        /**
         * Método para ir a la vista de inscribir a los alumnos a una actividad.
         * Si no hay sesión abierta, manda al usuario a iniciar sesión.
         * @return mixed Datos de los alumnos a inscribir.
         */
        public function vistaInscribir() {
            $this->vista = 'vistaInscribir';
            session_start();
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
                $datos = [
                    'actividad' => $this->Modelo->select_alumnos_inscripcion($_POST['id'], $id),
                    'alumnos' => $this->Modelo->tabla_alumno_inscripcion($id)
                ];
                return $datos;
            } else {
                $this->vistaSesion();
            }
        }

        /**
         * Método de la vista de iniciar sesión.
         */
        public function vistaSesion() {
            $this->vista = 'vistaSesion';
        }

        /**
         * Método que contiene toda la programación en el proceso de inscribir.
         * Comprueba que los alumnos del formulario estén ya inscritos y que los alumnos inscritos vengan del formulario.
         * @return array|null Datos de las actividades y alumnos inscritos.
         */

        public function inscribir() {
            $this->vista = 'vistaClase';
            session_start();
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
                $alumnosSelect = array_unique($_POST['alumnos']);
                $inscritosbd = $this->Modelo->datos_alumnos_inscritos_por_clase($_POST['id'], $id);
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
                    'actividades' => [
                        "actividad" => $this->Modelo->tabla_actividad_hoy(),
                        "alumnos" => $this->Modelo->numero_alumnos_inscritos_por_actividad($id)
                    ],
                    'alumnos' => $this->Modelo->tabla_alumno_inscripcion($id)
                ];
                return $datos;
            } else {
                $this->vistaSesion();
            }
        }

        /**
         * Método que muestra la vista del formulario de añadir alumnos desde la vista de añadir la clase.
         * Devuelve al formulario de la clase si encuentra campos vacíos o número de alumnos menor a 0.
         * @return array|null Datos de la clase y número de alumnos.
         */
        public function vistaCrearAlumnos() {
            session_start();
            $this->vista = 'vistaCrearAlumnos';
            if (isset($_POST['nombreClase'], $_POST['nAlumnos'])) {
                $clase = $_POST['nombreClase'];
                $nAlumnos = $_POST['nAlumnos'];
                if ($nAlumnos > 0) {
                    $datos = array(
                        'clase' => $clase,
                        'nAlumnos' => $nAlumnos
                    );
                    return $datos;
                } else {
                    $this->mensaje = 'El número de alumnos no puede ser 0 o menos.';
                    $this->vista = 'vistaCrearClase';
                }
            } else {
                $this->mensaje = 'Rellene todos los campos';
                $this->vista = 'vistaCrearClase';
            }
        }

        /**
         * Método que devuelve a la vista del listado de la clase.
         * @return array Datos de las inscripciones.
         */
        public function vistaListado() {
            if(!isset($_SESSION))
                session_start();
            $this->vista = 'vistaListado';
            $datos = [
                'listado' => $this->Modelo->tabla_inscripciones(),
                'momentos' => $this->Modelo->momentos()
            ];
            return $datos;
        }

        /**
         * Método que devuelve a la vista del listado de la clase.
         * @return array Datos de las inscripciones de un metodo en específico.
         */
        public function vistaListadoMomento() {
            if(!isset($_SESSION))
                session_start();
            $this->vista = 'vistaListado';
            $datos = [
                'listado' => $this->Modelo->tabla_inscripciones_momento($_POST['buscarmomento']),
                'momentos' => $this->Modelo->momentos()
            ];
            return $datos;
        }


        /**
         * Método que genera un PDF con las inscripciones seleccionadas.
         * Si no se selecciona ninguna actividad, muestra el formulario de selección.
         * @return array Datos de las inscripciones.
         */
        public function generarPDF() {
            $this->vista = 'vistaTablaInscripciones';
            $datos = $this->Modelo->tabla_inscripciones();
            $total = false;
            if (isset($_POST['todos'])) {
                $this->todasActividadesPDF();
            } elseif (isset($_POST['actividad'])) {
                $actividades_seleccionadas = $_POST['actividad'];
                $this->algunaActividadPDF($actividades_seleccionadas);
            } else {
                $this->vista = 'vistaFormularioPDF';
                $this->mensaje = 'Selecciona alguna actividad';
                return $this->Modelo->tabla_actividad_hoy();
            }
            return $datos;
        }

        /**
         * Método que muestra la vista del formulario para descargar el PDF.
         * @return array Datos de las actividades.
         */
        public function vistaDescargarPDF() {
            $this->vista = 'vistaFormularioPDF';
            session_start();
            return $this->Modelo->tabla_actividad_hoy();
        }

        /**
         * Método privado para generar un PDF con todas las actividades.
         */
        private function todasActividadesPDF() {
            $datos = $this->Modelo->tabla_inscripciones();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Autor');
            $pdf->SetTitle('Todas las Actividades');
            $pdf->SetSubject('Todas las Actividades');
            $pdf->SetKeywords('PDF, actividades, inscripciones');

            $ultima_actividad = '';

            foreach ($datos[key($datos)] as $actividad => $clases) {
                $pdf->AddPage();
                if ($actividad != $ultima_actividad) {
                    $pdf->SetFont('helvetica', 'B', 14);
                    $pdf->Cell(0, 10, 'Actividad: ' . $actividad, 0, 1);
                    $ultima_actividad = $actividad;
                }

                $pdf->SetFont('helvetica', '', 12);
                $html = '<table border="1" cellpadding="4">
                            <thead>
                                <tr style="background-color: #3498db; font-weight: bolder; text-align: center; color: #ffffff; font-size: 14px">
                                    <th>Alumno</th>
                                    <th>Clase</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($clases as $clase => $alumnos) {
                    foreach ($alumnos as $alumno) {
                        if (!empty($alumno)) {
                            $html .= '<tr><td>' . $alumno . '</td><td>' . $clase . '</td></tr>';
                        }
                    }
                }

                $html .= '</tbody></table>';
                $pdf->writeHTML($html, true, false, false, false, '');
            }

            $pdf->Output('todas_actividades.pdf', 'I');
        }

        /**
         * Método privado para generar un PDF con actividades seleccionadas.
         * @param array $actividades_seleccionadas Lista de actividades seleccionadas.
         */
        private function algunaActividadPDF($actividades_seleccionadas) {
            $datos = $this->Modelo->tabla_inscripciones();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Autor');
            $pdf->SetTitle('Tabla de Inscripciones');
            $pdf->SetSubject('Tabla de Inscripciones');
            $pdf->SetKeywords('PDF, tabla, inscripciones');

            $ultima_actividad = '';

            foreach ($actividades_seleccionadas as $actividad_seleccionada) {
                $clases = $datos[key($datos)][$actividad_seleccionada] ?? array();
                $pdf->AddPage();
                if ($actividad_seleccionada != $ultima_actividad) {
                    $pdf->SetFont('helvetica', 'B', 14);
                    $pdf->Cell(0, 10, 'Actividad: ' . $actividad_seleccionada, 0, 1);
                    $ultima_actividad = $actividad_seleccionada;
                }

                $pdf->SetFont('helvetica', '', 12);
                $html = '<table border="1" cellpadding="4">
                            <thead>
                                <tr style="background-color: #3498db; font-weight: bolder; text-align: center; color: #ffffff; font-size: 14px">
                                    <th>Alumno</th>
                                    <th>Clase</th>
                                </tr>
                            </thead>
                            <tbody>';

                foreach ($clases as $clase => $alumnos) {
                    foreach ($alumnos as $alumno) {
                        if (!empty($alumno)) {
                            $html .= '<tr><td>' . $alumno . '</td><td>' . $clase . '</td></tr>';
                        }
                    }
                }

                $html .= '</tbody></table>';
                $pdf->writeHTML($html, true, false, false, false, '');
            }

            $pdf->Output('tabla_inscripciones.pdf', 'I');
        }

        /**
         * Método para realizar una copia de seguridad de la base de datos.
         * Solo permite la exportación si el usuario es administrador (id 1).
         * @return array Datos de las inscripciones.
         */
        public function copiaSeguridad() {
            session_start();
            $this->vista = 'vistaListado';
            if (isset($_SESSION['id']) && $_SESSION['id'] == 1) {
                $this->Modelo->exportar_bbdd();
                header('Content-Type: text/csv; charset=UTF-8');
                header('Content-Disposition: attachment; filename="datos_exportados.csv"');
                readfile("datos_exportados.csv");
                exit;
            }
            $datos = $this->Modelo->tabla_inscripciones_hoy();
            return $datos;
        }
    }