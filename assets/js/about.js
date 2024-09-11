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
        let progress = $("." + id_categories[i]).find(".progress-bar");
        for (let k = 0; k < progress.length; k++) {
            let a = progress[k].style.width;
            // console.log(a);
            progress[k].animate(
                { width: "10%" },
                1000,
                function () { console.log("essai") });
            // console.log(a)
        }






    }
    )
};

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









