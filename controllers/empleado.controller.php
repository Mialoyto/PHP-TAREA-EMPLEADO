<?php
require_once '../models/Empleado.php';



// BUSCAR EMPLEADOS
if (isset($_POST['operacion'])) {

    // INSTANCIA DE LA CLASE
    $empleado = new Empleado();


    // BUSCAR EMPLEADOS
    // KEY = VALUE
    if ($_POST['operacion'] == 'search') {
        $respueta = $empleado->search(["nrodoc" => $_POST['nrodoc']]);

        echo json_encode($respueta);
    }



    // REGISTRAR EMPLEADO
    if ($_POST['operacion'] == 'add') {

        // ALMACENA LOS DATOS RECIBIDOS DE LA VISTA EN UN ARREGLO
        $dataRecibido = [
            "idsede"    => $_POST['idsede'],
            "apellidos" => $_POST['apellidos'],
            "nombres"   => $_POST['nombres'],
            "nrodoc"    => $_POST['nrodoc'],
            "fechanac"  => $_POST['fechanac'],
            "telefono"  => $_POST['telefono'],

        ];

        // ENVIAMOS EL ARREGLO COMO PARAMETRO DEL METODO 'add'
        $idobtenido = $empleado->add($dataRecibido);
        echo json_encode($idobtenido);
    }
} else {

    $empleado = new Empleado();

    if (isset($_GET['operacion'])) {

        if ($_GET['operacion'] == 'listar') {
            $resultado = $empleado->getAll();
            echo json_encode($resultado);
        }
    }
}


// TRABAJAR CON SPU CONDICION DONDE NO SE ENVIA NINGUN PARAMETRO, SOLO RETORNA DATOS AL VIEW




/* 
$listar = new Empleado();
$reg = $listar->getAll();
echo json_encode($reg);  */
