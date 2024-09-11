// POUR DEFILEMENT MAIN

import 'core-js/stable'; // Importer les polyfills nécessaires
import 'regenerator-runtime/runtime'; // Polyfill pour async/await
console.log('Home.js is loaded!');

// L'utilisation de setTimeOut cause une désynchronisation lorsque l'onglet est inactif
// Il vaut mieux utiliser requestAnimationFrame
// let defile = $("#sousTitre").find(".fs-3");
// let delais = 0;

// function showText(time) {
//     for (let i = 0; i < defile.length; i++) {


//         setTimeout(function () { defile.eq(i).fadeToggle(time / 2); defile.eq(i).fadeToggle(time / 2) }, i * time);
//         delais = defile.length * time;

//     };
//     // fonction récursive
//     setTimeout(function () { showText(time * 2) }, delais);

// };

let defile = $("#sousTitre").find(".fs-3");
let index = 0; // Pour suivre l'index actuel
let time = 1000; // Durée de l'animation pour chaque texte

function animateText() {
    // Cacher tous les textes sauf celui à l'index courant
    defile.hide();
    defile.eq(index).fadeIn(time / 2, function () {
        setTimeout(() => {
            $(this).fadeOut(time / 2, function () {
                // Incrémenter l'index pour passer au texte suivant
                index = (index + 1) % defile.length; // Boucle sur le nombre de textes
                animateText(); // Appel récursif
            });
        }, time); // Garder le texte visible avant de le cacher
    });
}

// Démarrer l'animation
requestAnimationFrame(animateText);


// Pour animation rotation
let t = 0;

function moveit(element, rayon, xcenter, ycenter, speed) {
    t += 0.05;

    let r = rayon;         // radius
    // let xcenter = 100;   // center X position
    // let ycenter = 100;   // center Y position

    let newLeft = Math.floor(xcenter + (r * Math.cos(t)));
    let newTop = Math.floor(ycenter + (r * Math.sin(t)));

    element.animate({
        top: newTop,
        left: newLeft,
    }, speed, function () {
        moveit(element, rayon, xcenter, ycenter, speed);
    });
}
// Le fonction rotateImage avait un problème de récursivité, elle a été remplacée par une animation css, plus fluide.
// function rotateImage(element, duree) {
//     element.css({ transform: 'rotate(0deg)' }); // Réinitialise la transformation initiale
//     element.animate(
//         { deg: 360 },
//         {
//             duration: duree,
//             step: function (now) {
//                 $(this).css({ transform: 'rotate(' + now + 'deg)' });
//             },
//             complete: function () {
//                 // Appel récursif pour continuer la rotation
//                 console.log("deuxieme tour")
//                 rotateImage(element, duree);
//             }
//         }
//     );
// }


// moveit(element, rayon, xcenter, ycenter, speed)
moveit($(".container1"), 150, 0, -200, 100);
// rotateImage($(".container2"), 15000) // cette rotation est faite directement en css