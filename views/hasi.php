<!DOCTYPE html>
<html lang='eu'>

<?php
include_once('../templates/head.php');
include_once('../templates/header.php');
agregarHead('Saioa hasi | IGKluba');
headerLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apodoEnviado = $_REQUEST['apodo'];
  $passEnviado = $_REQUEST['pass'];

  include_once('../modules/db-config.php');
  $usrCorrecto = $pdo->prepare('SELECT apodo, pass FROM cuenta WHERE apodo = :apodo;');
  $usrCorrecto->execute(['apodo' => $apodoEnviado]);
  $usrCorrecto = $usrCorrecto->fetch();

  if (!empty($usrCorrecto) && $apodoEnviado === $usrCorrecto['apodo'] && password_verify($passEnviado, $usrCorrecto['pass'])) {
    header('Location: nagusia');
  }

  echo 'Ezizena edo pasahitza txarto sartu egin da. Saiatu berriz.';
}
?>

<body>
  <main class="flex-center">
    <form action="" method="post">
      <div class="campo">
        <label for="apodo">Ezizena</label>
        <input type="text" id="apodo" name="apodo" minlength="1" maxlength="20" required>
      </div>
      <div class="campo">
        <label for="pass">Pasahitza</label>
        <input type="password" id="pass" name="pass" minlength="1" maxlength="30" required>
      </div>
      <button>Saioa hasi</button>
    </form>
  </main>
</body>

</html>