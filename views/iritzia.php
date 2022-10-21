<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

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
agregarHead('Iritzia eman | IGKluba', __FILE__);
headerGeneral();
?>

<body class="flex-stretch-col">
  <main class="flex-center-row">
    <form action="" method="post" class="flex-stretch-col">
      <div class="campo">
        <label for="nota">Nota:</label>
        <div>
          <select name="nota" id="nota">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <i class="fa-solid fa-star"></i>
        </div>
      </div>

      <div class="campo">
        <label for="texto">Iritzia:</label>
        <textarea name="texto" id="texto" minlength="1" maxlength="2295"></textarea>
      </div>

      <button id="login">Saioa hasi</button>
    </form>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>