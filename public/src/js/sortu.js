'use strict';

selectorArchivo();

const form = document.querySelector('form');
const btnRegistro = document.querySelector('#registrarse');
btnRegistro.addEventListener('click', (e) => {
  e.preventDefault();

  eliminarMensajesError();
  const [campos, valoresEnviados] = buscarCampos();

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ\- ]{1,50}$/.test(valoresEnviados.nombre)) return mostrarMensajeError('Izenak bakarrik letrak izan ditzake', campos.nombre);

  if (!/^[A-Za-zÀ-ÖØ-öø-ÿ\- ]{1,50}$/.test(valoresEnviados.apellido))
    return mostrarMensajeError('Abizena bakarrik letrak izan ditzake', campos.apellido);

  if (!/^[A-Za-z0-9_-]{1,20}$/.test(valoresEnviados.apodo))
    return mostrarMensajeError('Ezizena bakarrik letrak, zenbakiak, "-" edo "_" izan ditzake', campos.apodo);

  if (
    !/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,100})$/.test(
      valoresEnviados.correo
    )
  )
    return mostrarMensajeError('E-maila ez da egokia.', campos.correo);

  if (valoresEnviados.centro === '-') return mostrarMensajeError('Aukeratu ikastetxe bat', campos.centro);

  if (valoresEnviados.clase != undefined && !/^[A-Za-z0-9]{6,6}$/.test(valoresEnviados.clase))
    return mostrarMensajeError('Klasearen kodea ez da egokia', campos.clase);

  if (valoresEnviados.tel != undefined && !/^[\d]{9,9}$/.test(valoresEnviados.tel)) return mostrarMensajeError('Telefonoa ez da egokia', campos.tel);

  if (valoresEnviados.fecha === '' || calcularEdad(valoresEnviados.fecha) < 12)
    return mostrarMensajeError('Hamar urte baino gehiago izan behar dituzu', campos.fecha);

  if (valoresEnviados.imagen && valoresEnviados.imagen['type'].split('/')[0] !== 'image')
    return mostrarMensajeError('Fitxategia argazkia izan behar da', campos.imagen);

  const rgPwd = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#\-_])[A-Za-zÀ-ÖØ-öø-ÿ\d@$!%*?&#\-_]{8,30}$/);
  if (!rgPwd.test(valoresEnviados.pwd))
    return mostrarMensajeError(
      `Pasahitza gutxienez 8 karaktere, maiuskula bat, minuskula bat,
zenbaki bat eta ikur (@, #, !, _, -) bat behar du.`,
      campos.pwd
    );
  if (valoresEnviados.pwd !== valoresEnviados.pwdConf) return mostrarMensajeError('Pasahitzak ez datoz bat', campos.pwdConf);

  form.submit();
});
