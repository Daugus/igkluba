<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

$error = '';
$pedirClase = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apodoEnviado = $_REQUEST['apodo'];
  $passEnviado = $_REQUEST['pass'];

  include_once '../modules/select.php';
  $usrCorrecto = buscarCuenta($apodoEnviado);
  if (empty($usrCorrecto) || !password_verify($passEnviado, $usrCorrecto['pass'])) {
    $error = 'Ezizena edo pasahitza txarto sartu egin da. Saiatu berriz.';
  } else if (
    ($usrCorrecto['activo'] === 0 && (($usrCorrecto['rol'] === 'Irakasle') || ($usrCorrecto['rol'] === 'Ikasle' && $usrCorrecto['cod_clase'] !== null)))
    || isset($_SESSION['mostrarMensajeError'])
  ) {
    $error = 'Zure kontua oraindik ez dago onartuta.';
    unset($_SESSION['mostrarMensajeError']);
  } else if ($usrCorrecto['rol'] === 'Ikasle' && $usrCorrecto['cod_clase'] === null && !isset($_REQUEST['clase'])) {
    $error = 'Ez zara klase baten partea';
    $pedirClase = true;
  } else {
    $claseValida = true;

    include '../modules/db-config.php';
    if (isset($_REQUEST['clase'])) {
      $clase = $pdo->prepare('SELECT cod FROM clase where cod = :cod');
      $clase->execute(['cod' => $_REQUEST['clase']]);
      $clase = $clase->fetch();

      $claseValida = $clase !== false;
    }

    if ($claseValida) {
      if (isset($_REQUEST['clase'])) {
        $update = $pdo->prepare('UPDATE cuenta SET cod_clase = :cod_clase WHERE apodo = :apodo');
        $update->execute(['cod_clase' => $_REQUEST['clase'], 'apodo' => $_REQUEST['apodo']]);
        $_SESSION['mostrarMensajeError'] = true;
        header('Location: /hasi');
      } else {
        include_once '../modules/session.php';
        saveSession($usrCorrecto);
        $destino = isset($_SESSION['url']) ? $_SESSION['url'] : '/nagusia';
        header("Location: $destino");
      }
    } else {
      $error = 'Klase hori es da existitzen';
      $pedirClase = true;
    }
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
          <input type="password" id="pass" name="pass" minlength="1" maxlength="30" placeholder="Zure pasahitza" value="<?php if (isset($_REQUEST['pass'])) echo $_REQUEST['pass'] ?>">
        </div>

        <?php if ($pedirClase) { ?>
          <div class="campo">
            <label for="clase">Klasea:</label>
            <input type="text" id="clase" name="clase" maxlength="6" placeholder="Klasearen kodea" value="<?php if (isset($_REQUEST['clase'])) echo $_REQUEST['clase'] ?>">
          </div>
        <?php
        }
        ?>

        <button class="btn" id="login"><?php echo $pedirClase ? 'Eskatu' : 'Saioa hasi' ?></button>
      </form>
    </div>

    <div class="flex-center-col grupo-botones">
      <a href="/sortu" class="volver">Oraindik ez dut kontua sortu</a>
      <a href="/hasiera" class="volver">Itzuli</a>
    </div>
  </main>

  <?php if (!empty($error)) { ?>
    <div class="mensaje-error"><i class="fa-solid fa-circle-exclamation"></i>
      <p><?php echo $error ?></p>
    </div>
  <?php
  }
  ?>
</body>

</html>