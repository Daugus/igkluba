<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../modules/db-config.php';
$libro = $pdo->prepare('SELECT l.id, il.titulo_alternativo AS titulo, l.autor FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro WHERE l.id = :id AND il.nombre_idioma = "Gaztelania"');
$libro->execute(['id' => $id]);
$libro = $libro->fetch();
if (empty($libro)) header('Location: /nagusia');
// TODO: comprobar fecha de pub
$comprobarReview = $pdo->prepare('SELECT id FROM review WHERE id_cuenta = :id_cuenta AND id_libro = :id_libro');
$comprobarReview->execute(['id_cuenta' => $_SESSION['usr']['id'], 'id_libro' => $id]);
$comprobarReview = $comprobarReview->fetch();
if (!empty($comprobarReview)) header('Location: /liburua/' . $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once '../modules/db-config.php';
  $insert = $pdo->prepare('INSERT INTO review (nota, texto, edad_lector, nombre_idioma, id_libro, id_cuenta)
    VALUES (:nota, :texto, :edad_lector, :nombre_idioma, :id_libro, :id_cuenta)');
  $insert->execute([
    'nota' => $_REQUEST['nota'],
    'texto' => isset($_REQUEST['texto']) ? $_REQUEST['texto'] : null,
    'edad_lector' => $_REQUEST['edad'],
    'nombre_idioma' => $_REQUEST['idioma'],
    'id_libro' => $id,
    'id_cuenta' => $_SESSION['usr']['id']
  ]);

  if (isset($_REQUEST['texto'])) {
    header('Location: /iritzia/' . $pdo->lastInsertId());
  } else {
    header('Location: /liburua/' . $id);
  }
}

include_once '../templates/head.php';
include_once '../templates/header.php';
agregarHead('Iritzia eman | IGKluba', __FILE__);
headerGeneral();
?>

<body>
  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Iritzia eman</h1>

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
          <div>
            <select name="nota" id="nota">
              <option disabled selected>-</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <i class="fa-solid fa-star"></i>
          </div>
        </div>

        <div class="campo">
          <label for="idioma">Irakurritako hizkuntza:</label>
          <select name="idioma" id="idioma">
            <option disabled selected>-</option>
            <?php
            include_once '../modules/db-config.php';
            $idiomasLibro = $pdo->prepare('SELECT nombre_idioma AS nombre FROM idiomas_libro WHERE id_libro = :id;');
            $idiomasLibro->execute(['id' => $id]);
            $idiomasLibro = $idiomasLibro->fetchAll();
            foreach ($idiomasLibro as $idioma) {
              print_r($idioma);
            ?>
              <option value="<?php echo $idioma['nombre'] ?>"><?php echo $idioma['nombre'] ?></option>
            <?php
            }
            ?>
          </select>
        </div>

        <div class="campo">
          <label for="texto">Iritzia:</label>
          <textarea name="texto" id="texto" maxlength="2295" placeholder="Zure iritzia (300 hitz gehienez)..."></textarea>
        </div>

        <input type="hidden" value="<?php echo $_SESSION['usr']['fecha_nacimiento'] ?>" name="edad" id="edad">

        <button id="enviar">Bidali</button>
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