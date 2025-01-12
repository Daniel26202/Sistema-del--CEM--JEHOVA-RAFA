// document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('modalAgregarEnfermeras');
    const inputs = document.querySelectorAll('#modalAgregarEnfermeras input');


    const expresiones = {
        cedula : /^([0-9]{6,8}\S)$/,
        nombre : /^([A-Z]{1})([a-z]{2,10})$/,
        apellido : /^([A-Z]{1})([a-z]{2,10})$/,
        fechaNacimiento : /^\d{4}\-\d{2}\-\d{2}$/,
        telefono : /^([+]{1}[\d]{1,4})?[\s.-]?([\d]{3,4})[\s.-]?([\d]{3})[\s.-]?([\d]{4})$/,
        correo : /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    
    }

    const campos = {
    cedula: false,
    nombre: false,
    apellido: false,
    fechaNacimiento: false,
    telefono: false,
    correo: false
}

    function validarFormulario(e){
        
        switch (e.target.name) {

            case "cedula":
                validarCampos(expresiones.cedula, e.target, 'cedula');
            break;

            case "nombre":
                validarCampos(expresiones.nombre, e.target, 'nombre');
            
            break;
            case "apellido":
                validarCampos(expresiones.apellido, e.target, 'apellido');
            
            break;
           
           case "fechaNacimiento":
                validarCampos(expresiones.fechaNacimiento, e.target, 'fechaNacimiento');
            break;
            
            case "telefono":
                validarCampos(expresiones.telefono, e.target, 'telefono');
            
            break;
            case "correo":
                validarCampos(expresiones.correo, e.target, 'correo');
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

        } 

    }
 
  

inputs.forEach((input) => {
input.addEventListener('keyup', validarFormulario)
});


 let alerta = document.getElementById('alerta');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    if(campos.cedula && campos.nombre && campos.apellido && campos.fechaNacimiento && campos.telefono && campos.correo){

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
 

// });