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

$reviews = $pdo->prepare('SELECT * FROM review WHERE id_libro = :id_libro');
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
  <main>
    <a href="<?php echo $libro['enlace'] ?>" target="_blank" rel="noopener noreferrer"><img src="../src/img/azala/<?php echo $libro['id'] ?>.png" alt="portada" width="200"></a>
    <h2><?php echo $titulo_castellano ?></h2>
    <p><?php echo $libro['serie'] . ' #' . $libro['serie_num'] ?></p>
    <p>Egilea: <?php echo $libro['autor'] ?></p>
    <p><?php echo number_format((float)$libro['nota_media'], 2, '.', '') ?><i class="fa-solid fa-star"></i></p>
    <p>Argitaratze data: <?php echo $libro['fecha_pub'] ?></p>
    <?php
    $idiomas = [];
    foreach ($titulos as $titulo) {
      $idiomas[] = $titulo['nombre_idioma'];
    }
    ?>
    <p>Hizkuntza<?php if (count($idiomas) > 1) echo 'k' ?>: <?php echo implode(', ', $idiomas) ?></p>
    <p>Batez besteko adina: <?php echo $libro['edad_media'] ?></p>
    <p>Irakurle kopurua: <?php echo $libro['cantidad_reviews'] ?></p>
    <p>Formatua: <?php echo $libro['formato'] ?></p>
    <?php
    $etiquetas = [];
    foreach ($consultaEtiquetas as $etiqueta) {
      $etiquetas[] = $etiqueta['nombre'];
    }
    ?>
    <p>Etiketa<?php if (count($etiquetas) > 1) echo 'k' ?>: <?php echo implode(', ', $etiquetas) ?></p>
    <p>Sinopsia: <?php echo $libro['sinopsis'] ?></p>
    <h3>Iritziak:</h3>
    <?php
    foreach ($reviews as $review) {
    ?>
      <div class="review">
        <p><?php echo $review['texto'] ?></p>
        <p><?php echo $review['nota'] ?><i class="fa-solid fa-star"></i></p>
        <?php
        if ($_SESSION['usr']['rol'] !== 'Ikasle') {
        ?>
          <p>
            <?php
            $cuenta = $pdo->prepare('SELECT * FROM cuenta WHERE id = :id;');
            $cuenta->execute(['id' => $review['id_cuenta']]);
            $cuenta = $cuenta->fetch();
            echo $cuenta['apodo'];
            ?>
          </p>
        <?php
        }
        ?>
      </div>
    <?php
    }
    ?>
  </main>

  <?php
  include_once '../templates/footer.php';
  footerGeneral();
  ?>
</body>

</html>