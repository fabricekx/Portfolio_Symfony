let id_categories = ["presentation", "hard_skills", "formation", "experience", "langues", "soft_skills"]

// Onn cache toutes les catégories about sauf presentation qu'on montre
for (let j = 1; j < id_categories.length; j++) {
    $("." + id_categories[j]).hide();
};
$(".presentation").show();

//    création des clicks et des hides sur chaque catégorie
for (let i = 0; i < id_categories.length; i++) {
    $("#" + id_categories[i]).click(function () {
        // lors du click, on cache tout
        for (let j = 0; j < id_categories.length; j++) {
            $("." + id_categories[j]).hide();
        };

        // puis on montre la catégorie clickée
        $("." + id_categories[i]).fadeToggle(
            "slow",
            "swing");


        // puis on cherche les progress bar dans la catégorie
        let progressBars = $("." + id_categories[i]).find(".progress-bar");
        for (let k = 0; k < progressBars.length; k++) {
            // Récupérer la valeur cible de aria-valuenow
            // Récupérer la valeur cible de aria-valuenow du conteneur parent de la barre de progression
            let $progressBar = $(progressBars[k]);
            let targetWidth = $progressBar.closest('.progress').attr('aria-valuenow');
            targetWidth = targetWidth ? targetWidth + '%' : '0%'; // Convertit en pourcentage ou initialise à 0% si non défini

            console.log(targetWidth);
            $progressBar.animate(
                { width: targetWidth },
                {
                    duration: 1000, // Durée de l'animation en millisecondes
                    easing: 'swing', // Optionnel : type d'animation
                    step: function (now) {
                        $(this).text(Math.ceil(now) + '%'); // Affiche le pourcentage pendant l'animation
                    }
                })
        }


    }
    )
};

// $(".progress-bar").each(function() {
//     // Récupérer la valeur cible de aria-valuenow
//     let targetWidth = $(this).parent().attr('aria-valuenow') + '%';

//     // Animer la barre de progression de 0 à la valeur cible
//     $(this).animate(
//         { width: targetWidth },
//         {
//             duration: 1000, // Durée de l'animation en millisecondes
//             easing: 'swing', // Optionnel : type d'animation
//             step: function(now) {
//                 $(this).text(Math.ceil(now) + '%'); // Affiche le pourcentage pendant l'animation
//             }
//         }
//     );
// });

// let progress = $("#langues").find(".progress-bar");
// a = progress[0].style.width;
// progress[0].style.width = "10%"

// progress[0].animate(
//     {width :a},
//     1000,
//     function(){console.log("bonjour")}

// )
// console.log(a);
// console.log(progress[0].style.width);









