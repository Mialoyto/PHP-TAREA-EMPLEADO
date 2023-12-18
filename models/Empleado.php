<?php
require 'Conexion.php';

class Empleado extends Conexion
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = parent::getConexion();
    }



    // FUNCION PARA REGISTRAR EMPLEADOS
    public function add($data = [])
    {
        try {
            $consulta = $this->pdo->prepare("CALL spu_empleados_registrar(?,?,?,?,?,?)");
            $consulta->execute(
                array(
                    $data['idsede'],
                    $data['apellidos'],
                    $data['nombres'],
                    $data['nrodoc'],
                    $data['fechanac'],
                    $data['telefono']
                )
            );

            // ACTUALIZACION, RETORNAMOS EL 'idempleado'
            return $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    //FUNCION PARA BUSCAR EMPLEADOS
    public function search($data = [])
    {
        try {
            //SOLO REQUIERE EL NRODOC EL SPU_EMPELADOS_BUSCAR
            // variable consulta de la instancia actual prepara el procedimiento almacenado 
            $consulta = $this->pdo->prepare("CALL spu_empleados_buscar(?)");
            // EXECUTA EL SPU
            $consulta->execute(
                array($data['nrodoc'])
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $consulta = $this->pdo->prepare("CALL spu_empleados_listar()");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}


/* $empleado = new Empleado();
$registro = $empleado->search(["nrodoc" => "12345678"]);
var_dump($registro); */

/* $listar = new Empleado();
$reg = $listar->getAll();
echo json_encode($reg); */