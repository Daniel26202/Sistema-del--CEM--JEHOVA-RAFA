1. PLANIFICACIÓN DE LA AUDITORÍA INFORMÁTICA
1.1 Identificación del proyecto
Sistema: Sistema de gestión para el Centro de Especialidades Médicas Jehová Rafa (SISTEMA CEM JEHOVÁ RAFA)
Participantes: Dixon Bastias, Juan Silva, Wilmer Báez y Eduard Sandoval
Tutora asesora: Carmen Colmenares
Institución: Universidad Politécnica Territorial Andrés Eloy Blanco, El Tocuyo, estado Lara
Tipo de intervención: Auditoría informática con pruebas de sistema, integración, portabilidad, rendimiento, seguridad y servidor

1.2 Fundamentación
Probar un sistema de forma exhaustiva es inviable: Myers et al. (2011) y el ISTQB (2023) señalan que no se pueden ejercitar todas las combinaciones de entradas y condiciones, por lo que el esfuerzo se dirige según el riesgo. Las pruebas basadas en riesgo priorizan los componentes con mayor probabilidad e impacto de fallo (Bach, 1999; Amland, 2000; Felderer y Schieferdecker, 2014) y están contempladas en la norma ISO/IEC/IEEE 29119-2 (2021). El mismo criterio rige en auditoría: la ISO 19011 (2018) adopta un enfoque basado en riesgos y el ITAF (ISACA, 2014) exige evaluar el riesgo durante la planificación. En el ámbito sanitario, el software cuyo fallo puede afectar la seguridad del paciente o la confidencialidad de sus datos exige mayor rigor de verificación (IEC, 2016; ISO, 2016). Además, los fallos de los sistemas de información clínica son sociotécnicos, es decir, dependen del software y de su uso (Sittig y Singh, 2010; Coiera, 2015), y su usabilidad es un factor crítico de evaluación (Kushniruk y Patel, 2004). Por ello se verificó la navegación de los 19 módulos y se aplicaron pruebas profundas de caja negra a los de mayor riesgo clínico, administrativo y financiero: Pacientes, Facturación, Directorio Médico y Citas.
1.3 Objetivos
General: Validar que el sistema cumple los requisitos funcionales y no funcionales del SRS, detectar errores antes de la implementación en producción y asegurar su calidad, seguridad y usabilidad.
Específicos:
Verificar la lógica del backend PHP con pruebas unitarias automatizadas.
Comprobar el comportamiento de los módulos desde la perspectiva del usuario (navegación y caja negra).
Validar la integración entre interfaz, backend y base de datos.
Comprobar que la interfaz web y la API devuelven resultados equivalentes (prueba en paralelo).
Evaluar la portabilidad en navegadores y resoluciones representativas, así como el funcionamiento en diferentes sistemas operativos (local vs. servidor VPS).
Medir el comportamiento ante picos de carga (spike) y ante ciclos repetitivos prolongados (huracán).
Inspeccionar la configuración del servidor y verificar la resistencia a inyección SQL.
Evaluar el funcionamiento básico de la aplicación móvil.
Registrar defectos, proponer acciones correctivas y planificar el retesteo.
1.4 Alcance
Prueba
Alcance
Estado
Unitarias
Suite PHPUnit sobre el backend PHP
Ejecutada
Funcionales
Navegación y planillas de caja negra (Pacientes, Facturación, Directorio, Citas, etc.)
Mayoría ejecutada; pruebas pendientes en algunos módulos
Integración
Interfaz, backend y base de datos
Ejecutada
Aplicación móvil
Android (autenticación, navegación, sesión, conectividad, endpoints)
Ejecutada; iOS pendiente
Portabilidad
Chrome y Firefox en 4 resoluciones, abarcando funcionamiento local y en producción (VPS)
Ejecutada
Picos (spike)
Endpoints web y móviles, en 3 fases
Ejecutada
Huracán
Peticiones repetitivas y prolongadas hasta el límite del sistema
Ejecutada
En paralelo
Mismo caso por interfaz web y por API
Planificada
Servidor
Inspección de solo lectura
Ejecutada
Inyección SQL
16 casos y 59 payloads no destructivos
Ejecutada
Aceptación y Usabilidad
Sesiones con usuarios representativos
Pendiente (sin participantes)

