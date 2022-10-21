'use strict';

const fileInput = document.querySelector('#imagen');
const labelFileInput = document.querySelector('.file-input-text');
labelFileInput.addEventListener('keyup', (e) => {
  if (['Enter', 'Space'].includes(e.code)) fileInput.click();
});
fileInput.addEventListener('input', () => (labelFileInput.querySelector('span').innerText = fileInput.files[0].name));

const btnBidali = document.querySelector('#bidali');
btnBidali.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const form = document.querySelector('form');
  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input');
    if (valor !== null) valoresEnviados[valor.name] = valor.type === 'file' ? valor.files[0] : valor.value;
  });

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ ]{1,50}$/.test(valoresEnviados.nombre)) return mostrarMensajeError('txarto, izena ez du balio', form.querySelector('#nombre'));
  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ ]{1,50}$/.test(valoresEnviados.egilea)) return mostrarMensajeError('txarto, egilea ez du balio', form.querySelector('#egilea'));
  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ ]{1,100}$/.test(valoresEnviados.sinopsia)) return mostrarMensajeError('txarto, sinopsia ez du balio', form.querySelector('#sinopsia'));
  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ ]{1,50}$/.test(valoresEnviados.sinopsia)) return mostrarMensajeError('txarto, sinopsia ez du balio', form.querySelector('#sinopsia'));
  

  if (valoresEnviados.imagen && valoresEnviados.imagen['type'].split('/')[0] !== 'image')
    return mostrarMensajeError('txarto, ez da argazki bat', form.querySelector('#imagen'));

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






