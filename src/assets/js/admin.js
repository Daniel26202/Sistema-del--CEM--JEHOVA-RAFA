addEventListener("DOMContentLoaded", function () {

    const btnEPassword = document.querySelectorAll(".btn_editarPassword");
    const btnEUsuario = document.getElementById("btnEUsuario");

    btnEPassword.forEach(btn => {
        btn.addEventListener("click", function () {
            let id= btn.getAttribute("data-id-u");
            btnEUsuario.setAttribute("uk-toggle",`target: #modal-exampleEditar${id}`);
            alert(id);
        })

    });

})