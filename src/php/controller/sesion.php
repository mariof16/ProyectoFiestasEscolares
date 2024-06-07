<?php
    require_once 'controlador.php';
    require_once 'php/model/msesion.php';

    class Sesion extends Controlador{
        private $Sesion;
        function __construct(){
            $this->Sesion = new MSesion();
            $this->Modelo = new Modelo();
        }

        // Método para manejar el retorno después del inicio de sesión con Google
        public function handleGoogleCallback() {
            // Inicializa el cliente de Google
            $client = new Google_Client();
            $client->setClientId(ClientID);
            $client->setClientSecret(ClientSecret);
            $client->setRedirectUri(RedirectUri);
        
            // Obtiene el token de acceso después de la autenticación exitosa
            $token = $client->fetchAccessTokenWithAuthCode($_POST['code']);
        
            // Obtiene la información del perfil del usuario
            $oauth2 = new Google_Service_Oauth2($client);
            $userInfo = $oauth2->userinfo->get();
        
            // Almacena la información del usuario en la sesión o en la base de datos
            session_start();
            $_SESSION['google_user_info'] = $userInfo;
            
            // Ejecuta la función de inicio de sesión
            $this->inicioSesion();
        
            // Redirige al usuario a la página deseada después del inicio de sesión
            //header('Location: index.php'); // Reemplaza 'index.php' con la página deseada
        }
        
        /**
         * Método para iniciar sesión.
         * Verifica el nombre de usuario y establece las variables de sesión.
         * También maneja la opción de recordar la sesión mediante cookies.
         * @return array|null Datos del usuario autenticado o mensaje de error.
         */
        function inicioSesion() {
            session_start();
            if (isset($_POST['nombreUsuario']) && isset($_POST['contra'])) {
                $usuario = $_POST['nombreUsuario'];
                $contra = $_POST['contra'];

                // Intenta iniciar sesión con el usuario proporcionado
                $datos = $this->Sesion->inicio_sesion($usuario,$contra);
                if ($datos) {
                    // Establece variables de sesión
                    $_SESSION['id'] = $datos['id'];
                    $_SESSION['nombre'] = $datos['nombre'];
                    $_SESSION['perfil'] = $datos['perfil'];

                    // Maneja la opción "Recuérdame" con cookies
                    if (isset($_POST['recuerdame'])) {
                        $cookie = $_SESSION['id'] . '/' . $_SESSION['nombre'];
                        setcookie('sesion', $cookie, time() + 60 * 60 * 24 * 30, '/'); // Cookie dura 30 días
                    }

                    // Redirige según el perfil del usuario
                    switch ($datos['perfil']) {
                        case 2:
                            $this->vista = 'vistaClase';
                            $datos = [
                                'actividades' => [
                                    "actividad" => $this->Modelo->tabla_actividad(),
                                    "alumnos" => $this->Modelo->numero_alumnos_inscritos_por_actividad($_SESSION['id'])
                                ],
                                'alumnos' => $this->Modelo->tabla_alumno_inscripcion($_SESSION['id'])
                            ];
                            return $datos;
                            break;
                        default:
                            $this->vista = 'vistaListado';
                            $alumnos = [
                                'listado' => $this->Modelo->tabla_inscripciones(),
                                'momentos' => $this->Modelo->momentos()
                            ];
                            
                    }
                    // Retorna los datos de los alumnos si existen
                    if (!empty($alumnos['listado'])) {
                        return $alumnos;
                    }
                } else {
                    // Mensaje de error si el usuario o la contraseña son incorrectos
                    $this->mensaje = 'Usuario o contraseña incorrectos.';
                    $this->vista = 'vistaSesion';
                }
            } else {
                // Mensaje de error si no se rellenan todos los campos
                $this->mensaje = 'Rellene todos los campos';
                $this->vista = 'vistaSesion';
            }
        }

        /**
         * Método que cierra la sesión abierta y redirige a la vista de inicio de sesión.
         */
        public function cerrarSesion() {
            $this->vista = 'vistaSesion';
            session_start();
            session_unset(); // Destruye todas las variables de sesión
            session_destroy(); // Destruye la sesión

            // Elimina la cookie de sesión si existe
            if (isset($_COOKIE['sesion'])) {
                setcookie('sesion', '', time() - 1, '/');
            }

            // Establece el mensaje de cierre de sesión
            $this->mensaje = 'Se ha cerrado la sesión';
        }
    }