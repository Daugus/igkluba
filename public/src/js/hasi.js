const btnLogin = document.querySelector('#login');
btnLogin.addEventListener('click', (e) => {
  e.preventDefault();

  document.querySelectorAll('.error').forEach((mensaje) => mensaje.remove());

  const form = document.querySelector('form');
  const campos = [...form.querySelectorAll('.campo')];

  let valoresEnviados = {};
  campos.forEach((campo) => {
    const valor = campo.querySelector('input');
    valoresEnviados[valor.name] = valor.value;
  });

  if (valoresEnviados.apodo === '') return mostrarMensajeError('error, el apodo no puede estar vacío', document.querySelector('#apodo'));
  if (valoresEnviados.pass === '') return mostrarMensajeError('error, la contraseña no puede estar vacía', document.querySelector('#pass'));

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
