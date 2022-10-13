<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />

  <title>Saioa hasi | IGKluba</title>

  <link rel='stylesheet' href='style.css' />
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apodoEnviado = $_REQUEST['apodo'];
  $passEnviado = $_REQUEST['pass'];

  include_once('db-config.php');
  $usrCorrecto = $pdo->prepare('SELECT apodo, pass FROM cuenta WHERE apodo = :apodo;');
  $usrCorrecto->execute(['apodo' => $apodoEnviado]);
  $usrCorrecto = $usrCorrecto->fetch();

  if (!empty($usrCorrecto) && $apodoEnviado === $usrCorrecto['apodo'] && $passEnviado === $usrCorrecto['pass']) {
    header('Location: nagusia.php');
  }

  echo 'Ezizena edo pasahitza txarto sartu egin da. Saiatu berriz.';
}
?>

<body class="center">
  <form action="" method="post">
    <div class="campo">
      <label for="apodo">Ezizena</label>
      <input type="text" id="apodo" name="apodo" minlength="1" maxlength="20" required>
    </div>

    <div class="campo">
      <label for="pass">Pasahitza</label>
      <input type="password" id="pass" name="pass" minlength="8" maxlength="30" required>
    </div>

    <button>Saioa hasi</button>
  </form>
</body>

</html>