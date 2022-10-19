<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['busqueda'])) {
  $busqueda = preg_replace('/^#/', 'e:', str_replace(' ', '_', trim($_REQUEST['busqueda'])));
  header('Location: /bilaketa/' . $busqueda);
}

if (!isset($busqueda)) header('Location: /nagusia');
$busqueda = str_replace('_', ' ', $busqueda);

include_once '../templates/head.php';
agregarHead($busqueda . ' | IGKluba');
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