<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../templates/head.php';
agregarHead($_SESSION['usr']['apodo'] . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col">
    <p>Gune pertsonala</p>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>