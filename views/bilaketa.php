<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

// Pagina de busqueda para los libros
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['busqueda'])) {
  $busqueda = trim($_REQUEST['busqueda']);
  $_SESSION['busquedaOriginal'] = $busqueda;
  $busqueda = preg_replace('/^#/', 'e:', str_replace(' ', '_', $busqueda));
  header("Location: /bilaketa/$busqueda/1?ordenatu=nota&ordena=behera");
}

if (!isset($busqueda)) header('Location: /nagusia');
$busquedaOriginal = $_SESSION['busquedaOriginal'];

include_once '../templates/head.php';
agregarHead($busquedaOriginal . ' | IGKluba', __FILE__);
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral($busquedaOriginal);
  ?>

  <main>
    <!-- Desplegable para seleccionar la cantidad de columnas -->
    <?php agregarSelectColumnas(); ?>

    <?php
    include_once '../modules/select.php';
    $query = http_build_query($_REQUEST);

    $condicion = ["LOWER(il.titulo_alternativo) like '%$busquedaOriginal%'"];
    $orden = ['l.nota_media DESC'];

    $columnaOrden = isset($_REQUEST['ordenatu']) ? $_REQUEST['ordenatu'] : 'nota';
    switch ($columnaOrden) {
      case 'data':
        $orden = ['l.fecha_pub'];
        break;

      case 'irakurleak':
        $orden = ['l.cantidad_reviews'];
        break;

      case 'igoera':
        $orden = ['l.id'];
        break;

      case 'nota':
      default:
        $orden = ['l.nota_media'];
        break;
    }
    // Orden ascendente o descendente para la busqueda
    if (isset($_REQUEST['ordena']) && $_REQUEST['ordena'] === 'gora') {
      $orden[0] .= ' ASC';
    } else {
      $orden[0] .= ' DESC';
    }

    // Busqueda de libros
    $libros = buscarLibros($condicion, $orden);

    $resultados = count($libros);

    $pagina = intval($pagina);

    $libros = array_chunk($libros, 12);
    $cantidadPaginas = count($libros);
    $rutaBusqueda = '/bilaketa/' . $busquedaOriginal;

    // Ruta de la busqueda
    if ($pagina !== 1) {
      if ($cantidadPaginas === 0) {
        header("Location: $rutaBusqueda/1?$query");
      } else if ($cantidadPaginas < $pagina) {
        header("Location: $rutaBusqueda/$cantidadPaginas?$query");
      }
    }
    ?>
    <!-- Contar el numero de resultados que ha dado -->
    <h1 id="titulo-busqueda">"<?php echo $busquedaOriginal ?>" bilaketa <?php echo $resultados ?> erantzunak eman ditu:</h1>

    <?php if ($resultados > 0) { ?>
      <div id="resultados">
        <aside class="form-container" id="menu-busqueda">
          <form method="get" action="GET" class="flex-stretch-col">
            <p>Ordenatu</p>

            <!-- Filtros de busqueda -->
            <div class="select-container">
              <select name="orden" id="orden">
                <option value="igoera" <?php if (isset($_REQUEST['ordenatu']) && $_REQUEST['ordenatu'] === 'igoera') echo 'selected' ?>>Igoera data</option>
                <option value="nota" <?php if (!isset($_REQUEST['ordenatu']) || $_REQUEST['ordenatu'] === 'nota') echo 'selected' ?>>Nota</option>
                <option value="data" <?php if (isset($_REQUEST['ordenatu']) && $_REQUEST['ordenatu'] === 'data') echo 'selected' ?>>Argitaratze data</option>
                <option value="irakurleak" <?php if (isset($_REQUEST['ordenatu']) && $_REQUEST['ordenatu'] === 'irakurleak') echo 'selected' ?>>Irakurle kopurua</option>
              </select>
            </div>

            <div class="campo flex-stretch-col">
              <div class="flex-space-between-row radio-container">
                <label for="gora">Gora</label><input type="radio" name="direccion" value="gora" id="gora" <?php if (isset($_REQUEST['ordena']) && $_REQUEST['ordena'] === 'gora') echo 'checked' ?>>
              </div>
              <div class="flex-space-between-row radio-container">
                <label for="behera">Behera</label><input type="radio" name="direccion" value="behera" id="behera" <?php if (!isset($_REQUEST['ordena']) || $_REQUEST['ordena'] === 'behera') echo 'checked' ?>>
              </div>
            </div>

            <input type="hidden" value="<?php echo $busqor ?>" id="busqueda">
            <input type="hidden" value="<?php echo $pagina ?>" id="pagina">

            <button class="btn" type="submit" id="filtrar">Bilatu</button>
          </form>
        </aside>

        <section>
          <?php
          agregarLibros($libros[$pagina - 1]);

          if ($cantidadPaginas > 1) {
          ?>
            <!-- Cantidad de paginas -->
            <ul class="flex-center-row" id="selector-pagina">
              <?php
              foreach (range(1, $cantidadPaginas) as $enlacePagina) {
              ?>
                <li>
                  <a <?php if ($enlacePagina === $pagina) echo 'class="pagina-actual"' ?> href="<?php echo "$rutaBusqueda/$enlacePagina?$query" ?>">
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