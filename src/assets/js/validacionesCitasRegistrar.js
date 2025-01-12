document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('modalAgregarCita');
    const inputs = document.querySelectorAll('#modalAgregarCita input');


    const expresiones = {
        cedula : /^([1-9]{1})([0-9]{5,7})$/, 
        fecha : /^\d{4}\-\d{2}\-\d{2}$/
    }

    const campos = {
    cedula: false,
    fecha: false

}

    function validarFormulario(e){
        
        switch (e.target.name) {

            case "cedula":
                validarCampos(expresiones.cedula, e.target, 'cedula');
            break;

            case "fecha":
                validarCampos(expresiones.fecha, e.target, 'fecha');
            break;
            


        }
    }

    const validarCampos = (expresiones, input, campo) => {
        if(expresiones.test(input.value)){
            document.getElementById(`grp_${campo}`).classList.remove('grpFormInCorrect');
            document.getElementById(`grp_${campo}`).classList.add('grpFormCorrect');
            campos[campo] = true;
            
        }else {
            document.getElementById(`grp_${campo}`).classList.remove('grpFormCorrect');
            document.getElementById(`grp_${campo}`).classList.add('grpFormInCorrect');

            campos[campo] = false;

        }if (campos.cedula === true) {
            document.getElementById('pacienteCitas').classList.remove('d-none');
        }if (campos.cedula === false){
            document.getElementById('pacienteCitas').classList.add('d-none');

        }

    }
        
  

inputs.forEach((input) => {
input.addEventListener('keyup', validarFormulario)
});
    inputs.forEach((input) => {
        input.addEventListener('input', validarFormulario)
        });

 let alerta = document.getElementById('alerta');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    if(campos.cedula &&  campos.fecha){

      form.submit();

    } else {
      e.preventDefault();
      alerta.classList.remove('d-none');
      setTimeout(function() {
        alerta.classList.add('d-none');
}, 10000); 

   }
});


//Funcion para eliminar los mensajes, ya sea de registrar, eliminar o modificar

// if (document.getElementById('alerta-registrar')) {
 
//   setTimeout(function() {
//      document.getElementById('alerta-registrar').remove();
// }, 10000);

// }


// if (document.getElementById('alerta-eliminar')) {
 
//  setTimeout(function() {
//      document.getElementById('alerta-eliminar').remove();
// }, 10000);

// }

// if (document.getElementById('alerta-editar')) {

//   setTimeout(function() {
//      document.getElementById('alerta-editar').remove();
// }, 10000);


// }






 

});

