<?php
include_once '../modules/url.php';
$page = getPage();

$ruta_elegida = '';

if (count($page) === 1) {
  $ruta_elegida = '../views/' . $page[0] . '.php';
} else if (count($page) === 2 && in_array($page[0], ['liburu', 'bilaketa'])) {
  $ruta_elegida = '../views/' . $page[0] . '.php';
  $busqueda = $page[1];
}

if (empty($ruta_elegida) || !file_exists($ruta_elegida)) {
  header('Location: ' . getUrl() . '/hasiera');
}

include_once $ruta_elegida;
