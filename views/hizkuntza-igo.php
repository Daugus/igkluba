<!DOCTYPE html>
<html lang='eu'>

<?php

include_once '../templates/head.php';
agregarHead('Saioa hasi | IGKluba', __FILE__);

include_once '../modules/session.php';
checkSession();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once '../modules/db-config.php';
  $id_libro = $id;
  $id_cuenta = $_SESSION['usr']['id'];
  $id_idioma = $_REQUEST['idioma'];
  $titulo_alternativo = $_REQUEST['nuevoIdioma'];

  if ($id_idioma === 'otro') {

    $insert = $pdo->prepare(
      "INSERT INTO idioma (nombre)
      VALUES (:nombre)"
    );

    $insert->execute([
      'nombre' => $_REQUEST['nombreLibro']
    ]);

    $id_idioma = $pdo->lastInsertId();
  }


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

        <div class="campo hidden" id="nuevo-idioma">
          <label for="nuevoIdioma">Hizkuntza berria:</label>
          <input id="nuevoIdioma" name="nuevoIdioma" minlength="1" maxlength="30" placeholder="Hizkuntza">
        </div>

        <button id="login">Bidali</button>
      </form>
    </div>

    <div class="flex-center-col grupo-botones">
      <a href="/hasiera" class="volver">Itzuli</a>
    </div>
  </main>

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