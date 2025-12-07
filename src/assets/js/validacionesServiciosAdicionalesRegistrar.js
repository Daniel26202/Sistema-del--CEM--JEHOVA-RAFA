document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('modalAgregar');
    const inputs = document.querySelectorAll('#modalAgregar input');
    


    const expresiones = {
       // ^([0-9]{1,3})\.([0-9]{3}),([0-9]{2})|(\d{1,3})(\d{2})$
       nombre : /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        precio : /^(\d{1,3}\.\d{3},\d{2}|\d{1,3},\d{2})$/
    }

    const campos = {
        nombre: false,
        precio: true

}

    function validarFormulario(e){
        
        switch (e.target.name) {


            case "nombre":
                validarCampos(expresiones.nombre, e.target, 'nombre');
            break;

            case "precio":
                validarCampos(expresiones.precio, e.target, 'precio');
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

        }if (campos.precio === true) {
            document.getElementById('leyenda').classList.add('d-none');
        }if (campos.precio === false){
            document.getElementById('leyenda').classList.remove('d-none');

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
    if(campos.nombre && campos.precio){

      form.submit();

    } else {
      e.preventDefault();
      alerta.classList.remove('d-none');
      setTimeout(function() {
        alerta.classList.add('d-none');
}, 10000); 

   }
});





 

});

