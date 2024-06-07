<?php 
if($Control->mensaje){
    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
}
if(isset($_SESSION['perfil'])){if($_SESSION['perfil']==1){ ?>
<form action="/06/FiestasEscolares/" method="post">
    <input type="hidden" name="controlador" value="Controlador">
    <input type="hidden" name="metodo" value="vistaListadoMomento">
    <select name="buscarmomento" id="buscarmomento">
        <?php foreach($datos['momentos'] as $momento){ ?>
        <option value="<?php echo $momento['id'] ?>"><?php echo $momento['nombre'] ?></option>
        <?php } ?>
    </select>
    <input type="submit" value="Buscar" id="botonbuscar">
</form>
<?php }}

if(!empty($datos)){
    $datos = array_filter($datos, function($actividades) {
        return !empty($actividades);
    });
?>
<?php if(isset($_SESSION['id'])){ ?> <h2 class="mensaje">
    <form action="/06/FiestasEscolares/" method="post">
        <input type="hidden" name="controlador" value="Controlador">
        <input type="hidden" name="metodo" value="vistaDescargarPDF">
        <input type="submit" value="Descargar en PDF" class="boton ver"></form></h2> <?php } ?>
<?php
    if(isset($datos['listado'])){
        foreach ($datos['listado'] as $momento => $actividades) {
        ?>
        <main class="contenedor">
        <table>
            <caption><h2><?php echo $momento; ?></h2></caption>
            <?php
            foreach ($actividades as $actividad => $clases) {
                ?>
                <tr>
                    <th colspan="2" class="filaListado"><?php echo $actividad; ?></th>
                </tr>
                <?php
                foreach ($clases as $clase => $alumnos) { 
                    foreach ($alumnos as $alumno) {
                        echo "<tr><td>$alumno</td><td>$clase</td></tr>";
                    }
                }
            }
            ?>
        </table>
        </main>
        <?php
    } 
    } else {
        echo '<h2 class="mensaje">No hay inscripciones</h2>';
    }
    }
?>
</body>
</html>
