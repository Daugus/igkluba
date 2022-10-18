<?php
function headerInicio(): void
{
?>
  <header id="header-inicio" class="flex-center-row">
    <div id="logo">
      <img src="/src/img/logo.png" alt="Logo IGKluba">
    </div>
    <nav>
      <ul class="flex-center-row">
        <li><a href="sortu" class="btn">Sortu kontua</a></li>
        <li><a href="hasi" class="btn">Saioa hasi</a></li>
      </ul>
    </nav>
  </header>
<?php
}

function headerLogin(): void
{
?>
  <header id="header-login" class="flex-center-row">
    <a href="/"><img src="/src/img/logo.png" alt="Logo IGKluba"></a>
  </header>
<?php
}
?>