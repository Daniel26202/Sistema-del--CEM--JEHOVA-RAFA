let socket;

console.log("web soket");
const notificacionCampanita = document.getElementById("notificacion-campanita");

const conectarWebSocket = () => {
  const wsUrl = "ws://localhost:8080";
  socket = new WebSocket(wsUrl);

  socket.onopen = (ev) => {
    console.log("Conectado al WebSocket");
    // Puedes pedir citas al conectar
    socket.send(JSON.stringify({ action: "get_citas_proximas" }));
  };

  socket.onmessage = (ev) => {
    const data = JSON.parse(ev.data);
    if (data.type == "citas_proximas") {
      console.log(('hola mundo'));
      
      mostrarCitasProximas(data.citas);
      actualizarNotificacion(data.citas.length);
    
    }
  };

  socket.onclose = (ev) => {
    console.log("Conexión cerrada, intentando reconectar...");
    setTimeout(conectarWebSocket, 2000);
  };

  socket.onerror = (err) => {
    console.error("Error WebSocket:", err);
  };
};

const mostrarCitasProximas = (citas) => {
  const contenedor = document.getElementById("citas-proximas");
  if (!contenedor) return;

  contenedor.innerHTML = citas
    .map(
      (cita) => `
          <div  class="notification">
          <h5>Proxima cita:</h5>
        <span class="message">Paciente: ${cita.nombre} ${cita.apellido}.</span><br>
        <span class="message">fecha y hora ${cita.fecha} ${cita.hora}.</span><br>
        <span class="message">Doctor:${cita.nombre_d} ${cita.apellido_d}.</span>
        <span class="close" onclick="closeNotification()">✖</span>
    </div>
    
    `,
    )
    .join("");

  showNotification();
};

//notification citas
const showNotification = () => {
  document.querySelectorAll(".notification").forEach((notification) => {
    console.log(notification);
    notification.classList.add("show");
  });

  setTimeout(() => {
    closeNotification();
  }, 5000);
};

const closeNotification = () => {
  document.querySelectorAll(".notification").forEach((notification) => {
    notification.classList.remove("show");
    notification.classList.add("hide");

    setTimeout(() => {
      notification.style.display = "none";
      notification.classList.remove("hide");
    }, 500);
  });
};

const actualizarNotificacion = (total) => {
  const contador = document.getElementById("contador-citas");

  if (total > 0) {
    contador.textContent = total;
    contador.style.display = "block"; // Muestra el contador si hay citas
  } else {
    contador.style.display = "none"; // Oculta el contador si no hay citas
  }
};

// Manejar el clic en la campanita

notificacionCampanita.addEventListener("click", function () {
  const contenedor = document.getElementById("citas-proximas");

  // Alternar la visibilidad de las citas
  if (contenedor.style.display === "block") {
    contenedor.style.display = "none"; // Ocultar si ya está visible
  } else {
    contenedor.style.display = "block"; // Mostrar si está oculto
  }
});

conectarWebSocket();
