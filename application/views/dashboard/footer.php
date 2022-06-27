    <!-- Page level plugins -->
    <script src="<?=base_url()?>assets/vendor/chart.js/Chart.min.js"></script>
    <script src="<?=base_url()?>assets/vendor/chart.js/Chart.js"></script>
    <!-- Page level custom scripts -->
    <script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script>
$(document).ready(function(){
   graficoConsumo('mesActual');
   graficoLimiteGastos();
   gastoMensual();
 $(document).on("click",".consumoCategoria",function(){
          var id = $(this).data('id');
          graficoConsumo(id);

 })

      var ctx = document.getElementById("myPieChart");
      var ctx2 = document.getElementById("myPieChart2");

    function graficoConsumo(valor){


      if (window.grafica) {
          window.grafica.clear();
           window.grafica.destroy();
      }
     datos={mes:valor}
     url = '<?php echo(base_url());?>Login/darGraficoCategoria';

      $.post(url,datos).done(function(resp){
       var res= JSON.parse(resp); 
       const labelsCategorias = res.categorias.map(function(e){return e;});
       const labelsMonto = res.monto.map(function(e){return e;});
       const labelColor = res.color.map(function(e){return e;});
       const labelColorHover = res.colorHover.map(function(e){return e;});
      if (res.categorias.length>0){ 
            $('#totalconsumo').html('<strong>TOTAL DE CONSUMO: '+res.totalConsumo+'</strong')
          window.grafica = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: labelsCategorias,
              datasets: [{
                data: labelsMonto,
                backgroundColor:labelColor ,
                hoverBackgroundColor: labelColorHover,
              }],
            },
            options: {
              maintainAspectRatio: false,
              tooltips: {
                backgroundColor: "rgb(255,255,225)",
                bodyFontColor: "#000",
                borderColor: '#000',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: true,
                caretPadding: 10,
              },
              legend: {
                display: true
              },
              cutoutPercentage: 5,
            },
          });  
             }
        else{     
             window.grafica = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: ['Sin Datos'],
              datasets: [{
                data: 100,
                backgroundColor:'#000',
                hoverBackgroundColor: '#000',
              }],
            },
    
            options: {
              maintainAspectRatio: false,
              tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 0,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
              },
              legend: {display: true},
              cutoutPercentage: 80,

            },
          });
        }
      });
    } 

    function gastoMensual(){
      if (window.grafica) {
          window.grafica.clear();
           window.grafica.destroy();
      }
      url = '<?php echo(base_url());?>Login/darGraficoMensual';
      $.post(url).done(function(resp){
      var res= JSON.parse(resp); 


var Colorbackground = ['rgba(255, 99, 132, 0.5)','rgba(255, 159, 64, 0.5)','rgba(255, 205, 86, 0.5)','rgba(75, 192, 192, 0.5)','rgba(54, 162, 235, 0.5)','rgba(153, 102, 255, 0.5)','rgba(201, 203, 207, 0.5)','rgba(255, 99, 132, 0.5)','rgba(255, 159, 64, 0.5)','rgba(255, 205, 86, 0.5)','rgba(75, 192, 192, 0.5)','rgba(54, 162, 235, 0.5)','rgba(153, 102, 255, 0.5)','rgba(201, 203, 207, 0.5)']
var Colorborder = ['rgb(255, 99, 132)','rgb(255, 159, 64)','rgb(255, 205, 86)','rgb(75, 192, 192)','rgb(54, 162, 235)','rgb(153, 102, 255)','rgb(201, 203, 207)','rgb(255, 99, 132)','rgb(255, 159, 64)','rgb(255, 205, 86)','rgb(75, 192, 192)','rgb(54, 162, 235)','rgb(153, 102, 255)','rgb(201, 203, 207)']
const labels = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','diciembre',];
const data = {
  labels: labels,
  datasets: []
};
const config = {
  type: 'bar',
  data: data,
  options: {
      responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  const gastoMensual = new Chart(
    document.getElementById('graficoMensual'),
    config
  );
   
   res.forEach( function(valor, indice, array) {
    gastoMensual.data.datasets.push({
    label: valor.categoria,
    data: [valor.Enero,valor.Febrero,valor.Marzo,valor.Abril,valor.Mayo,valor.Junio,valor.Julio,valor.Agosto,valor.Septiembre,valor.Octubre,valor.Noviembre,valor.Diciembre],
    backgroundColor: [Colorbackground[indice]],
    borderColor: [Colorborder[indice]],
    borderWidth: 1
  });
      gastoMensual.update(); 
 });

      });

    }

function graficoLimiteGastos(){
  url = '<?php echo(base_url());?>Login/darGraficoLimitesGasto';
  $.post(url).done(function(resp){
   var res = JSON.parse(resp); 
       html='';
       color='';
       excedente= '';
    if(res!==0){
    
  $.each(res, function(i, item){
 
    if(item.porcentaje <= 25){
        color='info';
    }
     if(item.porcentaje > 25 && item.porcentaje < 50){
        color='success';
    }

    if(item.porcentaje >= 50 && item.porcentaje < 75 ){
    color="warning";
    }

    if(item.porcentaje >= 75){
      color='danger';
      
    }
     if(item.porcentaje > 100){
      color='danger';
      excedente= 'Excedente: '+(item.resto*-1).toFixed(2);
    }

    html+= `<h6 class=" font-weight-bold">Lugar: `+item.nombreLugar+` <br>
              Categoria: `+item.nombreCategoria+`<br>Limite: `+item.monto_limite+`<br>Consumo Actual: `+item.monto_consumo_actual+`<br>`+excedente+` <span class="float-right">`+item.porcentaje+`%</span>
            </h6>
            <div class="progress mb-4">
              <div class="progress-bar bg-`+color+`" role="progressbar" style="width: `+item.porcentaje+`%"
                aria-valuenow="`+item.porcentaje+`" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>`;
  })
  $('#limitesGastos .card-body').html(html);
    }
   }); 
}

})
</script>
