<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();
$accion = $_SESSION['usr']['rol'] === 'Admin' ? 'igo' : 'eskatu';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $directorio = './src/img/azala/';
  $archivo = $_FILES['imagen'];

  $imageFileType = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

  $esImagen = getimagesize($archivo['tmp_name']);
  if (!$esImagen) {
    $error = 'Fitxategia argazki bat ';
  } else if ($archivo['size'] > 5000000) {
    // >5MB
    $error = 'Argazkia 5MB baino txikiagoa izan behar da';
  } else if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
    $error = 'Argazkia PNG edo JPEG bat izan behar da';
  } else {
    $aceptado = $_SESSION['usr']['rol'] === 'Admin' ? 1 : 0;
    $tieneSerie = !empty($_REQUEST['serie']);

    include_once '../modules/db-config.php';
    $insert = $pdo->prepare('INSERT INTO libro (autor, serie, serie_num, fecha_pub, formato, sinopsis, aceptado)
          VALUES (:autor, :serie, :serie_num, :fecha_pub, :formato, :sinopsis, :aceptado)');
    $insert->execute([
      'autor' => $_REQUEST['autor'],
      'serie' => $tieneSerie ? $_REQUEST['serie'] : null,
      'serie_num' => $tieneSerie ? $_REQUEST['serie_num'] : null,
      'fecha_pub' => $_REQUEST['fecha'],
      'formato' => $_REQUEST['formato'],
      'sinopsis' => nl2br($_REQUEST['sinopsis']),
      'aceptado' => $aceptado
    ]);

    $idLibroInsertado = $pdo->lastInsertId();

    if ($aceptado === 0) {
      $insert = $pdo->prepare('INSERT INTO solicitud_libro (id_libro, id_cuenta) VALUES (:id_libro, :id_cuenta)');
      $insert->execute(['id_libro' => $idLibroInsertado, 'id_cuenta' => $_SESSION['usr']['id']]);
    }

    $insert = $pdo->prepare('INSERT INTO idiomas_libro VALUES (:id_libro, :id_idioma, :titulo_alternativo)');
    $insert->execute(['id_libro' => $idLibroInsertado, 'id_idioma' => 1, 'titulo_alternativo' => $_REQUEST['titulo']]);

    $rutaArchivo = $directorio . $idLibroInsertado . '.png';
    move_uploaded_file($archivo['tmp_name'], $rutaArchivo);

    if ($aceptado === 1) {
      header('Location: /liburua/' . $idLibroInsertado);
    } else {
      header('Location: /profila#nire-liburu-eskaerak');
    }
  }
}

include_once '../templates/head.php';
agregarHead('Liburua ' . $accion . ' | IGKluba', __FILE__);
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Liburua <?php echo $accion ?></h1>

      <form action="" method="post" enctype="multipart/form-data" class="flex-stretch-col" id="form-subir-libro">
        <div class="campo">
          <label for="titulo">Izenburua:</label>
          <input type="text" id="titulo" name="titulo" maxlength="100" placeholder="La Piedra Filosofal" value="<?php if (isset($_REQUEST['titulo'])) echo $_REQUEST['titulo'] ?>">
        </div>

        <div class="campo">
          <label for="autor">Egilea:</label>
          <input type="text" id="autor" name="autor" maxlength="100" placeholder="Abizena, Izena" value="<?php if (isset($_REQUEST['autor'])) echo $_REQUEST['autor'] ?>">
        </div>

        <div class="campo">
          <label for="serie">Saila:</label>
          <input type="text" id="serie" name="serie" maxlength="50" placeholder="Harry Potter" value="<?php if (isset($_REQUEST['serie'])) echo $_REQUEST['serie'] ?>">
        </div>

        <div class="campo">
          <label for="serie_num">Saila zenbakia:</label>
          <input type="number" id="serie_num" name="serie_num" min="-10" step="0.5" maxlength="5" placeholder="1" disabled="false" value="<?php if (isset($_REQUEST['serie_num'])) echo $_REQUEST['serie_num'] ?>">
        </div>

        <div class="campo">
          <label for="fecha">Argitaratze data:</label>
          <input type="date" id="fecha" name="fecha" value="<?php if (isset($_REQUEST['fecha'])) echo $_REQUEST['fecha'] ?>">
        </div>

        <div class="campo">
          <label for="formato">Formatua:</label>
          <select name="formato" id="formato">
            <option disabled selected>-</option>
            <option value="nobela" <?php if (isset($_REQUEST['formato']) && $_REQUEST['formato'] === 'nobela') echo 'selected' ?>>Nobela</option>
            <option value="komikia" <?php if (isset($_REQUEST['formato']) && $_REQUEST['formato'] === 'komikia') echo 'selected' ?>>Komikia</option>
            <option value="nobela grafikoa" <?php if (isset($_REQUEST['formato']) && $_REQUEST['formato'] === 'nobela grafikoa') echo 'selected' ?>>Nobela grafikoa</option>
            <option value="manga" <?php if (isset($_REQUEST['formato']) && $_REQUEST['formato'] === 'manga') echo 'selected' ?>>Manga</option>
          </select>
        </div>

        <div class="campo">
          <label for="imagen">Azala:</label>
          <label for="imagen" class="file-input-text" tabindex="0"><i class="fa-solid fa-file-image"></i> <span>Aukeratu azal bat...</span></label>
          <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png" class="hidden">
        </div>

        <div class="campo">
          <label for="sinopsis">Sinopsia:</label>
          <textarea name="sinopsis" id="sinopsis" maxlength="2550" placeholder="Liburaren sinopsia" value="<?php if (isset($_REQUEST['sinopsis'])) echo $_REQUEST['sinopsis'] ?>"></textarea>
        </div>

        <button id="enviar"><?php echo ucfirst($accion) ?></button>
      </form>
    </div>

    <?php if ($_SESSION['usr']['rol'] === 'Admin') { ?>
      <a href="/csv-igo" class="volver">CSV igo</a>
    <?php
    }
    ?>
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
</body>

</html>