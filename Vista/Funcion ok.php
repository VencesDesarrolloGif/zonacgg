function pruasadeba(){
     $.ajax({
        type: "POST",
        url: "ajax_ObtenerDatoscxdzEncuestas.php",
        data:{},
        dataType: "json",
        success: function(response) {
         var titulo = [];
         var cantidad = [];
         var prueba1= response;
         for (var i = 0; i < prueba1.length; i++) {
           titulo.push(prueba1[i]["nombreDocumento"]);
           cantidad.push(prueba1[i]["idDocumento"]);
             
         }

          var ctx = document.getElementById('GraficaXReclutadorSupervisor');
          var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: titulo,
                  datasets: [{
                      label: '# of Votes',
                      data: cantidad,
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(255, 206, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'Blue'
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero: true
                          }
                      }]
                  }
              }
          });

        },
       
    });
    document.getElementById("GraficaGRAL").style.display = "none";
    document.getElementById("GraficaXReclutadorSupervisor").style.display = "block";

}