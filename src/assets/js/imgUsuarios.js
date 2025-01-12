addEventListener("DOMContentLoaded", function () {

    

    const btnEditarUsuarios = document.querySelectorAll(".editarUsuario");
    const imagenesUsuarios = document.querySelectorAll(".imagenesUsuarios");

    const expresionesEditarUsuario = {
        imagen: /([A-Za-z0-9._-]\s?)+\.(jpg|JPG|PNG|png|jpeg|JPEG)+/,
        // nombre: /^([A-Z]{1})([a-z]{3,10})$/,
        // apellido: /^([A-Z]{1})([a-z]{3,10})$/,
        usuario: /^[a-zA-Z0-9._-]{3,16}$/,
        password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
    }

    const camposEditarUsuario = {
        imagen: true,
        // nombre: true,
        // apellido: true,
        usuario: true,
        password: true
    }


    function validarFormularioEditarUsuario(e) {

        switch (e.target.name) {

            case "imagenUsuario":
                let imagenSeparada = e.target.value.split("\\")
                let nombreImagen = imagenSeparada.pop();
                if (expresionesEditarUsuario.imagen.test(nombreImagen)) {
                    e.target.parentElement.classList.remove('grpFormInCorrect');
                    e.target.parentElement.classList.add('grpFormCorrect');
                    camposInsumos['imagen'] = true;
                } else {
                    e.target.parentElement.classList.remove('grpFormCorrect');
                    e.target.parentElement.classList.add('grpFormInCorrect');
                    camposInsumos['imagen'] = false;
                }
                break;

            // case "nombre":
            //     validarCamposEditarUsuario(expresionesEditarUsuario.nombre, e.target, 'nombre');
            //     break;

            // case "apellido":
            //     validarCamposEditarUsuario(expresionesEditarUsuario.apellido, e.target, 'apellido');

            //     break;
            case "usuario":
                validarCamposEditarUsuario(expresionesEditarUsuario.usuario, e.target, 'usuario');

                break;


            case "password":
                validarCamposEditarUsuario(expresionesEditarUsuario.password, e.target, 'password');

                break;
           
        }
    }



    const validarCamposEditarUsuario = (expresiones, input, campo) => {
        if (expresiones.test(input.value)) {
            input.parentElement.classList.remove('grpFormInCorrect');
            input.parentElement.classList.add('grpFormCorrect');
            camposEditarUsuario[campo] = true;
        } else {
            input.parentElement.classList.remove('grpFormCorrect');
            input.parentElement.classList.add('grpFormInCorrect');
            camposEditarUsuario[campo] = false;
        }

    }


    btnEditarUsuarios.forEach(btn => {
        btn.addEventListener("click", function () {
            let id = this.getAttribute("uk-toggle").split(" ")[1].substring(1,)
            let formulario = document.querySelector(`#${id} .uk-modal-dialog .formEditarUsuario`);
            let inputs = document.querySelectorAll(`#${id} .uk-modal-dialog .formEditarUsuario div .uk-card-body .flex-column input`);
            let alerta = document.querySelector(`#${id} .uk-modal-dialog .formEditarUsuario #alertaUsuario`);
            console.log(alerta)
            inputs.forEach(input => {
                input.addEventListener("input", validarFormularioEditarUsuario)
            })

            formulario.addEventListener("submit", function (e) {
                e.preventDefault();
                console.log(camposEditarUsuario.imagen)
                if (camposEditarUsuario.imagen && camposEditarUsuario.password && camposEditarUsuario.usuario) {
                    this.submit();
                } else {
                    alerta.classList.remove('d-none');
                    setTimeout(function () {
                        alerta.classList.add('d-none');
                    }, 8000);
                }
            })
        })
    });




    //imagenes de los usuarios
    imagenesUsuarios.forEach(imagenUsuario => {
        imagenUsuario.addEventListener("change", function (e) {
            let id = this.parentElement.parentElement.parentElement.parentElement.getAttribute("id");

            let imgSrc = document.querySelector(`#${id} .caja-imagen .uk-grid-small .uk-width-auto .uk-border-circle`);

            leerImagenesUsuarios(imagenUsuario.files, imgSrc)

        })
    })

    function leerImagenesUsuarios(ar, img) {
        for (var i = 0; i < ar.length; i++) {
            const reader = new FileReader();
            reader.readAsDataURL(ar[i]);
            reader.addEventListener("load", function (e) {
                img.setAttribute("src", `${e.currentTarget.result}`)
            })
        }
    }


    
    const inputDos = document.querySelectorAll(".inputDos");

    

    inputDos.forEach(dos => {
        dos.addEventListener("keyup", () => {
            activarMostrarContra.forEach(act => {
                act.classList.remove('d-none');
        if (dos.value == ""){
            act.classList.add('d-none');
            desMostrarContra.forEach(des => {
                des.classList.add("d-none");
        });
        }if (dos.type == "text" && dos.value.length > 0) {
            desMostrarContra.forEach(des => {
                des.classList.remove("d-none");
        });
            act.classList.add("d-none");
        } 
   
    });
    });

        
        
    })
    
    const activarMostrarContra = document.querySelectorAll(".mostrarPassword");
    const desMostrarContra = document.querySelectorAll(".ocultarPassword");

    function mostrarContrasena() {
        inputDos.forEach(dos => {
        if (dos.type == "password") {
            dos.type = "text";
            desMostrarContra.forEach(des => {
                des.classList.remove("d-none");
        });
        activarMostrarContra.forEach(act => {
            act.classList.add("d-none");
        });
        } else {
            dos.type = "password";
            desMostrarContra.forEach(des => {
                des.classList.add("d-none");
        });
        activarMostrarContra.forEach(act => {
            act.classList.remove("d-none");
        });
    }
});
    }
    activarMostrarContra.forEach(act => {
        act.addEventListener("click", mostrarContrasena);
    })
    desMostrarContra.forEach(des => {
        des.addEventListener("click", mostrarContrasena);
    })
   
 


})