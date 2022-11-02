<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apodoEnviado = $_REQUEST['apodo'];
  $passEnviado = $_REQUEST['pass'];

  include_once '../modules/select.php';
  $usrCorrecto = buscarCuenta($apodoEnviado);
  if (empty($usrCorrecto) || !password_verify($passEnviado, $usrCorrecto['pass'])) {
    $error = 'Ezizena edo pasahitza txarto sartu egin da. Saiatu berriz.';
  } else if ($usrCorrecto['activo'] === 0) {
    $error = 'Zure kontua oraindik ez dago onartuta.';
  } else {
    include_once '../modules/session.php';
    saveSession($usrCorrecto);
    $destino = isset($_SESSION['url']) ? $_SESSION['url'] : '/nagusia';
    header("Location: $destino");
  }
}

include_once '../templates/head.php';
agregarHead('Saioa hasi | IGKluba', __FILE__);
?>

<body>
  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Saioa hasi</h1>

      <form action="" method="post" class="flex-stretch-col">
        <div class="campo">
          <label for="apodo">Ezizena:</label>
          <input type="text" id="apodo" name="apodo" minlength="1" maxlength="20" placeholder="Zure ezizena" value="<?php if (isset($_REQUEST['apodo'])) echo $_REQUEST['apodo'] ?>">
        </div>

        <div class="campo">
          <label for="pass">Pasahitza:</label>
          <input type="password" id="pass" name="pass" minlength="1" maxlength="30" placeholder="Zure pasahitza">
        </div>

        <button id="login">Saioa hasi</button>
      </form>
    </div>

    <div class="flex-center-col grupo-botones">
      <a href="/sortu" class="volver">Oraindik ez dut kontua sortu</a>
      <a href="/hasiera" class="volver">Itzuli</a>
    </div>
  </main>

  <?php if (!empty($error)) { ?>
    <div class="error"><i class="fa-solid fa-circle-exclamation"></i>
      <p><?php echo $error ?></p>
    </div>
  <?php
  }
  ?>
</body>

</html>