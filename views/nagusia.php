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
    <?php agregarSelectColumnas(); ?>
    <h1>Gehien irakurritako liburuak</h1>

    <?php
    include_once '../modules/select.php';
    agregarLibros(buscarLibros(['1'], ['l.nota_media DESC', 'il.id_idioma ASC']));
    ?>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>