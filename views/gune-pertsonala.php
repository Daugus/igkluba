<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../templates/head.php';
agregarHead('Gune pertsonala | IGKluba');
?>

<body class="flex-stretch-col">
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col">
    <p>gune pertsonala</p>
  </main>

  <?php
  include_once '../templates/footer.php';
  footerGeneral();
  ?>
</body>

</html>