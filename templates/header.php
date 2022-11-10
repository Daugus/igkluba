<?php
function headerGeneral(String $valueBusqueda = ''): void
{
?>
  <header class="flex-space-between-row">
    <div>
      <a href="/naugusia">
        <picture>
          <source srcset="/src/img/logo-sin-texto.png" media="(max-width: 40em)">
          <img src="/src/img/logo.png" alt="Logo IGKluba">
        </picture>
      </a>
    </div>

    <form id="buscador" action="/bilaketa" method="POST" class="flex-center-row">
      <input id="busqueda" type="search" name="busqueda" placeholder="Bilatu liburua..." value="<?php echo $valueBusqueda ?>">
      <button id="buscar" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    <div id="header-perfil">
      <a href="/profila">
        <?php
        $rutaImagen = '/src/img/profila/' . $_SESSION['usr']['id'] .  '.png';
        if (!file_exists('../public' . $rutaImagen)) $rutaImagen = '/src/img/profila/default.svg';
        ?>
        <img src="<?php echo $rutaImagen ?>" alt="Profileko argazkia" class="foto-perfil">
      </a>
    </div>
  </header>

  <nav id="nav-general">
    <ul class="flex-center-row">
      <li><a href="/nagusia">Hasiera</a></li>
      <li><a href="/profila">Profila</a></li>
      <li><a href="/liburua-igo">Liburua <?php echo $_SESSION['usr']['rol'] === 'Admin' ? 'igo' : 'eskatu' ?></a></li>
      <li><a href="/itxi" id="logout">Saioa itxi</a></li>
    </ul>
  </nav>
<?php
}
