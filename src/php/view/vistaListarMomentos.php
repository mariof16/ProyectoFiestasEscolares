<main class="listado">
    <div class="header-momentos">
        <h2>Listado de Momentos</h2>
        <form action="/06/FiestasEscolares/" method="post">
            <input type="hidden" name="controlador" value="Momento">
            <input type="hidden" name="metodo" value="vistaFormularioMomento">
            <button type="submit" class="boton volver" id="crearMomento">Crear Momento</button>
        </form>
    </div>
    <table>
        <caption>Momentos Registrados</caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
                if(isset($datos)){foreach ($datos as $momento) { ?>
                    <tr>
                        <td><?php echo $momento['nombre'] ?></td>
                        <td><?php echo $momento['fecha_inicio'] ?></td>
                        <td><?php echo $momento['fecha_fin'] ?></td>
                        <td>
                            <form action="/06/FiestasEscolares/" method="post">
                                <input type="hidden" name="controlador" value="Momento">
                                <input type="hidden" name="metodo" value="vistaFormularioMomento">
                                <input type="hidden" name="id" value="<?php echo $momento['id']; ?>">
                                <button type="submit" class="boton modificar">Modificar</button>
                            </form>
                            <form action="/06/FiestasEscolares/" method="post">
                                <input type="hidden" name="controlador" value="Momento">
                                <input type="hidden" name="metodo" value="borrarMomento">
                                <input type="hidden" name="id" value="<?php echo $momento['id']; ?>">
                                <button type="submit" class="boton borrar">Borrar</button>
                            </form>
                        </td>
                   </tr>
                <?php }}else{
                    echo '<h2 class="mensaje">No hay Momentos</h2>';
                }
            ?>
        </tbody>

    </table>
</main>
</body>
</html>
