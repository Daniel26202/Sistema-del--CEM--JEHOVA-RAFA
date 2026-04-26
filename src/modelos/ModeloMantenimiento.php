<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloUsuarios;
use ZipArchive;
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

	public function generateBackup($backupRuta)
	{
		try {
			$this->beginTransaction();
			$date = date('Y-m-d');
			$bdSistema = $backupRuta . "bd_$date.sql";
			$bdSeguridad = $backupRuta . "bdseguri_$date.sql";

			// Comando para generar el respaldo con mysqldump
			$mysqldumpDbSi = "\"C:\\xampp\\mysql\\bin\\mysqldump\" -u $this->user --single-transaction --routines --triggers --events $this->dbname > \"$bdSistema\"";
			system($mysqldumpDbSi, $estado);

			$mysqldumpDbSe = "\"C:\\xampp\\mysql\\bin\\mysqldump\" -u $this->user --single-transaction --routines --triggers --events $this->dbsegname > \"$bdSeguridad\"";
			system($mysqldumpDbSe, $estado);

			if (file_exists($bdSistema) && file_exists($bdSeguridad)) {

				// se comprimen los archivos
				$zip = new ZipArchive();
				$nombreZip = $backupRuta . "bd-$date.zip";

				if ($zip->open($nombreZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
					$zip->addFile($bdSistema, basename($bdSistema));
					$zip->addFile($bdSeguridad, basename($bdSeguridad));
					$zip->close();

					$rclone = '"C:\\rclone-v1.70.2-windows-amd64\\rclone.exe"';
					$comando = "$rclone copy $nombreZip almacen:/bases/";
					system($comando, $estado);


					// Mostrar resultado
					if ($estado === 0) {
						// return "respaldo subido al correo.";
					} else {
						// return "error al subir el respaldo al correo.";
					}
				}
				if ($bdSistema) {
					// Se elimina el archivo
					unlink($bdSistema);
					unlink($bdSeguridad);
				}
			}
			$this->commit();
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}

	public function traerBds($backupRuta)
	{
		// buscar todos los archivos ZIP de respaldo
		$archivosZip = glob($backupRuta . "bd-*.zip");
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

			if (file_exists($nombreZip)) {
				// Crear carpeta
				$carpetaDesconp = $backupRuta . "desconp/";
				if (!file_exists($carpetaDesconp)) {
					mkdir($carpetaDesconp, 0777, true);
				}

				// Extraer el ZIP 
				$zip = new ZipArchive();
				if ($zip->open($nombreZip) === TRUE) {
					$zip->extractTo($carpetaDesconp);
					$zip->close();
				} else {
					return "Error al abrir el ZIP: $nombreZip";
				}

				// buscar archivos SQL extraídos
				$archivosSql = glob($carpetaDesconp . "*.sql");
				if (empty($archivosSql)) {
					return "No se encontraron archivos SQL en el respaldo.";
				}

				foreach ($archivosSql as $archiSql) {
					// Si el nombre contiene bdseguri
					if (strpos($archiSql, 'bdseguri') != false) {
						$bd = $this->dbsegname;
					} else {
						$bd = $this->dbname;
					}

					$comando = "\"C:\\xampp\\mysql\\bin\\mysql\" -u $this->user $bd < \"$archiSql\"";
					system($comando, $estado);

					if ($estado === 0) {
						return "Restauración exitosa de la $bd ";
					} else {
						return "Error restaurando: $bd, $archiSql , el zip: $nombreZip ";
					}
				}

				// elimina bds extraídos
				foreach ($archivosSql as $archiSql) {
					unlink($archiSql);
				}
			} else {
				return "noExisteSql";
			}
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
