<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../templates/head.php';
include_once '../templates/header.php';
agregarHead('IGKluba');
?>

 <body>
  <?php headerNagusia() ?>

  <main>
    <h1>Irakurle Gazteen Kluba</h1>
    <p>
      Muchos jóvenes de Secundaria nos apasionan por la lectura. Sin embargo, en las librerías hay tantos libros que no sabemos por dónde empezar!
      En esta web hay libros para chavales y no tan jovencitos: los más exitosos…incluso los que no nos han gustado. ¡Busca y disfruta!
    </p>
  </main>
  <?php include_once '../templates/footer.php';
  footerInicio(); 
  ?>
  

</html>