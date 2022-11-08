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
  $titulo_alternativo = $_REQUEST['titulo'];

  if ($id_idioma === 'otro') {
    $insert = $pdo->prepare(
      "INSERT INTO idioma (nombre)
      VALUES (:nombre)"
    );

    $insert->execute(['nombre' => $_REQUEST['idiomaNuevo']]);

    $id_idioma = $pdo->lastInsertId();
  }

  if ($_SESSION['usr']['rol'] === 'Admin') {
    $insert = $pdo->prepare(
      "INSERT INTO idiomas_libro (id_libro, id_idioma, titulo_alternativo)
      VALUES (:id_libro, :id_idioma, :titulo_alternativo)"
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

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Hizkuntza <?php echo $_SESSION['usr']['rol']  === 'Admin' ? 'gehitu' : 'eskatu' ?></h1>

      <form id="form-hizkuntza" action="" method="post" class="flex-stretch-col">
        <div class="campo">
          <label for="titulo">Izenburu berria:</label>
          <input type="text" id="titulo" name="titulo" placeholder="Izena">
        </div>

        <div class="campo">
          <label for="idioma">Hizkuntza:</label>

          <div class="select-container">
            <select name="idioma" id="idioma">
              <option disabled selected>-</option>
              <?php
              include_once '../modules/db-config.php';
              $idiomasLibro = $pdo->prepare(
                'SELECT DISTINCT i.id, i.nombre AS nombre
                FROM idioma i
                WHERE i.id NOT IN (SELECT DISTINCT idiomas_libro.id_idioma FROM idiomas_libro WHERE id_libro = :id)
                AND i.id NOT IN (SELECT id_idioma FROM solicitud_idioma WHERE id_libro = :id)
                ORDER BY i.nombre ASC;'
              );

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
          <label for="idiomaNuevo">Hizkuntza berria:</label>
          <input id="idiomaNuevo" name="idiomaNuevo" minlength="1" maxlength="30" placeholder="Hizkuntza">
        </div>

        <button class="btn" id="login">Bidali</button>
      </form>
    </div>

    <div class="flex-center-col grupo-botones">
      <a href="/liburua/<?php echo $id ?>" class="volver">Itzuli liburura</a>
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