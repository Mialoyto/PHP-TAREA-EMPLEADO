<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <div style="width: 70%; margin: auto;">
    <canvas id="lienzo"></canvas>
  </div>
  <!-- CDN CHART -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js">  </script>
  <script>
    const contexto = document.querySelector('#lienzo');
    const grafico = new Chart(contexto, {
      type: 'polarArea',
      data: {

        labels: [],
        datasets: [{
          label: 'Tipo combustible',
          data: []
        }]
      }
    });

    (function () {
      fetch( `../controllers/Vehiculo.controller.php?operacion=getResumenTipoCombustible`)
        .then(respuesta => respuesta.json())
        .then(datos => {
          // console.log(datos);
          grafico.data.labels = datos.map(registro => registro.tipocombustible);
          grafico.data.datasets[0].data = datos.map(registro => registro.total);
          grafico.update();
        })
        .catch(e => {
          console.error(e);
        })
    })();
  </script>
</body>

</html>