<?php
function headerInicio(): void
{
?>
  <header id="header-inicio">
    <nav>
      <ul class="flex-center">
        <li id="logo">
          <img src="src/img/logo.png" alt="Logo IGKluba">
        </li>
        <div class="flex-center">
          <li><a href="sortu" class="btn">Sortu kontua</a></li>
          <li><a href="hasi" class="btn">Saio hasi</a></li>
        </div>
      </ul>
    </nav>
  </header>
<?php
}
function headerLogin(): void
{
?>
  <header id="header-login" class="flex-center">
    <img src="src/img/logo.png" alt="Logo IGKluba">
  </header>
<?php
}
?>