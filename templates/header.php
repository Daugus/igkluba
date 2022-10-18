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

<?php
function headerNagusia(): void
{
?>
  <header id="header-nagusia">
    <nav>
    <div>
          <img src="src/img/usuario.png" alt="perfil" id="perfil">
        </div>
      <ul class="flex-center">
        <li id="logo">
          <img src="src/img/logo.png" alt="Logo IGKluba">
        </li>
         </ul>
       
     
    </nav>
     <!-- BARRA DE NAVEGACION -->
<p class="buscador">
  <input type="search" name="busqueda" size="120" placeholder="Billatu zure liburua...">
  <input type="submit" value="Billatu">
</p>
</header>
    <nav id="nav-nagusia">
      <a href="" id="active" >INICIO</a>
      <a href="" id="active" >MIS VALORACIONES</a>
      <a href="" id="active" >SUBIR LIBRO</a>
      <a href="/logout" id="active" >CERRAR SESIÓN</a>
    </nav>
  
<?php
}