'use strict';

const inputSerie = document.querySelector('#serie');
const inputSerieNum = document.querySelector('#serie_num');
inputSerie.addEventListener('input', (e) => {
  const serieVacia = e.target.value === '';
  inputSerieNum.disabled = serieVacia;
  if (serieVacia) inputSerieNum.value = '';
});

const fileInput = document.querySelector('#imagen');
const labelFileInput = document.querySelector('.file-input-text');
labelFileInput.addEventListener('keydown', (e) => {
  if (['Enter', 'Space'].includes(e.code)) {
    e.preventDefault();
    fileInput.click();
  }
});
fileInput.addEventListener('input', () => (labelFileInput.querySelector('span').innerText = fileInput.files[0].name));

const form = document.querySelector('#form-subir-libro');
const btnEnviar = document.querySelector('#enviar');
btnEnviar.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input, select, textarea');
    if (valor !== null) valoresEnviados[valor.name] = valor.type === 'file' ? valor.files[0] : valor.value;
  });

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ](?=.*[A-Za-zÀ-ÖØ-öø-ÿ\-])[A-Za-zÀ-ÖØ-öø-ÿ,. ]{1,100}[A-Za-zÀ-ÖØ-öø-ÿ]$/.test(valoresEnviados.titulo))
    return mostrarMensajeError('error, titulo inválido', form.querySelector('#titulo'));

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ](?=.*[A-Za-zÀ-ÖØ-öø-ÿ\-])[A-Za-zÀ-ÖØ-öø-ÿ,. ]{1,100}[A-Za-zÀ-ÖØ-öø-ÿ]$/.test(valoresEnviados.autor))
    return mostrarMensajeError('error, autor inválido', form.querySelector('#autor'));

  if (valoresEnviados.serie !== '') {
    if (!/^[A-Za-zÀ-ÖØ-öø-ÿ,.\- ]{1,50}$/.test(valoresEnviados.serie))
      return mostrarMensajeError('error, serie inválida', form.querySelector('#serie'));

    if (!/^[\d,.]{1,5}$/.test(valoresEnviados.serie_num))
      return mostrarMensajeError('error, número en serie inválida', form.querySelector('#serie_num'));
  }

  if (valoresEnviados.fecha === '') return mostrarMensajeError('error, la fecha es inválida', form.querySelector('#fecha'));

  if (valoresEnviados.formato === '-') return mostrarMensajeError('error, formato inválido', form.querySelector('#formato').parentElement);

  if (!/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/.test(valoresEnviados.enlace))
    return mostrarMensajeError('error, enlace inválido', form.querySelector('#enlace'));

  if (valoresEnviados.imagen === undefined) return mostrarMensajeError('error, elige un archivo', form.querySelector('#imagen'));
  if (valoresEnviados.imagen['type'].split('/')[0] !== 'image')
    return mostrarMensajeError('error, el archivo no es una imagen', form.querySelector('#imagen'));

  if (valoresEnviados.sinopsis.length === 0) return mostrarMensajeError('error, la sinopsis no puede estar vacía', form.querySelector('#sinopsis'));

  form.submit();
});

const mostrarMensajeError = (texto, campo) => {
  const div = document.createElement('div');
  div.classList.add('error');
  const p = document.createElement('p');
  p.innerText = texto;
  div.appendChild(p);
  campo.insertAdjacentElement('afterend', div);
};
