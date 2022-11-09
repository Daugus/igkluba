<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

include_once '../templates/head.php';
include_once '../templates/header.php';
include_once '../templates/footer.php';
agregarHead('IGKluba', '');
?>

<body id="bodyHasiera">
  <main id="main-hasiera">
    <div class="clm-izq-hasiera">
      <div>
        <h1>Irakurle Gazteen Kluba</h1>

        <p>Bigarren Hezkuntzako gazte askok irakurtzeko zaletasuna dugu. Hala ere, liburudendetan hainbeste liburu daude, ez dakigula nondik hasi! Webgune honetan gaztetxuentzako eta ez hain gaztetxuentzako liburuak daude: arrakastatsuenak…baita gustatu ez zaizkigunak ere. Bilatu eta gozatu!</p>

        <div class="botones-hasiera">
          <a href="/sortu" class="btn-hasiera">Sortu kontua</a>
          <a href="/hasi" class="btn-hasiera">Saioa hasi</a>
        </div>
      </div>
    </div>
  </main>

  <?php agregarFooter() ?>
</body>

</html>