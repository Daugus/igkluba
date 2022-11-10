'use strict';

const selectColumnas = document.querySelector('#select-columnas');
selectColumnas?.addEventListener('input', (e) => cambiarCantidadColumnas(e.target.value));

const cambiarCantidadColumnas = (cantidad) => {
  localStorage.setItem('columnas', cantidad);
  document.documentElement.style.setProperty('--max-columnas', cantidad);
};

if (localStorage.getItem('columnas')) {
  const columnas = localStorage.getItem('columnas');
  cambiarCantidadColumnas(columnas);
  if (selectColumnas != undefined) selectColumnas.querySelector(`[value='${columnas}']`).selected = true;
} else cambiarCantidadColumnas(4);

const navLinks = document.querySelectorAll('#nav-general a');
navLinks.forEach((link) => {
  if (link.href === window.location.href) return link.parentElement.classList.add('active');
});

const formBuscador = document.querySelector('#buscador');
const campoBusqueda = document.querySelector('#busqueda');
const btnBuscar = document.querySelector('#buscar');

btnBuscar?.addEventListener('click', (e) => {
  e.preventDefault();
  campoBusqueda.value = campoBusqueda.value.replaceAll(/[%_/\+ç¡´`#']/gi, '');
  if (campoBusqueda.value !== '') formBuscador.submit();
});

function selectorArchivo() {
  const fileInput = document.querySelector('[type="file"]');
  const labelFileInput = document.querySelector('.file-input-text');
  labelFileInput.addEventListener('keyup', (e) => {
    if (['Enter', 'Space'].includes(e.code)) {
      e.preventDefault();
      fileInput.click();
    }
  });

  fileInput.addEventListener('input', () => (labelFileInput.querySelector('span').innerText = fileInput.files[0].name));
}

const eliminarMensajesError = () => {
  document.querySelectorAll('.mensaje-error').forEach((mensaje) => mensaje.remove());
  document.querySelector('.campo-incorrecto')?.classList.remove('campo-incorrecto');
};

const buscarCampos = () => {
  const campos = [...form.querySelectorAll('.campo')];
  let elementosCampos = {};

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input, select, textarea');
    if (valor !== null) valoresEnviados[valor.name] = valor.type === 'file' ? valor.files[0] : valor.value;
    elementosCampos[valor.name] = valor;
  });

  return [elementosCampos, valoresEnviados];
};

const mostrarMensajeError = (texto, campo) => {
  const div = document.createElement('div');
  div.classList.add('mensaje-error');

  const i = document.createElement('i');
  i.classList.add('fa-solid', 'fa-circle-exclamation');

  const p = document.createElement('p');
  p.innerText = texto;

  div.appendChild(i);
  div.appendChild(p);

  div.addEventListener('animationend', (e) => e.target.classList.add('hidden'));
  div.addEventListener('click', () => div.classList.add('hidden'));
  document.body.appendChild(div);

  campo.focus();
  setTimeout(() => campo.classList.add('campo-incorrecto'), 5);
};

const calcularEdad = (fecha) => {
  const hoy = new Date();
  const fechaNacimiento = new Date(fecha);

  let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
  const m = hoy.getMonth() - fechaNacimiento.getMonth();
  if (m < 0 || (m === 0 && hoy.getDate() < fechaNacimiento.getDate())) edad--;

  return edad;
};

// agregar listeners de animacion a portadas y fotos de perfil
const portadas = [...document.querySelectorAll('.libro__portada, .cuenta__foto')];
portadas.forEach((imagen) => {
  imagen.addEventListener('animationend', () => imagen.classList.remove('animacion-subir'));
  imagen.addEventListener('mouseover', () => imagen.classList.add('animacion-subir'));
});
const agregarContadorPalabras = (max) => {
  const contador = document.querySelector('#contador');
  const textarea = document.querySelector('textarea');
  textarea.addEventListener('input', () => (contador.innerText = `${contarPalabras(textarea.value)}/${max}`));
};

const contarPalabras = (texto) =>
  texto
    .trim()
    .split(/[\n ]/)
    .filter((i) => i !== '').length;
