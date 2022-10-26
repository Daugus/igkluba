<?php

//----------------CONEXION CON BASE DE DATOS-----------------------
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

//-----------------CLASES Y GRUPOS---------------------------------
// si quiero eliminar a un alumno de su clase
if(isset($_REQUEST["ID_cuenta"])) {

    $id = $_REQUEST['ID_cuenta'];
    $name = $_REQUEST['nombre'];
    $surname = $_REQUEST['apellidos'];
    $nickname = $_REQUEST['apodo'];

    // preparo el borrado
    $borradoCuentaClase = $conexion->prepare("UPDATE cuenta SET cod_clase = 'null' WHERE ID_cuenta = ".$id.";");
    // ejecuto el borrado
    $borradoCuentaClase->execute();
    echo "operacion realizada";
    }

//--------------------SOLICITUDES DE IDIOMA---------------------------------
// si quiero eliminar una solicitud de idioma
if (isset($_REQUEST["id_libro"])) {

    $idLibro = $_REQUEST['id_libro'];

    // preparo el borrado
    $borradoSolLibro = $conexion->prepare("DELETE FROM solicitudidioma WHERE id_libro = ".$idLibro.";");
    // ejecuto el borrado
    $borradoSolLibro->execute();
    echo "operacion realizada";


}
// si quiero aceptar una solicitud de idioma

if (isset($_REQUEST["aceptar"])) {

    $idLibro = $_REQUEST['id_libro'];
    $id = $_REQUEST['ID_cuenta'];
    $nombre_idioma = $_REQUEST['nombre_idioma'];
    $titulo= $_REQUEST['titulo'];


    // preparo la insercion del nuevo idioma
    $insercion = $conexion->prepare("INSERT INTO idiomas_libro VALUES (:ID_libro,:nombre_idioma,:titulo)");
    // ejecuto la sentencia con un array con los valores
    $insercion->execute(
        array (
            $idLibro = "ID_libro",
            $nombre_idioma = "nombre_idioma",
            $titulo = "titulo"
        )
    );
    // preparo el borrado
    $borradoSolLibro = $conexion->prepare("DELETE FROM solicitudidioma WHERE id_libro = ".$idLibro.";");
    // ejecuto el borrado
    $borradoSolLibro->execute();
    echo "operacion realizada";


}

// añado el idioma a ese idlibro y lo borro de solicitudes de idioma

//----------------REDIRECCION AL ACABAR LA OPERACION---------------------------------
header("Location:areaPersonalProfesor.php");
die();
?>