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

    const validarCamposProveedor = (expresiones, input, campo,camposProveedor,  id='') => {
        const pError = document.querySelector(`.p-error-${campo}${id}`);
        console.log(pError)
        if(expresiones.test(input.value)){
            input.parentElement.classList.remove('grpFormInCorrect');
            input.parentElement.classList.add('grpFormCorrect');
            pError.classList.add("d-none");
            camposProveedor[campo] = true;

            
        }else {
            input.parentElement.classList.remove('grpFormCorrect');
            input.parentElement.classList.add('grpFormInCorrect');
            pError.classList.remove("d-none");
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



    function validarFormularioProveedorEdi(e, id){

        switch (e.target.name) {

            case "nombre":
            validarCamposProveedor(expresionesProveedor.nombre, e.target, 'nombre', camposProveedorEdi, id);

            break;
            case "telefono":
            validarCamposProveedor(expresionesProveedor.telefono, e.target, 'telefono', camposProveedorEdi, id);

            break;
            case "rif":
            validarCamposProveedor(expresionesProveedor.rif, e.target, 'rif', camposProveedorEdi, id);
            break;

            case "email":
            validarCamposProveedor(expresionesProveedor.email, e.target, 'email', camposProveedorEdi, id);
            break;

            case "direccion":
            validarCamposProveedor(expresionesProveedor.direccion, e.target, 'direccion', camposProveedorEdi, id);
            break;

        }
    }



    inputs.forEach(i=>{
        i.addEventListener("input",validarFormularioProveedor)
    })

    modalAgregarProveedor.addEventListener("submit",function(f){
        f.preventDefault();
        if (camposProveedor.nombre && camposProveedor.rif && camposProveedor.telefono && camposProveedor.email && camposProveedor.direccion){
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
            
            console.log(inputsEdi)

            inputsEdi.forEach(inp=>{
                inp.addEventListener("input",function (e) {
                    let id = this.children[1].getAttribute('data-index')
                    validarFormularioProveedorEdi(e, id);
                })
            })

            modalEdi.addEventListener("submit",function(e){
                e.preventDefault();

                if (
                  camposProveedorEdi.nombre &&
                  camposProveedorEdi.rif &&
                  camposProveedorEdi.telefono &&
                  camposProveedorEdi.email &&
                  camposProveedorEdi.direccion
                ) {
                  this.submit();
                } else {
                  alertEdi.classList.remove("d-none");
                  setTimeout(function () {
                    alertEdi.classList.add("d-none");
                  }, 10000);
                }
            })

        })
    })







})
