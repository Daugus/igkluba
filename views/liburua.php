<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if (!isset($busqueda)) header('Location: /nagusia');
$id = $busqueda;

include_once '../modules/db-config.php';
$libro = $pdo->prepare('SELECT * FROM libro WHERE id = :id;');
$libro->execute(['id' => $id]);
$libro = $libro->fetch();

if (empty($libro) || ($accion === '' && $libro['aceptado'] === 0)) header('Location: /nagusia');
if ($accion === 'onartu') {
  $update = $pdo->prepare('UPDATE libro SET aceptado = 1 where id = :id;');
  $update->execute(['id' => $id]);
  header('Location: /profila#liburu-eskaerak');
} else if ($accion === 'ukatu') {
  $delete = $pdo->prepare('DELETE FROM libro where id = :id;');
  $delete->execute(['id' => $id]);
  unlink("../public/src/img/azala/$id.png");
  header('Location: /profila#liburu-eskaerak');
}

$titulos = $pdo->prepare(
  'SELECT i.nombre AS nombre_idioma, il.titulo_alternativo AS titulo
    FROM idiomas_libro il JOIN idioma i ON il.id_idioma = i.id
    WHERE id_libro = :id_libro
    ORDER BY i.id ASC;'
);
$titulos->execute(['id_libro' => $id]);
$titulos = $titulos->fetchAll();

if ($accion !== 'eskaera') {
  $consultaEtiquetas = $pdo->prepare('SELECT nombre FROM etiqueta WHERE id_libro = :id_libro');
  $consultaEtiquetas->execute(['id_libro' => $id]);
  $consultaEtiquetas = $consultaEtiquetas->fetchAll();
}

include_once '../templates/head.php';
agregarHead($titulos[0]['titulo'] . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col" id="main-libro">
    <section class="flex-center-row" id="informacion">
      <div id="portada">
        <img src="/src/img/azala/<?php echo $libro['id'] ?>.png" alt="portada" class="portada-libro" id="portada">
      </div>

      <div class="flex-center-col" id="datos">
        <div class="flex-center-col" id="datos-importantes">
          <h1><?php echo $titulos[0]['titulo'] ?></h1>

          <?php if (isset($libro['serie'])) { ?>
            <p id="serie"><?php echo $libro['serie'] . ' #' . $libro['serie_num'] ?></p>
          <?php
          }
          ?>

          <p id="autor"><?php echo $libro['autor'] ?></p>
          <?php if ($accion !== 'eskaera') { ?>
            <p class="nota">
              <a href="#iritziak">
                <?php
                if ($libro['nota_media'] > 0) {
                  echo number_format((float)$libro['nota_media'], 2, '.', '');
                } else {
                  echo '-';
                }
                ?><i class="fa-solid fa-star"></i>
              </a>
            </p>
          <?php
          }
          ?>
        </div>

        <p><span>Argitaratze data:</span> <?php echo date_format(date_create($libro['fecha_pub']), 'd/m/Y') ?></p>
        <?php
        $idiomas = [];
        foreach ($titulos as $titulo) {
          $idiomas[] = $titulo['nombre_idioma'];
        }
        ?>
        <p><span>Hizkuntza<?php if (count($idiomas) > 1) echo 'k' ?>:</span> <?php echo implode(', ', $idiomas) ?></p>
        <?php if ($accion !== 'eskaera') { ?>
          <p><span>Batez besteko adina:</span> <?php echo $libro['edad_media'] > 0 ? $libro['edad_media'] : '-' ?></p>
          <p><span>Irakurle kopurua:</span> <?php echo $libro['cantidad_reviews'] > 0 ? $libro['cantidad_reviews'] : '-' ?></p>
          <?php
          $etiquetas = [];
          foreach ($consultaEtiquetas as $etiqueta) {
            $etiquetas[] = $etiqueta['nombre'];
          }
          ?>
          <p><span>Etiketa<?php if (count($etiquetas) > 1) echo 'k' ?>:</span> <?php echo implode(', ', $etiquetas) ?></p>
        <?php
        }
        ?>
        <p><span>Formatua:</span> <?php echo $libro['formato'] ?></p>
      </div>
    </section>

    <section id="sinopsis">
      <h2>Sinopsia:</h2>
      <p><?php echo $libro['sinopsis'] ?></p>
    </section>

    <section>
      <?php
      if ($accion !== 'eskaera') {
        // TODO: comprobar fecha de pub
        $comprobarReview = $pdo->prepare('SELECT id FROM review WHERE id_cuenta = :id_cuenta AND id_libro = :id_libro');
        $comprobarReview->execute(['id_cuenta' => $_SESSION['usr']['id'], 'id_libro' => $id]);
        $comprobarReview = $comprobarReview->fetch();

        if (empty($comprobarReview)) {
      ?>
          <a href="/liburua/<?php echo $libro['id'] ?>/iritzi" class="btn">Iritzia eman</a>
        <?php
        }
        ?>
        <a href="/liburua/<?php echo $libro['id'] ?>/hizkuntza-igo" class="btn">Hizkuntza berria <?php echo $_SESSION['usr']['rol']  === 'Admin' ? 'gehitu' : 'eskatu' ?></a>
      <?php
      } else {
      ?>
        <a href="/liburua/<?php echo $libro['id'] ?>/onartu" class="btn">Eskaera onartu</a>
        <a href="/liburua/<?php echo $libro['id'] ?>/ukatu" class="btn">Eskaera ukatu</a>
      <?php
      }
      ?>
    </section>

    <?php
    if ($accion !== 'eskaera') {
      include_once '../modules/select.php';
      $reviews = buscarReviews($libro['id'], ['r.id_libro = :id', 'r.texto <> ""']);
      if (count($reviews) > 0) agregarReviews($reviews);
    }
    ?>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>