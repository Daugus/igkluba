<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

include_once '../templates/head.php';
include_once '../templates/header.php';
include_once '../templates/footer.php';
agregarHead('IGKluba', '', false);
?>

<body class="flex-stretch-col">
  <?php headerInicio() ?>

  <main id="hasiera">
    <h1>Irakurle Gazteen Kluba</h1>
    <p>Bigarren Hezkuntzako gazte askok irakurtzeko zaletasuna dugu. Hala ere, liburudendetan hainbeste liburu daude, ez dakigula nondik hasi! Webgune honetan gaztetxuentzako eta ez hain gaztetxuentzako liburuak daude: arrakastatsuenak…baita gustatu ez zaizkigunak ere. Bilatu eta gozatu!</p>
    <img id="collage" src="/src/img/collage-Libros.png" alt="collage">
  </main>

  <?php footerInicio() ?>

</body>

</html>