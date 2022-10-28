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

// consultas
try {

    $usuario = "root";
    $contrasena = "";
    $servidor = "localhost";
    $database = "igkluba";

    // obtencion del perfil
    // creo la conexion
    $conexion = new PDO("mysql:host=$servidor;dbname=$database",$usuario,$contrasena);
    // convierto un posible error en una excepcion
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexion establecida";
    echo "<br>";

    // preparo la consulta
    $consulta = $conexion->prepare('SELECT cuenta.nombre AS "nombreCuenta", apellido, apodo, fecha_nacimiento, rol, clase.nombre AS "nombreClase" FROM cuenta, clase where clase.cod = cuenta.cod_clase AND id = 1');
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosPerfil = $consulta->fetch();
    //print_r($resultadosPerfil);

    // calculo de la fecha de caducidad
    $fechaActual = date('10-06-y');
    $fechaCaducida = strtotime('+1 day', strtotime($fechaActual)); //Se añade un año mas
    $fechaCaducida = date('d-m-y', $fechaCaducida);

    // obtencion de reviews
    // preparo la consulta
    $consulta = $conexion->prepare('SELECT nota,texto,nombre_idioma,serie FROM review, libro WHERE review.id_libro = libro.id and id_cuenta = 1;');
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosReview = $consulta->fetchAll();

    // obtencion de la clase
    // preparo la consulta
    $consulta = $conexion->prepare('SELECT cod, nombre from clase;');
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosClase = $consulta->fetchAll();
    
    // obtencion de alumnos
    // preparo la consulta usando la clase obtenida del desplegable de clases
    $codigoClase = $_REQUEST['cod'];
    $consulta = $conexion->prepare("SELECT id, nombre, apellido, apodo, fecha_nacimiento from cuenta where rol = 'Ikasle' and cod_clase = '".$codigoClase."';");
    // ejecuto la consulta
    $consulta->execute();
    // en resultados guardo todos los registros y los muesto en el perfil
    $resultadosAlumnos = $consulta->fetchAll();
    // la consulta de los alumnos utiliza la clase obtenida
    
    // mantengo la seleccion de la clase despues de darle a enviar
    
    
    // obtencion de solicitudes de idioma
    // preparo la consulta
    $consulta = $conexion->prepare('SELECT id_libro, id_alumno, titulo_alternativo, nombre_idioma, nombre, apellido, apodo FROM cuenta, solicitud_idioma WHERE solicitud_idioma.id_alumno = cuenta.id AND rol = "Ikasle" AND cod_clase = "'.$codigoClase.'";');
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
        echo    "<li class='perfilLista'>". $resultadosPerfil['nombreCuenta'] ." ". $resultadosPerfil['apellido'] ."</li>";
        echo    "<li class='perfilLista'> Apodo: " . $resultadosPerfil['apodo'] . "</li>";
        echo    "<li class='perfilLista'> Nacimiento: " . $resultadosPerfil['fecha_nacimiento'] . "</li>";
        echo    "<li class='perfilLista'> Clase: " . $resultadosPerfil['nombreClase'] . "</li>";
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
            echo        "<th id='titulo'>" . $columna['serie'] . "</th>";
            echo        "<th id='nota'>NOTA: " . $columna['nota'] . "/5</th>";
            echo    "</tr>";
            echo    "<tr>";
            echo        "<td id='review'>" . $columna['texto'] . "</td>";
            echo        "<td> <a href=''>Editar</a> <a id='eliminar' href=''>Eliminar</a> </td>";
            echo    "</tr>";
            echo "</table>";
            echo "<br>";
        }
        ?>
    </div>

    <!-- CLASES Y ALUMNOS -->
    <div id="contenedorClase">
        <form action="areaPersonalProfesor.php" method="POST">
            <label for="clase">Mostrar grupo </label>
            <select name="cod" id="clase">
                <?php
                foreach ($resultadosClase as $columna) {
                    echo "<option class='cod_clase' value='" . $columna['cod'] . "'>" . $columna['nombre'] . "</option>";
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
                echo                    "<li>". $columna['nombre'] . " ". $columna['apellido'] ."</li>";
                echo                    "<li> Apodo: ". $columna['apodo'] ."</li>";
                echo                    "<li>Fecha nacimiento: ". $columna['fecha_nacimiento'] ." </li>";
                echo                    "<li>Curso: 22-23 </li>";
                echo                    "<li>Fecha caducidad: ". $fechaCaducida ."</li>";
                echo                "</ul>";
                echo             "</div>";
                echo            "<div class='BOTON'>";

                // obtengo la clase seleccionada
                $codigoClase = $_REQUEST['cod'];
                // obtengo la id para el formulario
                $idAlumno = $columna['id'];
                // si elijo los que no tienen clase pongo un menu para añadirlos a otra clase
                if ($codigoClase == "NULO") {
                    echo "<form action='operacionConfirmacion.php' method='POST'>";
                    echo    "<label for='clase'>Añadir a grupo </label>";
                    echo    "<select name='cod' id='clase'>";
                                foreach ($resultadosClase as $columna) {
                                    echo "<option class='cod_clase' value='" . $columna['cod'] . "'>" . $columna['nombre'] . "</option>";
                                    $idClase = $columna['cod'];
                                }
                    echo    "</select>";
                    echo "<a href='operacionConfirmacion.php?&id=".$idAlumno."&cod=".$idClase."' name='eliminarAlumno' id='aceptar'>Aceptar</a>";


                    //echo    "<input type='submit' class='Enviar' name='AnadirAlumno' value='Enviar'>";
                    echo "</form>";
                }

                // si elijo a los que ya tienen clase pongo el menu para eliminarlos si se desea
                else {
                echo                "<a href='operacionConfirmacion.php?&id=".$columna['id']."' name='eliminarAlumno' id='eliminar'>Eliminar</a>";
                }
                
                echo            "</div>";
                echo       "</div>";
                // tomo id cuenta desde la url
                // voy a una nueva pagina
                // hago la operacion
            }
          
        ?>

    </div>

    <!-- SOLICITUDES IDIOMA -->
    <div id="contenedorIdioma">
        <form action="areaPersonalProfesor.php" method="POST" onsubmit="solIdiomas()">
            <label for="clase">Mostrar grupo </label>
            <select name="cod" id="clase">
                <?php
                foreach ($resultadosClase as $columna) {
                    echo "<option class='cod_clase' value='" . $columna['cod'] . "'>" . $columna['nombre'] . "</option>";
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
        echo                "<li>". $columna['nombre'] . " ". $columna['apellido'] ."</li>";
        echo                "<li> Apodo: ". $columna['apodo'] ."</li>";
        echo                "<li> Ha solicitado el libro: ".$columna['titulo_alternativo']." en ".$columna['nombre_idioma'];
        echo            "</ul>";    
        echo        "</div>";
        echo        "<div class='BOTONES'>";
        echo            "<ul>";
        echo                "<a href='operacionConfirmacion.php?&ID_libro=".$columna['id_libro']."&ID_cuenta=".$columna['id_alumno']."&nombre_idioma=".$columna['nombre_idioma']."&titulo=".$columna['titulo_alternativo']."' id='aceptar' name='aceptar'>Aceptar</a>";
        echo                "<a href='operacionConfirmacion.php?&ID_libro=".$columna['id_libro']."&ID_cuenta=".$columna['id_alumno']."&nombre_idioma=".$columna['nombre_idioma']."&titulo=".$columna['titulo_alternativo']."' id='eliminar' name='eliminar'>Eliminar</a>";
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