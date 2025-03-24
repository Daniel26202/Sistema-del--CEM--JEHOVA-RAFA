document.addEventListener("DOMContentLoaded", function () {
  let ctx = document.getElementById("chartFluids").getContext("2d");
  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Intracellular", "Extracellular", "Other"],
      datasets: [
        {
          data: [50, 30, 20],
          backgroundColor: ["#007bff", "#28a745", "#ffc107"],
        },
      ],
    },
  });
});
