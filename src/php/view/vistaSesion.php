    <img src="/06/FiestasEscolares/img/logo.png" id="imagenlogin">
    <main class="sesion">
        <h1>Inicio de sesión</h1>
        <?php 
            if ($Control->mensaje) {
                echo '<h2 class="mensaje">' . $Control->mensaje . '</h2>';
            }
        ?>
        <form id="loginForm" action="/06/FiestasEscolares/" method="post">
            <input type="hidden" name="controlador" value="Sesion">
            <input type="hidden" name="metodo" value="inicioSesion">
            
            <label for="nombreUsuario">Correo electrónico:</label>
            <input type="text" name="nombreUsuario" id="nombreUsuario" required>

            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" id="contra" required>
            
            <input type="submit" value="Iniciar Sesión">
        </form>
    </main>
</body>
</html>
