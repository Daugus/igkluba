<?php
function headerInicio(): void
{
  include_once('../modules/url.php');
  $url = getUrl();
?>
  <header id="header-inicio">
    <nav>
      <ul class="flex-center">
        <li id="logo">
          <img src="<?php echo $url ?>/src/img/logo.png" alt="Logo IGKluba">
        </li>
        <div class="flex-center">
          <li><a href="<?php echo $url ?>/sortu" class="btn">Sortu kontua</a></li>
          <li><a href="<?php echo $url ?>/hasi" class="btn">Saio hasi</a></li>
        </div>
      </ul>
    </nav>
  </header>
<?php
}
function headerLogin(): void
{
  include_once('../modules/url.php');
  $url = getUrl();
?>
  <header id="header-login" class="flex-center">
    <img src="<?php echo $url ?>/src/img/logo.png" alt="Logo IGKluba">
  </header>
<?php
}
?>