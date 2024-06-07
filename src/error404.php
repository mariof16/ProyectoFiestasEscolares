    <?php include 'php/view/template/cabecera.php';?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <style>
        #error-container {
            margin-top: 100px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        #error-heading {
            font-size: 36px;
            margin-bottom: 10px;
        }
        #error-message {
            font-size: 18px;
            margin-top: 0;
        }
        #home-link {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div id="error-container">
        <h1 id="error-heading">Página no encontrada</h1>
        <p id="error-message">Lo sentimos, la página que estás buscando no se ha encontrado.</p>
        <p>Puedes regresar a la <a id="home-link" href="https://proyectos.esvirgua.com/06/FiestasEscolares/src/">página principal</a> o intentar buscar nuevamente.</p>
        <img src="/06/FiestasEscolares/src/img/404.png">
    </div>
</body>
</html>
