// POUR DEFILEMENT MAIN

import 'core-js/stable'; // Importer les polyfills nécessaires
import 'regenerator-runtime/runtime'; // Polyfill pour async/await
console.log('Home.js is loaded!');
let defile = $("#sousTitre").find(".fs-3");
let delais = 0;

function showText(time) {
    for (let i = 0; i < defile.length; i++) {


        setTimeout(function () { defile.eq(i).fadeToggle(time / 2); defile.eq(i).fadeToggle(time / 2) }, i * time);
        delais = defile.length * time;

    };
    // fonction récursive
    setTimeout(function () { showText(time * 2) }, delais);

};

showText(1000);

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