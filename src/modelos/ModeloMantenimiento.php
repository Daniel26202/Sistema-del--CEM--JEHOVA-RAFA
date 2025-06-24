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
		$mysqldumpDbSi = "\"C:\\xampp\\mysql\\bin\\mysqldump\" -u $this->user $this->dbname > \"$bdSistema\"";
		system($mysqldumpDbSi, $estado);

		$mysqldumpDbSe = "\"C:\\xampp\\mysql\\bin\\mysqldump\" -u $this->user $this->dbsegname > \"$bdSeguridad\"";
		system($mysqldumpDbSe, $estado);

		if (file_exists($bdSistema) && file_exists($bdSeguridad)) {

			// se comprimen los archivos
			$zip = new ZipArchive();
			$nombreZip = $backupRuta . "bd-$date.zip";

			if ($zip->open($nombreZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
				$zip->addFile($bdSistema, basename($bdSistema));
				$zip->addFile($bdSeguridad, basename($bdSeguridad));
				$zip->close();
			} else {
				echo "errorZip";
			}

			// Se elimina el archivo
			unlink($bdSistema);
			unlink($bdSeguridad);

			exit;
		} else {
			echo "ErrorRespaldo";
		}
	}

	public function restaurarBackup($backupRuta)
	{

		$date = date('Y-m-d');
		$nombreZip = $backupRuta . "bd-$date.zip";


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
					echo "Restauración exitosa de la $bd";
				} else {
					echo "Error restaurando: $bd";
				}
			}

			// elimina bds extraídos
			foreach ($archivosSql as $archiSql) {
				unlink($archiSql);
			}
		} else {
			echo "noExisteRespaldo";
		}
	}
}
