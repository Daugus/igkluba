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
  headerLogin();
  ?>
  <main class="flex-center-row">
    <?php
    include_once '../modules/db-config.php';
    $libros = $pdo->prepare('SELECT l.id, il.titulo_alternativo titulo, l.autor, l.nota_media FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro WHERE il.nombre_idioma = "Gaztelania" ORDER BY l.nota_media DESC;');
    $libros->execute();
    $libros = $libros->fetchAll();
    foreach ($libros as $libro) {
    ?>
      <div class="libro">
        <a href="liburu/<?php echo $libro['id'] ?>"><img src="src/img/azala/<?php echo $libro['id'] ?>.png" alt="Portada <?php echo $libro['titulo'] ?>" height="300"></a>
        <p><?php echo $libro['titulo'] ?></p>
        <p><?php echo $libro['autor'] ?></p>
        <p><?php echo number_format((float)$libro['nota_media'], 2, '.', '') ?><i class="fa-solid fa-star"></i></p>
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