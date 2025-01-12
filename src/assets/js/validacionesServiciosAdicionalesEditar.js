document.addEventListener('DOMContentLoaded', function(){
let EditarPrecio = [];
let ClasesNombre ;
let ClasesPrecio ;
let infoPrecio ;
let alertaEditar; 
let formEditar; 


const expresionesEditar = {
    nombreEditar: /^[A-ZÁÉÍÓÚÑa-záéíóúñ]{1,}$/,
    precioEditar: /^(\d{1,3}\.\d{3},\d{2}|\d{1,3},\d{2})$/
    
};


const camposEditar = {
    nombreEditar: true,
    precioEditar: true
};


function validarFormularioEditar(e) {
    switch (e.target.name) {
        case "nombreEditar":
            validarCamposEditar(expresionesEditar.nombreEditar, e.target, 'nombreEditar');
            break;
        case "precioEditar":
            validarCamposEditar(expresionesEditar.precioEditar, e.target, 'precioEditar');
            break;
        
    }
}


const validarCamposEditar = (expresionesEditar, input, campo) => {
  

    if (expresionesEditar.test(input.value)) {
         camposEditar[campo] = true; 
         
    } else {
         camposEditar[campo] = false;
    }
    if (camposEditar.nombreEditar  === true) {
        if (ClasesNombre) {
            ClasesNombre.forEach(clase => {
                clase.classList.remove('grpFormInCorrect');
                clase.classList.add('grpFormCorrect');
            });
        }     
    } if (camposEditar.nombreEditar === false){
        if (ClasesNombre) {
            ClasesNombre.forEach(clase => {
                clase.classList.add('grpFormInCorrect');
                clase.classList.remove('grpFormCorrect');
            });
        }
       
    }
    if (camposEditar.precioEditar === true) {
        if (ClasesPrecio) {
            ClasesPrecio.forEach(clase => {
                clase.classList.remove('grpFormInCorrect');
                clase.classList.add('grpFormCorrect');
            });
        } 
        if (infoPrecio) {
            infoPrecio.forEach(leyenda => {
                leyenda.classList.add('d-none');
            });
        } 
    }if (camposEditar.precioEditar === false){
        if (ClasesPrecio) {
            ClasesPrecio.forEach(clase => {
                clase.classList.add('grpFormInCorrect');
                clase.classList.remove('grpFormCorrect');
            });
        } 
        if (infoPrecio) {
            infoPrecio.forEach(leyenda => {
                leyenda.classList.remove('d-none');
            });
        }
    }
   
};

function agregarEventosInputs() {
    EditarPrecio.forEach((input) => {
        input.addEventListener('keyup', validarFormularioEditar);
        input.addEventListener('input', validarFormularioEditar);
    });
}





document.querySelectorAll(".botonesEditarSA").forEach(btn => {
    btn.addEventListener("click", function() {
        let cadena = this.getAttribute("uk-toggle").split(" ");
        let nombreDeID = cadena[1].substring(1);

        EditarPrecio = document.querySelectorAll(`#${nombreDeID} .uk-modal-dialog .claseExpresiones input`);
        ClasesNombre = document.querySelectorAll(`#${nombreDeID} .uk-modal-dialog  #editargrp_nombre`);
        ClasesPrecio = document.querySelectorAll(`#${nombreDeID} .uk-modal-dialog  .editargrp_precio`);
        infoPrecio = document.querySelectorAll(`#${nombreDeID} .uk-modal-dialog  .leyendaEditar`);
        alertaEditar = document.querySelectorAll(`#${nombreDeID} .uk-modal-dialog  .alertaEditar`);
        formEditar = document.querySelectorAll(`#${nombreDeID} .uk-modal-dialog  .formEditar`);
        console.log(EditarPrecio);
        console.log(ClasesNombre);
        console.log(ClasesPrecio);
        
formEditar.forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (camposEditar.nombreEditar && camposEditar.precioEditar) {
            form.submit();
        } else {
            alertaEditar.forEach(alert => {
                alert.classList.remove('d-none');
                setTimeout(() => {
                    alert.classList.add('d-none');
                }, 10000);
            })
           
        }
    });

})
        agregarEventosInputs();
    });
});

 

});

