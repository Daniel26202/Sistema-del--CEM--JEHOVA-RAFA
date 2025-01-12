// esto es para los iconos y los input
addEventListener("DOMContentLoaded", function () {

    //este es el comentario 
    const comentario = document.querySelector(".comentario");

    //si existe el comentario lo muestra y después de 8sg lo oculta
    if (comentario) {

        comentario.style.display = "block";

        setTimeout(function () {
            comentario.style.display = "none";
        }, 8000)

    }





    // script.js
    document.getElementById('Buscarusuario').addEventListener('keyup', function() {
        
        const searchTerm = this.value.toLowerCase();
        const cards = document.querySelectorAll('.card');

       
        cards.forEach(card => {
            const cardTitle = card.querySelector('.card-title').textContent.toLowerCase();
           
            if (cardTitle.includes(searchTerm)) {
                card.classList.remove("d-none")
               // Muestra la tarjeta si coincide
            } else {
                card.classList.add("d-none") // Oculta la tarjeta si no coincide
            }
        });
    });


})