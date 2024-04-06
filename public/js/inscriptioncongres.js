
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


//envoie les param du form en post
async function sendData() {
    // Associate the FormData object with the form element
    const formDataMail = new FormData(formEmail);

    try {
        const response = await fetch("/changementEmail", {
            method: "POST",
            // Defini formData en post
            body: formDataMail
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
    if(!keys.includes("ateliers[]")) {
        window.alert("Selectionnez un atelier");
    }else {
        FormDiv.style.display = "none";
        recap.style.display = "none";
        commit.style.display = "block";
    }
    
    //debug a retiré
    for (const pair of formDataInscription.entries()) {
        console.log(pair[0], pair[1]);
    }

   

});
//au moment de la validation
confirmemail.addEventListener("click", function (e) {
    //empeche le submit automatique
    e.preventDefault();
    if (window.confirm("Vous êtes sur le point de definir cet email comme mail de connexion")) {
        sendData().await;
        location.reload();
    }

});



