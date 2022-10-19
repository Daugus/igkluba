'use strict';

const navLinks = document.querySelectorAll('#nav-general a');
navLinks.forEach((link) => {
  if (link.href === window.location.href) return link.parentElement.classList.add('active');
});

const formBuscador = document.querySelector('#buscador');
const campoBusqueda = document.querySelector('#busqueda');
const btnBuscar = document.querySelector('#buscar');

btnBuscar.addEventListener('click', (e) => {
  e.preventDefault();
  if (campoBusqueda.value !== '') formBuscador.submit();
});
