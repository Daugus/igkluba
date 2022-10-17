<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../modules/db-config.php';
$libro = $pdo->prepare('SELECT * FROM libro WHERE id = :id;');
$libro->execute(['id' => $_GET['id']]);
$libro = $libro->fetch();

$titulos = $pdo->prepare('SELECT * FROM idiomas_libro WHERE id_libro = :id_libro');
$titulos->execute(['id_libro' => $_GET['id']]);
$titulos = $titulos->fetchAll();

include_once '../modules/arrays.php';
$titulo_castellano = buscarEnArray($titulos, 'nombre_idioma', 'Gaztelania')['titulo_alternativo'];

include_once '../templates/head.php';
agregarHead($titulo_castellano . ' | IGKluba');
?>

<body>
  <h2>Izenburua: <?php echo $titulo_castellano ?></h2>
  <img src="src/img/azala/<?php echo $libro['id'] ?>.png" width="200">
  <p>Autorea: <?php echo $libro['autor'] ?></p>
  <p>Nota: <?php echo number_format((float)$libro['nota_media'], 2, '.', '') ?></p>
  <?php
  $idiomas = [];
  foreach ($titulos as $titulo) {
    $idiomas[] = $titulo['nombre_idioma'];
  }
  ?>
  <p>Hizkuntza: <?php echo implode(', ', $idiomas) ?></p>
  <p>Batez besteko adina: <?php echo $libro['edad_media'] ?></p>
  <p>Formatua: <?php echo $libro['formato'] ?></p>
  <p>Etiketak: <?php echo $libro['etiqueta'] ?></p>
</body>

</html>