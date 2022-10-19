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
    
        //CREAMOS LA CONEXIÓN CON EL SERVIDOR QUE SE ALMACENARÁ EN $conexion
        $conexion = mysqli_connect($servidor, $usuario, $contrasena) or die("No se ha podido conectar con el servidor");
    
        //CREAMOS LA CONEXIÓN CON LA BASE DE DATOS QUE SE ALMACENARÁ EN $db
        $db = mysqli_select_db($conexion, $database) or die("No se ha podido conectar con la base de datos");
    
        echo "conexion correcta";

        $sql = "SELECT * FROM cuenta where ID_cuenta = 1";
        $resultados = mysqli_query($conexion, $sql);
        if ($resultados->num_rows > 0) {
            while ($fila = $resultados->fetch_assoc()) {
                $item_1 = $fila["ID_cuenta"];
                $item_2 = $fila["nombre"];
                $item_3 = $fila["apellidos"];
                $item_4 = $fila["apodo"];
                $item_5 = $fila["cod_clase"];
                $item_6 = $fila["rol"];
            }
        }
        // este for each vacio actua de contenedor para los campos de perfil de usuario que se encuentra mas abajo
        foreach ($resultados as $columna) {
            
        }

        // calculo de la fecha de caducidad
        $fechaActual = date('10-06-y'); // 2016-12-29
        $fechaCaducida = strtotime ('+1 day' , strtotime($fechaActual)); //Se añade un año mas
        $fechaCaducida = date ('d-m-y',$fechaCaducida);

        // obtencion de reviews
        $sql = "SELECT nota,texto,nombre_idioma,titulo FROM review, libro where ID_cuenta = 1 and review.ID_libro = libro.ID_libro;";
        $resultadosReview = mysqli_query($conexion, $sql);
        if ($resultadosReview->num_rows > 0) {
            while ($fila = $resultadosReview->fetch_assoc()) {
                $item_1 = $fila["titulo"];
                $item_2 = $fila["nota"];
                $item_3 = $fila["texto"];
                $item_4 = $fila["nombre_idioma"];
            }
        }
       
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
        echo    "<li id='nombre'>".$columna['nombre']." ".$columna['apellidos']."</li>";
        echo    "<li id='apodo'> Apodo: ".$columna['apodo']."</li>";
        echo    "<li id='fechaNac'> Nacimiento: ".$columna['fecha_nac']."</li>";
        echo    "<li id='curso'> Clase: ".$columna['cod_clase']."</li>";
        echo    "<li id='fechaCad'> Fecha caducidad: ".$fechaCaducida."</li>";
        echo    "<li id=nivel'>  Rol: ".$columna['rol']."</li>";
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