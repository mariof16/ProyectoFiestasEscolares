<?php
try {
    require_once 'php/config/config.php';

    $ruta = RutaPorDefecto;
    $controlador = ControladorPorDefecto;

    /* Pregunta si existe el controlador enviado por $_POST['controlador'] */
    if (isset($_POST['controlador'])) {
        $ruta = strtolower($_POST['controlador']);
        $controlador = $_POST['controlador'];
    }

    // Verifica si el archivo del controlador existe
    $controladorPath = 'php/controller/' . $ruta . '.php';
    if (!file_exists($controladorPath)) {
        throw new Exception("Controlador no encontrado");
    }

    require $controladorPath;
    if (!class_exists($controlador)) {
        throw new Exception("Clase del controlador no encontrada");
    }

    $Control = new $controlador();

    /* Pregunta si existe el método enviado por $_POST['metodo'] */
    if (isset($_POST['metodo'])) {
        $metodo = $_POST['metodo'];
    } else {
        $metodo = MetodoPorDefecto;
    }

    // Verifica si el método existe en el controlador
    if (!method_exists($Control, $metodo)) {
        throw new Exception("Método no encontrado");
    }

    // Llama al método específico si se proporciona, de lo contrario, llama al método por defecto
    $datos = $Control->{$metodo}();

    /* Mostrar la vista */
    include 'php/view/template/cabecera.php';
    include 'php/view/' . $Control->vista . '.php';
} catch (Exception $e) {
    var_dump($e);
    header("Location: error404.php");
    exit();
} catch (\Throwable $e) {
    header("Location: error404.php");
    var_dump($e);
    exit();
}
?>
