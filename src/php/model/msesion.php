<?php
    require_once 'conexion.php';
    /**
     * Clase MSesion que extiende de la clase Conexión para manejar las sesiones.
     */
    class MSesion extends Conexion{
        /**
         * Método para manejar el inicio de sesión de un usuario.
         * 
         * Este método verifica las credenciales de un usuario (correo y contraseña) y retorna la información del usuario si las credenciales son correctas.
         * 
         * @param string $correo El correo electrónico del usuario.
         * @param string $psw La contraseña del usuario.
         * @return array|bool Retorna un array con la información del usuario si las credenciales son correctas, o `false` si las credenciales son incorrectas o el usuario no existe.
         */
        public function inicio_sesion($correo,$psw){
            $sql = "SELECT Usuarios.idUsuario AS id, Usuarios.nombre, Usuarios.contrasenia, idPerfil AS perfil FROM Usuarios
            JOIN Perfiles_Usuarios ON Usuarios.idUsuario = Perfiles_Usuarios.idUsuario
            WHERE correo = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('s', $correo);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();
            
            if($resul->num_rows > 0){
                $datos = $resul->fetch_assoc();
                if(password_verify($psw,$datos['contrasenia'])){
                    unset($datos['contrasenia']);
                    return $datos;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        /**
         * Método para comprobar si un usuario es un tutor.
         * 
         * Este método verifica si un usuario dado existe en la tabla de tutores.
         * 
         * @param string $usuario El nombre de usuario a verificar.
         * @return bool Retorna `true` si el usuario existe en la tabla de tutores, o `false` si no existe.
         */
        public function comprobar_usuario_tutor($usuario){
            $sql = "SELECT usuario FROM tutor WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('s', $usuario);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();
            if($resul->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        }
        public function comprobar_nombre_clase($clase){
            
        }
        /**
         * Método para registrar un nuevo tutor.
         * 
         * Este método inserta un nuevo registro en la tabla de tutores con el nombre, usuario y contraseña hash.
         * 
         * @param string $nombre El nombre del tutor.
         * @param string $usuario El nombre de usuario del tutor.
         * @param string $hash La contraseña del tutor, en formato hash.
         * @return int|null Retorna el ID del tutor recién insertado si la operación es exitosa, o `null` si la inserción falla.
         */
        public function registro($nombre,$usuario,$hash){
            $sql = "INSERT INTO tutor (nombre, usuario, psw) VALUES(?, ?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('sss', $nombre,$usuario,$hash);
            if ($stmt->execute()) {
                return $this->conexion->insert_id;
            } else {
                return null;
            }
        }
    }