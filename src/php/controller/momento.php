<?php
    require_once 'controlador.php';
    require_once 'php/model/mmomento.php';
    require_once 'php/model/modelo.php';
    
    /**
     * Clase Momento que maneja las operaciones relacionadas con los momentos.
     */
    class Momento extends Controlador {
        public $vista;

        /**
         * Constructor de la clase Momento.
         * Inicializa el modelo MMomento.
         */
        function __construct() {
            $this->Modelo = new MMomento();
        }

        /**
         * Método para listar los momentos.
         * Solo permite listar si el usuario tiene el perfil de administrador.
         * @return array|null Datos de los momentos.
         */
        public function vistaListar() {
            $this->vista = 'vistaListarMomentos';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    $momentos = $this->Modelo->momentos();
                    return $momentos;
                }
            }
        }

        /**
         * Método para mostrar el formulario de creación o modificación de momentos.
         * Si se proporciona un ID en GET, se carga el momento para modificarlo.
         * @return array|null Datos del momento a modificar.
         */
        public function vistaFormularioMomento() {
            $this->vista = 'vistaCrearMomento';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    if (isset($_POST['id']) && !empty($_POST['id'])) {
                        $this->vista = 'vistaModificarMomento';
                        $id = $_POST['id'];
                        $momento = $this->Modelo->datos_momento($id);
                        return $momento;
                    }
                    return;
                }
            }
        }

        /**
         * Método para crear un nuevo momento.
         * Valida los datos del formulario y guarda el momento en la base de datos.
         * @return array|null Mensaje de error o datos de los momentos.
         */
        public function crearMomento() {
            $this->vista = 'vistaListarMomentos';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    if ($_POST['nombre'] == '' || $_POST['fecha_inicio'] == '' || $_POST['fecha_fin'] == '') {
                        $this->vista = 'vistaCrearMomento';
                        $datos = array(
                            'mensaje' => 'Tienes que rellenar todos los datos'
                        );
                        return $datos;
                    }

                    $nombre = $_POST['nombre'];
                    $fechaInicio = $_POST['fecha_inicio'];
                    $fechaFin = $_POST['fecha_fin'];

                    if ($fechaInicio >= $fechaFin) {
                        $this->vista = 'vistaCrearMomento';
                        $datos = array(
                            'mensaje' => 'La fecha de inicio no puede ser mayor a la de fin'
                        );
                        return $datos;
                    }

                    if (!preg_match("/^[a-zA-Z0-9 ]{1,30}$/", $nombre)) {
                        $this->vista = 'vistaCrearMomento';
                        $datos = array(
                            'mensaje' => 'El nombre no debe tener caracteres especiales y debe tener un máximo de 30 caracteres.'
                        );
                        return $datos;
                    }

                    if (!$mensaje = $this->Modelo->insertar_momento($nombre, $fechaInicio, $fechaFin)) {
                        $momentos = $this->Modelo->momentos();
                        return $momentos;
                    } else {
                        $this->vista = 'vistaCrearMomento';
                        $datos = array(
                            'mensaje' => $mensaje
                        );
                        return $datos;
                    }
                }
            }
        }

        /**
         * Método para modificar un momento existente.
         * Valida los datos del formulario y actualiza el momento en la base de datos.
         * @return array|null Mensaje de error o datos de los momentos.
         */
        public function modificarMomento(){
            $this->vista = 'vistaListarMomentos';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    $id = $_POST['id'];
                    $momento=$this->Modelo->datos_momento($id);
                    if($_POST['nombre']=='' || $_POST['fecha_inicio'] == '' || $_POST['fecha_fin'] == ''){
                        $this->vista = 'vistaModificarMomento';
                        $datos = array(
                            'mensaje' => 'Tienes que rellenar todos los datos',
                            'nombre' => $momento['nombre'],
                            'fecha_inicio' => $momento['fecha_inicio'],
                            'fecha_fin' => $momento['fecha_fin'],
                            'id'=>$id
                        );
                        return $datos;
                    }
                    $nombre = $_POST['nombre'];
                    $fechaInicio = $_POST['fecha_inicio'];
                    $fechaFin = $_POST['fecha_fin'];

                    if (!preg_match("/^[a-zA-Z0-9 ]{1,30}$/", $nombre)) {
                        $this->vista = 'vistaModificarMomento';
                        $datos = array(
                            'mensaje' => 'El nombre no debe tener caracteres especiales y debe tener un máximo de 30 caracteres.',
                            'nombre' => $momento['nombre'],
                            'fecha_inicio' => $momento['fecha_inicio'],
                            'fecha_fin' => $momento['fecha_fin'],
                            'id'=>$id
                        );
                        return $datos;
                    }
                    
                    if(!$mensaje = $this->Modelo->modificar_momento($nombre, $fechaInicio, $fechaFin,$id)){
                        $momentos = $this->Modelo->momentos();
                        return $momentos;
                    }
                    else{
                        $this->vista = 'vistaModificarMomento';
                        $datos = array(
                            'mensaje' => $mensaje,
                            'nombre' => $momento['nombre'],
                            'fecha_inicio' => $momento['fecha_inicio'],
                            'fecha_fin' => $momento['fecha_fin'],
                            'id'=>$id
                        );
                        return $datos;
                    }
                }
            }
        }

        /**
         * Método para borrar un momento.
         * Solo permite borrar si el usuario tiene el perfil de administrador.
         * @return array|null Datos de los momentos.
         */
        public function borrarMomento() {
            $this->vista = 'vistaListarMomentos';
            session_start();
            if (isset($_SESSION['id'])) {
                if ($_SESSION['perfil'] == 1) {
                    $id = $_POST['id'];
                    if ($this->Modelo->borrar_momento($id)) {
                        $momentos = $this->Modelo->momentos();
                        return $momentos;
                    }
                }
            }
        }
    }
