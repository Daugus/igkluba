<?php
function footerInicio(): void
{
?>
  <footer id="footer-inicio">
    <p>Webgune hau Txurdinagako Lanbide Heziketako azken mailako Augusto, Unai eta Xabi ikasleek diseinatu dugu.</p>
  </footer>
<?php
}
function footerGeneral(): void
{
?>
  <footer class="flex-center-col" id="footer-general">
    <div class="footer-row">
      <div class="footer-col">
        <p>Profila</p>
        <ul>
          <li><a href="/gune-pertsonala">Gune pertsonala</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <p>Iritziak</p>
        <ul>
          <li><a href="/gune-pertsonala#nire-iritziak">Nire iritziak</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <p>Liburak eta hizkuntzak</p>
        <ul>
          <?php
          if ($_SESSION['usr']['rol'] === 'Admin') {
          ?>
            <li><a href="/liburua-igo">Liburua igo</a></li>
          <?php
          } else {
          ?>
            <li><a href="/liburua-eskatu">Liburua eskatu</a></li>
          <?php
          }
          ?>
          <li><a href="">Hizkuntza eskatu</a></li>
        </ul>
      </div>

      <div class="footer-texto">
        <ul class="flex-stretch-col">
          <li>Bigarren Hezkuntzako gazte askok irakurtzeko zaletasuna dugu. Hala ere, liburudendetan hainbeste liburu daude, ez dakigula nondik hasi! Webgune honetan gaztetxuentzako eta ez hain gaztetxuentzako liburuak daude: arrakastatsuenak…baita gustatu ez zaizkigunak ere. Bilatu eta gozatu!</li>
          <li>Contacto: <a href="mailto:leireirakas21@gmail.com">leireirakas21@gmail.com</a></li>
        </ul>
      </div>
    </div>

    <p>Webgune hau Txurdinagako Lanbide Heziketako azken mailako Augusto, Unai eta Xabi ikasleek diseinatu dugu.</p>
  </footer>
<?php
}
?>