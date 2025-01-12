addEventListener("DOMContentLoaded",function() {
    const modalAgregarProveedor = document.getElementById('modalAgregarProveedor');
    const inputs = document.querySelectorAll("#modalAgregarProveedor input");
    const alerta = document.getElementById("alerta-guardar-proveedor");
    const formBuscadorProveedor =  document.getElementById("form-buscador");

    const expresionesProveedor = {
        nombre : /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        telefono : /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
        rif : /^[VJEGP]\-[0-9]{8,9}$/,
        email :/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        direccion: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
    }

    const camposProveedor = {
        nombre: false,
        telefono: false,
        rif: false,
        email: false,
        direccion: false
    }

    const camposProveedorEdi = {
        nombre: true,
        telefono: true,
        rif: true,
        email: true,
        direccion: true
    }

    const validarCamposProveedor = (expresiones, input, campo,camposProveedor) => {
        if(expresiones.test(input.value)){
            input.parentElement.classList.remove('grpFormInCorrect');
            input.parentElement.classList.add('grpFormCorrect');
            camposProveedor[campo] = true;

            
        }else {
            input.parentElement.classList.remove('grpFormCorrect');
            input.parentElement.classList.add('grpFormInCorrect');
            camposProveedor[campo] = false;

        } 

    }



    function validarFormularioProveedor(e){

        switch (e.target.name) {

            case "nombre":
            validarCamposProveedor(expresionesProveedor.nombre, e.target, 'nombre', camposProveedor);

            break;
            case "telefono":
            validarCamposProveedor(expresionesProveedor.telefono, e.target, 'telefono', camposProveedor);

            break;
            case "rif":
            validarCamposProveedor(expresionesProveedor.rif, e.target, 'rif', camposProveedor);
            break;

            case "email":
            validarCamposProveedor(expresionesProveedor.email, e.target, 'email', camposProveedor);
            break;

            case "direccion":
            validarCamposProveedor(expresionesProveedor.direccion, e.target, 'direccion', camposProveedor);
            break;



        }
    }



    function validarFormularioProveedorEdi(e){

        switch (e.target.name) {

            case "nombre":
            validarCamposProveedor(expresionesProveedor.nombre, e.target, 'nombre', camposProveedorEdi);

            break;
            case "telefono":
            validarCamposProveedor(expresionesProveedor.telefono, e.target, 'telefono', camposProveedorEdi);

            break;
            case "rif":
            validarCamposProveedor(expresionesProveedor.rif, e.target, 'rif', camposProveedorEdi);
            break;

            case "email":
            validarCamposProveedor(expresionesProveedor.email, e.target, 'email', camposProveedorEdi);
            break;

            case "direccion":
            validarCamposProveedor(expresionesProveedor.direccion, e.target, 'direccion', camposProveedorEdi);
            break;

        }
    }



    inputs.forEach(i=>{
        i.addEventListener("input",validarFormularioProveedor)
    })

    modalAgregarProveedor.addEventListener("submit",function(f){
        f.preventDefault();
        if (camposProveedor.nombre && camposProveedor.rif && camposProveedor.telefono, camposProveedor.email && camposProveedor.direccion){
            this.submit();
        } else {
            alerta.classList.remove('d-none');
            setTimeout(function() {
                alerta.classList.add('d-none');
            }, 10000);
        }
    })

    document.querySelectorAll(".btn-editar").forEach(ele=>{
        ele.addEventListener("click",function(){
            let idModalEditar = this.getAttribute("uk-toggle").split(" ")[1].substring(1,)
            let inputsEdi = document.querySelectorAll(`#${idModalEditar} .uk-modal-dialog .input-group`)
            let modalEdi = document.querySelector(`#${idModalEditar} .uk-modal-dialog .form-modal`)
            alertEdi =  document.querySelector(`#${idModalEditar} .uk-modal-dialog .alerta-editar-proveedor`)
            

            inputsEdi.forEach(inp=>{
                inp.addEventListener("input",validarFormularioProveedorEdi)
            })

            modalEdi.addEventListener("submit",function(e){
                e.preventDefault();

                if (camposProveedorEdi.nombre && camposProveedorEdi.rif && camposProveedorEdi.telefono) {
                    this.submit();
                } else {
                    alertEdi.classList.remove('d-none');
                    setTimeout(function() {
                        alertEdi.classList.add('d-none');
                    }, 10000);
                }
            })

        })
    })





// para el buscador de Proveedores 
let inputBusProveedor = document.querySelector("#inputBuscarProveedor");
// const notifi = document.querySelector(".notifi");

// buscador de sintomas
function buscarProveedor() {
    let contador = 0;
    let contadorNo = 0;

    // selecciono todos los tr de la tabla
    const filas = document.querySelectorAll(".tbody tr");
    // recolecto el nombre del input
    let  valorInputprovvedor= inputBusProveedor.value;
    // se convierte en minúscula
 

    // recorro las filas de la tabla
    filas.forEach(fila => {
        // cuenta los síntomas que existen.
        contador = contador + 1;

        console.log(fila.children[2]);
        let rif = fila.children[2].innerText;

        // se convierte en minúscula
        
        // verifico si el nombre existe 
        if (rif.includes(valorInputprovvedor)) {
            fila.classList.remove("d-none");
           
        } else {
            fila.classList.add("d-none");
            // cuenta las veces que no encuentra un síntoma
            contadorNo = contadorNo + 1;
        }

        inputBusProveedor.addEventListener("keyup", ()=>{
            if(inputBusProveedor.value === ""){
                fila.classList.remove("d-none");
            }
           }) 

    });

    // verifica, si el contador de hospitalizaciones existentes es igual a las hospitalizaciones no existentes 
    // if (contador === contadorNo) {
    //     // muestra el texto.
    //     notifi.classList.remove("d-none");
    // }
}


formBuscadorProveedor.addEventListener("submit", function (f){
    f.preventDefault();
    
})
 

document.getElementById("buscarProveedor").addEventListener("click", function(){
    buscarProveedor();
   }) 











})
