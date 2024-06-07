<?php
    /**
     * Clase de conexión a la base de datos.
     */
    class Conexion {
        protected $conexion = null;

        /**
         * Constructor de la clase.
         * Establece la conexión con la base de datos y configura el conjunto de caracteres.
         */
        public function __construct() {
            require_once 'php/config/configDB.php';
            $this->conexion = new mysqli(HOST, USER, PSW, BDD);
            $this->conexion->set_charset("utf8");
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }