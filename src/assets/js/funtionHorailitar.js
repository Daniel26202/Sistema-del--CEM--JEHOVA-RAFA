export const convertirHora = (horaMilitar) => {
  // Separamos hora y minutos
  let [horaStr, minutoStr] = horaMilitar.split(":");

  let hora = parseInt(horaStr, 10);
  let minutos = parseInt(minutoStr, 10);

  // Validamos rango
  if (isNaN(hora) || isNaN(minutos) || hora < 0 || hora > 23 || minutos < 0 || minutos > 59) {
    return "Hora inválida";
  }

  // Determinamos AM o PM
  let sufijo = hora >= 12 ? "PM" : "AM";

  // Convertimos a formato 12 horas
  let hora12 = hora % 12;
  if (hora12 === 0) {
    hora12 = 12;
  }

  // Aseguramos que los minutos siempre tengan dos dígitos
  let minutosFormateados = minutos.toString().padStart(2, "0");

  return `${hora12}:${minutosFormateados} ${sufijo}`;
};
