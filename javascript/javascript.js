//Elemento HTML de mi formulario
const formulario = document.getElementById("formulario");

function Comprobar(evento) {
  // Valor del input login
  const login = document.getElementById("login").value;
  //Valor del input password
  const password = document.getElementById("password").value;

  if (login.length === 0 || password.length === 0) {
    //Si el valor del login o el password es 0,paro el envio del formulario
    evento.preventDefault();
    alert("No se pueden dejar campos vacios");
  } else if (password.includes(login)) {
    //Si la contraseña incluye el nombre de usuario,paro el envio del formualrio
    evento.preventDefault();
    alert("La contraseña no puede contener el usuario");
  }
}
//Cuando el formulario reciba el evento submit,ejecutará la función comprobar
formulario.addEventListener("submit", Comprobar);
