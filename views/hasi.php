<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

include_once '../templates/head.php';
include_once '../templates/header.php';
agregarHead('Saioa hasi | IGKluba', __FILE__);


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
?>

<body>
  <div class="page">
    <div class="container">
      <div class="left">
        <div class="eula">
          <img src="src/img/soloLogo.png" alt="logo">
        </div>
        <div class="login">SAIOA HASI</div>
        
          <div class="btn-one">
            <a  href="/">ITZULI</a>
          </div>
        
      </div>
      <div class="right">
        <div class="form" id="formulario">
          <label for="email" >Ezizena</label>
          <input type="email" id="email" placeholder="Sartu Email-a">
          <label for="password" >Pasahitza</label>
          <input type="password" id="password" placeholder="Sartu pasahitza">
          <input type="submit" id="submit" value="Bidali">
        </div>
      </div>
    </div>
  </div>

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

      <button id="login">SAIOA HASI</button>
    </form>
  </main>
</body>

</html>