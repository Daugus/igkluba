<!DOCTYPE html>
<html lang='eu'>

<?php

include_once '../templates/head.php';
agregarHead('Saioa hasi | IGKluba', __FILE__);

include_once '../modules/session.php';
checkSession();

// Actualizar titulo, añadir idioma o eliminar la solicitud de idioma
include_once '../modules/db-config.php';
if ($accion === 'onartu') {
  $select = $pdo->prepare('SELECT titulo_alternativo, id_libro FROM solicitud_idioma WHERE id = :id');
  $select->execute(['id' => $id]);
  $solicitud = $select->fetch();

  $update = $pdo->prepare('UPDATE idiomas_libro SET titulo_alternativo = :nuevo_titulo where id_libro = :id_libro;');
  $update->execute(['id_libro' => $solicitud['id_libro'], 'nuevo_titulo' => $solicitud['titulo_alternativo']]);

  $delete = $pdo->prepare('DELETE FROM solicitud_idioma where id = :id;');
  $delete->execute(['id' => $id]);

  header('Location: /profila#hizkuntza-eskaerak');
} else if ($accion === 'ukatu') {
  $delete = $pdo->prepare('DELETE FROM solicitud_idioma where id = :id;');
  $delete->execute(['id' => $id]);

  header('Location: /profila#hizkuntza-eskaerak');
}

// Coge la información
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $id_libro = $id;
  $id_cuenta = $_SESSION['usr']['id'];
  $id_idioma = $_REQUEST['idioma'];
  $titulo_alternativo = $_REQUEST['nombreLibro'];

  if ($id_idioma === 'otro') {

    // Inserta en la base de datos el nombre del idioma
    $insert = $pdo->prepare(
      "INSERT INTO idioma (nombre)
      VALUES (:nombre)"
    );

    $insert->execute([
      'nombre' => $_REQUEST['nuevoIdioma']
    ]);

    $id_idioma = $pdo->lastInsertId();
  }

  // Inserta el nuevo idioma en la base de datos
  if ($_SESSION['usr']['rol'] === 'Admin') {
    $insert = $pdo->prepare(
      "INSERT INTO idiomas_libro (id_libro, id_idioma, titulo_alternativo)
      VALUES (:id_libro,  :id_idioma, :titulo_alternativo)"
    );
    $insert->execute([
      'id_libro' => $id_libro,
      'id_idioma' => $id_idioma,
      'titulo_alternativo' => $titulo_alternativo
    ]);
  } else {
    $insert = $pdo->prepare(
      "INSERT INTO solicitud_idioma (id_libro, id_cuenta, id_idioma, titulo_alternativo)
      VALUES (:id_libro, :id_cuenta, :id_idioma, :titulo_alternativo)"
    );
    $insert->execute([
      'id_libro' => $id_libro,
      'id_cuenta' => $id_cuenta,
      'id_idioma' => $id_idioma,
      'titulo_alternativo' => $titulo_alternativo
    ]);
  }

  header('Location: /profila/');
}
?>

<body id="fondo-libros">
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Hezkuntza berria eskatu</h1>

      <form id="form-hizkuntza" action="" method="post" class="flex-stretch-col">
        <div class="campo">
          <label for="nombreLibro">Liburuaren izena:</label>
          <input type="text" id="nombreLibro" name="nombreLibro" placeholder="Izena">
        </div>

        <div class="campo">
          <label for="idioma">Irakurritako hizkuntza:</label>

          <!-- Select para sacar el idioma que no este de un libro de la base de datos -->
          <div class="select-container">
            <select name="idioma" id="idioma">
              <option disabled selected>-</option>
              <?php
              include_once '../modules/db-config.php';
              $idiomasLibro = $pdo->prepare('SELECT DISTINCT i.id, i.nombre AS nombre
             FROM idiomas_libro il JOIN idioma i ON il.id_idioma = i.id
             WHERE i.id not in (select DISTINCTROW idiomas_libro.id_idioma from idiomas_libro where id_libro = :id)
             and i.id NOT IN (SELECT id_idioma FROM solicitud_idioma WHERE id_libro = :id);');

              $idiomasLibro->execute(['id' => $id]);
              $idiomasLibro = $idiomasLibro->fetchAll();
              foreach ($idiomasLibro as $idioma) {
              ?>
                <option value="<?php echo $idioma['id'] ?>">
                  <?php echo $idioma['nombre'] ?>
                </option>
              <?php
              }
              ?>
              <option value="otro" name="otro">Otro</option>

            </select>
          </div>
        </div>

        <div class="campo hidden" id="nuevo-idioma">
          <label for="nuevoIdioma">Hizkuntza berria:</label>
          <input id="nuevoIdioma" name="nuevoIdioma" minlength="1" maxlength="30" placeholder="Hizkuntza">
        </div>

        <button type="submit" class="btn" id="login">Bidali</button>
      </form>
    </div>

    <div class="flex-center-col grupo-botones">
      <a href="/hasiera" class="volver">Itzuli</a>
    </div>
  </main>

  <!-- mensaje de error -->
  <?php if (!empty($error)) { ?>
    <div class="mensaje-error"><i class="fa-solid fa-circle-exclamation"></i>
      <p><?php echo $error ?></p>
    </div>
  <?php
  }
  ?>
  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>