<?php

namespace App\modelos;

use App\modelos\Db;
use ZipArchive;

class ModeloMantenimiento extends Db
{

	private $conexion;

	private $user;
	private $password;
	private $dbname;
	private $dbsegname;
	private $dbHost;

	private $contrRespaldb;


	public function __construct()
	{
		$this->conexion = $this->connectionSistema();

		require_once __DIR__ . "/../config/config.php";
		$this->user = user_cos;
		$this->password = pass_cos;
		$this->dbname = dbname_cos;
		$this->dbsegname = dbsegname_cos;
		$this->dbHost = host_cos;
		$this->contrRespaldb = passwordResp_cos;
	}

	public function generateBackup($backupRuta)
	{
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

				$rclone = '"C:\\Users\\Usuario\\Downloads\\rclone-v1.70.2-windows-amd64\\rclone.exe"';
				$comando = "$rclone copy $nombreZip almacen:/bases/";
				system($comando, $estado);

				// Mostrar resultado
				if ($estado === 0) {
					echo "respaldo subido a google drive.";
				} else {
					echo "error al subir el respaldo.";
				}
			} else {
				echo "errorZip";
			}

			// Se elimina el archivo
			unlink($bdSistema);
			unlink($bdSeguridad);
		} else {
			echo "ErrorRespaldo";
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

			return $archivosZip;
		} else {
			return "noExisteRespaldos";
		}
	}
	public function traerBdsNube($backupRuta)
	{
		$backupRuta = str_replace('/', '\\', $backupRuta);
		$backupRuta = '"' . $backupRuta . '"';
		$rclone = '"C:\\Users\\Usuario\\Downloads\\rclone-v1.70.2-windows-amd64\\rclone.exe"';

		$comando = "$rclone copy almacen:/bases/ $backupRuta --include \"*.zip\" --ignore-existing -v";
		exec($comando, $output, $status);
		if ($status === 0) {
			return "Descarga completa. Solo se copiaron archivos nuevos.";
		} else {
			return "Ocurrió un error al descargar los respaldos.";
		}
	}

	public function restaurarBackup($backupRuta, $nombreBd)
	{
		if ($nombreBd === null) {
			// buscar todos los archivos ZIP de respaldo
			$archivosZip = glob($backupRuta . "bd-*.zip");

			if (!empty($archivosZip)) {
				// Ordenar por fecha de modificación
				usort($archivosZip, function ($a, $b) {
					return filemtime($b) - filemtime($a);
				});

				$nombreZip = $archivosZip[0];
			} else {
				echo "noExisteRespaldo";
			}
		} else {
			$nombreZip = $backupRuta . $nombreBd;
		}


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
				echo "Error al abrir el ZIP: $nombreZip";
			}

			// buscar archivos SQL extraídos
			$archivosSql = glob($carpetaDesconp . "*.sql");
			if (empty($archivosSql)) {
				echo "No se encontraron archivos SQL en el respaldo.";
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
					echo "Restauración exitosa de la $bd, $archiSql ";
				} else {
					echo "Error restaurando: $bd, $archiSql , el zip: $nombreZip ";
				}
			}

			// elimina bds extraídos
			foreach ($archivosSql as $archiSql) {
				unlink($archiSql);
			}
		} else {
			echo "noExisteSql";
		}
	}
}
