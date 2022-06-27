<h5>Limite de Gastos</h5>
<hr/>
<div id="principal">
  <form id="formPrincipal">
    <div class="form-row ml-5 mr-5" style="justify-content: center;">
      <label class="text-success f-5" for="">Limite de Gastos es el monto maximo para una determinada categoria en un determinado tiempo, 
        nos mostrara un aviso cuando este proximo a alcanzar el limite indicado, 
        podremos asignar un limite de gastos por semana o por mes, ademas, tendra la posibilidad de seleccionar un limite por categoria para poder tener un mejor seguimientos de los gastos.  </label>
    </div>
    <br>
    <div class="form-row ml-5 mr-5" style="justify-content: space-around;">
    <div class="form-group col-md-2">
      <label for="montoIngresar">Desde </label>
          <input class="form-control" type="text" id="from" name="from">
    </div>
    <div class="form-group col-md-2">
      <label for="concepto">Hasta </label>
  <input class="form-control" type="text" id="to" name="to">
    </div>
     
      <div class="form-group col-md-2">
        <label> Limite de Gasto </label>
        <input type="number" class="form-control press montoIngresar" id="montoIngresar" placeholder="">
      </div>
      
      <div class="form-group col-md-3">
        <label> Categoria  </label>
      <select class="form-control text-uppercase press cmbcategoria" name="categoria[]" multiple="multiple" id="cmbcategoria">
      </select>` 
      </div>
    </div>

  </form>
</div>
<form>
  <div class="float-right mr-5">
    <button type="button" class="btn btn-outline-success" id="btnRegistrarLimite"> Registrar Limite </button>
  </div>
<br>
<h4>  ¿ En que lugar/es desea aplicar el Limite de gasto ? </h4>
<br>
  <div class="row row-cols-1 row-cols-md-3 divLugares" >
    <?php echo($lugares)?>
  </div> 
  <br> 
  <div  style="position: relative;width: 100%;bottom: 1px;"> 
<div class="float-right mr-5">
    <button type="button" class="btn btn-outline-success" id="btnRegistrarGasto">Registrar Gasto</button>
    </div>
  </div>
</form>




<!-- Modal --> 
<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">



</div>


</div><!-- div que cierra el main del body menu-->
<script>
function noPunto(event){
  
    var e = event || window.event;
    var key = e.keyCode || e.which;

    if ( key === 110 || key === 190) {     
        
       e.preventDefault();     
    }
}
</script>