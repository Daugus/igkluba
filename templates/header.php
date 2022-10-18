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

function headerGeneral(): void
{
?>
  <header id="header-general">
    <div>
      <div>
        <img src="/src/img/usuario.png" alt="perfil" id="perfil">
      </div>
      <ul class="flex-center">
        <li id="logo">
          <a href="/"><img src="/src/img/logo.png" alt="Logo IGKluba"></a>
        </li>
      </ul>
    </div>

    <p class="buscador">
      <input id="buscador" type="search" name="busqueda" placeholder="Billatu zure liburua...">
      <input type="submit" value="Billatu">
    </p>
  </header>

  <nav id="nav-general">
    <ul class="flex-center-row">
      <li><a href="">Inicio</a></li>
      <li><a href="">Mis Valoraciones</a></li>
      <li><a href="">Subir Libro</a></li>
      <li><a href="/logout" id="logout">Cerrar Sesión</a></li>
    </ul>
  </nav>
<?php
}




?>