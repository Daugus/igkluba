<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

include_once '../templates/head.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apodoEnviado = $_REQUEST['apodo'];
  $passEnviado = $_REQUEST['pass'];

  include_once '../modules/db-config.php';
  $usrCorrecto = $pdo->prepare('SELECT id, nombre, apellido, apodo, rol, activo, pass, cod_clase FROM cuenta WHERE apodo = :apodo;');
  $usrCorrecto->execute(['apodo' => $apodoEnviado]);
  $usrCorrecto = $usrCorrecto->fetch();

  if (!empty($usrCorrecto) && password_verify($passEnviado, $usrCorrecto['pass'])) {
    include_once '../modules/session.php';
    saveSession($usrCorrecto);
    $destino = isset($_SESSION['url']) ? $_SESSION['url'] : 'nagusia';
    header("Location: $destino");
  }

  echo 'Ezizena edo pasahitza txarto sartu egin da. Saiatu berriz.';
}

include_once '../templates/header.php';
agregarHead('Saioa hasi | IGKluba', __FILE__, false);
headerLogin();
?>

<body class="flex-stretch-col">
  <main class="flex-center-row">
    <form action="" method="post" class="flex-stretch-col form-hasi-sortu">
      <div class="campo">
        <label for="apodo">Ezizena:</label>
        <input type="text" id="apodo" name="apodo" minlength="1" maxlength="20" required>
      </div>

      <div class="campo">
        <label for="pass">Pasahitza:</label>
        <input type="password" id="pass" name="pass" minlength="1" maxlength="30" required>
      </div>

      <button id="login">Saioa hasi</button>
      <a href="/sortu" id="registro-hasi">ez daukazu kontua? sesioa sortu</a>
    </form>
  </main>
  <a href="/hasiera" id="itzuli">Itzuli</a>

  <?php
  include_once '../templates/footer.php';
  footerInicio();
  ?>
</body>

</html>