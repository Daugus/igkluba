<!DOCTYPE html>
<html lang='eu'>

<?php

include_once '../templates/head.php';
agregarHead('Saioa hasi | IGKluba', __FILE__);

include_once '../modules/session.php';
checkSession();
?>
<?php
$metodo = '';
$recoger = $_POST['otro'];
if (isset($_POST['Hizkuntza-berria'])) {
  $metodo = $_POST['Hizkuntza-berria'];
}


echo $recoger . " " . $metodo;

?>




<body id="fondo-libros">
  <?php
  include_once '../templates/header.php';
  headerGeneral();
  ?>

  <main class="flex-center-col main-form">
    <div class="form-container">
      <h1>Hezkuntza berria eskatu</h1>

      <form id="form-hizkuntza" action="" name="formHizkuntza" method="post" class="flex-stretch-col">
        <div class="campo">
          <label for="Liburu-izena">Liburuaren izena:</label>
          <input type="text" id="Liburu-izena" name="Liburu-izena" minlength="1" maxlength="20" placeholder="Izena">
        </div>

        <div class="campo">
          <label for="idioma">Irakurritako hizkuntza:</label>
          <select name="idioma" id="idioma">
            <option disabled selected>-</option>
            <?php
            include_once '../modules/db-config.php';
            $idiomasLibro = $pdo->prepare('SELECT DISTINCT i.id, i.nombre AS nombre
            FROM idiomas_libro il JOIN idioma i ON il.id_idioma = i.id 
            WHERE i.id not in (select DISTINCTROW idiomas_libro.id_idioma from idiomas_libro where id_libro = :id);');

            $idiomasLibro->execute(['id' => $id]);
            $idiomasLibro = $idiomasLibro->fetchAll();
            foreach ($idiomasLibro as $idioma) {
            ?>
              <option value="<?php echo $idioma['nombre'] ?>">
                <?php echo $idioma['nombre'] ?>
              </option>
            <?php
            }
            ?>
            <option value="otro" name="otro" onclick="recoger_usuario()">Otro</option>
          </select>
        </div>

        <div class="campo" id="recojanme" style="display:none">
          <label for="Hizkuntza-berria">Hizkuntza berria:</label>

          <input id="Hizkuntza-berria" name="Hizkuntza-berria" minlength="1" maxlength="30" placeholder="Hizkuntza">

        </div>

        <button id="login">Bidali</button>
      </form>
    </div>

    <div class="flex-center-col grupo-botones">
      <a href="/hasiera" class="volver">Itzuli</a>
    </div>
  </main>

  <?php if (!empty($error)) { ?>
    <div class="error"><i class="fa-solid fa-circle-exclamation"></i>
      <p><?php echo $error ?></p>
    </div>
  <?php
  }
  ?>
  <?php
  include_once '../templates/footer.php';
  agregarFooter();
  ?>
</body>

</html>