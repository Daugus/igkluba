<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../modules/db-config.php';
$review = $pdo->prepare('SELECT r.id AS id_review, l.id AS id_libro FROM review r JOIN libro l ON r.id_libro = l.id WHERE r.id = :id');
$review->execute(['id' => $id]);
$review = $review->fetch();
if (empty($review)) header('Location: /nagusia');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once '../modules/db-config.php';
  $insert = $pdo->prepare('INSERT INTO respuesta (texto, id_review, id_cuenta, aceptado)
    VALUES (:texto, :id_review, :id_cuenta, :aceptado)');
  $insert->execute([
    'texto' => nl2br($_REQUEST['texto']),
    'id_review' => $id,
    'id_cuenta' => $_SESSION['usr']['id'],
    'aceptado' => $_SESSION['usr']['rol'] === 'Ikasle' ? 0 : 1
  ]);

  header('Location: /iritzia/' . $id);
}

include_once '../templates/head.php';
agregarHead('Erantzun | IGKluba', __FILE__);
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col main-form" id="main-erantzun">
    <div class="form-container">
      <h1>Erantzun</h1>

      <form action="" method="post" class="flex-stretch-col" id="form-iritzia">
        <div class="campo textarea-container">
          <label for="texto">Erantzuna:<br><span id="contador">0/100</span></label>
          <textarea name="texto" id="texto" minlength="1" maxlength="2295" placeholder="Zure erantzuna (100 hitz gehienez)..."></textarea>
        </div>

        <button class="btn" id="enviar">Bidali</button>
      </form>
    </div>

    <div class="flex-center-col grupo-volver">
      <a href="/iritzia/<?php echo $id ?>" class="volver">Itzuli iritzira</a>
      <a href="/liburua/<?php echo $review['id_libro'] ?>" class="volver">Itzuli liburura</a>
    </div>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>