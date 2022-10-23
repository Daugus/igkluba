<?php
include_once '../modules/url.php';
$page = getPage();

$ruta_elegida = '';
$accion = '';

$cantidadSecciones = count($page);
switch ($cantidadSecciones) {
  case 1:
    $ruta_elegida = '../views/' . $page[0] . '.php';
    break;

  case 2:
    if (in_array($page[0], ['liburua', 'iritzia', 'bilaketa'])) {
      $ruta_elegida = '../views/' . $page[0] . '.php';
      $busqueda = $page[1];
    }
    break;

  case 3:
    if (in_array($page[0], ['liburua', 'iritzia', 'iritzi'])) {
      $id = $page[1];

      if (in_array($page[2], ['iritzi', 'erantzun'])) {
        $ruta_elegida = '../views/' . $page[2] . '.php';
      } else if ($page[2] !== 'iritzia' && in_array($page[2], ['aldatu', 'ezabatu'])) {
        $ruta_elegida = '../views/' . $page[0] . '.php';
        $accion = $page[2];
      }
    }

    break;
}


if (empty($ruta_elegida) || !file_exists($ruta_elegida)) {
  header('Location: ' . getUrl() . '/hasiera');
}

include_once $ruta_elegida;
