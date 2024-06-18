// window.onload = function () {
//   const flechIzq = document.querySelector(".flechIzq"),
//     flechDer = document.querySelector(".flechDer"),
//     slider = document.querySelector("#slider"),
//     sliderSection = document.querySelectorAll(".slider-section");

//   flechIzq.addEventListener("click", (e) => moveToLeft());
//   flechDer.addEventListener("click", (e) => moveToRight());

//   setInterval(() => {
//     moveToRight();
//   }, 5000);

//   let operacion = 0;
//   let counter = 0;
//   let widthImg = 34.2;

//   function moveToRight() {
//     if (counter >= sliderSection.length - 1) {
//       counter = 0;
//       operacion = 0;
//       slider.style.transform = `translate(-${operacion}%)`;
//       return;
//     }
//     counter++;
//     operacion = operacion + widthImg;
//     slider.style.transform = `translate(-${operacion}%)`;
//     slider.style.transition = "all ease 0.6s";
//   }

//   function moveToLeft() {
//     counter--;
//     if (counter < 0) {
//       counter = sliderSection.length - 1;
//       operacion = widthImg * (sliderSection.length - 1);
//       slider.style.transform = `translate(-${operacion}%)`;
//       return;
//     }
//     operacion = operacion - widthImg;
//     slider.style.transform = `translate(-${operacion}%)`;
//     slider.style.transition = "all ease 0.6s";
//   }

//   console.log("ESTO NO LLEGA");
// };

document.addEventListener("includesLoaded", function() {
    const flechIzq = document.querySelector(".flechIzq"),
          flechDer = document.querySelector(".flechDer"),
          slider = document.querySelector("#slider"),
          sliderSection = document.querySelectorAll(".slider-section");
  
    if (!flechIzq || !flechDer || !slider || sliderSection.length === 0) {
        console.error("Elementos del carrusel no encontrados.");
        return;
    }
  
    flechIzq.addEventListener("click", () => {
        moveToLeft();
        console.log("Flecha Izq pulsada");
    });
  
    flechDer.addEventListener("click", () => {
        moveToRight();
        console.log("Flecha Der pulsada");
    });
  
    setInterval(() => {
        moveToRight();
    }, 5000);
  
    let operacion = 0;
    let counter = 0;
    const widthImg = 34.2;
  
    function moveToRight() {
        if (counter >= sliderSection.length - 1) {
            counter = 0;
            operacion = 0;
            slider.style.transform = `translate(-${operacion}%)`;
            return;
        }
        counter++;
        operacion = operacion + widthImg;
        slider.style.transform = `translate(-${operacion}%)`;
        slider.style.transition = "all ease 0.6s";
    }
  
    function moveToLeft() {
        counter--;
        if (counter < 0) {
            counter = sliderSection.length - 1;
            operacion = widthImg * (sliderSection.length - 1);
            slider.style.transform = `translate(-${operacion}%)`;
            return;
        }
        operacion = operacion - widthImg;
        slider.style.transform = `translate(-${operacion}%)`;
        slider.style.transition = "all ease 0.6s";
    }
  
    console.log("Carrusel inicializado.");
  });