<!DOCTYPE html>
<html lang="en">

<head>
  <title>Registrar empleado</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <div class="container">
    <div class="card mt-4 border-primary">
      <div class="card-header bg-primary text-light">REGISTRAR EMPLEADO</div>

      <div class="card-body">
        <form action="" id="formRegEmp">
          <div class="mb-3">
            <label for="sede" class="form-lable">SEDES :</label>
            <select name="sede" id="sede" class="form-control form-select shadow" required>
              <option value="">SELECIONAR</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="apellidos" class="form-lable">APELLIDOS :</label>
            <input type="text" id="apellidos" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="nombres" class="form-lable">NOMBRES :</label>
            <input type="text" id="nombres" class="form-control" required />
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="nrodoc" class="form-lable">NÚMERO DOCUMENTO :</label>
              <input minlength="8" type="text" id="nrodoc" class="form-control text-end" required />
            </div>

            <div class="col-md-4 mb-3">
              <label for="fechanac" class="form-lable">FECHA NACIMIENTO :</label>
              <input type="date" id="fechanac" class="form-control text-end" required placeholder="Año-Mes-Día"/>
            </div>

            <div class="col-md-4 mb-3">
              <label for="telefono" class="form-lable">TELEFONO :</label>
              <input type="text" id="telefono" class="form-control text-end" required minlength="9"/>
            </div>

            <div class="mb-3 text-end">
              <button class="btn btn-success" id="guardar" type="submit">
                Guardar datos
              </button>
              <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    // El código aquí se ejecutará cuando el DOM esté completamente cargado
    document.addEventListener("DOMContentLoaded", () => {
      function $(id) {
        return document.querySelector(id);
      }

      // funcion autoejecutable para traer datos del backend
      (function() {

        fetch(`../controllers/sede.controller.php?operacion=listar`)
          .then(respuesta => respuesta.json())
          .then(datos => {
            console.log(datos)

            datos.forEach(element => {
              
              const tagOption = document.createElement("option");
              tagOption.value = element.idsede
              tagOption.innerHTML = element.sede
              $("#sede").appendChild(tagOption)
            });
          })
          .catch(e => {
            console.error(e)
          });
      })();






      $("#formRegEmp").addEventListener("submit", (event) => {
        event.preventDefault();

        if (confirm("Desea registrar empleado?")) {
          const parametros = new FormData();
          parametros.append("operacion", "add");

          parametros.append("idsede", $("#sede").value.toUpperCase());
          parametros.append("apellidos", $("#apellidos").value.toUpperCase());
          parametros.append("nombres", $("#nombres").value.toUpperCase());
          parametros.append("nrodoc", $("#nrodoc").value.toUpperCase());
          parametros.append("fechanac", $("#fechanac").value.toUpperCase());
          parametros.append("telefono", $("#telefono").value.toUpperCase());

          fetch(`../controllers/empleado.controller.php`, {
              method: "POST",
              body: parametros,
            })
            .then(respuesta => respuesta.text())
            .then(datos => {
              if (datos.idsede > 0) {
                $("#formRegEmp").reset();
                alert(`Empleado registrado con ID : ${datos.idempleado}`);
              }
            })
            .catch(e => {
              console.error(e);
            });
        }
      });
    })
  </script>
</body>

</html>