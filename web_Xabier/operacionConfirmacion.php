<?php

//----------------CONEXION CON BASE DE DATOS-----------------------
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

//-----------------CLASES Y GRUPOS---------------------------------

if(isset($_REQUEST["id"])) {

    $id = $_REQUEST['id'];
    $idComponente = $_REQUEST['idComponente'];

    // si quiero eliminar a un alumno de su clase
    if ($idComponente == 'eliminar') {
        // preparo el borrado
        $borradoCuentaClase = $conexion->prepare("UPDATE cuenta SET cod_clase = 'NULO' WHERE id = ".$id.";");
        // ejecuto el borrado
        $borradoCuentaClase->execute();
        echo "el alumno ha sido eliminado del grupo";
        echo "<br>";
    }
    // si quiero añadir a un alumno a una clase
    else if ($idComponente == 'aceptar') {

// el codigo de clase siempre es nulo y no puede añadir alumnos actualmente
        $resultadosClase = $_REQUEST['cod'];
        print_r($resultadosClase);
        // preparo la insercion
        $insercionCuentaClase = $conexion->prepare("UPDATE cuenta SET cod_clase = '".$resultadosClase."' WHERE id = ".$id.";");
        // ejecuto el borrado
        $insercionCuentaClase->execute();
        echo "el alumno ha añadido al grupo";
        echo "<br>";
    }


    }


//--------------------SOLICITUDES DE IDIOMA---------------------------------

if (isset($_REQUEST["id_libro"])) {

    $idLibro = $_REQUEST['id_libro'];
    $idSolicitud = $_REQUEST['idSolicitud'];
    $nombre_idioma = $_REQUEST['nombre_idioma'];
    $titulo = $_REQUEST['titulo'];
    $id = $_REQUEST['id_cuenta'];

    // si quiero eliminar una solicitud de idioma
    if ($idSolicitud == 'eliminar') {

        // preparo el borrado
        $borradoSolLibro = $conexion->prepare("DELETE FROM solicitud_idioma 
        WHERE id_libro = ".$idLibro." AND nombre_idioma LIKE '".$nombre_idioma."' AND titulo_alternativo LIKE '".$titulo."';");
        // ejecuto el borrado
        $borradoSolLibro->execute();
        echo "operacion de borrado realizada";
        echo "<br>";
    }
    
    // si quiero aceptar una solicitud de idioma
    if ($idSolicitud == 'aceptar') {
        
        // preparo la insercion del nuevo idioma
        $insercion = $conexion->prepare("INSERT INTO idiomas_libro VALUES (".$idLibro.",'".$nombre_idioma."','".$titulo."');");
        // ejecuto la insercion
        $insercion->execute();
        // añado el idioma a ese idlibro y lo borro de solicitudes de idioma
        $borradoSolLibro = $conexion->prepare("DELETE FROM solicitud_idioma 
        WHERE id_libro = ".$idLibro." AND nombre_idioma LIKE '".$nombre_idioma."' AND titulo_alternativo LIKE '".$titulo."';");
        // ejecuto el borrado
        $borradoSolLibro->execute();
        echo "operacion de insercion realizada";
        echo "<br>";

    }

}

//----------------REVIEWS---------------------------------

if (isset($_REQUEST["ComponenteReview"])) {

    $ComponenteReview = $_REQUEST["ComponenteReview"];
    $idReview = $_REQUEST["idReview"];

    // si quiero borrar la review
    if ($ComponenteReview == "eliminar") {
        
        // prepado el borrado
        $borradoReview = $conexion->prepare("DELETE FROM review WHERE id = ".$idReview.";");
        // ejecuto el borrado
        $borradoReview->execute();
        echo "eliminacion de review realizada";
        echo "<br>";
    }

    // si quiero modificar la review
    else if ($ComponenteReview == "modificar") {
        echo "modificacion review";
    }
}


//----------------REDIRECCION AL ACABAR LA OPERACION---------------------------------

//header("Location:areaPersonalProfesor.php");
//die();

}// cierre del try
catch (PDOException $e) {
    echo "la conexion ha fallado: " . $e->getMessage();
}
?>