<main>
    <form action="/06/FiestasEscolares/" method="post">
        <input type="hidden" name="metodo" value="generarPDF">
        <h2>Lista de Actividades:</h2>
        <?php 
            if($Control->mensaje){
                echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
            }
        ?>
        <ul>
            <li>
                <input type="checkbox" id="todos" name="todos">
                <label for="todos">Todos</label>
            </li>
        </ul>
        <hr>
        <ul>
            <?php $fecha = date("Y-m-d"); foreach($datos as $actividad){ ?>
                <li>
                    <input type="checkbox" id="<?php echo $actividad['nombre']; ?>" name="actividad[]" value="<?php echo $actividad['nombre']; ?>">
                    <label for="<?php echo $actividad['nombre']; ?>"><?php echo $actividad['nombre']; ?></label>
                </li>
            <?php } ?>
        </ul>
        <input type="submit" value="Descargar PDF">
    </form>
    <form action="/06/FiestasEscolares/" method="post">
            <input type="hidden" name="controlador" value="Controlador">
            <input type="hidden" name="metodo" value="vistaListado">
            <button type="submit" class="boton volver">Volver</button>
    </form>
</main>
</body>
</html>
