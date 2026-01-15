<?php  
namespace App\modelos;
use App\modelos\ModelBase;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloUsuarios;


class ModeloPerfil extends ModelBase{
	
	private $conexion;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	private function returnObjectModel()
	{
		return ['modeloUsuario'=>new ModeloUsuarios(), 'modeloDoctores'=>new ModeloDoctores()];
	}
	
	public function seleccionarUsuario(){
		try {
			$data = [
				'usuario' => $this->returnObjectModel()['modeloUsuario']->getUsuario()
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
				'id_usuario' => $this->returnObjectModel()['modeloUsuario']->getIdUsuario(),
				'cedula' => $this->returnObjectModel()['modeloDoctores']->getCedula(),
				'nombre' => $this->returnObjectModel()['modeloDoctores']->getNombre(),
				'apellido' => $this->returnObjectModel()['modeloDoctores']->getApellido(),
				'telefono' => $this->returnObjectModel()['modeloDoctores']->getTelefono(),
			];

			$data2 = [
				'correo' => $this->returnObjectModel()['modeloUsuario']->getIdUsuario(),
				'usuario' => $this->returnObjectModel()['modeloDoctores']->getCedula(),
			];

			$data3 = [
				'id_usuario' => $this->returnObjectModel()['modeloUsuario']->getCorreo(),
				'usuario' => $this->returnObjectModel()['modeloUsuario']->getUsuario(),

			];

			$sql = "SELECT * FROM segurity.usuario WHERE id_usuario = :id_usuario AND usuario = :usuario";
			$this->setSQL($sql);

			$validar  = $this->search($data3, false);

			if ($validar == []) {
				throw new \Exception("El id del usuario o doctor no existe");
			}

			$sql= "UPDATE bd.personal SET cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono WHERE usuario = :id";

			$this->setSQL($sql);
			$this->update($data1, $this->returnObjectModel()['modeloUsuario']->getIdUsuario());

			$sql = "UPDATE segurity.usuario SET usuario=:usuario, correo =:correo WHERE id_usuario = :id";

			$this->setSQL($sql);
			$this->update($data2, $this->returnObjectModel()['modeloUsuario']->getIdUsuario());

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	




}