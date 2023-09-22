document.addEventListener("DOMContentLoaded", function () {
  eventListeners();
  darkMode();
});
function darkMode() {
  const prefiereDarkMode = window.matchMedia("(prefers-color-scheme: dark)");

  //   console.log(prefiereDarkMode.matches);

  if (prefiereDarkMode.matches) {
    document.body.classList.add("dark-mode");
  } else {
    document.body.classList.remove("dark-mode");
  }

  prefiereDarkMode.addEventListener("change", () => {
    if (prefiereDarkMode.matches) {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
  });

  const botonDarkMode = document.querySelector(".dark-mode-boton");
  botonDarkMode.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
  });
}
function eventListeners() {
  const mobileMenu = document.querySelector(".mobile-menu");

  mobileMenu.addEventListener("click", navegacionResponsive);

  // Muestra campos condicionales
  const metodoContacto = document.querySelectorAll(
    'input[name="contacto[contacto]"]'
  );
  metodoContacto.forEach((input) =>
    input.addEventListener("click", mostrarMetodosContacto)
  );
}
function navegacionResponsive() {
  const navegacion = document.querySelector(".navegacion");

  navegacion.classList.toggle("mostrar");
  //   if (navegacion.classList.contains("mostrar")) {
  //     navegacion.classList.remove("mostrar");
  //   } else {
  //     navegacion.classList.add("mostrar");
  //   }
}

function mostrarMetodosContacto(e) {
  const contactoDiv = document.querySelector("#contacto");
  if (e.target.value === "telefono") {
    contactoDiv.innerHTML = `
      <label for="telefono">Numero telefónico:</label>
      <input data-cy="input-telefono" type="tel" placeholder="Tu numero telefónico" id="telefono" name="contacto[telefono]" />

      <p>Elija la fecha y la hora para ser contactado</p>

      <label for="fecha">Fecha:</label>
      <input data-cy="input-fecha" type="date" id="fecha" name="contacto[fecha]" />

      <label for="hora">Hora:</label>
      <input data-cy="input-time" type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]" />
    `;
  } else {
    contactoDiv.innerHTML = `
    
    <label for="email">E-mail:</label>
    <input data-cy="input-email" type="email" placeholder="Tu correo electronico" id="email" name="contacto[email]" required />
    
    `;
  }
}
