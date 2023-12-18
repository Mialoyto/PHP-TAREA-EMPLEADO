<?php 
require_once 'Conexion.php';

Class Sede extends Conexion{
    private $pdo;
    public function __CONSTRUCT(){
        $this->pdo = parent::getConexion();
    }

    // RETORNA LA LISTA COMPLETA DE SEDES
    public function getAll(){
        try{
            $consulta = $this->pdo->prepare("CALL spu_sedes_listar()");
            $consulta->execute();
            return $consulta->fetchAll((PDO::FETCH_ASSOC));

        }catch(Exception $e){
            die($e->getMessage());
        }

    }
}

/* $sede = new Sede();
$res = $sede->getAll();
echo json_encode($res); */
?>