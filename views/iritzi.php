<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../modules/db-config.php';

$editar = ($accion === '') ? false : true;
if ($editar) {
  $review = $pdo->prepare('SELECT * FROM review WHERE id = :id_review');
  $review->execute(['id_review' => $id]);
  $review = $review->fetch();

  if (empty($review)) header('Location: /liburua/' . $id);

  if ($accion === 'ezabatu') {
    echo ('DELETE FROM review WHERE id = ' . $id . ';');
    $delete = $pdo->prepare('DELETE FROM review WHERE id = :id_review;');
    $delete->execute(['id_review' => $id]);

    header('Location: /liburua/' . $review['id_libro']);
  }

  $libro = $pdo->prepare(
    'SELECT l.id, il.titulo_alternativo AS titulo, l.autor
      FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro
      WHERE l.id = :id
        AND l.aceptado = true'
    // AND il.nombre_idioma = "Gaztelania"'
  );
  $libro->execute(['id' => $review['id_libro']]);
  $libro = $libro->fetch();
} else {
  $libro = $pdo->prepare(
    'SELECT l.id, il.titulo_alternativo AS titulo, l.autor
      FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro
      WHERE l.id = :id
        AND l.aceptado = true'
    //AND il.nombre_idioma = "Gaztelania"'
  );
  $libro->execute(['id' => $id]);
  $libro = $libro->fetch();

  if (empty($libro)) header('Location: /nagusia');

  $review = $pdo->prepare('SELECT * FROM review WHERE id_cuenta = :id_cuenta AND id_libro = :id_libro');
  $review->execute(['id_cuenta' => $_SESSION['usr']['id'], 'id_libro' => $id]);
  $review = $review->fetch();

  if (!empty($review)) header('Location: /liburua/' . $id);
}
// TODO: comprobar fecha de pub

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ((bool) $_REQUEST['editar']) {
    $update = $pdo->prepare(
      'UPDATE review set nota = :nota, texto = :texto, edad_lector = :edad_lector, nombre_idioma = :nombre_idioma, aceptado = :aceptado
      WHERE id = :id_review'
    );
    $update->execute([
      'nota' => $_REQUEST['nota'],
      'texto' => isset($_REQUEST['texto']) ? $_REQUEST['texto'] : null,
      'edad_lector' => $_REQUEST['edad'],
      'nombre_idioma' => $_REQUEST['idioma'],
      'id_review' => $_REQUEST['id_review'],
      'aceptado' => $_SESSION['usr']['rol'] === 'Ikasle' ? 0 : 1
    ]);
  } else {
    $insert = $pdo->prepare(
      'INSERT INTO review (nota, texto, edad_lector, nombre_idioma, id_libro, id_cuenta, aceptado)
        VALUES (:nota, :texto, :edad_lector, :nombre_idioma, :id_libro, :id_cuenta, :aceptado)'
    );
    $insert->execute([
      'nota' => $_REQUEST['nota'],
      'texto' => isset($_REQUEST['texto']) ? nl2br($_REQUEST['texto']) : null,
      'edad_lector' => $_REQUEST['edad'],
      'nombre_idioma' => $_REQUEST['idioma'],
      'id_libro' => $id,
      'id_cuenta' => $_SESSION['usr']['id'],
      'aceptado' => $_SESSION['usr']['rol'] === 'Ikasle' ? 0 : 1
    ]);
  }

  if (isset($_REQUEST['texto'])) {
    $id_review = isset($_REQUEST['id_review']) ?  $_REQUEST['id_review'] : $pdo->lastInsertId();
    header('Location: /iritzia/' . $id_review);
  } else {
    header('Location: /liburua/' . $id);
  }
}

include_once '../templates/head.php';
agregarHead('Iritzia eman | IGKluba', __FILE__);
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Iritzia <?php echo $editar ? 'aldatu' : 'eman' ?></h1>

      <form action="" method="post" class="flex-stretch-col" id="form-iritzia">
        <div class="campo-predefinido">
          <p>Izenburua:</p>
          <p><?php echo $libro['titulo'] ?></p>
        </div>

        <div class="campo-predefinido">
          <p>Egilea:</p>
          <p><?php echo $libro['autor'] ?></p>
        </div>

        <div class="campo">
          <label for="nota">Nota:</label>
          <div class="select-nota">
            <div class="select-container">
              <select name="nota" id="nota">
                <option disabled selected>-</option>
                <?php
                foreach (range(1, 5) as $nota) {
                ?>
                  <option value="<?php echo $nota ?>" <?php if ($editar && $nota === $review['nota']) echo 'selected' ?>><?php echo $nota ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <i class="fa-solid fa-star"></i>
          </div>
        </div>

        <div class="campo">
          <label for="idioma">Irakurritako hizkuntza:</label>

          <div class="select-container">
            <select name="idioma" id="idioma">
              <option disabled selected>-</option>
              <?php
              include_once '../modules/db-config.php';
              $idiomasLibro = $pdo->prepare('SELECT i.id, i.nombre AS nombre
                                            FROM idiomas_libro il JOIN idioma i ON il.id_idioma = i.id
                                            WHERE id_libro = :id;');
              $idiomasLibro->execute(['id' => $id]);
              $idiomasLibro = $idiomasLibro->fetchAll();
              foreach ($idiomasLibro as $idioma) {
              ?>
                <option value="<?php echo $idioma['nombre'] ?>" <?php if ($editar && $idioma['nombre'] === $review['nombre_idioma']) echo 'selected' ?>>
                  <?php echo $idioma['nombre'] ?>
                </option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>

        <div class="campo">
          <label for="texto">Iritzia:</label>
          <textarea name="texto" id="texto" maxlength="2295" placeholder="Zure iritzia (300 hitz gehienez)..."><?php if ($editar) echo $review['texto'] ?></textarea>
        </div>

        <input type="hidden" value="<?php echo $_SESSION['usr']['fecha_nacimiento'] ?>" name="edad" id="edad">
        <input type="hidden" name="editar" value="<?php echo $editar ?>">
        <?php
        if ($editar) {
        ?>
          <input type="hidden" name="id_review" value="<?php echo $review['id'] ?>">
        <?php
        }
        ?>

        <button class="btn" id="enviar">Bidali</button>
      </form>
    </div>

    <a href="/liburua/<?php echo $id ?>" class="volver">Itzuli liburura</a>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>