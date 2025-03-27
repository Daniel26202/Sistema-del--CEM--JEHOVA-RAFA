INSERT INTO
    rol (id_rol, nombre, estado, descripción)
VALUES
    (1, 'admin', 'activo', 'Administrador del sistema'),
    (2, 'doctor', 'activo', 'Médico de la clínica'),
    (3, 'recepcion', 'activo', 'Personal de recepción');

INSERT INTO
    usuario (
        id_usuario,
        id_rol,
        imagen,
        usuario,
        correo,
        password,
        estado
    )
VALUES
    (
        1,
        1,
        '',
        'adminUser',
        'admin@clinica.com',
        'password_hash',
        'ACTIVO'
    ),
    (
        2,
        2,
        '',
        'drSmith',
        'dr.smith@clinica.com',
        'password_hash',
        'ACTIVO'
    ),
    (
        3,
        3,
        '',
        'recepUser',
        'recep@clinica.com',
        'password_hash',
        'ACTIVO'
    );

INSERT INTO
    categoria_servicio (id_categoria, nombre, estado)
VALUES
    (1, 'Consulta', 'activo'),
    (2, 'Procedimiento', 'activo'),
    (3, 'Examen', 'activo');

INSERT INTO
    especialidad (id_especialidad, nombre, estado)
VALUES
    (1, 'Cardiología', 'activo'),
    (2, 'Pediatría', 'activo'),
    (3, 'Dermatología', 'activo');

INSERT INTO
    personal (
        id_personal,
        nacionalidad,
        cedula,
        nombre,
        apellido,
        telefono,
        email,
        tipodecategoria,
        id_especialidad,
        id_usuario
    )
VALUES
    (
        1,
        'V',
        'V12345678',
        'Juan',
        'Pérez',
        '04141234567',
        'juan.perez@clinica.com',
        'doctor',
        1,
        2
    ),
    (
        2,
        'V',
        'V87654321',
        'María',
        'González',
        '04147654321',
        'maria.gonzalez@clinica.com',
        'recepcion',
        NULL,
        3
    );

INSERT INTO
    proveedor (
        id_proveedor,
        nombre,
        rif,
        telefono,
        email,
        direccion,
        estado
    )
VALUES
    (
        1,
        'Proveedor A',
        'J-12345678-9',
        '02121234567',
        'contacto@proveedora.com',
        'Av. Principal 123',
        'activo'
    ),
    (
        2,
        'Proveedor B',
        'J-98765432-1',
        '02129876543',
        'info@proveedorb.com',
        'Calle Secundaria 456',
        'activo'
    );

INSERT INTO
    insumo (
        id_insumo,
        imagen,
        nombre,
        descripcion,
        precio,
        cantidad,
        stockMinimo,
        estado
    )
VALUES
    (
        1,
        'img/insumo1.png',
        'Guantes',
        'Guantes de látex',
        10.00,
        100,
        20,
        'activo'
    ),
    (
        2,
        'img/insumo2.png',
        'Mascarillas',
        'Mascarillas N95',
        15.50,
        200,
        30,
        'activo'
    );

INSERT INTO
    inventario (
        id_inventario,
        id_insumo,
        cantidad,
        fachaVencimiento,
        numero_de_lote
    )
VALUES
    (1, 1, 100, '2025-12-31', 101),
    (2, 2, 200, '2025-10-31', 202);

INSERT INTO
    entrada (
        id_entrada,
        id_proveedor,
        numero_de_lote,
        fechaDeIngreso,
        estado
    )
VALUES
    (1, 1, 101, '2025-03-20', 'recibido'),
    (2, 2, 202, '2025-03-21', 'recibido');

INSERT INTO
    entrada_insumo (
        id_entradaDeInsumo,
        id_insumo,
        id_entrada,
        fechaDeVencimiento,
        precio,
        cantidad_entrante,
        cantidad_disponible
    )
VALUES
    (1, 1, 1, '2025-12-31', 10.00, 100, 100),
    (2, 2, 2, '2025-10-31', 15.50, 200, 200);

INSERT INTO
    cita (
        id_cita,
        fecha,
        hora,
        estado,
        serviciomedico_id_servicioMedico
    )
VALUES
    (1, '2025-04-01', '09:00:00', 'pendiente', 1),
    (2, '2025-04-01', '10:00:00', 'confirmada', 2);

INSERT INTO
    control (
        id_control,
        id_paciente,
        id_usuario,
        diagnostico,
        medicamentosRecetados,
        fecha_control,
        fechaRegreso,
        nota,
        estado
    )
