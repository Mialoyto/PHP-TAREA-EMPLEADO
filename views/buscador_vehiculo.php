<!doctype html>
<html lang="es">

<head>
  <title>Buscar vehiculo</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <div class="container-fluid" style="max-width:30rem;">
    <div class="card mt-2">
      <div class="card-header bg-secondary">
        <span class="text-light">BUSCAR VEHICULOS</span>
      </div>
      <div class="card-body">
        <form action="" id="FormData" autocomplete="off">

          <div class="input-group mb-3">
            <input type="text" maxlength="7" class="form-control" id="placa" autofocus
              placeholder="Ingrese placa ej. ABC-000">
            <button class="btn btn-success" type="button" id="btBuscar">BUSCAR PLACA</button>
          </div>
          <small id="status"></small>



          <div class="mb-3">
            <label for="marca" class="form-lable">Marca :</label>
            <input type="text" id="marca" class="form-control" disabled>
          </div>

          <div class="mb-3">
            <label for="modelo" class="form-lable">Modelo :</label>
            <input type="text" id="modelo" class="form-control" disabled>
          </div>

          <div class="mb-3">
            <label for="color" class="form-lable">Color :</label>
            <input type="text" id="color" class="form-control" disabled>
          </div>

          <div class="mb-3">
            <label for="tipocombustible" class="form-lable">Tipo combustible :</label>
            <input type="text" id="tipocombustible" class="form-control" disabled>
          </div>

          <div class="mb-3">
            <label for="peso" class="form-lable">Peso :</label>
            <input type="text" id="peso" class="form-control" disabled>
          </div>

          <div class="mb-3">
            <label for="afabricacion" class="form-lable">Año fabricación :</label>
            <input type="text" id="afabricacion" class="form-control" disabled>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>

    document.addEventListener("DOMContentLoaded", () => {

      function $(id) { return document.querySelector(id) }

      function buscarPlaca() {
        const placa = $("#placa").value

        if (placa != "") {
          //FormData : Empaqueta datos y enviarlo al backend
          const parametros = new FormData();
          parametros.append("operacion", "search");
          parametros.append("placa", placa)

          $("#status").innerHTML = "Buscando, por favor espere...";

          fetch(`../controllers/Vehiculo.controller.php`, {
            method: "POST",
            body: parametros

          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              console.log(datos);
              if (!datos) {
                $("#status").innerHTML = "No se encontró el registro"
                $("FormData").reset();
                $("placa").focus();
              } else {
                $("#status").innerHTML = "Vehiculo encontrado"
                $("#marca").value = datos.marca;
                $("#modelo").value = datos.modelo;
                $("#color").value = datos.color;
                $("#tipocombustible").value = datos.tipocombustible;
                $("#peso").value = datos.peso;
                $("#afabricacion").value = datos.afabricacion;
                
              }


            })
            .catch(error => {
              console.error(error)
            })
        }

      }
      $("#placa").addEventListener("keypress", (event) => {
        if (event.keycode == 13) {
          buscarPlaca();
        }
      })

      $("#btBuscar").addEventListener("click", buscarPlaca);
    })
  </script>


</body>

</html>