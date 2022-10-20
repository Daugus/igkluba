<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../templates/head.php';
agregarHead('IGKluba');
?>

<body class="flex-stretch-col">
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>
  <main id="main-nagusia" class="flex-center-row">
    <?php
    include_once '../modules/libros.php';
    buscarLibros('il.nombre_idioma = "Gaztelania"');
    ?>
  </main>
  <?php
  include_once '../templates/footer.php';
  footerGeneral();
  ?>
</body>

</html>