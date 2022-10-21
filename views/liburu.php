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
if (empty($libro)) header('Location: ../nagusia');

$reviews = $pdo->prepare('SELECT * FROM review WHERE id_libro = :id_libro;');
$reviews->execute(['id_libro' => $id]);
$reviews = $reviews->fetchAll();

$titulos = $pdo->prepare('SELECT * FROM idiomas_libro WHERE id_libro = :id_libro');
$titulos->execute(['id_libro' => $id]);
$titulos = $titulos->fetchAll();

$consultaEtiquetas = $pdo->prepare('SELECT nombre FROM etiqueta WHERE id_libro = :id_libro');
$consultaEtiquetas->execute(['id_libro' => $id]);
$consultaEtiquetas = $consultaEtiquetas->fetchAll();

include_once '../modules/arrays.php';
$titulo_castellano = buscarEnArray($titulos, 'nombre_idioma', 'Gaztelania')['titulo_alternativo'];

include_once '../templates/head.php';
agregarHead($titulo_castellano . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col" id="main-libro">
    <section class="flex-center-row" id="superior">
      <a href="<?php echo $libro['enlace'] ?>" target="_blank" rel="noopener noreferrer" id="portada">
        <img src="../src/img/azala/<?php echo $libro['id'] ?>.png" alt="portada">
      </a>

      <div class="flex-center-col" id="datos">
        <div class="flex-center-col" id="titulo-serie">
          <h1><?php echo $titulo_castellano ?></h1>

          <?php
          if (isset($libro['serie'])) {
          ?>
            <p id="serie"><?php echo $libro['serie'] . ' #' . $libro['serie_num'] ?></p>
          <?php
          }
          ?>

          <p id="autor"><?php echo $libro['autor'] ?></p>
          <p class="nota">
            <a href="#iritziak">
              <?php echo number_format((float)$libro['nota_media'], 2, '.', '') ?><i class="fa-solid fa-star"></i>
            </a>
          </p>
        </div>

        <p><span>Argitaratze data:</span> <?php echo $libro['fecha_pub'] ?></p>
        <?php
        $idiomas = [];
        foreach ($titulos as $titulo) {
          $idiomas[] = $titulo['nombre_idioma'];
        }
        ?>
        <p><span>Hizkuntza<?php if (count($idiomas) > 1) echo 'k' ?>:</span> <?php echo implode(', ', $idiomas) ?></p>
        <p><span>Batez besteko adina:</span> <?php echo $libro['edad_media'] ?></p>
        <p><span>Irakurle kopurua:</span> <?php echo $libro['cantidad_reviews'] ?></p>
        <p><span>Formatua:</span> <?php echo $libro['formato'] ?></p>
        <?php
        $etiquetas = [];
        foreach ($consultaEtiquetas as $etiqueta) {
          $etiquetas[] = $etiqueta['nombre'];
        }
        ?>
        <p><span>Etiketa<?php if (count($etiquetas) > 1) echo 'k' ?>:</span> <?php echo implode(', ', $etiquetas) ?></p>
      </div>
    </section>

    <section id="central">
      <h2>Sinopsia:</h2>
      <p id="sinopsis"><?php echo $libro['sinopsis'] ?></p>
    </section>

    <section id="inferior">
      <h2 id="iritziak">Iritziak:</h2>
      <div class="flex-stretch-col" id="reviews">
        <?php
        foreach ($reviews as $review) {
        ?>
          <div class="review">
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

            if (isset($review['texto'])) {
            ?>
              <p><?php echo $review['texto'] ?></p>
            <?php
            }
            ?>

            <p class="nota"><?php echo $review['nota'] ?><i class="fa-solid fa-star"></i></p>

            <?php
            $cantidadRespuestas = $pdo->prepare('SELECT count(id) AS cantidad_respuestas FROM respuesta WHERE id_review = :id_review;');
            $cantidadRespuestas->execute(['id_review' => $review['id']]);
            $cantidadRespuestas = $cantidadRespuestas->fetch()['cantidad_respuestas'];
            if ($cantidadRespuestas > 0) {
            ?>
              <a href="/erantzunak/<?php echo $review['id'] ?>" class="ver-respuestas">
                Erantzunak (<?php echo $cantidadRespuestas ?>)
              </a>
            <?php
            }
            ?>
          </div>
        <?php
        }
        ?>
      </div>
    </section>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>