let socket;
let reconnectTimeout;


console.log("web soket");
const notificacionCampanita = document.getElementById("notificacion-campanita");


const conectarWebSocket = async () => {
  const wsUrl = "ws://localhost:8080";
  const checkUrl = "http://localhost:8080";

  // 1. Intentamos una pequeña petición para ver si el servidor está encendido
  // Esto evita el error rojo "ERR_CONNECTION_REFUSED" en muchos navegadores
  try {
    await fetch(checkUrl, {
      mode: "no-cors",
      signal: AbortSignal.timeout(2000),
    });
  } catch (err) {
    console.warn("⚠️ Servidor WebSocket no detectado. Reintentando en 5s...");
    cancelarYReconectar(5000);
    return;
  }

  // 2. Si pasamos el check, cerramos cualquier socket previo antes de abrir uno nuevo
  if (socket) {
    socket.close();
  }

  socket = new WebSocket(wsUrl);

  socket.onopen = (ev) => {
    console.log(
      "%c✅ Conectado al WebSocket",
      "color: #2ecc71; font-weight: bold;",
    );
    socket.send(JSON.stringify({ action: "get_citas_proximas" }));
  };

  socket.onmessage = (ev) => {
    try {
      const data = JSON.parse(ev.data);
      if (data.type === "citas_proximas") {
        console.log("Citas recibidas correctamente");
        mostrarCitasProximas(data.citas);
        actualizarNotificacion(data.citas.length);
        actualizarListaDesplegable(data.citas);
      }
    } catch (error) {
      console.error("Error al procesar mensaje del servidor:", error);
    }
  };

  socket.onclose = (ev) => {
    // Si el cierre no fue intencional (code 1000), reconectamos
    if (ev.code !== 1000) {
      console.log(
        "%c🔄 Conexión perdida. Intentando reconectar...",
        "color: #f39c12;",
      );
      cancelarYReconectar(5000);
    }
  };

  socket.onerror = (err) => {
    // Manejo silencioso del error para no llenar la consola
    console.debug("Error técnico en el socket (probablemente fuera de línea)");
  };
};

// Función auxiliar para manejar los tiempos de reconexión sin duplicar procesos
const cancelarYReconectar = (tiempo) => {
  if (reconnectTimeout) clearTimeout(reconnectTimeout);
  reconnectTimeout = setTimeout(() => {
    conectarWebSocket();
  }, tiempo);
};



const mostrarCitasProximas = (citas) => {
  // Buscamos o creamos el contenedor flotante
  let contenedor = document.getElementById("citas-flotantes-container");
  if (!contenedor) {
    contenedor = document.createElement("div");
    contenedor.id = "citas-flotantes-container";
    document.body.appendChild(contenedor);
  }

  citas.forEach((cita) => {
    const id = `toast-${Date.now()}-${Math.floor(Math.random() * 1000)}`;

    const html = `
            <div id="${id}" class="toast-notif">
                <span class="close-btn" onclick="cerrarToast('${id}')">×</span>
                <h5>🔔 Nueva Cita Próxima</h5>
                <div style="font-size: 0.9rem;">
                    <strong>${cita.nombre} ${cita.apellido}</strong><br>
                    <span>📅 ${cita.fecha} - ${cita.hora}</span><br>
                    <small>Médico: ${cita.nombre_d} ${cita.apellido_d}</small>
                </div>
            </div>
        `;

    contenedor.insertAdjacentHTML("afterbegin", html);

    // Auto-cerrar después de 6 segundos
    setTimeout(() => cerrarToast(id), 6000);
  });
};

// Función para cerrar con animación
const cerrarToast = (id) => {
  const el = document.getElementById(id);
  if (el) {
    el.classList.add("hide");
    setTimeout(() => el.remove(), 300);
  }
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

//click en notificación para mostrar/ocultar citas

const actualizarListaDesplegable = (citas) => {
    const lista = document.getElementById("lista-citas-desplegable");
    
    if (!citas || citas.length === 0) {
        lista.innerHTML = '<div style="padding: 20px; text-align: center; color: #999;">No hay citas próximas</div>';
        return;
    }
    lista.innerHTML = citas
      .map(
        (cita) => `
        <div class="cita-item">
            <strong>${cita.nombre} ${cita.apellido}</strong><br>
            <span style="color: #666;">📅 ${cita.fecha} - ${cita.hora}</span><br>
            <small style="color: #007bff;">Médico: ${cita.nombre_d} ${cita.apellido_d}</small>
        </div>
    `,
      )
      .join("");
};

document.getElementById("notificacion-campanita").addEventListener("click", function(e) {
    e.stopPropagation(); // Evita que se cierre al hacer click en ella misma
    const panel = document.getElementById("dropdown-citas");
    panel.classList.toggle("active");
});

document.addEventListener("click", () => {
    document.getElementById("dropdown-citas").classList.remove("active");
});


conectarWebSocket();