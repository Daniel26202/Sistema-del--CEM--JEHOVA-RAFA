addEventListener("DOMContentLoaded",function() {

   const imagenDoctores = document.getElementById("imagenDoctores");

   //imagenes de los doctores
    imagenDoctores.addEventListener("change", function(e){
        leerimagenDoctores(imagenDoctores.files)
    })

    function leerimagenDoctores(ar) {
        for (var i = 0; i < ar.length; i++) {
            const reader = new FileReader();
            reader.readAsDataURL(ar[i]);
            reader.addEventListener("load",function(e){
                let newImg = `<img  style="height: 200px;width: 100%;" src=${e.currentTarget.result}>`;
                document.querySelector("#contenedor-img-doctor").innerHTML = newImg;
            })
        }
    }
})