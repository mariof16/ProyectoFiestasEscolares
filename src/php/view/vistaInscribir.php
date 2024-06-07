<div class="contenedor_inscribir">
    <main class="contenedor">
            <div>
                <h2>Clase: <?php echo $datos['alumnos'][0]['clase']; ?></h2>
                <?php
                $actividades = array();
                $no_inscritos = array();

                $datosclase = $datos['alumnos']; 

                foreach($datosclase as $fila) {
                    if ($fila['actividad']) {
                        $actividades[$fila['actividad']][] = $fila['alumno'];
                    } else {
                        $no_inscritos[] = $fila['alumno'];
                    }
                }
                foreach ($actividades as $actividad => $alumnos) {
                    ?>
                    <table>
                        <tr><th><h3><?php echo $actividad; ?></h3></th></tr>
                    <?php
                    foreach ($alumnos as $alumno) {
                        echo "<tr><td>$alumno</td></tr>";
                    }
                    ?></table><?php
                }
                ?>
                <table>
                    <caption><h3>No Inscritos</h3></caption>
                <?php
                foreach ($no_inscritos as $alumno) {
                    echo "<tr><td>$alumno</td></tr>";
                }
                ?></table>
            </div>
    </main>
    <main class="contenedor">
        <h2><?php if(isset($datos['actividad']['clase'])){ echo $datos['actividad']['clase']['nombre']; } ?></h2>
        <h2><?php echo $datos['actividad']['actividad'] ?>: Máximo <?php echo $datos['actividad']['max_alumnos']; ?> Alumnos.</h2>
        <form action="/06/FiestasEscolares/" method="post">
            <?php if(isset($datos['actividad']['clase'])){ ?> <input type="hidden" name="clase" value="<?php echo $datos['actividad']['clase']['idSeccion']; ?>"> <?php } ?>
            <input type="hidden" name="controlador" value="<?php echo $datos['actividad']['rutaForm']['controlador']; ?>">
            <input type="hidden" name="metodo" value="<?php echo $datos['actividad']['rutaForm']['metodo']; ?>">
            <input type="hidden" name="id" value=" <?php echo $datos['actividad']['id']; ?>">
            <?php
                for ($i = 0; $i < $datos['actividad']['max_alumnos']; $i++) {
            ?>
                <p><select name="alumnos[<?php echo $i; ?>]">
                    <option value="0">- Ninguno -</option>
                    <?php
                    foreach ($datos['actividad']['alumnos'] as $fila) {
                        ?>
                        <option value="<?php echo $fila['id']; ?>"
                            <?php
                            if (isset($datos['actividad']['alumnos_inscritos'][$i]) && in_array($fila['id'], $datos['actividad']['alumnos_inscritos'][$i])) {
                                echo "selected";
                            }
                            ?>
                        ><?php echo $fila['nombre']; ?></option>
                        <?php
                    }
                    ?>
                </select></p>
            <?php
                }
            ?>
            <input type="submit" value="Enviar">
        </form>
        <form action="/06/FiestasEscolares/" method="post">
                <input type="hidden" name="controlador" value="<?php echo $datos['actividad']['rutaVolver']['controlador']; ?>">
                <input type="hidden" name="metodo" value="<?php echo $datos['actividad']['rutaVolver']['metodo']; ?>">
                <button type="submit" class="boton volver">Volver</button>
        </form>
    </main>
</div>
</body>
</html>
