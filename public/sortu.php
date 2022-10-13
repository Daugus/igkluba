<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />

  <title>Sortu kontua | IGKluba</title>

  <link rel='stylesheet' href='src/style.css' />
  <script src='src/js/sortu.js' defer></script>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $apodoEnviado = $_REQUEST['apodo'];
  $passEnviado = $_REQUEST['pass'];

  include_once(__DIR__ . '/../db-config.php');
  $usrCorrecto = $pdo->prepare('SELECT apodo, pass FROM cuenta WHERE apodo = :apodo;');
  $usrCorrecto->execute(['apodo' => $apodoEnviado]);
  $usrCorrecto = $usrCorrecto->fetch();

  if (!empty($usrCorrecto) && $apodoEnviado === $usrCorrecto['apodo'] && $passEnviado === $usrCorrecto['pass']) {
    header('Location: principal.php');
  }

  echo 'apodo o contraseña incorrecta';
}
?>

<body class="center">
  <form action="" method="post">
    <div class="campo">
      <label for="nombre">Izena</label>
      <input type="text" id="nombre" name="nombre" minlength="1" maxlength="50" pattern="^[A-Za-zÀ-ÖØ-öø-ÿ ]+$" required>
    </div>

    <div class="campo">
      <label for="apellido">Abizena</label>
      <input type="text" id="apellido" name="apellido" minlength="1" maxlength="50" pattern="^[A-Za-zÀ-ÖØ-öø-ÿ ]+$" required>
    </div>

    <div class="campo">
      <label for="apodo">Ezizena</label>
      <input type="text" id="apodo" name="apodo" minlength="1" maxlength="20" pattern="^[A-Za-z0-9_-]+$" required>
    </div>

    <div class="campo">
      <label for="clase">Klasea</label>
      <input type="text" id="clase" name="clase" minlength="8" maxlength="8" pattern="^[A-Za-z0-9]{8,8}$" required>
    </div>

    <div class="campo">
      <label for="pass">Pasahitza</label>
      <input type="password" id="pass" name="pass" minlength="8" maxlength="30" required>
    </div>

    <div class="campo">
      <label for="pass">Pasahitza berridatzi</label>
      <input type="password" id="pass" name="pass" minlength="8" maxlength="30" required>
    </div>

    <div class="campo">
      <label for="fecha">Jaiotze data</label>
      <input type="date" id="fecha" name="fecha" required>
    </div>

    <div class="campo">
      <label for="imagen">Profileko argazkia</label>
      <input type="file" id="imagen" name="imagen">
    </div>

    <button type="submit" id="registrarse">Sortu kontua</button>
  </form>
</body>

</html>