

const confirmemail = document.getElementById("mailconfirm");
const form = document.getElementById("formemail");
//envoie les param du form en post
async function sendData() {
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
//au moment de la validation
confirmemail.addEventListener("click",function(e) {
    //empeche le submit automatique
    e.preventDefault();
   if(window.confirm("Vous êtes sur le point de definir cet email comme mail de connexion")){
       sendData();
       location.reload();
   }
   
});

