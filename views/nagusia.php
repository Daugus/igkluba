<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

include_once '../templates/head.php';
agregarHead('IGKluba');
?>

<body class="flex-stretch-col">
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>
  <main id="main-nagusia" class="flex-center-row">
    <?php
    include_once '../modules/db-config.php';
    $libros = $pdo->prepare('SELECT l.id, il.titulo_alternativo titulo, l.autor, l.nota_media FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro WHERE il.nombre_idioma = "Gaztelania" ORDER BY l.nota_media DESC limit 24;');
    $libros->execute();
    $libros = $libros->fetchAll();
    foreach ($libros as $libro) {
    ?>
      <div class="flex-center-col libro">
        <a href="/liburu/<?php echo $libro['id'] ?>" class="libro__portada"><img src="/src/img/azala/<?php echo $libro['id'] ?>.png" alt="Portada <?php echo $libro['titulo'] ?>"></a>
        <div class="flex-center-col libro__texto">
          <a href="/liburu/<?php echo $libro['id'] ?>" class="libro__titulo"><?php echo $libro['titulo'] ?></a>
          <a href="/#<?php echo $libro['autor'] ?>" class="libro__autor"><?php echo $libro['autor'] ?></a>
          <p class="libro__nota"><?php echo number_format((float)$libro['nota_media'], 2, '.', '') ?><i class="fa-solid fa-star"></i></p>
        </div>
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