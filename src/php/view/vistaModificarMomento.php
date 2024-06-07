<main class="formMomento">
    <h1>Modificar Momento</h1>
    <?php if(isset($datos['mensaje'])){ ?>
    <h2 class="mensaje" id=error><?php echo $datos['mensaje']; ?></h2>
    <?php } ?>
    <form id="momentoForm" action="/06/FiestasEscolares/" method="POST">
        <input type="hidden" name="controlador" value="Momento">
        <input type="hidden" name="metodo" value="modificarMomento">
        <label for="nombre">Nombre del Momento:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $datos['nombre']; ?>" required>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d', strtotime($datos['fecha_inicio'])); ?>" required>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d', strtotime($datos['fecha_fin'])); ?>" required>

        <input type="hidden" id="id" name="id" value="<?php echo $datos['id']; ?>">
    
        <input type="submit" value="Modificar Momento">
    </form>
    <form action="/06/FiestasEscolares/Momento/vistaListar" method="post">
            <input type="hidden" name="controlador" value="Momento">
            <input type="hidden" name="metodo" value="vistaListar">
            <button type="submit" class="boton volver">Volver</button>
    </form>
</main>
<script>
    document.getElementById('momentoForm').addEventListener('submit', function(event) {
        const fechaInicio = new Date(document.getElementById('fecha_inicio').value);
        const fechaFin = new Date(document.getElementById('fecha_fin').value);
        const errorElement = document.getElementById('error');

        if (fechaFin <= fechaInicio) {
            event.preventDefault();
            errorElement.textContent = 'La fecha de fin debe ser mayor que la fecha de inicio.';
        } else {
            errorElement.textContent = '';
        }
    });
</script>
</body>
</html>
