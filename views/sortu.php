<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

include_once '../templates/head.php';
agregarHead('Sortu kontua | IGKluba', __FILE__);

$imgInvalida = '';
$claseInvalida = false;
$apodoInvalido = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (array_key_exists('imagen', $_FILES) && !empty($_FILES['imagen']['name'])) {
    $archivo = $_FILES['imagen'];
    print_r($archivo);

    $directorio = './src/img/profila/';
    $imageFileType = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    $esImagen = getimagesize($archivo['tmp_name']);
    if (!$esImagen) {
      $imgInvalida = 'El archivo no es una imagen';
    } else if ($archivo['size'] > 3000000) {
      // >3MB
      $imgInvalida = 'La imagen no puede ser mayor de 3MB';
    } else if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
      $imgInvalida = 'La imagen solo puede ser de tipo JPG o PNG';
    }
  }

  if ($imgInvalida === '') {
    include_once '../modules/db-config.php';
    $clase = $pdo->prepare('SELECT cod FROM clase where cod = :cod');
    $clase->execute(['cod' => $_REQUEST['clase']]);
    $clase = $clase->fetch();

    if (empty($clase)) {
      $claseInvalida = true;
    } else {
      $buscarApodo = $pdo->prepare('SELECT apodo FROM cuenta where apodo = :apodo');
      $buscarApodo->execute(['apodo' => $_REQUEST['apodo']]);
      $buscarApodo = $buscarApodo->fetch();

      if (!empty($buscarApodo)) {
        $apodoInvalido = true;
      } else {
        $insert = $pdo->prepare('INSERT INTO cuenta (nombre, apellido, apodo, rol, activo, pass, fecha_nacimiento, cod_clase, id_centro)
          VALUES (:nombre, :apellido, :apodo, :rol, :activo, :pass, :fecha_nacimiento, :cod_clase, :id_centro)');
        $insert->execute([
          'nombre' => $_REQUEST['nombre'],
          'apellido' => $_REQUEST['apellido'],
          'apodo' => $_REQUEST['apodo'],
          'rol' => 'ikasle',
          'activo' => 0,
          'pass' => password_hash($_REQUEST['pwd'], PASSWORD_DEFAULT),
          'fecha_nacimiento' => $_REQUEST['fecha'],
          'cod_clase' => $_REQUEST['clase'],
          'id_centro' => $_REQUEST['centro']
        ]);

        $rutaArchivo = $directorio . $pdo->lastInsertId() . '.png';
        move_uploaded_file($archivo['tmp_name'], $rutaArchivo);

        header('Location: hasi');
      }
    }
  }
}
?>

<body class="flex-center">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="campo">
      <label for="nombre">Izena</label>
      <input type="text" id="nombre" name="nombre" maxlength="50">
    </div>

    <div class="campo">
      <label for="apellido">Abizena</label>
      <input type="text" id="apellido" name="apellido" maxlength="50">
    </div>

    <div class="campo">
      <label for="apodo">Ezizena</label>
      <input type="text" id="apodo" name="apodo" maxlength="20">

      <?php
      if ($apodoInvalido) {
      ?>
        <div class="error">
          <p>Ese apodo ya está existe</p>
        </div>
      <?php
      }
      ?>
    </div>

    <div class="campo">
      <label for="centro">Zentroa</label>
      <select name="centro" id="centro">
        <?php
        include_once '../modules/db-config.php';
        $centros = $pdo->prepare('SELECT id, nombre FROM centro;');
        $centros->execute();
        $centros = $centros->fetchAll();

        foreach ($centros as $centro) {
        ?>
          <option value="<?php echo $centro['id'] ?>"><?php echo $centro['nombre'] ?></option>
        <?php
        }
        ?>
      </select>
    </div>

    <div class="campo">
      <label for="clase">Klasea</label>
      <input type="text" id="clase" name="clase" maxlength="8">

      <?php
      if ($claseInvalida) {
      ?>
        <div class="error">
          <p>Esa clase no existe</p>
        </div>
      <?php
      }
      ?>
    </div>

    <div class="campo">
      <label for="fecha">Jaiotze data</label>
      <input type="date" id="fecha" name="fecha">
    </div>

    <div class="campo">
      <label for="imagen">Profileko argazkia</label>
      <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png">

      <?php
      if ($imgInvalida !== '') {
      ?>
        <div class="error">
          <p>
            <?php echo $imgInvalida ?>
          </p>
        </div>
      <?php
      }
      ?>
    </div>

    <div class="campo">
      <label for="pwd">Pasahitza</label>
      <input type="password" id="pwd" name="pwd" maxlength="30">
    </div>

    <div class="campo">
      <label for="pwdConf">Pasahitza berridatzi</label>
      <input type="password" id="pwdConf" name="pwdConf" maxlength="30">
    </div>

    <button type="submit" id="registrarse">Sortu kontua</button>
  </form>
</body>

</html>