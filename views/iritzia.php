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
if (empty($review)) header('Location: /liburua/' . $review['id']);
if (empty($review['texto'])) header('Location: /nagusia');

$respuestas = $pdo->prepare('SELECT * FROM respuesta where id_review = :id_review;');
$respuestas->execute(['id_review' => $review['id']]);
$respuestas = $respuestas->fetchAll();

include_once '../templates/head.php';
agregarHead(implode(' ', array_slice(explode(' ', $review['texto']), 0, 6)) . '... | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col" id="main-respuestas">
    <section class="flex-center-col">
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

          if ($_SESSION['usr']['rol'] !== 'Ikasle') {
            echo ' (' . $cuenta['nombre'] . ' ' . $cuenta['apellido'] . ')';
          }
          ?>:
        </h3>
      <?php
      }
      ?>

      <p><?php echo $review['texto'] ?></p>

      <p class="nota"><?php echo $review['nota'] ?><i class="fa-solid fa-star"></i></p>
    </section>

    <a href="/iritzia/<?php echo $review['id'] ?>/erantzun" class="btn">Erantzun</a>

    <?php
    if (count($respuestas) > 0) {
    ?>
      <section>
        <h2>Erantzunak</h2>

        <ol class="flex-stretch-col" id="respuestas">
          <?php
          foreach ($respuestas as $respuesta) {
          ?>
            <li>
              <article class="repuesta">
                <h3 id="reviewer">
                  <?php
                  $cuenta = $pdo->prepare('SELECT id, apodo, nombre, apellido FROM cuenta WHERE id = :id;');
                  $cuenta->execute(['id' => $respuesta['id_cuenta']]);
                  $cuenta = $cuenta->fetch();
                  echo $cuenta['apodo'];

                  if ($_SESSION['usr']['rol'] !== 'Ikasle') {
                    echo ' (' . $cuenta['nombre'] . ' ' . $cuenta['apellido'] . ')';
                  }
                  ?>:
                </h3>

                <p><?php echo $respuesta['texto'] ?></p>
              </article>
            </li>
          <?php
          }
          ?>
        </ol>
      </section>
    <?php
    }
    ?>

    <a href="/liburua/<?php echo $review['id_libro'] ?>" class="volver">Itzuli liburura</a>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>