document.addEventListener("DOMContentLoaded", () => {
  
  let radioatelier = document.getElementById('ratelier');
  let radiotheme = document.getElementById('rtheme');
  let radiovacation = document.getElementById('rvacation');
  
  let forms = document.querySelectorAll('.form');
  
  let radios = [radioatelier, radiotheme, radiovacation];
  
  radios.forEach(function(radio){
      radio.addEventListener('click', () => {
          let id = radio.id.slice(1);
          forms.forEach(function(form){
             form.style.display = "none"; 
          });
          document.getElementById(id).style.display = 'block';
      });
  });
});