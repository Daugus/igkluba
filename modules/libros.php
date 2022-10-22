<?php

function buscarLibros(String $condicion, String $orden = 'l.nota_media DESC', String $agrupar = ''): array
{
  include '../modules/db-config.php';
  $libros = $pdo->prepare('SELECT DISTINCT l.id, il.titulo_alternativo AS titulo, l.autor, l.nota_media
  FROM libro l JOIN idiomas_libro il ON l.id = il.id_libro
  WHERE ' . $condicion
    . ' ' . $agrupar
    . ' ORDER BY ' . $orden
    . ' LIMIT 24;');
  $libros->execute();
  $libros = $libros->fetchAll();

  return $libros;
}

function agregarLibros(array $libros)
{
  foreach ($libros as $libro) {
    $url = '/liburua/' . $libro['id'] . '-' . str_replace(' ', '_', strtolower($libro['titulo']));
?>
    <article class="flex-space-between-col libro">
      <a href="<?php echo $url ?>" class="libro__portada">
        <img src="/src/img/azala/<?php echo $libro['id'] ?>.png" alt="Portada <?php echo $libro['titulo'] ?>">
      </a>

      <div class="flex-center-col libro__texto">
        <a href="<?php echo $url ?>" class="libro__titulo">
          <?php echo $libro['titulo'] ?>
        </a>

        <a href="/#<?php echo $libro['autor'] ?>" class="libro__autor">
          <?php echo $libro['autor'] ?>
        </a>

        <a href="<?php echo $url ?>#iritziak" class="nota libro__nota">
          <?php echo number_format((float)$libro['nota_media'], 2, '.', '') ?><i class="fa-solid fa-star"></i>
        </a>
      </div>
    </article>
<?php
  }
}
?>