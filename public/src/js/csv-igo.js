'use strict';

selectorArchivo();

const fileInput = document.querySelector('#csv');
const fileLabel = document.querySelector('.file-input-text');
const form = document.querySelector('#form-subir-csv');
const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();

  const csv = fileInput.files[0];
  if (csv === undefined) return mostrarMensajeError('Fitxategi bat aukeratu', fileLabel);
  const type = csv['name'].split('.');
  if (type.splice(type.length - 1)[0].toLowerCase() !== 'csv') return mostrarMensajeError('Fitxategia CSV bat izan behar da', fileLabel);

  form.submit();
});
