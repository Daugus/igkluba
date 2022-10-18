<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if (!isset($busqueda)) header('Location: /nagusia');

include_once '../templates/head.php';
agregarHead('term' . ' | IGKluba');
?>

<body class="flex-stretch-col">
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col">
    <p>bilaketa: <?php echo $busqueda ?></p>
  </main>

  <?php
  include_once '../templates/footer.php';
  footerGeneral();
  ?>
</body>

</html>