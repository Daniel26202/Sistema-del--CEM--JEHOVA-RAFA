addEventListener("DOMContentLoaded", function () {
    console.log("entradas.js ...")
    const selectEntrada = document.getElementById("selectEntrada");
    const tablaEntradas = document.getElementById("tablaEntradas");
    const botonAgregarEntrada = document.getElementById("botonAgregarEntrada");
    const modalAgregarEntrada = document.getElementById('modalAgregarEntrada');
    const inputs = document.querySelectorAll('#modalAgregarEntrada .input');
    const formularioDeFecha = document.getElementById("formularioDeFecha")
    const fechaInicio = document.getElementById("fechaInicio");
    const fechaFinal = document.getElementById("fechaFinal");
    const alertaFecha = document.getElementById("alerta-fecha");


    const expresionesEntrada = {
        cantidad: /^([1-9]{1})([0-9]{1,3})?$/,
        precio: /^(\d{1,3}\.\d{3},\d{2}|\d{1,3},\d{2})$/,
        fechaDeVencimiento: /^\d{4}\-\d{2}\-\d{2}$/
        //^([0-9]+)$
    }

    const camposEntrada = {
        cantidad: false,
        precio: false,
        fechaDeVencimiento: false,
        fechaInicio:false,
        fechaFinal:false
    }

    const camposEntradaEditar = {
        cantidad: true,
        precio: true,
        fechaDeVencimiento: false
    }


    //ajax
    const traerProveedoresEditar = async () => {
        let peticion = await fetch("?c=controladorEntrada/proveedoresEditar");
        let resultado = await peticion.json();
        
        html = '';
        resultado.forEach(res => {
            html += `
            <option value="${res.id_proveedor}">
            ${res.nombre}
            </option>`
        })

    }


    



    


    //sirve para buscar las entradas por rango de fecha
    const traerEntradasPorFecha = () => {

        if (fechaInicio.value >= fechaFinal.value) {
 
            alertaFecha.classList.remove('d-none');
            alertaFecha.innerText = "VERIFIQUE QUE LA FECHA DE  INICIO SEA MENOR A LA FECHA FINAL";

            //funcion de js para el tiempo
            setTimeout(function() {
                alertaFecha.classList.add('d-none');
            }, 8000); 

        } else {
            tablaEntradas.querySelectorAll("tr").forEach(ele => {


                //aqui estoy seleccionando las entradas  y validando
                //esto es para todos los insumos
                if (selectEntrada.value == "Todas las Entradas") {
                    
                    if (ele.children[3].innerText >= fechaInicio.value && ele.children[3].innerText <= fechaFinal.value) {
                        console.log("WT")
                        ele.classList.remove("d-none")
                    } else {
                        ele.classList.add("d-none")
                    }
                    
                    //y este es para un insumo en espifico
                } else {
                    if (ele.children[0].innerText == selectEntrada.value && ele.children[3].innerText >= fechaInicio.value && ele.children[3].innerText <= fechaFinal.value) {
                        console.log("W")
                        ele.classList.remove("d-none")
                    } else {
                        ele.classList.add("d-none")
                    }
                }
    

    
            })
        }
    }

//expresiones de formularios de editar
    document.querySelectorAll(".btn-enviar-datos").forEach(ele => {
        ele.addEventListener("click", function () {
            
            let modalCompletoEditar = this.parentElement.parentElement.parentElement.getAttribute("id")

            inputsModal = document.querySelectorAll(`#${modalCompletoEditar}  .uk-modal-body .input-group .form-control`)

            let formulario = document.querySelector(`#${modalCompletoEditar} .uk-modal-dialog .form-enviar-datos`);

            let id = modalCompletoEditar.replace("modal-exampleEntradaEditar", "");




            if (camposEntradaEditar.cantidad && camposEntradaEditar.precio) {
                formulario.submit();
                // editarEntrada(inputsModal)
                //UIkit.modal(`#${modalCompletoEditar}`).hide();

            } else {
                document.querySelector(`#${modalCompletoEditar}  .uk-modal-body .alerta-editar-entrada`).classList.remove("d-none");
                setTimeout(function () {
                    document.querySelector(`#${modalCompletoEditar}  .uk-modal-body .alerta-editar-entrada`).classList.add('d-none');
                }, 8000);
            }



        })
    })

    document.querySelectorAll(".btn-editar").forEach(ele => {
        ele.addEventListener("click", function () {
            let idModalEditar = this.getAttribute("uk-toggle").split(" ")[1].substring(1,)
            let selected_proveedor_editar = document.querySelector(`#${idModalEditar} .uk-modal-dialog .caja_selected_proveedor .selected_proveedor`)
            traerProveedoresEditar()



            let inputsEditar = document.querySelectorAll(`#${idModalEditar} .uk-modal-body .input-group .input-exp `);
            console.log(inputsEditar)

            inputsEditar.forEach(i => {
                console.log(i)
                i.addEventListener("input", validarFormularioEntradaEditar);
            })




        })
    })



//evento que ese activa cuando el select se activa
    selectEntrada.addEventListener("change", function () {
        //traerDatosEntrada();
        //si es igual a todas me busca todas las entradas
        if (selectEntrada.value == "Todas las Entradas") {
            console.log(tablaEntradas)
            tablaEntradas.querySelectorAll("tr").forEach(ele => ele.classList.remove("d-none"))
            document.getElementById("id_insumo_oculto").value = ""

            //si no me muestra todas las entradas que tengan el producto en especifico
        } else {
            document.getElementById("id_insumo_oculto").value = selectEntrada.value;
            tablaEntradas.querySelectorAll("tr").forEach(ele => {
                console.log(selectEntrada.value)

                if (ele.children[0].innerText == selectEntrada.value) {
                    ele.classList.remove("d-none")
                } else {
                    console.log("no")
                    ele.classList.add("d-none")
                }


            })
        }


    })

//usamos la funcion para validar la fecha
    document.querySelectorAll(".fecha-exp").forEach(ele=>{
        ele.addEventListener("input",function(e){
            console.log(e.target.name)
            validacionDeFechas(e,ele)
        })

//usamos la funcion para validar la fecha
        ele.addEventListener("keyup",function(e){
            console.log(e.target.name)
            validacionDeFechas(e,ele)
        })
    })

//aqui usamos la validacion de la fecha
    const validacionDeFechas =(e,ele)=>{
        if (e.target.name == "fechaInicio") {
            
            if(expresionesEntrada.fechaDeVencimiento.test(ele.value)){
                ele.style.borderBottom="2px solid rgb(13, 240, 13)";
                camposEntrada["fechaInicio"] = true;
            }else{
                ele.style.borderBottom="2px solid rgb(224, 3, 3)";
                camposEntrada["fechaInicio"] = false;
            }
        }else if(e.target.name == "fechaFinal") {
            if(expresionesEntrada.fechaDeVencimiento.test(ele.value)){
                ele.style.borderBottom="2px solid rgb(13, 240, 13)";
                camposEntrada["fechaFinal"] = true;
            }else{
                ele.style.borderBottom="2px solid rgb(224, 3, 3)";
                camposEntrada["fechaFinal"] = false;
            }
        }
    }



    //fomulario de buscar fecha
    formularioDeFecha.addEventListener("submit", function (e) {
        e.preventDefault();
        console.log(e)

        if(camposEntrada.fechaInicio && camposEntrada.fechaFinal){
            traerEntradasPorFecha()
        }else{
            alertaFecha.classList.remove('d-none');
            alertaFecha.innerText = "VERIFIQUE QUE LAS FECHAS TENGAN UN FORMATO VALIDO";
            setTimeout(function() {
                alertaFecha.classList.add('d-none');
            }, 8000); 
        }
        

    })

    //funcion para validar los inputs
    const validarCamposEntrada = (expresiones, input, campo, camposEntrada, precio = true) => {


        if (expresiones.test(input.value)) {
            input.parentElement.classList.remove('grpFormInCorrect');
            input.parentElement.classList.add('grpFormCorrect');
            camposEntrada[campo] = true;

            if (precio == false) {
                document.getElementById("formatoPrecio").classList.add("d-none")
            }

            if (tablaEntradas.rows.length > 0 && input.classList.contains("comprobacion")) {

                id = input.parentElement.parentElement.parentElement.getAttribute("id")

                idNumero = id.replace("modal-exampleEntradaEditar", "")
                let formato = document.querySelector(`#${id} .uk-modal-dialog  .formatoPrecio${idNumero}`)

                formato.classList.add("d-none")

            }




        } else {
            input.parentElement.classList.remove('grpFormCorrect');
            input.parentElement.classList.add('grpFormInCorrect');
            camposEntrada[campo] = false;

            if (precio == false) {
                document.getElementById("formatoPrecio").classList.remove("d-none")
            }




            if (tablaEntradas.rows.length > 0 && input.classList.contains("comprobacion")) {

                id = input.parentElement.parentElement.parentElement.getAttribute("id")

                idNumero = id.replace("modal-exampleEntradaEditar", "")
                let formato = document.querySelector(`#${id} .uk-modal-dialog  .formatoPrecio${idNumero}`)

                formato.classList.remove("d-none")

            }
        }
    };
    //funcion para validar formulario agregar
    function validarFormularioEntrada(e) {
        switch (e.target.name) {
            case "cantidad":
                validarCamposEntrada(expresionesEntrada.cantidad, e.target, "cantidad", camposEntrada)
                break;
            case "precio":
                validarCamposEntrada(expresionesEntrada.precio, e.target, "precio", camposEntrada, false)
                break;
            case "fechaDeVencimiento":
                validarCamposEntrada(expresionesEntrada.fechaDeVencimiento, e.target, "fechaDeVencimiento", camposEntrada)

                break;
        }
    };

    //editar
    function validarFormularioEntradaEditar(e) {
        switch (e.target.name) {
            case "cantidad":
                validarCamposEntrada(expresionesEntrada.cantidad, e.target, "cantidad", camposEntradaEditar)
                break;
            case "precio":
                validarCamposEntrada(expresionesEntrada.precio, e.target, "precio", camposEntradaEditar)
                break;
            case "fechaDeVencimiento":
                validarCamposEntrada(expresionesEntrada.fechaDeVencimiento, e.target, "fechaDeVencimiento", camposEntradaEditar)
                break;

        }
    };

    inputs.forEach(input => {
        input.addEventListener("input", validarFormularioEntrada)
    })

    //https://m.youtube.com/watch?v=o74K2iwQUbo
    modalAgregarEntrada.addEventListener('submit', function (e) {
        e.preventDefault();
        if (camposEntrada.cantidad && camposEntrada.precio && camposEntrada.fechaDeVencimiento && document.getElementById("fechaDeVencimiento").value > document.getElementById("fechaDeIngreso").value && document.getElementById("id_insumoModal").value != "") {
            this.submit();
        } else {
            document.getElementById("alerta-guardar-entrada").classList.remove("d-none");
            setTimeout(function () {
                document.getElementById("alerta-guardar-entrada").classList.add('d-none');
            }, 8000);
        }
    })



    document.getElementById("btnBuscarEntrada").addEventListener('click', (e) => {
        e.preventDefault();
    })







})



