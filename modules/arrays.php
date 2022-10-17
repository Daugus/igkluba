<?php
function buscarEnArray($array, $columna, $valor): array
{
  $resultado = [];

  foreach ($array as $subarray) {
    if ($subarray[$columna] === $valor) {
      $resultado = $subarray;
      break;
    }
  }

  return $resultado;
}
