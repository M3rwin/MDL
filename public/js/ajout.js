document.addEventListener("DOMContentLoaded", () => {
  
  var formAtelier = document.querySelector('.atelier');
  var formTheme = document.querySelector('.theme');
  var formVacation = document.querySelector('.vacation');
  
  const radios = document.querySelectorAll('#choix input[type=radio]');

    radios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            formAtelier.style.display = 'none';
            formTheme.style.display = 'none';
            formVacation.style.display = 'none';

            if(this.checked) {
                document.querySelector('.' + )
            }
        });
    });
});