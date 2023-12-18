<?php


//VARIABLES
$apellidos = "Loyola Torres";
$nombres = "Miguel";


//CONSTANTES
define ("DNI","12345678");

// echo $apellidos. "" . $nombres . "" .DNI;

// ARREGLO (1) = UNI-DIMENSIONAL
$amigos = array("Karina","Mellisa","Vania","Emily","Sheyla");
$paises = ["Perú","Chile","Argentina"];

//Funcion imprime : tipo, longi, Dato (DEBUG)
//var_dump($amigos);

// foreach($amigos as $amigo){
//   echo $amigo;

//ARREGLO (2) = MULTI_DIMENSIONAL
/* $softwares =[
  ["Eset","Avast","Windws Defender","Avira"],
  ["WarZone","Gow","FF","Pepsiman"],
  ["VSCode","NetBeans","Android Studio","Pseint"]
]; */

/* echo $softwares [0][3]. "<br>";
echo $softwares [2][0]. "<br>";
echo $softwares [2][2]. "<br>";
echo $softwares [1][0]. "<br>"; */


/* foreach ($softwares as $lista){
  foreach($lista as $software){
    echo $software . "<br>";
  }
}
 */
// ARRREGLO (3) =ASOCIATIVA (SIN INDICE)
/* $catalogo =[
  "so"  => "Windows 10",
  "antivirus" => "Panda",
  "utilitario" => "WinRAR",
  "videojuego" => "MarioBross",
];

echo $catalogo["utilitario"]; */


// ARRREGLO (4) MULTIDIMENSIONAL + ASOCIATIVO (CON/SIN ÍNDICE)
$desarrollador =[
  "datospersonales" =>[
    "apellidos"   => "Loyola Torres",
    "nombres"     => "Alex",
    "Edad"        => 24,
    "telefono"    => ["123456789","987654321"],
  ],
  "formacion"       =>[
    "inicial"     => ["Los terrible"],
    "primaria"    => ["Hola que hace"],
    "secundaria"  => ["Maranga","Rosedal"],
  ],
  "habilidades"     =>[
    "Base de datos" => ["MySQL", "MMSQL", "MondoDB"],
    "Framework" => ["Laravel", "CodeIgniter", "Hibernite","zend"]
  ],

];
/* echo "<pre>";
var_dump($desarrollador);
echo "</pre>"; */

echo json_encode($desarrollador);

?>

