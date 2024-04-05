

const confirmemail = document.getElementById("mailconfirm");
const form = document.getElementById("formemail");

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

confirmemail.addEventListener("click",function(e) {
    e.preventDefault();
   if(window.confirm("Vous êtes sur le point de definir cet email comme mail de connexion")){
       sendData();
       location.reload();
   }
   
});

