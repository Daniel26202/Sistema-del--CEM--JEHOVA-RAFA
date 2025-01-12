addEventListener("DOMContentLoaded", function () {
    console.log("Patologias...")

    // const formBuscador = document.getElementById('form-buscadorPatologias');
    // const tabla2 = document.getElementById('tablaPatologia');
    // const btnreiniciar = document.getElementById('reiniciarBusquedaPatologia');
    // const tbody = tabla2.getElementsByTagName('tbody')[0];
    // const filas = tbody.getElementsByTagName('tr');


    let inputPatologia = document.querySelector("#inputB");



function buscarPatologia() {
   

    // selecciono todos los tr de la tabla
    const filas = document.querySelectorAll(".tbodyPatologia tr");
    // recolecto el nombre del input
    let  valorInputPatologia= inputPatologia.value;
    // se convierte en minúscula
    valorInputPatologia = valorInputPatologia.toLowerCase();
    let coincidenciasEncontradas = 0;
    // recorro las filas de la tabla
    filas.forEach(fila => {
        // cuenta los síntomas que existen.
        

        console.log(fila.children[1]);
        let patologia = fila.children[1].innerText;


        // se convierte en minúscula
        patologia = patologia.toLowerCase();

        // verifico si el nombre existe 
        if (patologia.includes(valorInputPatologia)) {
            fila.classList.remove("d-none");
            coincidenciasEncontradas++;

           
        }
        else {
            fila.classList.add("d-none");
        
          

            // cuenta las veces que no encuentra un síntoma
        }
       

        inputPatologia.addEventListener("keyup", ()=>{
            if(inputPatologia.value === ""){
                fila.classList.remove("d-none");
            }
           }) 

    });

    if (coincidenciasEncontradas === 0) {
        document.getElementById("noResultado").classList.remove("d-none"); 
    } else {
        document.getElementById("noResultado").classList.add("d-none"); 
    }
}

inputPatologia.addEventListener("keyup", function(){
    buscarPatologia();
   }) 

document.getElementById("form-buscador-patologia").addEventListener("submit",function(e){
    e.preventDefault();
})


})