Fuera de alcance: Escaneos activos o destructivos, pruebas de estrés hasta el punto de fallo, servicios de terceros y validación en iOS.
1.5 Criterios de entrada y salida
Entrada: Ambiente disponible y autorizado; cuentas de prueba y datos sintéticos identificables; versiones registradas; copia de seguridad y forma de detener la carga; casos, resultados esperados y responsables acordados.
Salida: Cada caso con evidencia y estado (Planificado, Pasó, Falló, Bloqueado o No ejecutado); defectos con pasos, impacto y prioridad; incidencias críticas de seguridad solo cerradas con corrección y retesteo; análisis final que separe lo realizado de lo pendiente.
1.6 Riesgos y limitaciones
Riesgo
Efecto
Tratamiento
Pruebas en ambiente local
No reproducen producción
Repetir carga y seguridad en preproducción
Carga desde una sola IP y sesión
El límite de 60 peticiones por 10 s condiciona los tiempos
Separar respuestas 2xx de las 429
Sin participantes ni iPhone
Aceptación, usabilidad e iOS sin validar
Programar sesiones y prueba en iOS
Restauración de respaldos no ejecutada
No se demuestra la recuperación
Simulacro autorizado

1.7 Módulos y orden de ejecución
Módulos (19): Inicio de sesión, Pacientes, Clientes, Citas, Control médico, Hospitalización, Insumos, Entrada, Facturación, Proveedores, Doctores, Servicios, Patologías, Usuarios, Roles, Bitácora, Reportes, Estadísticas y Perfil.
Orden de las pruebas: Respaldo del ambiente -> Unitarias -> Funcionales -> Integración -> Móvil -> Portabilidad -> Picos -> Huracán -> Paralelo -> Servidor -> Inyección SQL -> Análisis de defectos y retesteo.
1.8 Ambientes de prueba
Ambiente
Rol
Configuración
Uso en la auditoría
Windows + XAMPP
Estación local
Apache 2.4.58, PHP 8.2.12, MariaDB (XAMPP)
Desarrollo, aplicación móvil y pruebas de carga web
Linux Mint 22.3
Equipo de un desarrollador
XAMPP, Apache 2.4.58, PHP 8.2.12, MariaDB 10.4.32
Pruebas del servidor y ejecución completa funcional
VPS (producción)
Despliegue real
Apache 2.4.69, PHP 8.4, MariaDB 10.11.10; 1 vCPU AMD EPYC, 961 MB RAM
Revisión básica, pruebas de portabilidad OS y solo lectura

Nota: Las métricas de carga obtenidas en el ambiente local no son comparables con las del VPS debido a la diferencia de recursos de hardware (1 núcleo y 961 MB de RAM en el VPS). Cada resultado se rotula con el ambiente correspondiente.
1.9 Equipo y responsabilidades
Integrante
Responsabilidad
Edouard Sandoval
Pruebas de picos (spike), huracán, portabilidad y unitarias.
Dixon Bastias
Pruebas funcionales y de carga (PF-02).
Juan Silva
Pruebas funcionales e integración (PF-01, PF-03, PF-04, INT-01 a INT-07).
Wilmer Báez
Pruebas funcionales, carga y seguridad SQL (PF-05, P01 a P04, SQL-01 a SQL-16).
Carmen Colmenares
Tutora asesora: acompañamiento metodológico.



