'use strict';

const fileInput = document.querySelector('#imagen');
const labelFileInput = document.querySelector('.file-input-text');
labelFileInput.addEventListener('keyup', (e) => {
  if (['Enter', 'Space'].includes(e.code)) {
    e.preventDefault();
    fileInput.click();
  }
});
fileInput.addEventListener('input', () => (labelFileInput.querySelector('span').innerText = fileInput.files[0].name));

const form = document.querySelector('form');
const btnRegistro = document.querySelector('#registrarse');
btnRegistro.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.mensaje-error').forEach((mensaje) => mensaje.remove());

  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input, select');
    if (valor !== null) valoresEnviados[valor.name] = valor.type === 'file' ? valor.files[0] : valor.value;
  });

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ\- ]{1,50}$/.test(valoresEnviados.nombre)) return mostrarMensajeError('Izenak bakarrik letrak izan ditzake');

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ\- ]{1,50}$/.test(valoresEnviados.apellido)) return mostrarMensajeError('Abizena bakarrik letrak izan ditzake');

  if (!/^[A-Za-z0-9_-]{1,20}$/.test(valoresEnviados.apodo))
    return mostrarMensajeError('Ezizena bakarrik letrak, zenbakiak, "-" edo "_" izan ditzake');

  if (
    !/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,100})$/.test(
      valoresEnviados.correo
    )
  )
    return mostrarMensajeError('E-maila ez da egokia.');

  if (valoresEnviados.centro === '-') return mostrarMensajeError('Aukeratu ikastetxe bat');

  if (!/^[A-Za-z0-9]{8,8}$/.test(valoresEnviados.clase)) return mostrarMensajeError('Klasearen kodea ez da egokia');

  if (valoresEnviados.fecha === '' || calcularEdad(valoresEnviados.fecha) < 12)
    return mostrarMensajeError('Hamar urte baino gehiago izan behar dituzu');

  if (valoresEnviados.imagen && valoresEnviados.imagen['type'].split('/')[0] !== 'image') return mostrarMensajeError('Fitxategia ez da argazki bat');

  const rgPwd = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-zÀ-ÖØ-öø-ÿ\d@$!%*?&]{8,30}$/);
  if (!rgPwd.test(valoresEnviados.pwd))
    return mostrarMensajeError(
      'Pasahitza gutxienez 8 karaktere izan behar ditu, eta hauetatik gutxienez maiuskula bat, minuskula bat, zenbakia bat eta ikur bat (@, $, !, %, *, ?, &).'
    );
  if (valoresEnviados.pwd !== valoresEnviados.pwdConf) return mostrarMensajeError('Pasahitzak ez datoz bat');

  form.submit();
});
