<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkLogin();

$imgInvalida = '';
$claseInvalida = false;
$apodoInvalido = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $directorio = './src/img/profila/';
  $archivo = $_FILES['imagen'];

  if (array_key_exists('imagen', $_FILES) && !empty($_FILES['imagen']['name'])) {
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

        header('Location: /hasi');
      }
    }
  }
}

include_once '../templates/head.php';
agregarHead('Sortu kontua | IGKluba', __FILE__, false);

include_once '../templates/header.php';
headerLogin();
?>

<body>
  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Sortu kontua</h1>

      <form action="" method="post" enctype="multipart/form-data" class="flex-stretch-col">
        <div class="campo">
          <label for="nombre">Izena:</label>
          <input type="text" id="nombre" name="nombre" maxlength="50" placeholder="Zure izena">
        </div>

        <div class="campo">
          <label for="apellido">Abizena:</label>
          <input type="text" id="apellido" name="apellido" maxlength="50" placeholder="Zure abizena">
        </div>

        <div class="campo">
          <label for="apodo">Ezizena:</label>
          <input type="text" id="apodo" name="apodo" maxlength="20" placeholder="Zure ezizena">
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
          <label for="centro">Zentroa:</label>
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
          <label for="clase">Klasea:</label>
          <input type="text" id="clase" name="clase" maxlength="8" placeholder="Klasearen kodea">
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
          <label for="fecha">Jaiotze data:</label>
          <input type="date" id="fecha" name="fecha">
        </div>

        <div class="campo">
          <label for="imagen">Profileko argazkia:</label>
          <label for="imagen" class="file-input-text" tabindex="0"><i class="fa-solid fa-file-image"></i> <span>Aukeratu argazki bat...</span></label>
          <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png" class="hidden">
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
          <label for="pwd">Pasahitza:</label>
          <input type="password" id="pwd" name="pwd" maxlength="30" placeholder="Zure pasahitza">
        </div>

        <div class="campo">
          <label for="pwdConf">Pasahitza berridatzi:</label>
          <input type="password" id="pwdConf" name="pwdConf" maxlength="30" placeholder="Zure pasahitza">
        </div>

        <button type="submit" id="registrarse">Sortu kontua</button>
      </form>
    </div>

    <div class="flex-center-col grupo-volver">
      <a href="/hasi" class="volver">Kontua badaukat</a>
      <a href="/hasiera" class="volver">Itzuli</a>
    </div>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>