<?php
// Incorpora el archivo externo una sola vez
// si detecta un error, se detiene.
require_once '../models/Vehiculo.php';
// 1. recibirá peticiones (GET - POST - REQUEST)
// 2. realizará el proceso (MODELO - CLASE)
// 3. Devolver un resultado (JSON)

//_GET : ES MAS RAPIDO 
// _POST : MAS SEGURO Y ENVIA DATOS BINARIOS
//isset() : verifica si existe el objeto

if (isset($_POST['operacion'])) {

  //Instanciar la clase
  $Vehiculo = new Vehiculo();


  //1.        KEY       =  VALUE
  if ($_POST['operacion'] == 'search') {
    $respueta = $Vehiculo->search(["placa" => $_POST['placa']]);

    // realiza
    sleep(2);
    echo json_encode($respueta);
  }


  // nuevo proceso
  if ($_POST['operacion'] == 'add') {
    // almacenar los datos recibiendo de las vistas en un arreglo
    $datosRecibidos = [
      "idmarca"           => $_POST['idmarca'],
      "modelo"            => $_POST['modelo'],
      "color"             => $_POST['color'],
      "tipocombustible"   => $_POST['tipocombustible'],
      "peso"              => $_POST["peso"],
      "afabricacion"      => $_POST["afabricacion"],
      "placa"             => $_POST["placa"]
    ];

    // Enviamos el arreglo como parametro del metodo 'add'
    $idobtenido = $Vehiculo->add($datosRecibidos);
    echo json_encode($idobtenido);
  }
}

if(isset($_GET['operacion'])){

  $Vehiculo = new Vehiculo();
  
  if($_GET['operacion']=='getResumenTipoCombustible'){
    echo json_encode($Vehiculo->getResumenTipoCombustible());
  }
}
