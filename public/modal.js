function initModal() {
    const elementoClicable = document.getElementById('cambiarContraseña');
    const elementoModal = document.getElementById('mi-modal');
  
    elementoClicable.addEventListener('click', () => {
      elementoModal.show();
    });
  
    console.log("Modal inicializado.");
  }
  
  document.addEventListener("DOMContentLoaded", initModal);