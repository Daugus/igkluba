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
    <section class="flex-center-row" id="superior">

      <div id="perfil">
        <a href="/gune-pertsonala">
          <?php
          $rutaImagen = '/src/img/profila/' . $usuario['id'] .  '.png';
          if (!file_exists('../public' . $rutaImagen)) $rutaImagen = '/src/img/profila/default.svg';
          ?>
          <img src="<?php echo $rutaImagen ?>" alt="Profileko argazkia">
        </a>
      </div>

      <div class="flex-center-col" id="datos">
        <h1><?php echo $usuario['nombre'] . ' ' . $usuario['apellido'] ?></h1>
        <p id="apodo"><?php echo $usuario['apodo'] ?></p>

        <p><span>Jaiotze data:</span> <?php echo $usuario['fecha_nacimiento'] ?></p>
        <p><span>Zentroa:</span> <?php echo $usuario['nombre_centro'] ?></p>
        <p><span>Emaila:</span> <?php echo $usuario['nombre_centro'] ?></p>

        <?php if ($usuario['rol'] === 'Ikasle') : ?>
          <p><span>Clase:</span> <?php echo $clase['nombre'] ?></p>
        <?php endif ?>

        <?php
        ?>
      </div>
    </section>
  </main>

  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>