<!doctype html>
<html lang="es">

<head>
    <title>Buscar Empleados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="container-fluid" style="max-width: 30rem;">
        <div class="card mt-2">
            <div class="card-header bg-primary">
                <span class="text-light">BUSCAR EMPLEADO</span>
            </div>
            <div class="card-body">
                <form action="" autocomplete="off" id="formEmp">
                    <div class="input-group mb-3">
                        <input type="text" id="nrodoc" class="form-control border-success" placeholder="Ingrese DNI ej. 12345678" maxlength="8">
                        <button class="btn btn-success" type="button" id="buscarEmp">BUSCAR EMPLEADO</button>
                    </div>
                    <small id="status"></small>


                    <div class="mb-3">
                        <label for="sede" class="form-lable">Sede :</label>
                        <input type="text" id="sede" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="apellidos" class="form-lable">Apellidos :</label>
                        <input type="text" id="apellidos" class="form-control" disabled>
                    </div>


                    <div class="mb-3">
                        <label for="nombres" class="form-lable">Nombres :</label>
                        <input type="text" id="nombres" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="fechanac" class="form-lable">Fecha de nacimiento :</label>
                        <input type="text" id="fechanac" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-lable">Telefono :</label>
                        <input type="text" id="telefono" class="form-control" disabled>
                    </div>
                    
                    <div class="mb-2 text-start">
                        <a href="../views/listar-empleado.php"><button class="btn btn-secondary">Volver atrás</button></a>
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

            function buscarEmpleado() {
                const nrodoc = $("#nrodoc").value

                if (nrodoc != "") {
                    const parametros = new FormData();
                    parametros.append("operacion", "search");
                    parametros.append("nrodoc", nrodoc)

                    $("#status").textContent = "Buscando, por favor espere...";

                    fetch(`../controllers/empleado.controller.php`, {
                            method: "POST",
                            body: parametros
                        })
                        .then(respuesta => respuesta.json())
                        .then(datos => {
                            console.log(datos);
                            if (!datos) {
                                $("#status").textContent = "No se encontro el registro"
                                $("#formEmp").reset();
                                $("#nrodoc").focus();
                            } else {
                                $("#status").innerHTML = "Empleado encontrado";
                                $("#sede").value = datos.sede;
                                $("#apellidos").value = datos.apellidos;
                                $("#nombres").value = datos.nombres;
                                $("#fechanac").value = datos.fechanac;
                                $("#telefono").value = datos.telefono;
                            }
                        })
                        .catch(e => {
                            console.log(e);
                        })
                }
            }

            $("#nrodoc").addEventListener("keypress", (event) => {
                if (event.key == 'Enter') {
                    buscarEmpleado();
                }
            })

            $("#buscarEmp").addEventListener("click", buscarEmpleado);

        })
    </script>
</body>

</html>