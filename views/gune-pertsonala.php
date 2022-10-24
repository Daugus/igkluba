<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();

$usuario = $_SESSION['usr'];

if ($usuario['rol'] === 'Ikasle') {
  include '../modules/db-config.php';
  $clase = $pdo->prepare('SELECT * FROM clase WHERE cod = :cod_clase;');
  $clase->execute(['cod_clase' => $usuario['cod_clase']]);
  $clase = $clase->fetch();
}

include_once '../templates/head.php';
agregarHead($_SESSION['usr']['apodo'] . ' | IGKluba');
?>

<body>
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col" id="main-personal">
    <section class="flex-center-row" id="informacion">
      <div id="perfil">
        <?php
        $rutaImagen = '../public/src/img/profila/' . $usuario['id'] .  '.png';
        if (!file_exists($rutaImagen)) $rutaImagen = '/src/img/profila/default.svg';
        ?>
        <img src="<?php echo str_replace('../public', '', $rutaImagen) ?>" alt="Profileko argazkia" width="100">
      </div>

      <div class="flex-center-col" id="datos">
        <div class="flex-center-col" id="datos-importantes">
          <h1><?php echo $usuario['nombre'] . ' ' . $usuario['apellido'] ?></h1>
          <p id="apodo"><?php echo $usuario['apodo'] ?></p>
        </div>

        <p><span>Jaiotze data:</span> <?php echo $usuario['fecha_nacimiento'] ?></p>
        <p><span>E-maila:</span> <?php echo $usuario['correo'] ?></p>

        <p><span>Ikastetxea:</span> <?php echo $usuario['nombre_centro'] ?></p>
        <?php if ($usuario['rol'] === 'Ikasle') { ?>
          <p><span>Ikasturtea:</span> <?php echo $clase['curso'] ?></p>
          <p><span>Maila:</span> <?php echo $clase['nivel'] ?></p>
          <p><span>Klasea:</span> <?php echo $clase['nombre'] ?></p>
        <?php } else if ($usuario['rol'] === 'Irakasle') { ?>
          <p><span>Telefonoa:</span> <?php echo $usuario['tel'] ?></p>
        <?php } ?>
      </div>
    </section>

    <?php
    include_once '../modules/reviews.php';
    $reviews = buscarReviews($usuario['id'], ['r.id_cuenta = :id']);
    if (count($reviews) > 0) agregarReviews($reviews, true);
    ?>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>