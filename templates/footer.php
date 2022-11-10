<?php
function agregarFooter($agregarFooterMovil = true): void
{
?>
  <footer class="flex-center-col" id="footer-general">
    <p>Webgune hau Txurdinagako Lanbide Heziketako azken mailako Augusto, Unai eta Xabi ikasleek diseinatu dugu.</p>
    <p>Kontaktua: <a href="mailto:leireirakas21@gmail.com">leireirakas21@gmail.com</a></p>
  </footer>

  <footer id="footer-movil">
    <nav id="nav-movil">
      <ul class="flex-space-evenly-row">
        <li>
          <a href="/liburua-igo">
            <i class="fa-solid fa-book"></i>
            <?php echo $_SESSION['usr']['rol'] === 'Admin' ? 'Igo' : 'Eskatu' ?>
          </a>
        </li>

        <li>
          <a href="/nagusia">
            <i class="fa-solid fa-house"></i>
            Hasiera
          </a>
        </li>

        <li>
          <a href="/profila">
            <i class="fa-solid fa-user"></i>
            Profila
          </a>
        </li>
      </ul>
    </nav>
  </footer>
<?php
}
