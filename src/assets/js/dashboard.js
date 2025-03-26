document.addEventListener("DOMContentLoaded", function () {

    // función async
    const traerPromPacientes = async () => {
        try {

            // llamo la función buscar Insumos
            let peticionInsumos = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/mostrarInsumos/" + valorI);

            let resultadoInsu = await peticionInsumos.json();

            //si se trae algo
            if (resultadoInsu.length > 0) {
            } else {
            }

        } catch (error) {
            console.log("insumos lamentablemente Algo Salio Mal Por favor Intente Mas Tarde...");
        }
    }

    let ctx = document.getElementById("chartFluids").getContext("2d");
    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Intracellular", "Extracellular", "Other"],
            datasets: [
                {
                    // pacientes mas visto por los doctores 
                    data: [50, 30, 20],
                    backgroundColor: ["#007bff", "#28a745", "#ffc107"],
                },
            ],
        },
    });
});
