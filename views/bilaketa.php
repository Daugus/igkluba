<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['busqueda'])) {
  $busqueda = preg_replace('/^#/', 'e:', str_replace(' ', '_', trim($_REQUEST['busqueda'])));
  header('Location: /bilaketa/' . $busqueda);
}

if (!isset($busqueda)) header('Location: /nagusia');
$busqueda = str_replace('_', ' ', $busqueda);

include_once '../templates/head.php';
agregarHead($busqueda . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral($busqueda);
  ?>

  <main>
    <?php
    $busqueda = strtolower($busqueda);
    include_once '../modules/select.php';
    ?>

    <?php
    $librosPorTitulo = buscarLibros(
      "LOWER(il.titulo_alternativo) like '%$busqueda%'",
      'il.id_idioma ASC, l.nota_media DESC'
    );
    $librosPorAutor = buscarLibros(
      "LOWER(l.autor) like '%$busqueda%'",
      'l.autor ASC, l.nota_media DESC'
    );

    $cantidadPorLibro = count($librosPorTitulo);
    $cantidadPorAutor = count($librosPorAutor);
    ?>

    <h1>"<?php echo $busqueda ?>" bilaketa <?php echo $cantidadPorLibro + $cantidadPorAutor ?> erantzunak eman ditu:</h1>

    <?php
    if ($cantidadPorLibro > 0) {
    ?>
      <section>
        <h2>Titulo bidez <span>(<?php echo $cantidadPorLibro ?>)</span>:</h2>

        <?php agregarLibros($librosPorTitulo) ?>
      </section>
    <?php
    }

    if ($cantidadPorAutor > 0) {
    ?>
      <section>
        <h2>Egile bidez <span>(<?php echo $cantidadPorAutor ?>)</span>:</h2>

        <div class="grid">
          <?php agregarLibros($librosPorAutor) ?>
        </div>
      </section>
    <?php
    }

    if ($cantidadPorLibro === 0 && $cantidadPorAutor === 0) {
    ?>
      <p>Saiatu bilaketa aldatzen.</p>
    <?php
    }
    ?>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>