VALUES
    (
        1,
        1,
        2,
        'Dolor de cabeza',
        'Paracetamol 500mg',
        '2025-04-01 09:30:00',
        '2025-04-08',
        'Revisar en una semana',
        'completado'
    ),
    (
        2,
        2,
        2,
        'Fiebre',
        'Ibuprofeno 200mg',
        '2025-04-01 10:30:00',
        '2025-04-08',
        'Revisar temperatura',
        'pendiente'
    );

INSERT INTO
    factura (
        id_factura,
        fecha,
        total,
        estado,
        serviciomedico_id_servicioMedico
    )
VALUES
    (1, '2025-04-01', 250.00, 'pagada', 1),
    (2, '2025-04-01', 400.00, 'pendiente', 2);

INSERT INTO
    horacostohospitalizacion (id_horacostohospitalizacion, hora, costo)
VALUES
    (1, 1, 50.00),
    (2, 2, 75.00);

INSERT INTO
    horario (id_horario, diaslaborables)
VALUES
    (1, 'Lunes a Viernes'),
    (2, 'Sábados');

INSERT INTO
    horarioydoctor (
        id_horarioydoctor,
        id_personal,
        id_horario,
        horaDeEntrada,
        horaDeSalida
    )
VALUES
    (1, 1, 1, '08:00:00', '16:00:00'),
    (2, 1, 2, '09:00:00', '13:00:00');

INSERT INTO
    hospitalizacion (
        id_hospitalizacion,
        id_horacostohospitalizacion,
        duracion,
        precio_horas,
        total,
        historiaclinica,
        fecha_hora,
        estado
    )
VALUES
    (
        1,
        1,
        72,
        50.00,
        3600.00,
        'Paciente ingresado por cirugía',
        '2025-03-25 08:00:00',
        'activo'
    ),
    (
        2,
        2,
        48,
        75.00,
        3600.00,
        'Paciente en observación',
        '2025-03-26 09:00:00',
        'activo'
    );

INSERT INTO
    hospitalizacion_has_serviciomedico (
        hospitalizacion_id_hospitalizacion,
        serviciomedico_id_servicioMedico
    )
VALUES
    (1, 1),
    (2, 2);

INSERT INTO
    serviciomedico (
        id_servicioMedico,
        id_categoria,
        id_personal,
        precio,
        estado,
        paciente_id_paciente
    )
VALUES
    (1, 1, 1, 250.00, 'activo', 1),
    (2, 1, 1, 400.00, 'activo', 2);

INSERT INTO
    serviciomedico_has_insumo (
        serviciomedico_id_servicioMedico,
        insumo_id_insumo
    )
VALUES
    (1, 1),
    (2, 2);

INSERT INTO
    sintomas (id_sintomas, nombre, estado)
VALUES
    (1, 'Dolor de cabeza', 'activo'),
    (2, 'Fiebre', 'activo');

INSERT INTO
    sintomas_control (id_sintomas_control, id_sintomas, id_control)
VALUES
    (1, 1, 1),
    (2, 2, 2);

INSERT INTO
    pago (id_pago, nombre)
VALUES
    (1, 'Tarjeta de Crédito'),
    (2, 'Efectivo');

INSERT INTO
    pagodefactura (
        id_pagoDeFactura,
        id_pago,
        id_factura,
        referencia,
        monto
    )
VALUES
    (1, 1, 1, 'REF123', 250.00),
    (2, 2, 2, 'REF456', 400.00);

INSERT INTO
    patologia (id_patologia, nombre_patologia, estado)
VALUES
    (1, 'Hipertensión', 'activo'),
    (2, 'Diabetes', 'activo');

INSERT INTO
    patologiadepaciente (
        id_patologiaDePaciente,
        id_paciente,
        id_patologia,
        fecha_registro
    )
VALUES
    (1, 1, 1, '2025-03-30 10:00:00'),
    (2, 2, 2, '2025-03-30 11:00:00');

INSERT INTO
    permisos (idpermisos, nombre)
VALUES
    (1, 'Ver registros'),
    (2, 'Editar registros'),
    (3, 'Eliminar registros');

INSERT INTO
    rol_has_permisos (rol_id_rol, permisos_idpermisos)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (2, 1),
    (3, 1);

INSERT INTO
    recuperar_contr (
        id_recuperar_contr,
        id_usuario,
        codigo,
        fecha_expiracion,
        intentos_fallidos,
        fecha_desbloqueo
    )
VALUES
    (
        1,
        2,
        'ABC123',
        '2025-04-05 00:00:00',
        0,
        '2025-04-05 00:00:00'
    );

INSERT INTO
    bitacora (
        id_bitacora,
        id_usuario,
        tabla,
        actividad,
        fecha_hora
    )
VALUES
    (
        1,
        1,
        'usuario',
        'Creación de usuario admin',
        '2025-03-25 10:00:00'
    ),
    (
        2,
        2,
        'cita',
        'Creación de cita para paciente 1',
        '2025-03-25 10:05:00'
    );