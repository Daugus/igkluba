<!DOCTYPE html>
<html lang='eu'>

<?php
include_once '../modules/session.php';
checkSession();


include_once '../templates/head.php';
agregarHead('Sortu kontua | IGKluba', __FILE__, false);

?>

<body class="flex-stretch-col">

    <h1 id="titulo-añadir-libro">Gehitu liburu berria</h1>
  <main class="flex-center-row">
    
    <form action="" method="post" enctype="multipart/form-data" class="flex-stretch-col form-hasi-sortu">
      <div class="campo">
        <label for="nombre">Liburuaren izena:</label>
        <input type="text" id="nombre" name="nombre" maxlength="50" placeholder="Liburuaren izena...">
      </div>

      <div class="campo">
        <label for="egilea">Liburuaren egilea:</label>
        <input type="text" id="egilea" name="egilea" maxlength="50" placeholder="Libruaren egilea...">
      </div>

      <div class="campo">
        <label for="imagen">Liburuaren azala:</label>
        <label for="imagen" class="file-input-text" tabindex="0"><i class="fa-solid fa-file-image"></i> <span>Aukeratu argazki bat...</span></label>
        <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png" class="hidden">
      </div>

      <div class="campo">
        <label for="sinopsia" id="Agregar-sinopsis">Azaldu liburuaren sinopsia:</label>
        <input type="textarea" id="Agregar-sinopsis" name="Agregar-sinopsis" maxlength="20" placeholder="sinopsia...">
      </div>

      <div class="campo">
        <label for="hizkuntza">Irakurri duzu beste hizkuntza batean?</label>
        <select name="hizkuntza" id="hizkuntza">
          <option value="">--</option>
          <option value="1">Ingelesa</option>
          <option value="2">Euskera</option>
          <option value="3">Beste bat</option>
        </select>
      </div>

      <div class="campo">
        <label for="formatua">Ze formatutan irakurri duzu?</label>
        <select name="formatua" id="formatua">
          <option value="">--</option>
          <option value="1">Liburu</option>
          <option value="2">comic</option>
          <option value="3">Manga</option>
          <option value="4">Beste bat</option>
        </select>
      </div>

      <div class="campo">
        <label for="etiketa">Ze etiketarekin deskribatuko zenuke?:</label>
        <input type="text" id="etiketa" name="etiketa" maxlength="8" placeholder="Etiketak...">
      </div>
      <br>
      <button type="submit" href="/nagusia" id="bidali" class="btn">Bidali</button>
    </form>
    
  </main>
   
     
      <a href="/nagusia" class="btn">Itzuli</a>
      
  
    
  <?php
  include_once '../templates/footer.php';
  footerInicio();
  ?>
</body>

</html>