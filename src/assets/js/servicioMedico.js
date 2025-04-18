addEventListener("DOMContentLoaded",function(){

    async function traerEspecialidadDoctor(id_doctor) {
        try {
            let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Consultas/mostrarEspecialidad/"+id_doctor);
            let resultado = await peticion.json();
            console.log(resultado)
            resultado.forEach(res => {
            document.getElementById("inputEspecialidad").value = res.nombre;
                
            });
        } catch (error) {
            console.log(error)
        }
    }
    
    document.getElementById("id_doctor").addEventListener("change",function(){
        traerEspecialidadDoctor(this.value)
    })
   





    // para el buscador de Proveedores 
let inputBusServicio = document.querySelector("#inputBuscarOtrosServ");
// const notifi = document.querySelector(".notifi");

// buscador de sintomas
function buscarServicios() {
   

    // selecciono todos los tr de la tabla
    const filas = document.querySelectorAll(".tbody tr");
    // recolecto el nombre del input
    let  valorInputServicios= inputBusServicio.value;
    // se convierte en minúscula
    valorInputServicios = valorInputServicios.toLowerCase();
    let coincidenciasEncontradas = 0;
    // recorro las filas de la tabla
    filas.forEach(fila => {
        // cuenta los síntomas que existen.
     
   

        console.log(fila.children[0]);
        let servicio = fila.children[0].innerText;
        let porEspecialidad = fila.children[2].innerText;

      
        // se convierte en minúscula
        servicio = servicio.toLowerCase();
        porEspecialidad = porEspecialidad.toLowerCase();
        // verifico si el nombre existe 
        if (servicio.includes(valorInputServicios) || porEspecialidad.includes(valorInputServicios) ) {
            fila.classList.remove("d-none");
            
            coincidenciasEncontradas++;
           
        }
        else {
            fila.classList.add("d-none");
           

            // cuenta las veces que no encuentra un síntoma
           
        }
      

        inputBusServicio.addEventListener("keyup", ()=>{
            if(inputBusServicio.value === ""){
                fila.classList.remove("d-none");
            }
           }) 

    });
    if (coincidenciasEncontradas === 0) {
        document.getElementById("noresultados").classList.remove("d-none"); 
    } else {
        document.getElementById("noresultados").classList.add("d-none"); 
    }

    

}
inputBusServicio.addEventListener("keyup", function(){
    buscarServicios();
   }) 


   

   document.getElementById("buscadorServicioMedico").addEventListener("submit", function (f){
    f.preventDefault();
    
})

 
// Buscador Categoria

let inutCategoria = document.querySelector("#inputBuscarCategoria");



function buscarCategoria() {
   

    // selecciono todos los tr de la tabla
    const filas = document.querySelectorAll(".tbodyCategoria tr");
    // recolecto el nombre del input
    let  valorInputCategoria= inutCategoria.value;
    // se convierte en minúscula
    valorInputCategoria = valorInputCategoria.toLowerCase();
    let coincidenciasEncontradas = 0;
    // recorro las filas de la tabla
    filas.forEach(fila => {
        // cuenta los síntomas que existen.
        

        console.log(fila.children[1]);
        let categoria = fila.children[1].innerText;


        // se convierte en minúscula
        categoria = categoria.toLowerCase();

        // verifico si el nombre existe 
        if (categoria.includes(valorInputCategoria)) {
            fila.classList.remove("d-none");
            coincidenciasEncontradas++;

           
        }
        else {
            fila.classList.add("d-none");
        
          

            // cuenta las veces que no encuentra un síntoma
        }
       

        inutCategoria.addEventListener("keyup", ()=>{
            if(inutCategoria.value === ""){
                fila.classList.remove("d-none");
            }
           }) 

    });

    if (coincidenciasEncontradas === 0) {
        document.getElementById("noResultadoCat").classList.remove("d-none"); 
    } else {
        document.getElementById("noResultadoCat").classList.add("d-none"); 
    }
}

inutCategoria.addEventListener("keyup", function(){
    buscarCategoria();
   }) 



})