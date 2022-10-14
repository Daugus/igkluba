<?php
include_once('../modules/url.php');
$url = getPage();

$ruta_elegida = '';

if (count($url) === 1) {
  $ruta_elegida = '../views/' . $url[0] . '.php';
}

if (count($url) === 0 || !file_exists($ruta_elegida)) {
  header('Location: hasiera');
}

include_once $ruta_elegida;
