<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="areaPersonalProfesor.css">
    <script src="areaPersonalProfesor.js"></script>
    <title>Área Personal</title>
</head>
<?php
    /*
    Al cargar la pagina el area personal toma los datos de la cuenta que ha iniciado sesion desde la base de datos.
    Con los datos obtenidos de la BD, se rellenan los campos del area personal.

    Para las reviews uso una estructura repetitiva que van tomando las reviews que ha escrito el alumno desde la BD y
    escribo cada review una a una hasta que no queden mas de ese alumno.

    Para los grupos uso una estructura repetitiva que van tomando las clases desde la BD y
    escribo cada clase una a una hasta que no queden mas.

    Para los alumnos uso una estructura repetitiva que van tomando los desde la BD en base al grupo seleccionado
    escribo cada alumno uno a uno hasta que no queden mas.

    Para las solicitudes de idioma de los alumnos uso una estructura repetitiva que van tomando los desde la BD en base al grupo seleccionado
    escribo cada solicitud una a una hasta que no queden mas.
    */


try {

    $usuario = "root";
    $contrasena = "";
    $servidor = "localhost";
    $database = "bdlibrosunamuno";

    // obtencion del perfil
    // creo la conexion
    $conexion = new PDO("mysql:host=$servidor;dbname=$database",$usuario,$contrasena);
    // convierto un posible error en una excepcion
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexion establecida";
    echo "<br>";

    // preparo la consulta
    $consulta = $conexion->prepare('SELECT * FROM cuenta where ID_cuenta = 1');
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosPerfil = $consulta->fetch();


    // calculo de la fecha de caducidad
    $fechaActual = date('10-06-y');
    $fechaCaducida = strtotime('+1 day', strtotime($fechaActual)); //Se añade un año mas
    $fechaCaducida = date('d-m-y', $fechaCaducida);

    // obtencion de reviews
    // preparo la consulta
    $consulta = $conexion->prepare('SELECT nota,texto,nombre_idioma,titulo FROM review, libro where ID_cuenta = 1 and review.ID_libro = libro.ID_libro;');
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosReview = $consulta->fetchAll();

    // obtencion de la clase
    // preparo la consulta
    $consulta = $conexion->prepare('SELECT cod_clase, nombre from clase;');
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosClase = $consulta->fetchAll();
    
    // obtencion de alumnos
    // preparo la consulta usando la clase obtenida del desplegable de clases
    $codigoClase = $_REQUEST['cod_clase'];
    $consulta = $conexion->prepare("SELECT nombre, apellidos, apodo, fecha_nac from cuenta where rol = 'alumno' and cod_clase = '".$codigoClase."';");
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosAlumnos = $consulta->fetchAll();
    // la consulta de los alumnos utiliza la clase obtenida
    
    // mantengo la seleccion de la clase despues de darle a enviar
    
    
    // obtencion de solicitudes de idioma
    // preparo la consulta
    $consulta = $conexion->prepare('SELECT titulo, nombre_idioma, nombre, apellidos, apodo FROM cuenta, solicitudidioma WHERE cuenta.ID_cuenta = solicitudidioma.ID_cuenta and cod_clase = "'.$codigoClase.'";');
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo las solicitudes y las muestro en solicitudes de idioma
    $resultadosSolIdioma = $consulta->fetchAll();

} catch (PDOException $e) {
    echo "la conexion ha fallado: " . $e->getMessage();
}



?>

