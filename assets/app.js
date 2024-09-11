// import '../node_modules/bootstrap/dist/js/bootstrap.bundle.js';             // Importe le fichier de configuration bootstrap.js
// import 'bootstrap/dist/js/bootstrap.bundle.js'; // Chemin correct pour Bootstrap

import 'bootstrap'; // Simplifie l'import de Bootstrap grâce à webpack
import $ from 'jquery';  // Import jQuery

import './styles/app.scss';          // Importe les styles SCSS de l'application
import './js/home.js';
import './js/about.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
// Vérification simple pour voir si Bootstrap est chargé
console.log(typeof bootstrap); // Devrait afficher "object" si Bootstrap est chargé
console.log(typeof $.fn.collapse); // Devrait afficher "function"
