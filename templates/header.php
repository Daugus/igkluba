<?php
function headerInicio(): void
{
?>
  <header id="header-inicio" class="flex-space-between-row">
    <div id="logo">
      <img src="/src/img/logo.png" alt="Logo IGKluba">
    </div>
    <nav>
      <ul class="flex-center-row">
        <a href="/sortu" class="btn">Sortu kontua</a>
        <a href="/hasi" class="btn">Saioa hasi</a>
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

function headerGeneral(String $valueBusqueda = ''): void
{
?>
  <header class="flex-space-between-row" id="header-general">
    <div>
      <a href="/"><img src="/src/img/logo.png" alt="Logo IGKluba"></a>
    </div>

    <form id="buscador" action="/bilaketa" method="POST" class="flex-center-row">
      <input id="busqueda" type="search" name="busqueda" placeholder="Bilatu liburua edo egilea..." value="<?php echo $valueBusqueda ?>">
      <button id="buscar" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    <div id="perfil">
      <a href="/gune-pertsonala">
        <?php
        $rutaImagen = '/src/img/profila/' . $_SESSION['usr']['id'] .  '.png';
        if (!file_exists('../public' . $rutaImagen)) $rutaImagen = '/src/img/profila/default.svg';
        ?>
        <img src="<?php echo $rutaImagen ?>" alt="Profileko argazkia">
      </a>
    </div>
  </header>

  <nav id="nav-general">
    <ul class="flex-center-row">
      <li><a href="/nagusia">Hasiera</a></li>
      <li><a href="/gune-pertsonala">Gune pertsonala</a></li>
      <li><a href="#">Liburua eskatu</a></li>
      <li><a href="/itxi" id="logout">Saioa itxi</a></li>
    </ul>
  </nav>
<?php
}
