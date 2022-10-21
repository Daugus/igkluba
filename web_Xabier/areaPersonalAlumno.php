<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="areaPersonalAlumno.css">
    <title>Área Personal</title>
</head>
<?php
    /*
    Al cargar la pagina el area personal toma los datos de la cuenta que ha iniciado sesion desde la base de datos.
    Con los datos obtenidos de la BD, se rellenan los campos del area personal.

    Para las reviews uso una estructura repetitiva que van tomando las reviews que ha escrito el alumno desde la BD y
    escribo cada review una a una hasta que no queden mas de ese alumno.
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
        $fechaActual = date('10-06-y'); // 2016-12-29
        $fechaCaducida = strtotime ('+1 day' , strtotime($fechaActual)); //Se añade un año mas
        $fechaCaducida = date ('d-m-y',$fechaCaducida);

        // obtencion de reviews
        // preparo la consulta
        $consulta = $conexion->prepare('SELECT nota,texto,nombre_idioma,titulo FROM review, libro where ID_cuenta = 1 and review.ID_libro = libro.ID_libro;');
        // ejecuto la consulta
        $consulta->execute();
        // en resultados guardo todos los registros y los muesto en el perfil
        $resultadosReview = $consulta->fetchAll();
        
        }
        catch (PDOException $e){
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

    <div id="contenedorUsuario">
        <img id="pfp" src="img_110805-1084281250.png" alt="Foto de perfil">
        <?php
        echo "<ul>";
        echo    "<li id='nombre'>".$resultadosPerfil['nombre']." ".$resultadosPerfil['apellidos']."</li>";
        echo    "<li id='apodo'> Apodo: ".$resultadosPerfil['apodo']."</li>";
        echo    "<li id='fechaNac'> Nacimiento: ".$resultadosPerfil['fecha_nac']."</li>";
        echo    "<li id='curso'> Clase: ".$resultadosPerfil['cod_clase']."</li>";
        echo    "<li id='fechaCad'> Fecha caducidad: ".$fechaCaducida."</li>";
        echo    "<li id=nivel'>  Rol: ".$resultadosPerfil['rol']."</li>";
        echo "</ul>";
        ?>  
    </div>

    <div id="botones">
        <a href="" id="pedirLibro">Solicitar libro</a>
        <a href="" id="pedirTrad">Solicitar traducción</a>
    </div>
    
    <div id="contenedorReviews">
        <h2>Mis Valoraciones</h2>
        <?php
            foreach ($resultadosReview as $columna) {
                echo "<table>";
                echo    "<tr>";
                echo        "<th id='titulo'>".$columna['titulo']."</th>";
                echo        "<th id='nota'>NOTA: ".$columna['nota']."/5</th>";
                echo    "</tr>";
                echo    "<tr>";
                echo        "<td id='review'>".$columna['texto']."</td>";
                echo    "</tr>";
                echo "</table>";
                echo "<br>";    
        }
        ?>
    </div>

</body>
</html>