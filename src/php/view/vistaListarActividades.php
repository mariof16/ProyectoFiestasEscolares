<main class="listado">
    <div class="header-momentos">
        <h2>Listado de Actividades</h2>
        <form action="/06/FiestasEscolares/" method="post">
            <input type="hidden" name="controlador" value="Actividad">
            <input type="hidden" name="metodo" value="vistaFormularioActividad">
            <button type="submit" class="boton volver" id="crearMomento">Crear Actividad</button>
        </form> 
    </div>
    <table>
        <caption>Actividades registradas</caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Género</th>
                <th>Descripción</th>
                <th>Fecha Fin</th>
                <th>Máximo de Alumnos</th>
                <th>Momento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php

                if(isset($datos['actividades'])){foreach ($datos['actividades'] as $actividad) { ?>
                    <tr>
                        <td><?php echo $actividad['nombre'] ?></td>
                        <td><?php echo $actividad['genero'] ?></td>
                        <td class="listadescripcion"><?php echo $actividad['descripcion'] ?></td>
                        <td><?php echo $actividad['fecha_fin'] ?></td>
                        <td class="listadonumero"><?php echo $actividad['nMaxAlumnos'] ?></td>
                        <td><?php echo $actividad['momento'] ?></td>
                        <td>
                            <form action="/06/FiestasEscolares/" method="post">
                                <input type="hidden" name="controlador" value="Actividad">
                                <input type="hidden" name="metodo" value="vistaFormularioActividad">
                                <input type="hidden" name="id" value="<?php echo $actividad['id'] ?>">
                                <button type="submit" class="boton modificar">Modificar</button>
                            </form>
                            <form action="/06/FiestasEscolares/" method="post">
                                <input type="hidden" name="controlador" value="Actividad">
                                <input type="hidden" name="metodo" value="borrarActividad">
                                <input type="hidden" name="id" value="<?php echo $actividad['id'] ?>">
                                <button type="submit" class="boton borrar">Borrar</button>
                            </form>
                        </td>
                   </tr>
                <?php }}else{
                      echo '<h2 class="mensaje">No hay Actividades</h2>';
                }
            ?>
        </tbody>
    </table>
</main>
</body>
</html>
