<?php
include_once '../modules/url.php';
$url['page'] = getPage();

$ruta_elegida = '';

if (count($url['page']) === 1) {
  $ruta_elegida = '../views/' . $url['page'][0] . '.php';
} else if (count($url['page']) === 2 && $url['page'][0] === 'liburu') {
  $ruta_elegida = '../views/' . $url['page'][0] . '.php';
  $id = $url['page'][1];
}

if (empty($ruta_elegida) || !file_exists($ruta_elegida)) {
  header('Location: ' . getUrl() . '/hasiera');
}

include_once $ruta_elegida;
