<?php


return [
    //Pacientes
    "getPacientes" => "consultar",
    "papeleraPaciente" => "consultar",
    "guardar" => "guardar",
    "setPaciente"  => "editar",
    "eliminar" => "eliminar",
    "restablecer" => "restablecer",

    //Patlogias
    "patologias" => "consultar",
    "papeleraPatologias" => "consultar",
    "registrarPatologia" => "guardar",
    "eliminarPatologia" => "eliminar",

    //Factura
    "factura" => "consultar",
    "facturaCita" => "consultar",
    "comprobante" => "consultar",
    "mostrarPaciente" => "consultar",
    "mostrarPacienteConCita" => "consultar",
    "mostrarTodosLosServicios" => "consultar",
    "mostrarTodosLosDoctores" => "consultar",
    "mostrarPrecio" => "consultar",
    "mostrarNombreTodosDoctores" => "consultar",
    "nombreSegunIdC" => "consultar",
    "nombreSegunIdD" => "consultar",
    "insumosAjax" => "consultar",
    "mostrarPDF" => "consultar",
    "mostrarPDF2" => "consultar",
    "mostrarPDF3" => "consultar",
    "guardarFactura" => "guardar",
    "guardarFacturaHospit" => "guardar",
    "facturarHospitalizacion" => "consultar",

    //Citas
    "mostrarPacienteCita" => "consultar",
    "mostrarPacienteCitaGet" => "consultar",
    "citas" => "consultar",
    "citasHoy" => "consultar",
    "citasP" => "consultar",
    "guardarCita" => "guardar",
    "eliminarCita" => "eliminar",
    "citasHoyP" => "consultar",
    "citasRealizadas" => "consultar",
    "mostrarDoctoresCita" => "consultar",
    "mostrarHorario" => "consultar",
    "editarCita" => "editar",
    "insertaPaciente" => "guardar",
    "validarHorariosDisponlibles" => "consultar",


    //Servicios Medicos
    "consultas" => "consultar",
    "papeleraServicio" => "consultar",
    "guardar" => "guardar",
    "eliminar" => "eliminar",
    "restablecer" => "restablecer",
    "editar" => "editar",
    "mostrarEspecialidad" => "consultar",
    "registrarCategoria" => "guardar",
    "eliminarCategoria" => "eliminar",
    "serviciosDoctor" => "consultar",


    //Doctores
    "doctores" => "consultar",
    "agregarDoctor" => "guardar",
    "editarDoctor" => "editar",
    "borrarDoctor" => "eliminar",
    "selectDiasDoctorEditar" => "consultar",
    "registrarEspecialidad" => "guardar",
    "EliminarEspecialidad" => "eliminar",
    "buscarEspecialidad" => "consultar",
    "buscarDoctor" => "consultar",
    "buscarHorario" => "consultar",
    "guardarDoctores" => "guardar",

    //Usuarios
    "usuarios" => "consultar",
    "administradores" => "consultar",
    "papeleraUsuario" => "consultar",
    "registrarAdmin" => "guardar",
    "editarAdministrador" => "editar",
    "eliminarAdministrador" => "eliminar",
    "editarUsuario" => "editar",
    "borrarUsuario" => "eliminar",
    "registrarAdmin" => "guardar",
    "buscarUsuario" => "consultar",
    "buscarUsuarioAdmin" => "consultar",
    "editarAdministrador" => "editar",
    "eliminarAdministrador" => "eliminar",
    "verificarPassw" => "consultar",

    //Hospitalizacion
    "traerSesion" => "consultar",
    "traerSesionR" => "consultar",
    "hospitalizacion" => "consultar",
    "hospitalizacionesRealizadas" => "consultar",
    "validarPaciente"  => "consultar",
    "validarControl" => "consultar",
    "mostrarInformacionPCD" => "consultar",
    "mostrarInsumos" => "consultar",
    "mostrarUnInsumo" => "consultar",
    "agregarH" => "guardar",
    "traerInsuDHEd" => "consultar",
    "modificarH" => "editar",
    "eliminaL" => "eliminar",
    "buscarIExH" => "consultar",
    "enviarAFacturar" => "editar",


    //Control
    "control" => "consultar",
    "mostrarPacientesJS" => "consultar",
    "mostrarBusquedaPacientesJS" => "consultar",
    "mostrarControlPacientesJS" => "consultar",
    "mostrarPacienteJS" => "consultar",
    "insertarControl" => "guardar",
    "eliminarControl" => "eliminar",
    "editarControl" => "editar",
    "mostrarSP" => "consultar",
    "mostrarPP" => "consultar",
    "mostrarPIdP" => "consultar",
    "eliminarSintoma" => "eliminar",
    "agregarSintoma" => "guardar",

    //Insumos
    "insumos" => "consultar",
    "retornarLasEntradas" => "consultar",
    "InsumosVencidos" => "consultar",
    "info" => "consultar",
    "mostrarBusquedaInsumo" => "consultar",
    "papelera" => "consultar",
    "guardarInsumo" => "guardar",
    "editar" => "editar",
    "eliminar" => "eliminar",
    "restablecerInsumo" => "restablecer",
    "cantidadInsumos" => "consultar",
    "cantidadInsumosVencidos" => "consultar",

    //Entrada
    "entrada" => "consultar",
    "papelera" => "consultar",
    "guardar" => "guardar",
    "eliminar" => "eliminar",
    "editar" => "editar",
    "entradaInsumo" => "consultar",
    "restablecerEntrada" => "restablecer",
    "proveedoresEditar" => "consultar",
    "selectProveedores" => "consultar",
    "selectInsumos" => "consultar",
    "selectInsumosEditar" => "consultar",


    //Proveedores
    "proveedores" => "consultar",
    "papelera" => "consultar",
    "insertar" => "guardar",
    "update" => "eliminar",
    "restablecerProveedor" => "restablecer",
    "editar" => "editar",
    "validarRif" => "consultar",
    "validarRifEditar" => "consultar",
    "buscarProveedor" => "consultar",


    //Roles
    "mostrar" => "consultar",
    "mostrarPermisos" => "consultar",
    "guardarRol" => "guardar",
    "modificarRol" => "editar",
    "eliminarRol" => "eliminar",
    "validarRol" => "consultar",

    //Reportes
    "reportes" => "consultar",
    "buscarPDF" => "consultar",
    "buscarEntradasInsumosPDF" => "consultar",
    "factura" => "consultar",
    "pacientePDF" => "consultar",
    "insumosPDF" => "consultar",
    "reportesFactura" => "consultar",
    "reportesFacturasAnuladas" => "consultar",
    "buscarPago" => "consultar",
    "buscarMasServicios" => "consultar",
    "buscarInsumos" => "consultar",
    "buscarCita" => "consultar",
    "buscarCitaPDF" => "consultar",
    "anularFactura" => "eliminar",


    //Reportes Estadisticos
    "estadisticas" => "consultar",
    "edadGenero" => "consultar",
    "tasaMorbilidad" => "consultar",
    "filtrar_tasaMorbilidad" => "consultar",
    "insumos" => "consultar",


];
