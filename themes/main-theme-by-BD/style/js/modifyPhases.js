document.getElementById('modifyPhases').addEventListener('click', function() {
  const phase = document.getElementById('phase');
                phase.innerText = 'Fase 2 di 2';
                // Change the width of the progress bar to 100%
                const progressBar = document.getElementById('progress-bar');
                progressBar.style.width = '100%';
                progressBar.innerText = '100%';

                // Hide the content div and display the form div
                const contentDiv = document.getElementById('content');
                const formDiv = document.getElementById('form');
                contentDiv.style.display = 'none';
                formDiv.className = "purchase-phases__form d-block"
  
                const phaseButton = document.getElementById('phaseButton1');
                phaseButton.className = 'd-none';

  
  

                
            });

            jQuery("a.dismiss_modal").click(function(){
              jQuery('#orderModal').modal('hide')
              });