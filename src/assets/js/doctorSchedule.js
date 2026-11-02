(() => {
    const diasSemana = [
        { nombre: "lunes", etiqueta: "Lunes" },
        { nombre: "martes", etiqueta: "Martes" },
        { nombre: "miercoles", etiqueta: "Miércoles" },
        { nombre: "jueves", etiqueta: "Jueves" },
        { nombre: "viernes", etiqueta: "Viernes" },
        { nombre: "sabado", etiqueta: "Sábado" },
        { nombre: "domingo", etiqueta: "Domingo" },
    ];

    const normalizarTexto = (valor) =>
        String(valor ?? "")
            .trim()
            .toLocaleLowerCase("es")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");

    const obtenerDiasDelHorario = (valor) => {
        const partes = normalizarTexto(valor).split(/\s+a\s+/);
        const inicio = diasSemana.findIndex((dia) => dia.nombre === partes[0]);
        const fin = partes.length === 2 ? diasSemana.findIndex((dia) => dia.nombre === partes[1]) : inicio;

        if (inicio < 0 || fin < 0 || partes.length > 2) {
            return [];
        }

        const dias = [];
        for (let indice = inicio, recorridos = 0; recorridos < diasSemana.length; recorridos += 1) {
            dias.push(diasSemana[indice]);
            if (indice === fin) {
                return dias;
            }
            indice = (indice + 1) % diasSemana.length;
        }

        return [];
    };

    const convertirHora = (valor) => {
        const coincidencia = String(valor ?? "").match(/^(\d{1,2}):(\d{2})(?::\d{2})?$/);
        if (!coincidencia) {
            return null;
        }

        const hora = Number(coincidencia[1]);
        const minutos = Number(coincidencia[2]);
        if (hora > 23 || minutos > 59) {
            return null;
        }

        const sufijo = hora >= 12 ? "PM" : "AM";
        const hora12 = hora % 12 || 12;
        return `${hora12}:${String(minutos).padStart(2, "0")} ${sufijo}`;
    };

    const crearIcono = (clase, contenido, etiquetaOculta = true) => {
        const icono = document.createElement("span");
        icono.className = clase;
        if (etiquetaOculta) {
            icono.setAttribute("aria-hidden", "true");
        }
        icono.innerHTML = contenido;
        return icono;
    };

    const mostrarMensaje = (contenedor, texto, estado) => {
        const mensaje = document.createElement("p");
        mensaje.className = "doctor-schedule-message";
        mensaje.textContent = texto;
        if (estado === "error") {
            mensaje.setAttribute("role", "alert");
        }
        contenedor.replaceChildren(mensaje);
    };

    window.doctorScheduleUtils = Object.freeze({
        obtenerDiasDelHorario,
        convertirHora,
    });

    window.renderDoctorSchedules = (contenedor, horarios, opciones = {}) => {
        if (!(contenedor instanceof HTMLElement)) {
            throw new TypeError("El contenedor de horarios no es válido.");
        }

        contenedor.setAttribute("aria-busy", opciones.cargando ? "true" : "false");
        if (opciones.cargando) {
            mostrarMensaje(contenedor, "Cargando horarios...", "cargando");
            return;
        }
        if (opciones.error) {
            mostrarMensaje(
                contenedor,
                "No se pudieron cargar los horarios. Intenta nuevamente seleccionando el doctor.",
                "error",
            );
            return;
        }
        if (!Array.isArray(horarios)) {
            throw new TypeError("La respuesta de horarios no tiene un formato válido.");
        }

        const horariosPorDia = new Map(diasSemana.map((dia) => [dia.nombre, []]));
        horarios.forEach((horario) => {
            const dias = obtenerDiasDelHorario(horario.diaslaborables);
            const entrada = convertirHora(horario.horaDeEntrada);
            const salida = convertirHora(horario.horaDeSalida);

            if (dias.length === 0 || !entrada || !salida) {
                console.warn("Se omitió un horario con día u horas no reconocidos.", horario);
                return;
            }
            dias.forEach((dia) => {
                const turnos = horariosPorDia.get(dia.nombre);
                if (turnos.some((turno) => turno.entrada === entrada && turno.salida === salida)) {
                    return;
                }
                turnos.push({
                    entrada,
                    salida,
                });
            });
        });

        const fragmento = document.createDocumentFragment();
        let totalDias = 0;

        diasSemana.forEach((dia) => {
            const turnos = horariosPorDia.get(dia.nombre);
            if (turnos.length === 0) {
                return;
            }

            totalDias += 1;
            const tarjeta = document.createElement("article");
            tarjeta.className = "doctor-schedule-card";

            tarjeta.appendChild(
                crearIcono(
                    "doctor-schedule-card-icon",
                    `<svg viewBox="0 0 24 24" fill="none">
                        <rect x="4" y="5.5" width="16" height="15" rx="2.5" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 3.5v4M16 3.5v4M4 10h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>`,
                ),
            );

            const contenido = document.createElement("div");
            contenido.className = "doctor-schedule-content";

            const nombreDia = document.createElement("h6");
            nombreDia.className = "doctor-schedule-day";
            nombreDia.textContent = dia.etiqueta;
            contenido.appendChild(nombreDia);

            const listaTurnos = document.createElement("div");
            listaTurnos.className = "doctor-schedule-shifts";
            turnos.forEach((turno) => {
                const rango = document.createElement("div");
                rango.className = "doctor-schedule-range";
                rango.appendChild(
                    crearIcono(
                        "",
                        `<svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>`,
                    ),
                );
                rango.append(document.createTextNode(`${turno.entrada} - ${turno.salida}`));
                listaTurnos.appendChild(rango);
            });
            contenido.appendChild(listaTurnos);
            tarjeta.appendChild(contenido);
            fragmento.appendChild(tarjeta);
        });

        if (totalDias === 0) {
            mostrarMensaje(contenedor, "No hay horarios disponibles para este doctor.", "vacio");
            return;
        }

        contenedor.replaceChildren(fragmento);
    };
})();
