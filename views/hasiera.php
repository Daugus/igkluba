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

<body class="body-hasiera">
  <main id="main-hasiera">
    <div id="fondo-movil"></div>
    <div class="flex-center-col clm-izq-hasiera">
      <div id="hasiera">
        <h1>Irakurle Gazteen Kluba</h1>

        <p>Bigarren Hezkuntzako gazte askok irakurtzeko zaletasuna dugu. Hala ere, liburudendetan hainbeste liburu daude, ez dakigula nondik hasi! Webgune honetan gaztetxuentzako eta ez hain gaztetxuentzako liburuak daude: arrakastatsuenak…baita gustatu ez zaizkigunak ere. Bilatu eta gozatu!</p>

        <br>

        <p>Webgune hau Txurdinagako Lanbide Heziketako azken mailako Augusto, Unai eta Xabi ikasleek diseinatu dugu.</p>

        <br>

        <p>Kontaktua: <a href="mailto:leireirakas21@gmail.com">leireirakas21@gmail.com</a></p>

        <div class="flex-center-row" id="botones-hasiera">
          <a href="/sortu">Sortu kontua</a>
          <a href="/hasi">Saioa hasi</a>
        </div>
      </div>
    </div>
  </main>
</body>

</html>