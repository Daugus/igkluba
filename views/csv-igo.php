<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if ($_SESSION['usr']['rol'] !== 'Admin') header('Location: naugusia');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $csv = $_FILES['csv'];
  $delimeter = ',';

  $columnas = [];
  $numFila = 0;
  $handle = fopen($csv['tmp_name'], 'r');
  if ($handle === false) {
    $error = 'error handle';
  }

  include_once '../modules/db-config.php';
  while (($datos = fgetcsv($handle, 0, $delimeter)) !== false) {
    if ($numFila === 0) {
      $columnas = $datos;
    } else {
      $libro = array_combine($columnas, $datos);

      $tieneSerie = !empty($libro['serie']) && $libro['serie'] !== '-';

      $insert = $pdo->prepare('INSERT INTO libro (autor, serie, serie_num, fecha_pub, formato, sinopsis, enlace, aceptado)
              VALUES (:autor, :serie, :serie_num, :fecha_pub, :formato, :sinopsis, :enlace, :aceptado)');
      $insert->execute([
        'autor' => $libro['autor'],
        'serie' => $tieneSerie ? $libro['serie'] : null,
        'serie_num' => $tieneSerie ? $libro['serie_num'] : null,
        'fecha_pub' => $libro['fecha_pub'],
        'formato' => $libro['formato'],
        'sinopsis' => $libro['sinopsis'],
        'enlace' => $libro['enlace'],
        'aceptado' => 1
      ]);

      $insert = $pdo->prepare('INSERT INTO idiomas_libro VALUES (:id_libro, :nombre_idioma, :titulo)');
      $insert->execute(['id_libro' => $pdo->lastInsertId(), 'nombre_idioma' => 'Gaztelania', 'titulo' => $libro['titulo_castellano']]);
    }

    $numFila++;
  }

  fclose($handle);
  header('Location: /nagusia');
}

include_once '../templates/head.php';
agregarHead('CSV igo | IGKluba', __FILE__);
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Liburua igo CSV bidez</h1>

      <form action="" method="post" enctype="multipart/form-data" class="flex-stretch-col" id="form-subir-csv">
        <div class="campo">
          <label for="csv">CSV:</label>
          <label for="csv" class="file-input-text" tabindex="0"><i class="fa-solid fa-file-image"></i> <span>Aukeratu CSV bat...</span></label>
          <input type="file" id="csv" name="csv" accept="text/csv,.csv" class="hidden">
        </div>

        <button class="btn" id="enviar">Igo</button>
      </form>
    </div>

    <a href="/liburua-igo" class="volver">Liburu bakarra igo</a>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();

  if (!empty($error)) {
  ?>
    <div class="mensaje-error"><i class="fa-solid fa-circle-exclamation"></i>
      <p><?php echo $error ?></p>
    </div>
  <?php
  }
  ?>
  ?>
</body>

</html>