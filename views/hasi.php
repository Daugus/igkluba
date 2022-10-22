<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apodoEnviado = $_REQUEST['apodo'];
  $passEnviado = $_REQUEST['pass'];

  include_once '../modules/db-config.php';
  $usrCorrecto = $pdo->prepare('SELECT * FROM cuenta WHERE apodo = :apodo;');
  $usrCorrecto->execute(['apodo' => $apodoEnviado]);
  $usrCorrecto = $usrCorrecto->fetch();

  if (!empty($usrCorrecto) && password_verify($passEnviado, $usrCorrecto['pass'])) {
    include_once '../modules/session.php';
    saveSession($usrCorrecto);
    $destino = isset($_SESSION['url']) ? $_SESSION['url'] : 'nagusia';
    header("Location: /$destino");
  }

  echo 'Ezizena edo pasahitza txarto sartu egin da. Saiatu berriz.';
}

include_once '../templates/head.php';
include_once '../templates/header.php';
agregarHead('Saioa hasi | IGKluba', __FILE__, false);
headerLogin();
?>

<body>
  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Saioa hasi</h1>

      <form action="" method="post" class="flex-stretch-col">
        <div class="campo">
          <label for="apodo">Ezizena:</label>
          <input type="text" id="apodo" name="apodo" minlength="1" maxlength="20" placeholder="Zure ezizena">
        </div>

        <div class="campo">
          <label for="pass">Pasahitza:</label>
          <input type="password" id="pass" name="pass" minlength="1" maxlength="30" placeholder="Zure pasahitza">
        </div>

        <button id="login">Saioa hasi</button>
      </form>
    </div>

    <div class="flex-center-col grupo-volver">
      <a href="/sortu" class="volver">Oraindik ez dut kontua sortu</a>
      <a href="/hasiera" class="volver">Itzuli</a>
    </div>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>