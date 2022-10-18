'use strict';

const btnRegistro = document.querySelector('#registrarse');
btnRegistro.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const form = document.querySelector('form');
  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input');
    if (valor !== null) valoresEnviados[valor.name] = valor.type === 'file' ? valor.files[0] : valor.value;
  });

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ ]{1,50}$/.test(valoresEnviados.nombre)) return mostrarMensajeError('error, nombre inválido', form.querySelector('#nombre'));
  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ ]{1,50}$/.test(valoresEnviados.apellido))
    return mostrarMensajeError('error, apellido inválido', form.querySelector('#apellido'));
  if (!/^[A-Za-z0-9_-]{1,20}$/.test(valoresEnviados.apodo)) return mostrarMensajeError('error, apodo inválido', form.querySelector('#apodo'));
  if (!/^[A-Za-z0-9]{8,8}$/.test(valoresEnviados.clase)) return mostrarMensajeError('error, clase inválido', form.querySelector('#clase'));

  if (!esMayorDe10(valoresEnviados.fecha)) return mostrarMensajeError('error, el usr no es mayor de diez años', form.querySelector('#fecha'));

  if (valoresEnviados.imagen && valoresEnviados.imagen['type'].split('/')[0] !== 'image')
    return mostrarMensajeError('error, el archivo no es una imagen', form.querySelector('#imagen'));

  const rgPwd = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-zÀ-ÖØ-öø-ÿ\d@$!%*?&]{8,30}$/);
  if (!rgPwd.test(valoresEnviados.pwd)) return mostrarMensajeError('error, contraseña inválido', form.querySelector('#pwd'));
  if (valoresEnviados.pwd !== valoresEnviados.pwdConf)
    return mostrarMensajeError('error, las contraseñas no coinciden', form.querySelector('#pwdConf'));

  form.submit();
});

const esMayorDe10 = (fecha) => {
  const hoy = new Date();
  const fechaNacimiento = new Date(fecha);

  let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
  const m = hoy.getMonth() - fechaNacimiento.getMonth();
  if (m < 0 || (m === 0 && hoy.getDate() < fechaNacimiento.getDate())) edad--;

  return edad > 10;
};

const mostrarMensajeError = (texto, campo) => {
  const div = document.createElement('div');
  div.classList.add('error');
  const p = document.createElement('p');
  p.innerText = texto;
  div.appendChild(p);
  campo.insertAdjacentElement('afterend', div);
};
