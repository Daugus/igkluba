<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

if (!isset($busqueda) || $_SESSION['usr']['rol'] !== 'Irakasle') header('Location: /profila');

include_once '../modules/db-config.php';
$clase = $pdo->prepare(
  'SELECT *
    FROM clase c JOIN profesor_clase pc ON c.cod = pc.cod_clase
    WHERE cod = :cod;'
);
$clase->execute(['cod' => $busqueda]);
$clase = $clase->fetch();

include_once '../modules/select.php';

include_once '../templates/head.php';
agregarHead($clase['nombre'] . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main id="main-clase">
    <h1><?php echo $clase['nombre'] ?></h1>

    <?php
    $alumnos = buscarAlumnos($clase['cod']);
    if (count($alumnos) > 0) agregarAlumnos($alumnos);
    ?>

    <a href="/profila#klaseak" class="volver">Itzuli</a>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>