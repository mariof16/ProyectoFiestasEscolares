<?php $actividad = $datos['actividad'];?>
<main class="formMomento">
    <h1>Modificar Actividad <?php echo $actividad['nombre'] ?></h1>
    <?php if(isset($datos['mensaje'])){ ?>
    <h2 class="mensaje" id=error><?php echo $datos['mensaje']; ?></h2>
    <?php } ?>
    <form id="formularioactividad" action="/06/FiestasEscolares/" method="POST">
        <input type="hidden" name="id" value="<?php echo $actividad['id'] ?>">
        <input type="hidden" name="controlador" value="Actividad">
        <input type="hidden" name="metodo" value="modificarActividad">
        <div class="form-row">
            <div class="form-group nombre">
                <label for="nombre">Nombre de la actividad:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $actividad['nombre'] ?>" required>
            </div>
            <div class="form-group genero">
                <label for="genero">Género:</label>
                <select id="genero" name="genero" required>
                    <option value="M" <?php echo ($actividad['genero']=='M')? 'selected' : ''; ?>>Masculino</option>
                    <option value="F" <?php echo ($actividad['genero']=='F')? 'selected' : ''; ?>>Femenino</option>
                    <option value="X" <?php echo ($actividad['genero']=='X')? 'selected' : ''; ?>>Mixto</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required value="<?php echo $actividad['fecha_fin'] ?>">
            </div>
            <div class="form-group alumnos">
                <label for="nMaxAlumnos">Alumnos:</label>
                <input type="number" id="nMaxAlumnos" name="nMaxAlumnos" required value="<?php echo $actividad['nMaxAlumnos'] ?>">
            </div>
            <div class="form-group momento">
                <label for="momento">Momento:</label>
                <select name="momento" id="momento" required>
                    <option value="null" <?php echo ($actividad['id_momento']==NULL)? 'selected' : ''; ?>>Ninguno</option>
                    <?php foreach($datos['momentos'] as $momento) { ?>
                        <option value="<?php echo $momento['id']; ?>" <?php echo ($actividad['id_momento']==$momento['id'])? 'selected' : '';  ?> fechaInicio="<?php echo $momento['fecha_inicio']; ?>" fechaFin="<?php echo $momento['fecha_fin']; ?>"><?php echo $momento['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group-full">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo $actividad['descripcion'] ?></textarea>
        </div>
        <input type="submit" value="Modificar Actividad" class="volver">
    </form>
    <form action="/06/FiestasEscolares/src" method="post">
            <input type="hidden" name="controlador" value="Actividad">
            <input type="hidden" name="metodo" value="vistaListar">
            <button type="submit" class="boton volver">Volver</button>
    </form>
</main>
<script>
    document.getElementById('formularioactividad').addEventListener('submit', function(event) {
        const fechaFinActividad = new Date(document.getElementById('fecha_fin').value);
        const momentoSelect = document.getElementById('momento');
        const momentoSeleccionado = momentoSelect.options[momentoSelect.selectedIndex];
        const errorElement = document.getElementById('error');

        if (momentoSeleccionado.value !== "null") {
            const fechaInicioMomento = new Date(momentoSeleccionado.getAttribute('fechaInicio'));
            const fechaFinMomento = new Date(momentoSeleccionado.getAttribute('fechaFin'));

            if (fechaFinActividad < fechaInicioMomento || fechaFinActividad > fechaFinMomento) {
                event.preventDefault();
                errorElement.textContent = 'La fecha de fin de la actividad debe estar entre las fechas de inicio y fin del momento seleccionado.';
                return;
            }
        }
        errorElement.textContent = '';
    });
</script>
</body>
</html>
