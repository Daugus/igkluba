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

    <section class="grid-libros">
      <?php
      include_once '../modules/select.php';
      agregarLibros(buscarLibros('1', 'l.nota_media DESC, il.id_idioma ASC'));
      ?>
    </section>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>