const btnFiltrar = document.querySelector('#filtrar');
const selectOrden = document.querySelector('#orden');
const busqueda = document.querySelector('#busqueda').value;
const pagina = document.querySelector('#pagina').value;

btnFiltrar.addEventListener('click', (e) => {
  e.preventDefault();

  const direccionOrden = document.querySelector('[name="direccion"]:checked');

  window.location.replace(`/bilaketa/${busqueda}/${pagina}?ordenatu=${selectOrden.value}&ordena=${direccionOrden.value}`);
});
