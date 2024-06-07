<?php
require_once 'conexion.php';

/**
 * Clase MMomento que extiende la clase Conexion para manejar los momentos en la base de datos.
 */
class MMomento extends Conexion {
    
    /**
     * Método para obtener todos los momentos.
     * @return array Un array de todos los momentos.
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

    /**
     * Método para obtener los datos de un momento específico.
     * @param int $id El ID del momento.
     * @return array Un array con los datos del momento.
     */
    public function datos_momento($id) {
        $sql = "SELECT * FROM ACT_Momentos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();

        $stmt->close();
        return $datos;
    }

    /**
     * Método para borrar un momento.
     * @param int $id El ID del momento a borrar.
     * @return bool True si se borra correctamente, False en caso contrario.
     */
    public function borrar_momento($id) {
        $sql = "DELETE FROM ACT_Momentos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Método para insertar un nuevo momento.
     * @param string $nombre El nombre del momento.
     * @param string $fecha_inicio La fecha de inicio del momento.
     * @param string $fecha_fin La fecha de fin del momento.
     * @return mixed True si se inserta correctamente, mensaje de error en caso contrario.
     */
    public function insertar_momento($nombre, $fecha_inicio, $fecha_fin) {
        $sql = "INSERT INTO ACT_Momentos (nombre, fecha_inicio, fecha_fin) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sss', $nombre, $fecha_inicio, $fecha_fin);

        try {
            $stmt->execute();
            return false; // Indicar éxito en la inserción
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // Código de error de MySQL para entrada duplicada
                return 'Pon otro nombre';
            } else {
                // Manejar otros tipos de errores de mysqli si es necesario
                return 'Error al insertar el momento: ' . $e->getMessage();
            }
        }
    }

    /**
     * Método para modificar un momento existente.
     * @param string $nombre El nuevo nombre del momento.
     * @param string $fecha_inicio La nueva fecha de inicio del momento.
     * @param string $fecha_fin La nueva fecha de fin del momento.
     * @param int $id El ID del momento a modificar.
     * @return mixed True si se modifica correctamente, mensaje de error en caso contrario.
     */
    public function modificar_momento($nombre, $fecha_inicio, $fecha_fin,$id) {
        $sql = "UPDATE ACT_Momentos SET nombre = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sssi', $nombre, $fecha_inicio, $fecha_fin, $id);

        try {
            $stmt->execute();
            return false; // Cambiado a true para indicar éxito en la inserción
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // Código de error de MySQL para entrada duplicada
                return 'Pon otro nombre';
            } else {
                // Manejar otros tipos de errores de mysqli si es necesario
                return 'Error al insertar el momento: ' . $e->getMessage();
            }
        }
    }

    /**
     * Método para obtener los datos de un momento específico.
     * @param int $id El ID del momento.
     * @return array Un array con los datos del momento.
     */
    public function momento_especifico($id) {
        $sql = "SELECT * FROM ACT_Momentos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $datos = $resultado->fetch_assoc();

        $stmt->close();
        return $datos;
    }
}