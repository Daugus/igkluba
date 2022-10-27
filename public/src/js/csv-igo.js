'use strict';

const form = document.querySelector('#form-subir-csv');

const fileInput = document.querySelector('#csv');
const labelFileInput = document.querySelector('.file-input-text');
labelFileInput.addEventListener('keydown', (e) => {
  if (['Enter', 'Space'].includes(e.code)) {
    e.preventDefault();
    fileInput.click();
  }
});
fileInput.addEventListener('input', () => (labelFileInput.querySelector('span').innerText = fileInput.files[0].name));

const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const csv = fileInput.files[0];
  if (csv === undefined) return mostrarMensajeError('error, elige un archivo');
  const type = csv['name'].split('.');
  if (type.splice(type.length - 1)[0].toLowerCase() !== 'csv') return mostrarMensajeError('error, el archivo no es una csv');

  form.submit();
});
