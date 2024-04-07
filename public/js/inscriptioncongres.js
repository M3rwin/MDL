
//bouton pour changer l'email
const confirmemail = document.getElementById("mailconfirm");
//form pour changer l'email
const formEmail = document.getElementById("formemail");
//le formulaire d'inscription
const FormInscription = document.getElementById("FormInscription");
//div dans le formulaire
const FormDiv = document.getElementById("FormDiv");
//bouton pour afficher recap d'inscription
const recap = document.getElementById("recap");
//bouton pour valider la commande
const commit = document.getElementById("commit");
//section conteant les bouton
const SubmitSection = document.getElementById("SubmitSection");
// Les Ateliers
const ateliers = document.getElementsByName("ateliers[]");
//Les nuités
const nuites = document.getElementsByName("Nuites[]");
//envoie les param du form en post
async function sendData(form) {
    // Associate the FormData object with the form element
    const formData = new FormData(form);

    try {
        const response = await fetch("/changementEmail", {
            method: "POST",
            // Defini formData en post
            body: formData
        });
        console.log(await response);
    } catch (e) {
        console.error(e);
    }
}

//recupère les informations du form
recap.addEventListener("click", function () {
    const formDataInscription = new FormData(FormInscription);

    let keys = [];

    for (const pair of formDataInscription.entries()) {
        keys = keys + [pair[0]];
    }
    //verifie si un atelier est coché
    if (!keys.includes("ateliers[]")) {
        window.alert("Selectionnez un atelier");
    } else {
        //on prends la liste des ateliers cochés
        let ateliersChecked = [];
        for (let atelier of ateliers) {
            if (atelier.checked) {
                ateliersChecked.push(atelier.id);
            }
        }
        //on prends la liste des nuités cochés
        let nuitesChecked = [];
        for (let nuite of nuites) {
            if (nuite.checked) {
                nuitesChecked.push(nuite.value.split('_'));
            }
        }

        FormDiv.style.display = "none";
        recap.style.display = "none";
        commit.style.display = "block";
        FormInscription.innerHTML += '<div class="card-container" >'
                + '<div class="card-header"><h2>Resumé de l\'inscription : </h2></div>'
                + '<ul class="card-content" id="resume">'
                + '<li><strong>Ateliers Selectionnés</strong></li>';
        let resume = document.getElementById("resume");

        for (let atelier of ateliersChecked) {

            resume.innerHTML += '<li>' + atelier + '</li>';
        }
        
        let total =130;
            resume.innerHTML += '<li><strong>Nuités Selectionnés</strong></li>';
            for (let nuite of nuitesChecked) {

                resume.innerHTML += '<li>' + nuite[1] +' <strong>'+nuite[2]+'</strong> '+nuite[4] +'<strong style="display: flex;flex-direction: row-reverse;"> '+nuite[3]+ '€</strong></li>';
                total += parseInt(nuite[3]);
            }
            resume.innerHTML +='<li>INSCRIPTION AU CONGRES'+'<strong style="display: flex;flex-direction: row-reverse;"> '+130+ '€</strong></li>'
                    +'<h2> TOTAL : '+total +'€</h2>';
        FormInscription.innerHTML += '</ul><\div>';
    }

    //debug a retiré
    for (const pair of formDataInscription.entries()) {
        console.log(pair[0], pair[1]);
    }
    for (let atelier of ateliers) {
        if (atelier.checked) {
            console.log(atelier.id);
        }
    }



});


//au moment de la validation
confirmemail.addEventListener("click", function (e) {
    //empeche le submit automatique
    e.preventDefault();
    if (window.confirm("Vous êtes sur le point de definir cet email comme mail de connexion")) {
        sendData(formEmail).await;
        location.reload();
    }

});



