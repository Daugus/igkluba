'use strict';

const navLinks = document.querySelectorAll('#nav-general a');
navLinks.forEach((link) => {
  if (link.href === window.location.href) return link.parentElement.classList.add('active');
});

const formBuscador = document.querySelector('#buscador');
const campoBusqueda = document.querySelector('#busqueda');
const btnBuscar = document.querySelector('#buscar');

btnBuscar?.addEventListener('click', (e) => {
  e.preventDefault();
  if (campoBusqueda.value !== '') formBuscador.submit();
});

const mostrarMensajeError = (texto) => {
  const div = document.createElement('div');
  div.classList.add('error');

  const i = document.createElement('i');
  i.classList.add('fa-solid', 'fa-circle-exclamation');

  const p = document.createElement('p');
  p.innerText = texto;

  div.appendChild(i);
  div.appendChild(p);
  document.body.appendChild(div);
};

const calcularEdad = (fecha) => {
  const hoy = new Date();
  const fechaNacimiento = new Date(fecha);

  let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
  const m = hoy.getMonth() - fechaNacimiento.getMonth();
  if (m < 0 || (m === 0 && hoy.getDate() < fechaNacimiento.getDate())) edad--;

  return edad;
};
