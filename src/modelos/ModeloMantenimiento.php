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
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();
		// Aquí puedes usar $this para acceder a la conexión
		$this->conexion = $this;

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
		$bdSistema = $backupRuta . "bdsistema-$date.sql";
		$bdSeguridad = $backupRuta . "bdseguridad-$date.sql";

		// Comando para generar el respaldo con mysqldump
		$mysqldumpDbSi = "mysqldump --opt --user=$this->user --password=$this->password --host=$this->dbHost bd > $bdSistema";
		exec($mysqldumpDbSi, $ALGO, $OTRA);

		$mysqldumpDbSe = "mysqldump --opt --user={$this->user} --password={$this->password} --host={$this->dbHost} {$this->dbsegname} > $bdSeguridad";
		$verdbs = shell_exec($mysqldumpDbSe);

		if (file_exists($bdSistema) && file_exists($bdSeguridad)) {

			$bdSiEncrypt = $bdSistema . ".enc";
			$bdSeEncrypt = $bdSeguridad . ".enc";

			// // cifrar el respaldo
			// $CommandoBdSi = "openssl enc -aes-256-cbc -salt -in $bdSistema -out $bdSiEncrypt -pass pass:{$this->contrRespaldb}";
			// shell_exec($CommandoBdSi);

			// $CommandoBdSe = "openssl enc -aes-256-cbc -salt -in $bdSeguridad -out $bdSeEncrypt -pass pass:{$this->contrRespaldb}";
			// shell_exec($CommandoBdSe);
			// para no mostrar descarga en el navegador
	
			if (file_exists("") && file_exists($bdSeEncrypt)) {

				// se comprimen los archivos
				$zip = new ZipArchive();
				$nombreZip = $backupRuta . "bd-$date.zip";

				if ($zip->open($nombreZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
					$zip->addFile($bdSiEncrypt, basename($bdSiEncrypt));
					$zip->addFile($bdSeEncrypt, basename($bdSeEncrypt));
					$zip->close();
				} else {
					return "errorZip";
				}

				// Se elimina el archivo
				unlink($bdSistema);
				unlink($bdSeguridad);

				// para no mostrar descarga en el navegador
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="' . basename($nombreZip) . '"');
				header('Content-Length: ' . filesize($nombreZip));
				readfile($nombreZip);
				exit;
			} else {

				echo "ErrorCifrar ... ".$OTRA . " " . $verdbs ;
				print_r($ALGO);
			}
		} else {
			echo "ErrorRespaldo";
		}
	}

	//restaurar la base de datos
	// public function restaurarBackup($backupRuta)
	// {
	// 	$date = date('Y-m-d');
	// 	$encryptedFile = $backupRuta . "backup-$date.sql.enc";
	// 	$decryptedFile = $backupRuta . "backup-$date.sql";

	// 	if (!file_exists($encryptedFile)) {
	// 		echo "El archivo de respaldo cifrado no existe.";
	// 		return;
	// 	}

	// 	// Comando para descifrar el archivo de respaldo
	// 	$decryptCommand = "openssl enc -aes-256-cbc -d -in $encryptedFile -out $decryptedFile -pass pass:{$this->encryptionKey}";
	// 	shell_exec($decryptCommandec);

	// 	if ($resultDec === 0 && file_exists($decryptedFile)) {
	// 		// Comando para restaurar la base de datos desde el respaldo descifrado
	// 		$restoreCommand = "mysql --user={$this->dbUser} --password={$this->dbPassword} --host={$this->dbHost} {$this->dbName} < $decryptedFile";
	// 		shell_exec($restoreCommandultRestore);

	// 		if ($resultRestore === 0) {
	// 			// Se elimina el archivo descifrado por seguridad
	// 			unlink($decryptedFile);
	// 			echo "Base de datos restaurada exitosamente.";
	// 		} else {
	// 			echo "Error al restaurar la base de datos.";
	// 		}
	// 	} else {
	// 		echo "Error al descifrar el respaldo.";
	// 	}
	// }
}
