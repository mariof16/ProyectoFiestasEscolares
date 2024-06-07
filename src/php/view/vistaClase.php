<div class="contenedor_flex">
    <main class="contenedor">
        <div>
            <h2>Clase: <?php echo $datos['alumnos'][0]['clase']; ?></h2>
            <?php
            // Separar alumnos inscritos de los no inscritos
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
            // Mostrar tablas de alumnos inscritos por actividad
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
            // Mostrar tabla de alumnos no inscritos
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
        <div>
            <table class="alumnos">
                <tr>
                    <th>Actividad</th>
                    <th>Max Alumnos</th>
                    <th>Descripcion</th>
                    <th>Inscritos</th>
                    <th></th>
                </tr>
                <?php
                $datosactivades = $datos['actividades'];
                $fecha = date("Y-m-d");
                foreach($datosactivades['actividad'] as $actividad){
                    $alumnos_inscritos = 0;
                    foreach ($datosactivades['alumnos'] as $inscripcion) {
                        if ($inscripcion['actividad'] == $actividad['id']) {
                            $alumnos_inscritos = $inscripcion['numero_alumnos_inscritos'];
                            break;
                        }
                    }
                    if($actividad['fecha_fin']>=$fecha)
                    ?>
                    <tr>
                        <td class="<?php if($alumnos_inscritos<$actividad['nMaxAlumnos']){echo "noinscrito";}?>"><?php echo $actividad['nombre']; ?></td>
                        <td><?php echo $actividad['nMaxAlumnos']; ?></td>
                        <td><?php echo $actividad['descripcion']; ?></td>
                        <td><?php echo $alumnos_inscritos; ?></td>
                        <td>
                            <form action="/06/FiestasEscolares/" method="post">
                                <input type="hidden" name="controlador" value="Controlador">
                                <input type="hidden" name="metodo" value="vistaInscribir">
                                <input type="hidden" name="id" value="<?php echo $actividad['id']; ?>">
                                <button type="submit" class="inscribir boton volver"><?php echo ($alumnos_inscritos > 0) ? 'Modificar' : 'Inscribir'; ?></button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </main>
</div>