<body>
    <header>
        <nav>
            <ul>
                <li></li>
                <li></li>
            </ul>
        </nav>
    </header>

    <!-- PERFIL -->
    <div id="contenedorUsuario">
        <img class="pfp" src="img_110805-1084281250.png" alt="Foto de perfil">
        <?php 
        echo "<ul>";
        echo    "<li class='perfilLista'>". $resultadosPerfil['nombre'] ." ". $resultadosPerfil['apellidos'] ."</li>";
        echo    "<li class='perfilLista'> Apodo: " . $resultadosPerfil['apodo'] . "</li>";
        echo    "<li class='perfilLista'> Nacimiento: " . $resultadosPerfil['fecha_nac'] . "</li>";
        echo    "<li class='perfilLista'> Clase: " . $resultadosPerfil['cod_clase'] . "</li>";
        echo    "<li class='perfilLista'> Fecha caducidad: " . $fechaCaducida . "</li>";
        echo    "<li class='perfilLista'>  Rol: " . $resultadosPerfil['rol'] . "</li>";
        echo "</ul>";
        ?>
    </div>

    <div id="botones">
        <button id="grupos" onclick="grupos()">Mostrar grupos</button>
        <button id="reviews" onclick="reviews()">Mostrar reviews</a>
        <button id="solicitudIdiomas" onclick="solIdiomas()">solicitudes idioma</a>
        <button id="solicitudAdmision" onclick="solAdmision()">Solicitudes admisión</a>
    </div>

    <!-- REVIEWS -->
    <div id="contenedorReviews">
        <h2>Mis Valoraciones</h2>
        <?php 
        foreach ($resultadosReview as $columna) {
            echo "<table>";
            echo    "<tr>";
            echo        "<th id='titulo'>" . $columna['titulo'] . "</th>";
            echo        "<th id='nota'>NOTA: " . $columna['nota'] . "/5</th>";
            echo    "</tr>";
            echo    "<tr>";
            echo        "<td id='review'>" . $columna['texto'] . "</td>";
            echo    "</tr>";
            echo "</table>";
            echo "<br>";
        }
        ?>
    </div>

    <!-- CLASES Y ALUMNOS -->
    <div id="contenedorClase">
        <form action="areaPersonalProfesor.php" method="POST" onsubmit="grupos()">
            <label for="clase">Mostrar grupo </label>
            <select name="cod_clase" id="clase">
                <?php
                foreach ($resultadosClase as $columna) {
                    echo "<option class='cod_clase' value='" . $columna['cod_clase'] . "'>" . $columna['nombre'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" class="Enviar" name="Enviar" value="Enviar">
        </form>
        <?php 
            foreach ($resultadosAlumnos as $columna) {
                echo    "<div id='contenedorAlumno'>";
                echo            "<div class='FOTO-PERFIL'><img class='pfp' src='img_110805-1084281250.png' alt='Foto de perfil'></div>";
                echo            "<div class='LI'>";
                echo                "<ul>";
                echo                    "<li>". $columna['nombre'] . " ". $columna['apellidos'] ."</li>";
                echo                    "<li> Apodo: ". $columna['apodo'] ."</li>";
                echo                    "<li>Fecha nacimiento: ". $columna['fecha_nac'] ." </li>";
                echo                    "<li>Curso: 22-23 </li>";
                echo                    "<li>Fecha caducidad: ". $fechaCaducida ."</li>";
                echo                "</ul>";
                echo             "</div>";
                echo            "<div class='BOTON'>";
                echo                "<button href='' id='eliminar'>Eliminar</button>";
                echo            "</div>";
                echo       "</div>";
            }
        ?>

    </div>

    <!-- SOLICITUDES IDIOMA -->
    <div id="contenedorIdioma">
        <form action="areaPersonalProfesor.php" method="POST" onsubmit="solIdiomas()">
            <label for="clase">Mostrar grupo </label>
            <select name="cod_clase" id="clase">
                <?php
                foreach ($resultadosClase as $columna) {
                    echo "<option class='cod_clase' value='" . $columna['cod_clase'] . "'>" . $columna['nombre'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" class="Enviar" name="Enviar" value="Enviar">
        </form>
    <?php
    foreach ($resultadosSolIdioma as $columna) {
        echo    "<div id='contenedorSolicitudIdioma'>";
        echo        "<div class='FOTO-LIBRO'><img id='caratula' src='img_110805-1084281250.png' alt='Carátula del libro'></div>";
        echo        "<div class='ALUMNO'>";
        echo            "<ul>";
        echo                "<li>". $columna['nombre'] . " ". $columna['apellidos'] ."</li>";
        echo                "<li> Apodo: ". $columna['apodo'] ."</li>";
        echo                "<li> Ha solicitado el libro: ".$columna['titulo']." en ".$columna['nombre_idioma'];
        echo            "</ul>";    
        echo        "</div>";
        echo        "<div class='BOTONES'>";
        echo            "<ul>";
        echo                "<button href='' id='aceptar'>Aceptar</button>";
        echo                "<button href='' id='eliminar'>Eliminar</button>";
        echo            "</ul>";
        echo        "</div>";
        echo    "</div>";
    }
    ?>
    </div>
    <div id="contenedorAdmision">
        contenedor admision
    </div>

</body>

</html>