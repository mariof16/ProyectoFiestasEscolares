<!DOCTYPE html>
<html>
    <head>
        <title>Inscripciones</title>
        <link rel="stylesheet" href="/06/FiestasEscolares/css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <div class="cabeceraIzquierda">
                <h1>Inscripciones Fiestas Escolares</h1>
            </div>
            <div class="cabeceraDerecha">
                <nav>
                    <form action="/06/FiestasEscolares/" method="post" style="display:inline;">
                        <input type="hidden" name="controlador" value="Controlador">
                        <input type="hidden" name="metodo" value="vistaListado">
                        <button type="submit" class="boton modificar">Alumnos Inscritos</button>
                    </form>
                    <?php if (isset($_SESSION['id'])): ?>
                        <?php if ($_SESSION['perfil'] == 2): ?>
                            <form action="/06/FiestasEscolares/" method="post" style="display:inline;">
                                <input type="hidden" name="controlador" value="Controlador">
                                <input type="hidden" name="metodo" value="vistaClase">
                                <button type="submit" class="boton ver">Inscripciones</button>
                            </form>
                        <?php endif; ?>
                        <?php if ($_SESSION['perfil'] == 1): ?>
                            <form action="/06/FiestasEscolares/" method="post" style="display:inline;">
                                <input type="hidden" name="controlador" value="Momento">
                                <input type="hidden" name="metodo" value="vistaListar">
                                <button type="submit" class="boton ver">Gestión Momentos</button>
                            </form>
                            <form action="/06/FiestasEscolares/" method="post" style="display:inline;">
                                <input type="hidden" name="controlador" value="Actividad">
                                <input type="hidden" name="metodo" value="vistaListar">
                                <button type="submit" class="boton ver">Gestión Actividades</button>
                            </form>
                            <form action="/06/FiestasEscolares/" method="post" style="display:inline;">
                                <input type="hidden" name="controlador" value="Controlador">
                                <input type="hidden" name="metodo" value="copiaSeguridad">
                                <button type="submit" class="boton ver">Copia de seguridad</button>
                            </form>
                        <?php endif; ?>
                        <form action="/06/FiestasEscolares/" method="post" style="display:inline;">
                            <input type="hidden" name="controlador" value="Sesion">
                            <input type="hidden" name="metodo" value="cerrarSesion">
                            <button type="submit" class="boton borrar">Cerrar sesión</button>
                        </form>
                    <?php else: ?>
                        <form action="/06/FiestasEscolares/" method="post" style="display:inline;">
                            <input type="hidden" name="controlador" value="Sesion">
                            <input type="hidden" name="metodo" value="vistaSesion">
                            <button type="submit" class="boton borrar">Iniciar Sesión</button>
                        </form>
                    <?php endif; ?>
                </nav>
            </div>
        </header>