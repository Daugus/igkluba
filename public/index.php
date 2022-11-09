<?php
$url = parse_url($_SERVER['REQUEST_URI']);
$page =  array_slice(array_filter(explode('/', strtolower($url['path']))), 0);

$ruta_elegida = '';
$accion = '';

$cantidadSecciones = count($page);
if ($cantidadSecciones === 1) {
  $ruta_elegida = '../views/' . $page[0] . '.php';
} else if ($cantidadSecciones === 2) {
  if (in_array($page[0], ['liburua', 'iritzia', 'profila', 'klasea'])) {
    $ruta_elegida = '../views/' . $page[0] . '.php';
    $busqueda = $page[1];
  }
} else if ($cantidadSecciones === 3 && $page[0] !== 'bilaketa') {
  if (in_array($page[0], ['liburua', 'iritzia', 'iritzi', 'erantzun', 'profila'])) {
    $id = $page[1];

    if (in_array($page[2], ['iritzi', 'erantzun', 'hizkuntza-igo'])) {
      $ruta_elegida = '../views/' . $page[2] . '.php';
    } else if (($page[0] !== 'iritzia' && in_array($page[2], ['aldatu', 'ezabatu', 'eskaera']))
      || in_array($page[0], ['liburua', 'profila']) && in_array($page[2], ['onartu', 'ukatu'])
    ) {
      $ruta_elegida = '../views/' . $page[0] . '.php';
      $busqueda = $page[1];
      $accion = $page[2];
    }
  }
} else if ($cantidadSecciones === 3 && $page[0] === 'bilaketa' && intval($page[2]) > 0) {
  $ruta_elegida = '../views/' . $page[0] . '.php';
  $busqueda = $page[1];
  $pagina = intval($page[2]);
}

if (empty($ruta_elegida) || !file_exists($ruta_elegida)) {
  header('Location: /hasiera');
}

include_once $ruta_elegida;
