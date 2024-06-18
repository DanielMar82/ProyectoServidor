// function includeHTML() {
//     var z, i, elmnt, file, xhttp;
//     /*loop through a collection of all HTML elements:*/
//     z = document.getElementsByTagName("*");
//     for (i = 0; i < z.length; i++) {
//       elmnt = z[i];
//       /*search for elements with a certain atrribute:*/
//       file = elmnt.getAttribute("include-html");
//       if (file) {
//         /*make an HTTP request using the attribute value as the file name:*/
//         xhttp = new XMLHttpRequest();
//         xhttp.onreadystatechange = function() {
//           if (this.readyState == 4) {
//             if (this.status == 200) {elmnt.innerHTML = this.responseText;}
//             if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
//             /*remove the attribute, and call this function once more:*/
//             elmnt.removeAttribute("include-html");
//             includeHTML();
//           }
//         }      
//         xhttp.open("GET", file, true);
//         xhttp.send();
//         /*exit the function:*/
//         return;
//       }
//     }
//   };



//   includeHTML();
// function includeHTML() {
//     return new Promise((resolve, reject) => {
//         var z = document.getElementsByTagName("*");
//         var elements = [];
        
//         for (var i = 0; i < z.length; i++) {
//             var file = z[i].getAttribute("include-html");
//             if (file) {
//                 elements.push({ element: z[i], file: file });
//             }
//         }
  
//         if (elements.length === 0) {
//             resolve();
//             return;
//         }
  
//         var loaded = 0;
//         elements.forEach(({ element, file }) => {
//             var xhttp = new XMLHttpRequest();
//             xhttp.onreadystatechange = function() {
//                 if (this.readyState == 4) {
//                     if (this.status == 200) {
//                         element.innerHTML = this.responseText;
//                     } else if (this.status == 404) {
//                         element.innerHTML = "Page not found.";
//                     }
//                     element.removeAttribute("include-html");
//                     loaded++;
//                     if (loaded === elements.length) {
//                         resolve();
//                     }
//                 }
//             }
//             xhttp.open("GET", file, true);
//             xhttp.send();
//         });
//     });
//   }
  
//   includeHTML().then(() => {
//     document.dispatchEvent(new Event("includesLoaded"));
//   });


function includeHTML() {
    return new Promise((resolve, reject) => {
        var z = document.getElementsByTagName("*");
        var elements = [];
        
        for (var i = 0; i < z.length; i++) {
            var file = z[i].getAttribute("include-html");
            if (file) {
                elements.push({ element: z[i], file: file });
            }
        }
  
        if (elements.length === 0) {
            resolve();
            return;
        }
  
        var loaded = 0;
        elements.forEach(({ element, file }) => {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        element.innerHTML = this.responseText;
                    } else if (this.status == 404) {
                        element.innerHTML = "Page not found.";
                    } else {
                        console.error("Failed to load", file, this.status);
                    }
                    element.removeAttribute("include-html");
                    loaded++;
                    if (loaded === elements.length) {
                        resolve();
                    }
                }
            };
            // Agregar una marca de tiempo para evitar el caché
            xhttp.open("GET", file + "?t=" + new Date().getTime(), true);
            xhttp.send();
        });
    });
}

includeHTML().then(() => {
    document.dispatchEvent(new Event("includesLoaded"));
}).catch(error => {
    console.error("Error including HTML:", error);
});