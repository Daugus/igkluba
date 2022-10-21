<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../templates/head.php';
agregarHead('IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main>
    <h1>Gehien irakurritako liburuak</h1>

    <section id="main-nagusia-bilaketa">
      <?php
      include_once '../modules/libros.php';
      $librosPopulares = buscarLibros('il.nombre_idioma = "Gaztelania"');
      agregarLibros($librosPopulares);
      ?>
    </section>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>