<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

// Crear y gestionar el codigo de la clase
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once '../modules/db-config.php';

  $charsDisponibles = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $chars = [];

  $max = strlen($charsDisponibles) - 1;
  for ($i = 0; $i < 6; $i++) $chars[] = $charsDisponibles[random_int(0, $max)];

  $codClase = implode('', $chars);

  $year = intval(date('Y'));
  $curso = $year . '-' . $year + 1;

  $insert = $pdo->prepare(
    'INSERT INTO clase (cod, nombre, nivel, curso, id_centro)
      VALUES (:cod, :nombre, :nivel, :curso, :id_centro)'
  );
  $insert->execute([
    'cod' => $codClase,
    'nombre' => $_REQUEST['nombre'],
    'nivel' => $_REQUEST['nivel'],
    'curso' => $curso,
    'id_centro' => $_SESSION['usr']['id_centro']
  ]);

  $insert = $pdo->prepare('INSERT INTO profesor_clase (id_profesor, cod_clase) values (:id_profesor, :cod_clase)');
  $insert->execute([
    'id_profesor' => $_SESSION['usr']['id'],
    'cod_clase' => $codClase
  ]);

  header("Location: /klasea/$codClase");
}

if (!isset($busqueda) || $_SESSION['usr']['rol'] !== 'Irakasle') header('Location: /profila');


// Eliminar clase
if ($accion === 'ezabatu') {
  include_once '../modules/db-config.php';
  $delete = $pdo->prepare('DELETE FROM clase WHERE cod = :cod');
  $delete->execute(['cod' => $busqueda]);
  header('Location: /profila#klaseak');
} else if ($accion !== '') {
  header('Location: /profila#klaseak');
}

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

  <main class="flex-stretch-col" id="main-clase">
    <h1><?php echo $clase['nombre'] ?></h1>

    <!-- Datos de la clase -->
    <section id="datos">
      <p><span>Kodea</span>: <?php echo $clase['cod'] ?></p>
      <p><span>Maila</span>: <?php echo $clase['nivel'] ?></p>
      <p><span>Ikasturte</span>: <?php echo $clase['curso'] ?></p>
      <?php
      $centro = $pdo->prepare('SELECT nombre FROM centro WHERE id = :id;');
      $centro->execute(['id' => $clase['id_centro']]);
      $centro = $centro->fetch();
      ?>
      <p><span>Ikastetxea</span>: <?php echo $centro['nombre'] ?></p>
    </section>

    <a href="/klasea/<?php echo $clase['cod'] ?>/ezabatu" class="btn">Klasea ezabatu</a>

    <?php
    // Busca los alumnos
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