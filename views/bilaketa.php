<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['busqueda'])) {
  $busqueda = trim($_REQUEST['busqueda']);
  $_SESSION['busquedaOriginal'] = $busqueda;
  $busqueda = preg_replace('/^#/', 'e:', str_replace(' ', '_', $busqueda));
  header('Location: /bilaketa/' . $busqueda . '/1');
}

if (!isset($busqueda)) header('Location: /nagusia');
$busquedaOriginal = $_SESSION['busquedaOriginal'];

include_once '../templates/head.php';
agregarHead($busquedaOriginal . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral($busquedaOriginal);
  ?>

  <main>
    <?php
    include_once '../modules/select.php';

    $libros = buscarLibros(
      "LOWER(il.titulo_alternativo) like '%$busquedaOriginal%'",
      'il.id_idioma ASC, l.nota_media DESC'
    );

    $resultados = count($libros);

    $pagina = intval($pagina);

    $libros = array_chunk($libros, 4);
    $cantidadPaginas = count($libros);
    $rutaBusqueda = '/bilaketa/' . $busquedaOriginal;

    if ($pagina !== 1) {
      if ($cantidadPaginas === 0) {
        header("Location: $rutaBusqueda/1");
      } else if ($cantidadPaginas < $pagina) {
        header("Location: $rutaBusqueda/$cantidadPaginas");
      }
    }
    ?>

    <h1 id="titulo-busqueda">"<?php echo $busquedaOriginal ?>" bilaketa <?php echo $resultados ?> erantzunak eman ditu:</h1>

    <?php if ($resultados > 0) { ?>
      <div id="resultados">
        <aside id="menu-busqueda">
          <section>
            <p>Orden</p>
          </section>
          <section>
            <p>Filtros</p>
          </section>
        </aside>

        <section>
          <?php
          agregarLibros($libros[$pagina - 1]);

          if ($cantidadPaginas > 1) {
          ?>
            <ul class="flex-center-row" id="selector-pagina">
              <?php
              foreach (range(1, $cantidadPaginas) as $enlacePagina) {
              ?>
                <li>
                  <a <?php if ($enlacePagina === $pagina) echo 'class="pagina-actual"' ?> href="<?php echo $rutaBusqueda . '/' . $enlacePagina ?>">
                    <span>
                      <?php echo $enlacePagina ?>
                    </span>
                  </a>
                </li>
              <?php
              }
              ?>
            </ul>
          <?php
          }
          ?>
        </section>
      </div>
    <?php
    } else {
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