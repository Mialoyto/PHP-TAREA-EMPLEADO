<?php
// 1. Acceso al archivo
require 'Conexion.php';

// 2.heredar sus atributos y metodos
class Vehiculo extends Conexion
{

  //este objeto almacenara la conexion y se la facilitara a todos los metodos
  private $pdo;
  public function __construct()
  {
    $this->pdo = parent::getConexion();
  }

  /* $data  es unaarreglos asociativo que contiene los valorea requerios por
SPU para registrar vehiculos */
  public function add($data = [])
  {
    try {
      $consulta = $this->pdo->prepare("CALL spu_vehiculos_registrar(?,?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idmarca'],
          $data['modelo'],
          $data['color'],
          $data['tipocombustible'],
          $data['peso'],
          $data['afabricacion'],
          $data['placa']
        )
      );
      // Actualizacion, ahora retornamos el 'idvehiculo' 
      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }



  //3. Almacenara la conexion en el objeto
  public function search($data = [])
  {
    try {
      // El SPU requiere el numero de placa
      $consulta = $this->pdo->prepare("CALL spu_vehiculos_buscar(?)");
      $consulta->execute(
        //obtine la placa de la base de datos
        array($data['placa'])
      );

      //devolver el registro encontrado
      //  fetch() => retorna la primera coincidencia (1)
      //  fetchAll() => retona todas las coincidencias (n)
      // FECHT_ASSOC => define el resultado como un objeto.
      // return $consulta->fetchAll(PDO::FETCH_CLASS);
      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public  function getResumenTipoCombustible()
  {
    try {
      $consulta = $this->pdo->prepare("CALL spu_resumen_TipoCombustible()");
      $consulta -> execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
}

//PRUEBA - no olvidar borrar o comentar
/* $vehiculo = new Vehiculo();
$registro = $vehiculo->search(["placa" => "ABC-111"]);
var_dump($registro); */


/* 
PHP => Mysql, Oracle, SQL Server
CLASE:
MYSQLConnect  V5
Mysqli        V7
PDO           
*/