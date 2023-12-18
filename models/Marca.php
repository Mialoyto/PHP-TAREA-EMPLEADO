<?php

require_once 'Conexion.php';
class Marca extends Conexion{

  private $pdo;
  public function __CONSTRUCT(){
    $this->pdo = parent::getConexion();
  }

//DEvuelve la lista completa de marcas
  public function getAll(){
    try{
      $consulta = $this->pdo->prepare("CALL spu_marcas_listar()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage()); 

    }
  }
}

/* $marca = new Marca();
$resultado = $marca->getAll();
// var_dump($resultado);
echo json_encode($resultado); */