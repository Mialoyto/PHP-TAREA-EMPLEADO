<!doctype html>
<html lang="en">

<head>
  <title>Registrar vehiculo</title>
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
        <h5 class="text-light">REGISTRA VEHICULOS</h5>
        <span class="text-light">Completar registro</span>
      </div>
      <div class="card-body">
        <form action="" id="formBusqueda" autocomplete="off">

          <div class="mb-3">
            <label for="marca" class="form-lable">Marca :</label>
            <select name="marca" id="marca" class="form-control shadow " required>
              <option value="">Selecione</option>

            </select>
          </div>

          <div class="mb-3">
            <label for="modelo" class="form-lable">Modelo :</label>
            <input type="text" id="modelo" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="color" class="form-lable">Color :</label>
            <input type="text" id="color" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="tipocombustible" class="form-lable">Tipo combustible :</label>
            <select name="tipocombustible" id="tipocombustible" class="form-select" required>
              <option value="">Seleccione</option>
              <option value="GSL">Gasolina</option>
              <option value="DSL">GNV</option>
              <option value="GNV">DSL</option>
            </select>
          </div>

          <div class="row">

            <div class="col-md-4 mb-3">
              <label for="peso" class="form-lable">Peso :</label>
              <input type="number" id="peso" class="form-control text-end" required>
            </div>

            <div class="col-md-4 mb-3">
              <label for="afabricacion" class="form-lable">Año fabricación :</label>
              <input type="number" id="afabricacion" class="form-control text-end" required>
            </div>

            <div class="col-md-4 mb-3">
              <label for="placa" class="form-lable">Placa :</label>
              <input type="text" id="placa" minlength="7" class="form-control text-end" required>
            </div>
            <div class="mb-3 text-end">
              <button class="btn btn-success" id="guardar" type="submit">Guardar datos</button>
              <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

          </div>


        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", () => {

      function $(id) {
        return document.querySelector(id)
      }

      /* funcion autoejecuta que trae datos de marcas (backend)
      y las agrega como <option> </option> a la lsita (select) marca */
      (function () {

        fetch(`../controllers/Marca.controller.php?operacion=listar`)
          .then(respuesta => respuesta.json())
          .then(datos => {
            console.log(datos)

            datos.forEach(element => {

              const tagOption = document.createElement("option")
              tagOption.value = element.idmarca
              tagOption.innerHTML = element.marca
              $("#marca").appendChild(tagOption)

            });
          })
          .catch(e => {
            console.error(e);
          });
      })();
/* -------------------------------------------------------------------------------- */
      $("#formBusqueda").addEventListener("submit", (event) => {

        // evitamos el envío por ACTION
        event.preventDefault();

        // Enviare por AJAX (fetch)
        if (confirm("¿Desea registrar este vehículo?")) {
          const parametros = new FormData();
          parametros.append("operacion", "add") // IMPORTANTE!
          // A partir de este punto  las variables que requiere el SPU
          parametros.append("idmarca", $("#marca").value)
          parametros.append("modelo", $("#modelo").value)
          parametros.append("color", $("#color").value)
          parametros.append("tipocombustible", $("#tipocombustible").value)
          parametros.append("peso", $("#peso").value)
          parametros.append("afabricacion", $("#afabricacion").value)
          parametros.append("placa", $("#placa").value)

          fetch(`../controllers/Vehiculo.controller.php`, {
            method: 'POST',
            body: parametros
          })
            .then(respuesta => respuesta.text())
            .then(datos => {
              // console.log(datos);
              // const idvehiculo = datos.idvehiculo;

              if (datos.idvehiculo > 0) {
                $("#formBusqueda").reset();
                alert(`Vehiculo registrado con ID: ${datos.idvehiculo}`)
              }
              // console.log(datos)
              // alert("proceso terminado correctamente")

            })
            .catch(e => {
              console.error(e);
            });
        }
      })


    })
  </script>


</body>

</html>