<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloUsuarios;
use ZipArchive;
use Exception;

require_once __DIR__ . "/../config/config.php";

class ModeloMantenimiento extends ModelBase
{


	private $user, $usuario;
	private $password;
	private $passwordU;
	private $dbname;
	private $dbsegname;
	private $dbHost;

	private $contrRespaldb;


	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);

		$this->user = user_cos;
		$this->password = pass_cos;
		$this->dbname = dbname_cos;
		$this->dbsegname = dbsegname_cos;
		$this->dbHost = host_cos;
		$this->contrRespaldb = passwordResp_cos;
	}

	// obtener la ruta dele ejecutable segun SO
	private function getEjecutable($nameWindows, $nameLinux = null)
	{
		if ($nameLinux === null) $nameLinux = $nameWindows;

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			// windows
			return "\"C:\\xampp\\mysql\\bin\\{$nameWindows}.exe\"";
		}
		if (file_exists("/opt/lampp/bin/{$nameLinux}")) {
			return "/opt/lampp/bin/{$nameLinux}";
		}
		// linux
		return "/usr/bin/{$nameLinux}";
	}


	//obtener la ruta de rclone según el SO

	private function getRclonePath()
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return '"C:\\rclone-v1.70.2-windows-amd64\\rclone.exe"';
		}
		return 'rclone'; // En Linux está en PATH
	}

	public function generateBackup($backupRuta, $tipo = 'completo')
	{
		try {
			$this->beginTransaction();
			$date = date('Y-m-d_H-i-s');

			//defino los prefijos exactos
			$prefijo = "full_";
			if ($tipo === 'incremental') $prefijo = "inc_";
			if ($tipo === 'diferencial') $prefijo = "diff_";
			if ($tipo === 'log')         $prefijo = "log_";

			$bdSistema = $backupRuta . "{$prefijo}bd_$date.sql";
			$bdSeguridad = $backupRuta . "{$prefijo}bdseguri_$date.sql";

			$mysqldump = $this->getEjecutable('mysqldump');
			$mysqlBin = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? "C:\\xampp\\mysql\\bin\\mysql.exe" : "/opt/lampp/bin/mysql";

			$username = $this->user;
			$passwordStr = (!empty($this->password)) ? "-p\"{$this->password}\"" : "";
			$auth = "-u{$username} {$passwordStr}";


			$estadoSi = 1;
			$estadoSe = 1;

			// respaldo de logs (solo para el corte de logs binarios, sin datos ni estructuras, pero forzando el flush para marcar el punto de control)
			if ($tipo === 'log') {
				$comandoFlush = "{$mysqlBin} {$auth} -e \"FLUSH LOGS;\" 2>&1";
				system($comandoFlush, $estadoFlush);

				if ($estadoFlush === 0) {
					file_put_contents($bdSistema, "-- Corte automático de Logs Binarios de Transacciones (Punto de Control) el $date.\n");
					file_put_contents($bdSeguridad, "-- Log de Seguridad transaccional sincronizado el $date.\n");
					// Forzamos el estado a 0 (éxito) para el procesamiento del ZIP
					$estadoSi = 0;
					$estadoSe = 0;
				}
			}

			//respaldo incremental (solo datos nuevos desde el último respaldo, sin estructuras ni triggers para evitar conflictos)
			elseif ($tipo === 'incremental') {

				$mysqlbinlog = $this->getEjecutable('mysqlbinlog');

				// Obtener el archivo binario actualmente activo
				$cmdStatus = "{$mysqlBin} {$auth} -e \"SHOW MASTER STATUS\"";
				exec($cmdStatus, $statusOutput, $statusCode);

				if ($statusCode !== 0 || count($statusOutput) < 2) {
					throw new Exception("No se pudo obtener el estado del Binary Log.");
				}

				// Buscar el archivo binario en la respuesta
				$binlogFile = null;

				foreach ($statusOutput as $line) {
					if (strpos($line, 'mysql-bin.') !== false) {
						preg_match('/mysql-bin\.\d+/', $line, $match);

						if (!empty($match[0])) {
							$binlogFile = $match[0];
							break;
						}
					}
				}

				if (!$binlogFile) {
					throw new Exception("No se encontró el archivo Binary Log.");
				}

				$binlogPath = "C:\\xampp\\mysql\\data\\{$binlogFile}";

				// Extraer los cambios de la BD del sistema
				$cmdSi = "{$mysqlbinlog} --database={$this->dbname} \"{$binlogPath}\" > \"{$bdSistema}\"";
				system($cmdSi, $estadoSi);

				// Extraer los cambios de la BD de seguridad
				$cmdSe = "{$mysqlbinlog} --database={$this->dbsegname} \"{$binlogPath}\" > \"{$bdSeguridad}\"";
				system($cmdSe, $estadoSe);
			}

			//respaldo diferencial (cambios desde el último completo, pero con estructuras limpias para evitar conflictos de llaves)
			elseif ($tipo === 'diferencial') {

				$mysqlbinlog = $this->getEjecutable('mysqlbinlog');

				// El respaldo completo terminó en mysql-bin.000026, posición 385
				$binlogInicial = "mysql-bin.000026";
				$posicionInicial = 385;

				// Obtener el Binary Log actualmente activo
				$cmdStatus = "{$mysqlBin} {$auth} -e \"SHOW MASTER STATUS\"";
				exec($cmdStatus, $statusOutput, $statusCode);

				if ($statusCode !== 0 || count($statusOutput) < 2) {
					throw new \Exception("No se pudo obtener el estado del Binary Log.");
				}

				// Buscar el archivo Binary Log actual
				$binlogActual = null;

				foreach ($statusOutput as $line) {
					if (strpos($line, 'mysql-bin.') !== false) {
						preg_match('/mysql-bin\.\d+/', $line, $match);

						if (!empty($match[0])) {
							$binlogActual = $match[0];
							break;
						}
					}
				}

				if (!$binlogActual) {
					throw new \Exception("No se encontró el archivo Binary Log actual.");
				}

				$binlogInicialPath = "C:\\xampp\\mysql\\data\\{$binlogInicial}";
				$binlogActualPath = "C:\\xampp\\mysql\\data\\{$binlogActual}";

				// Extraer cambios desde el respaldo completo hasta el Binary Log actual
				$cmdSi = "{$mysqlbinlog} --start-position={$posicionInicial} --database={$this->dbname} \"{$binlogInicialPath}\"";

				if ($binlogActual !== $binlogInicial) {
					$cmdSi .= " \"{$binlogActualPath}\"";
				}

				$cmdSi .= " > \"{$bdSistema}\"";

				system($cmdSi, $estadoSi);

				// Seguridad
				$cmdSe = "{$mysqlbinlog} --start-position={$posicionInicial} --database={$this->dbsegname} \"{$binlogInicialPath}\"";

				if ($binlogActual !== $binlogInicial) {
					$cmdSe .= " \"{$binlogActualPath}\"";
				}

				$cmdSe .= " > \"{$bdSeguridad}\"";

				system($cmdSe, $estadoSe);
			}

			//resplado completo o por defecto
			else {
				// SE AGREGÓ --events AQUÍ
				$cmdSe = "{$mysqldump} {$auth} --single-transaction --routines --triggers --events {$this->dbsegname} > \"{$bdSeguridad}\"";
				system($cmdSe, $estadoSe);

				// SE AGREGÓ --events AQUÍ
				// Conservamos los binlogs; el script de respaldo diferencial los procesa después.
				$cmdSi = "{$mysqldump} {$auth} --flush-logs --master-data=2 --single-transaction --routines --triggers --events {$this->dbname} > \"{$bdSistema}\"";
				system($cmdSi, $estadoSi);
			}


			$estado = ($estadoSi === 0 && $estadoSe === 0) ? 0 : 1;


			if ($estado === 0 && file_exists($bdSistema) && file_exists($bdSeguridad)) {

				$zip = new ZipArchive();
				$nombreZip = $backupRuta . "{$prefijo}bd-$date.zip";

				if ($zip->open($nombreZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
					$zip->addFile($bdSistema, basename($bdSistema));
					$zip->addFile($bdSeguridad, basename($bdSeguridad));
					$zip->close();
				}

				if (file_exists($nombreZip) && filesize($nombreZip) > 0) {
					// Solo si el ZIP es válido eliminamos los archivos temporales sueltos
					unlink($bdSistema);
					unlink($bdSeguridad);

					$this->commit();
					return true;
				} else {
					throw new \Exception("La extensión ZipArchive falló al empaquetar el respaldo en formato comprimido.");
				}
			} else {
				throw new \Exception("Error en la ejecución del volcado físico para el tipo: $tipo (Estado General: $estado)");
			}
		} catch (\Exception $e) {
			$this->rollBack();
			if (isset($bdSistema) && file_exists($bdSistema)) unlink($bdSistema);
			if (isset($bdSeguridad) && file_exists($bdSeguridad)) unlink($bdSeguridad);
			return $e->getMessage();
		}
	}

	public function traerBds($backupRuta)
	{
		// buscar todos los archivos ZIP de respaldo
		$archivosZip = glob($backupRuta . "full_*.zip");
		if (!empty($archivosZip)) {
			// Ordenar por fecha de modificación
			usort($archivosZip, function ($a, $b) {
				return filemtime($b) - filemtime($a);
			});

			$archivosZipB = [];
			foreach ($archivosZip as $value) {
				$archivosZipB[] = basename($value, ".zip");
			}

			return $archivosZipB;
		} else {
			return "noExisteRespaldos";
		}
	}

	public function traerBdsNube($backupRuta)
	{
		// cambiamos todas / por \\ y eliminamos la ultima.
		$backupRuta = rtrim(str_replace('/', '\\', $backupRuta), '\\');
		$rclone = '"C:\\rclone-v1.70.2-windows-amd64\\rclone.exe"';

		// dentro del comando se agrega las comillas con el delimitador \"
		$comando = "$rclone copy almacen:/bases/ \"$backupRuta\" --include \"*.zip\" --ignore-existing -v";
		exec($comando, $output, $status);
		if ($status === 0) {
			return "Descarga completa. Solo se copiaron archivos nuevos.";
		} else {
			return "Ocurrio un error al descargar los respaldos.";
		}
	}

	public function restaurarBackup($backupRuta, $nombreZip)
	{
		try {
			// Corregimos la asignación de la ruta completa
			if (strpos($nombreZip, $backupRuta) === false) {
				$rutaCompletaZip = $backupRuta . $nombreZip;
			} else {
				$rutaCompletaZip = $nombreZip;
			}

			if (strpos($rutaCompletaZip, '.zip') === false) {
				$rutaCompletaZip .= '.zip';
			}

			if (!file_exists($rutaCompletaZip)) {
				return "No existe el archivo ZIP local en la ruta: " . $rutaCompletaZip;
			}

			// Crear carpeta temporal de descompresión
			$carpetaDesconp = $backupRuta . "desconp/";
			if (!file_exists($carpetaDesconp)) {
				mkdir($carpetaDesconp, 0777, true);
			}

			// Extraer el ZIP
			$zip = new ZipArchive();
			if ($zip->open($rutaCompletaZip) === TRUE) {
				$zip->extractTo($carpetaDesconp);
				$zip->close();
			} else {
				return "Error al abrir el archivo ZIP local: " . basename($rutaCompletaZip);
			}

			// Buscar archivos SQL extraídos
			$archivosSql = glob($carpetaDesconp . "*.sql");
			if (empty($archivosSql)) {
				return "No se encontraron archivos SQL dentro del respaldo.";
			}

			// SEPARAR Y FORZAR ORDEN DE RESTAURACIÓN (Seguridad primero)..............
			$archivoSeguridad = null;
			$archivoPrincipal = null;
			$otrosArchivos = [];

			foreach ($archivosSql as $archiSql) {
				// Saltamos los archivos incrementales
				if (strpos($archiSql, 'inc_') !== false) {
					continue;
				}

				if (strpos($archiSql, 'bdseguri') !== false) {
					$archivoSeguridad = $archiSql;
				} elseif (strpos($archiSql, 'bd_') !== false) {
					$archivoPrincipal = $archiSql;
				} else {
					$otrosArchivos[] = $archiSql;
				}
			}

			// Armamos la lista final asegurando el orden correcto
			$archivosAProcesar = [];
			if ($archivoSeguridad) {
				$archivosAProcesar[] = $archivoSeguridad; // Primero va la seguridad
			}
			if ($archivoPrincipal) {
				$archivosAProcesar[] = $archivoPrincipal; // Luego va la principal
			}
			$archivosAProcesar = array_merge($archivosAProcesar, $otrosArchivos);

			// ======================================================================

			$mysqlBin = "/opt/lampp/bin/mysql";
			if (!file_exists($mysqlBin)) {
				$mysqlBin = $this->getEjecutable('mysql');
			}

			$username = $this->user;
			$passwordStr = (!empty($this->password)) ? "-p\"{$this->password}\"" : "";
			$auth = "-u{$username} {$passwordStr}";

			foreach ($archivosAProcesar as $archiSql) {

				if (strpos($archiSql, 'bdseguri') !== false) {
					$bd = $this->dbsegname;
				} else {
					$bd = $this->dbname;
				}

				$flagsBds = "--force";

				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
					// WINDOWS
					$comando = "cmd /c \"\"{$mysqlBin}\" {$auth} --init-command=\"SET FOREIGN_KEY_CHECKS=0;\" {$bd} < \"{$archiSql}\" 2>&1\"";
				} else {
					// Linux
					$comando = "{$mysqlBin} {$auth} {$flagsBds} {$bd} -e \"SET FOREIGN_KEY_CHECKS=0; SOURCE {$archiSql}; SET FOREIGN_KEY_CHECKS=1;\" 2>&1";
				}

				// Inicializamos el array para capturar errores
				$salidaError = [];
				exec($comando, $salidaError, $estado);

				if ($estado !== 0) {
					if (empty($salidaError)) {
						if (!file_exists($archiSql)) {
							$errorConsola = "El archivo SQL temporal no se encuentra en la ruta: " . basename($archiSql);
						} elseif (!is_readable($archiSql)) {
							$errorConsola = "El servidor web no tiene permisos de lectura sobre el archivo: " . basename($archiSql);
						} else {
							$errorConsola = "Error de ejecución en el binario de MySQL.";
						}
					} else {
						$errorConsola = implode(" | ", $salidaError);
					}

					return "Error restaurando la base de datos local ({$bd}). Detalle: " . $errorConsola;
				}
			}

			// Limpieza de archivos temporales procesados
			foreach ($archivosSql as $archiSql) {
				if (file_exists($archiSql)) {
					unlink($archiSql);
				}
			}

			if (is_dir($carpetaDesconp)) {
				rmdir($carpetaDesconp);
			}

			return "Restauración exitosa procesada correctamente en la máquina local.";
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function verifU()
	{
		try {

			$sql = "SELECT p.nombre AS nombre_personal, p.apellido AS apellido_personal,u.id_usuario, r.id_rol, u.usuario, u.password, r.nombre AS rol FROM segurity.usuario u INNER JOIN segurity.rol r ON u.id_rol = r.id_rol INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario = :usuario AND u.estado = 'ACT' AND r.nombre = 'Superadmin' ;";
			$this->setSQL($sql);
			$resultado = $this->search(["usuario" => $this->getUsuario()], false);

			if ($resultado) {
				// Obtenemos el hash(el resultado de una función matemática(también se puede definir cómo, una huella digital)) de la contraseña almacenada
				$hashAlmacenado = $resultado['password'];
				$password = $this->getPassword();
				// Verificamos si la contraseña ingresada coincide con el hash(también llamada, huella digital)
				if (password_verify($password, $hashAlmacenado)) {
					return $resultado;
				} else {
					// Contraseña incorrecta
					return false;
				}
			} else {
				// Usuario no encontrado o inactivo
				return false;
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getUsuario()
	{
		return $this->usuario;
	}

	public function getPassword()
	{
		return $this->passwordU;
	}

	public function setPassword($password)
	{
		$this->passwordU = $password;
	}

	public function setUsuario($usuario)
	{
		if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
			throw new \InvalidArgumentException("El usuario esta mal escrito.");
		}
		$this->usuario = $usuario;
	}
}
