<?php
function agregarFooter(): void
{
?>
  <footer class="flex-center-col" id="footerNormal">
    <p>Webgune hau Txurdinagako Lanbide Heziketako azken mailako Augusto, Unai eta Xabi ikasleek diseinatu dugu.</p>
    <p>Kontaktua: <a href="mailto:leireirakas21@gmail.com">leireirakas21@gmail.com</a></p>
  </footer>
  <footer id="footerMovil">
    <nav id="nav-movil">
      <ul class="nav-footer-movil">
        <li><a href="/nagusia">Hasiera</a></li>
        <li><a href="/profila">Gune pertsonala</a></li>
        <li><a href="/liburua-igo">Liburua <?php echo $_SESSION['usr']['rol'] === 'Admin' ? 'igo' : 'eskatu' ?></a></li>
        <li><a href="/itxi" id="logout">Saioa itxi</a></li>
      </ul>
    </nav>
  </footer>
<?php
}
