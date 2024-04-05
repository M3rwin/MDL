

const confirmemail = document.getElementById("mailconfirm");
const formEmail = document.getElementById("formemail");
const FormInscription = document.getElementById("FormInscription");
const recap = document.getElementById("recap");

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



