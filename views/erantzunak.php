<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if (!isset($busqueda)) header('Location: /nagusia');
$id_review = $busqueda;

include_once '../modules/db-config.php';
$review = $pdo->prepare('SELECT * FROM review WHERE id = :id;');
$review->execute(['id' => $id_review]);
$review = $review->fetch();

$respuestas = $pdo->prepare('SELECT * FROM respuesta where id_review = :id_review;');
$respuestas->execute(['id_review' => $review['id']]);
$respuestas = $respuestas->fetchAll();

include_once '../templates/head.php';
agregarHead('erantzunak' . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col" id="main-respuestas">
    <div class="review">
      <h1>Iritzia:</h1>
      <?php
      if ($_SESSION['usr']['rol'] !== 'Ikasle') {
      ?>
        <h3 id="reviewer">
          <?php
          $cuenta = $pdo->prepare('SELECT id, apodo, nombre, apellido FROM cuenta WHERE id = :id;');
          $cuenta->execute(['id' => $review['id_cuenta']]);
          $cuenta = $cuenta->fetch();
          echo $cuenta['apodo'];
          ?>:
        </h3>
      <?php
      }
      ?>

      <p><?php echo $review['texto'] ?></p>

      <p class="nota"><?php echo $review['nota'] ?><i class="fa-solid fa-star"></i></p>
    </div>
  </main>

  <?php
  include_once '../templates/footer.php';
  footerGeneral();
  ?>
</body>

</html>