1.10 Cronograma de Actividades (Pasos de la Auditoría)
El proceso de auditoría informática transforma el encargo en un programa verificable y se ejecuta mediante un cronograma de fases secuenciales:
Fase 1: Planeación. Definición de objetivos, alcance, criterios, módulos a evaluar, orden de ejecución y responsables del encargo.
Fase 2: Diseño. Elaboración de casos de prueba, definición de datos de entrada, resultados esperados y criterios de aceptación, materializados en las planillas de caja negra y pruebas técnicas.
Fase 3: Preparación. Respaldo de la base de datos, creación de cuentas, autorización del ambiente y verificación de prerrequisitos técnicos (conexión a internet, capacidades del equipo, claves de acceso) e insumos necesarios (software, equipos de registro).
Fase 4: Ejecución. Aplicación práctica de las pruebas unitarias, funcionales, de integración, portabilidad y de seguridad. Incluye la evaluación de resistencia enviando datos sincronizadamente mediante un software BOT para evidenciar si el sistema colapsa.
Fase 5: Análisis. Comparación estructurada entre la respuesta esperada y la respuesta arrojada por el sistema. Clasificación de los hallazgos y registro detallado de defectos y desviaciones.
Fase 6: Retesteo. Repetición de los casos de prueba que fallaron inicialmente, una vez aplicadas las correcciones por parte del equipo de desarrollo.
Fase 7: Cierre. Consolidación de observaciones, emisión del veredicto final (aprobado/fallido) de los módulos y entrega del informe de resultados con sus limitaciones y recomendaciones.
1.11 Definición de las Pruebas a Usar
El enfoque metodológico combina diversas técnicas para asegurar la calidad del software antes de su implementación en producción:
Pruebas Funcionales (Caja Negra): Se usan para comprobar la navegación y el comportamiento operativo de los módulos desde la perspectiva del usuario final, verificando mediante planillas que las entradas arrojen los resultados correctos.
Pruebas Unitarias (Caja Blanca): Se utilizan para la validación lógica interna, verificando automatizadamente las reglas de negocio y los métodos del backend mediante PHPUnit.
Pruebas No Funcionales de Resistencia (Sensibilidad, Estrés o Picos): Se emplean para conocer la integridad y los límites de resistencia del sistema. Se utilizan simulaciones automatizadas (BOT) para observar si el programa colapsa o se ralentiza significativamente al procesar envíos de datos masivos y sincronizados.
Pruebas de Integración: Se usan para validar la correcta sincronización y flujo de información entre la interfaz web, el backend PHP y la base de datos.
Pruebas de Portabilidad: Se utilizan para evaluar que la interfaz gráfica y funcionalidad se mantengan consistentes a través de distintos navegadores, resoluciones y entornos de despliegue.
Pruebas de Seguridad y Servidor: Se emplean para inspeccionar la configuración del servidor, los servicios expuestos y comprobar la resistencia frente a vulnerabilidades como inyecciones SQL.
1.12 Tipos de Datos y Elementos de Prueba
Para ejecutar las auditorías en los formularios (caja negra) y registrar adecuadamente la información en las planillas, se procesarán los siguientes elementos y tipos de datos:
Datos de Campo: Hacen referencia a las variables específicas de cada módulo evaluado (por ejemplo: nombre, apellido, cédula, teléfono). Se testea que no admitan tipos de datos incorrectos, como caracteres especiales en correos (@ faltantes) o letras en campos numéricos.
Valor de Entrada: Representa el dato exacto que se ingresa en el sistema para evaluar un escenario en particular.
Tipo de Escenario: Define la condición de la prueba, permitiendo comparar si el funcionamiento real del sistema es idéntico al esperado (escenarios correctos o incorrectos).
Respuesta Esperada vs. Respuesta del Sistema: Constituye el núcleo de la validación; se documenta la cantidad, texto o acción que el sistema debe arrojar según los requisitos, contrastándolo frente al valor o acción que realmente produce.
Post Condiciones y Defectos: Datos resultantes del proceso, donde se enumeran de manera descriptiva los defectos encontrados (por ejemplo: si el programa no completó con éxito la respuesta, se ralentizó o no admitió determinados caracteres).

