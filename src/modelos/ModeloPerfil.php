<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloUsuarios;


class ModeloPerfil extends ModelBase
{

	private $id_usuario, $usuario, $usuarioRegistrado, $cedula, $nombre, $apellido, $telefono, $correo, $imagen, $imagenTemporal, $cedulaRegistrada, $nacionalidad;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	public function seleccionarUsuario()
	{
		try {
			$data = [
				'usuario' => $this->getUsuario()
			];
			$sql = "SELECT *,u.usuario as user FROM segurity.usuario u INNER JOIN  bd.personal p ON p.usuario = u.id_usuario  WHERE u.usuario =:usuario";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	public function update_perfil()
	{
		try {

			$data1 = [
				'cedula' => $this->getCedula(),
				'nombre' => $this->getNombre(),
				'apellido' => $this->getApellido(),
				'telefono' => $this->getTelefono(),
			];



			$data3 = [
				'id_usuario' => $this->getIdUsuario(),
				'usuario' => $this->getUsuario(),

			];

			$sql = "SELECT * FROM segurity.usuario WHERE id_usuario = :id_usuario AND usuario = :usuario";
			$this->setSQL($sql);

			$validar  = $this->search($data3, false);

			if ($validar == []) {
				throw new \Exception("El id del usuario o doctor no existe");
			}

			if ($this->getImagen() == null) {
				$data2 = [
					'correo' => $this->getCorreo(),
					'usuario' => $this->getUsuario(),
				];
				$sql = "UPDATE bd.personal SET cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono WHERE usuario = :id";

				$this->setSQL($sql);
				$this->update($data1, $this->getIdUsuario());

				$sql = "UPDATE segurity.usuario SET usuario=:usuario, correo =:correo WHERE id_usuario = :id";

				$this->setSQL($sql);
				$this->update($data2, $this->getIdUsuario());
			} else {
				$sql = "SELECT imagen FROM segurity.usuario WHERE id_usuario=:id_usuario";
				$this->setSQL($sql);
				$img = $this->search(['id_usuario' => $this->getIdUsuario()], false);
				$nombreImagenAntigua = $img["imagen"];

				$data2 = [
					'correo' => $this->getCorreo(),
					'usuario' => $this->getUsuario(),
					'imagen' => $this->getImagen(),
				];
				$sql = "UPDATE bd.personal SET cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono WHERE usuario = :id";

				$this->setSQL($sql);
				$this->update($data1, $this->getIdUsuario());

				$sql = "UPDATE segurity.usuario SET usuario=:usuario, correo =:correo, imagen=:imagen WHERE id_usuario = :id";

				$this->setSQL($sql);
				$this->update($data2, $this->getIdUsuario());

				$rutaImagenAntigua = "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $this->getIdUsuario() . "_" . $nombreImagenAntigua;
				if (file_exists($rutaImagenAntigua) && $nombreImagenAntigua != "doctor.png") {
					unlink($rutaImagenAntigua);
				}

				move_uploaded_file($this->getImagenTemporal(), "./src/assets/images/img_ingresadas_por_usuarios/usuarios/" . $this->getIdUsuario() . "_" . $this->getImagen());
			}

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//getters
	public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}



	public function getCedula()
	{
		return $this->cedula;
	}



	public function getCedulaRegistrada()
	{
		return $this->cedulaRegistrada;
	}



	public function getNombre()
	{
		return $this->nombre;
	}


	public function getApellido()
	{
		return $this->apellido;
	}



	public function getTelefono()
	{
		return $this->telefono;
	}


	public function getUsuario()
	{
		return $this->usuario;
	}

	public function getUsuarioRegistrado()
	{
		return $this->usuarioRegistrado;
	}

	public function getCorreo()
	{
		return $this->correo;
	}

	public function getImagenTemporal()
	{
		return $this->imagenTemporal;
	}

	public function getImagen()
	{
		return $this->imagen;
	}


	//setters
	public function setImagenTemporal($imagenT)
	{
		// // Validar que el archivo se haya subido sin errores
		// if ($imagenT['error'] !== UPLOAD_ERR_OK) {
		//     throw new \InvalidArgumentException('Error al subir la imagen.');
		// }

		// // Validar extensión
		// $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
		// $extension = strtolower(pathinfo($imagenT['name'], PATHINFO_EXTENSION));

		// if (!in_array($extension, $extensionesPermitidas)) {
		//     throw new \InvalidArgumentException('Solo se permiten imágenes JPG, PNG o GIF.');
		// }

		// // Validar tamaño (ejemplo: máximo 5 MB)
		// if ($imagenT['size'] > 5 * 1024 * 1024) {
		//     throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
		// }

		// Si todo está bien, guardamos el nombre temporal para moverlo después
		$this->imagenTemporal = $imagenT;
	}

	public function setImagen($imagen)
	{
		// Validar que el archivo se haya subido sin errores
		// if ($imagen['error'] !== UPLOAD_ERR_OK) {
		//     throw new \InvalidArgumentException('Error al subir la imagen.');
		// }

		// // Validar extensión
		// $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
		// $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

		// if (!in_array($extension, $extensionesPermitidas)) {
		//     throw new \InvalidArgumentException('Solo se permiten imágenes JPG, PNG o GIF.');
		// }

		// // Validar tamaño (ejemplo: máximo 5 MB)
		// if ($imagen['size'] > 5 * 1024 * 1024) {
		//     throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
		// }

		// Si todo está bien, guardamos el nombre temporal para moverlo después
		$this->imagen = $imagen;
	}

	public function setIdUsuario($id_usuario)
	{
		if (!preg_match("/^[0-9]+$/", $id_usuario)) {
			throw new \InvalidArgumentException("El ID del usuario debe ser un número entero positivo.");
		}

		if ((int)$id_usuario <= 0) {
			throw new \InvalidArgumentException("El ID del usuario debe ser mayor que cero.");
		}

		$this->id_usuario = (int)$id_usuario;
	}

	public function setNacionalidad($nacionalidad)
	{
		if (!$nacionalidad == 'V' || $nacionalidad == 'E') {
			throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
		}
		$this->nacionalidad = $nacionalidad;
	}

	public function setCedula($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
		}
		$this->cedula = $cedula;
	}

	public function setCedulaRegistrada($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{7,8})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula registrada debe contener entre 7 y 8 dígitos.");
		}
		$this->cedulaRegistrada = $cedula;
	}

	public function setNombre($nombre)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $nombre)) {
			throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
		$this->nombre = $nombre;
	}

	public function setApellido($apellido)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $apellido)) {
			throw new \InvalidArgumentException("El apellido debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
		$this->apellido = $apellido;
	}

	public function setTelefono($telefono)
	{
		if (!preg_match("/^(0?)(412|422|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/", $telefono)) {
			throw new \InvalidArgumentException("El teléfono debe comenzar con un código válido y contener solo números.");
		}
		$this->telefono = $telefono;
	}


	public function setUsuario($usuario)
	{
		if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
			throw new \InvalidArgumentException("El usuario esta mal escrito.");
		}
		$this->usuario = $usuario;
	}

	public function setUsuarioRegistrado($usuario)
	{
		if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
			throw new \InvalidArgumentException("El usuario esta mal escrito.");
		}
		$this->usuarioRegistrado = $usuario;
	}


	public function setCorreo($correo)
	{
		if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $correo)) {
			throw new \InvalidArgumentException("El correo debe estar bien escrito.");
		}
		$this->correo = $correo;
	}
}
