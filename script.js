document.addEventListener("DOMContentLoaded", function() {
    const modalidadesLink = document.querySelector("a[href='#modalidades']");
    const proyectosLink = document.querySelector("a[href='#proyectos']");
  
    modalidadesLink.addEventListener("click", function() {
      fetch("modalidades.php")
        .then(response => response.text())
        .then(data => {
          const modalidadesContainer = document.querySelector("#modalidades-container");
          modalidadesContainer.innerHTML = data;
        });
    });
  
    proyectosLink.addEventListener("click", function() {
      fetch("proyectos.php")
        .then(response => response.text())
        .then(data => {
          const proyectosContainer = document.querySelector("#proyectos-container");
          proyectosContainer.innerHTML = data;
        });
    });
  });