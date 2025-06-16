<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloMantenimiento;
use App\modelos\ModeloPermisos;

class ControladorMantenimiento
{

	private $modelo;
	private $bitacora;
	private $permisos;
	private $backupCarpeta = __DIR__ . "/../config/backups/";


	// Para descargar la base de datos
	private $dbUser     = "tu_usuario";
	private $dbPassword = "tu_contraseña";
	private $dbHost     = "localhost";
	private $dbName     = "tu_base_datos";

	// Clave de cifrado fija (sin variables de entorno)
	private $encryptionKey = "mi_clave_segura";

	function __construct()
	{
		$this->modelo = new ModeloMantenimiento();
		$this->bitacora = new ModeloBitacora;
		$this->permisos = new ModeloPermisos();
		// Crea la carpeta de respaldos si no existe
		if (!is_dir($this->backupCarpeta)) {
			mkdir($this->backupCarpeta, 0777, true);
		}
	}

	public function mantenimiento()
	{
		require_once './src/vistas/vistaMantenimiento/mantenimiento.php';
	}
	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

	// Función para generar, cifrar y descargar el respaldo
	public function generateBackup()
	{
		$date = date('Y-m-d');
		$backupFile = $this->backupCarpeta . "backup-$date.sql";

		// Comando para generar el respaldo con mysqldump
		$dumpCommand = "mysqldump --opt --user={$this->dbUser} --password={$this->dbPassword} --host={$this->dbHost} {$this->dbName} > $backupFile";
		exec($dumpCommand, $output, $result);

		if ($result === 0 && file_exists($backupFile)) {
			// Nombre del archivo cifrado
			$encryptedFile = $backupFile . ".enc";

			// Comando para cifrar el respaldo usando OpenSSL
			$encryptionCommand = "openssl enc -aes-256-cbc -salt -in $backupFile -out $encryptedFile -pass pass:{$this->encryptionKey}";
			exec($encryptionCommand, $outputEnc, $resultEnc);

			if ($resultEnc === 0 && file_exists($encryptedFile)) {
				// Se elimina el archivo sin cifrar
				unlink($backupFile);

				// Se configuran los encabezados para la descarga del archivo cifrado
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="' . basename($encryptedFile) . '"');
				header('Content-Length: ' . filesize($encryptedFile));
				readfile($encryptedFile);
				exit;
			} else {
				echo "Error al cifrar el respaldo.";
			}
		} else {
			echo "Error al generar el respaldo.";
		}
	}

	// Función para restaurar la base de datos a partir de un respaldo cifrado
	public function restoreBackup()
	{
		$date = date('Y-m-d');
		$encryptedFile = $this->backupCarpeta . "backup-$date.sql.enc";
		$decryptedFile = $this->backupCarpeta . "backup-$date.sql";

		if (!file_exists($encryptedFile)) {
			echo "El archivo de respaldo cifrado no existe.";
			return;
		}

		// Comando para descifrar el archivo de respaldo
		$decryptCommand = "openssl enc -aes-256-cbc -d -in $encryptedFile -out $decryptedFile -pass pass:{$this->encryptionKey}";
		exec($decryptCommand, $outputDec, $resultDec);

		if ($resultDec === 0 && file_exists($decryptedFile)) {
			// Comando para restaurar la base de datos desde el respaldo descifrado
			$restoreCommand = "mysql --user={$this->dbUser} --password={$this->dbPassword} --host={$this->dbHost} {$this->dbName} < $decryptedFile";
			exec($restoreCommand, $outputRestore, $resultRestore);

			if ($resultRestore === 0) {
				// Se elimina el archivo descifrado por seguridad
				unlink($decryptedFile);
				echo "Base de datos restaurada exitosamente.";
			} else {
				echo "Error al restaurar la base de datos.";
			}
		} else {
			echo "Error al descifrar el respaldo.";
		}
	}
}
