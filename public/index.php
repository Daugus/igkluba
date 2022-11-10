<?php
$url = parse_url($_SERVER['REQUEST_URI']);
$page =  array_slice(array_filter(explode('/', strtolower($url['path']))), 0);

$ruta_elegida = '';
$accion = '';

$cantidadSecciones = count($page);
switch ($cantidadSecciones) {
  case 1:
    $ruta_elegida = '../views/' . $page[0] . '.php';
    break;

  case 2:
    if (in_array($page[0], ['liburua', 'iritzia', 'bilaketa', 'profila'])) {
      $ruta_elegida = '../views/' . $page[0] . '.php';
      $busqueda = $page[1];
    }
    break;

  case 3:
    if (in_array($page[0], ['liburua', 'iritzia', 'iritzi', 'erantzun', 'profila', 'hizkuntza-igo'])) {
      $id = $page[1];

      if (in_array($page[2], ['iritzi', 'erantzun', 'hizkuntza-igo'])) {
        $ruta_elegida = '../views/' . $page[2] . '.php';
      } else if (($page[0] !== 'iritzia' && in_array($page[2], ['aldatu', 'ezabatu', 'eskaera']))
        || in_array($page[0], ['liburua', 'profila', 'hizkuntza-igo']) && in_array($page[2], ['onartu', 'ukatu'])
      ) {
        $ruta_elegida = '../views/' . $page[0] . '.php';
        $busqueda = $page[1];
        $accion = $page[2];
      }
    }

    break;
}

if (empty($ruta_elegida) || !file_exists($ruta_elegida)) {
  header('Location: /hasiera');
}

include_once $ruta_elegida;
