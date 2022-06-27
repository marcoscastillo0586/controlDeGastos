<h5>Registro de Gastos</h5>
<hr/>
<div id="principal">
  <form id="formPrincipal">
    <div class="form-row ml-5 mr-5" style="justify-content: center;">
      <div class="form-group col-md-3">
        <label for="concepto"> Fecha</label>
            <input type="text" id="from" name="from" class="form-control text-uppercase">
      </div>
      
      <div class="form-group col-md-3">
        <label for="concepto"> Concepto </label>
        <input type="text" class="form-control text-uppercase" id="concepto" placeholder="Motivo del Gasto">
      </div>   
      
     
      <div class="form-group col-md-2">
        <label> Monto a Debitar </label>
        <input type="number" class="form-control press montoIngresar" id="montoIngresar_0" placeholder="">
      </div>
      
      <div class="form-group col-md-4">
        <label> Categoria  </label>
          <a href="#" class="badge badge-light agregarCategoria pt-2" style="height: 20px;"> Agregar una Categor&iacute;a Nueva</a>
      <select class="form-control text-uppercase press cmbcategoria" name="categoria" id="cmbcategoria_0">
                           
                </select>` 
      </div>
      
      <div class="form-group col-md-3" style="display: flex;align-items: center;">
          <button type="button" class="btn btn-link agregarRenglon" disabled > Agregar Rengl&oacute;n </button>
      </div>
    </div>

    
  </form>
</div>
<form>
  <div class="float-right mr-5">
    <button type="button" class="btn btn-outline-success" id="btnRegistrarGasto"> Registrar Gasto </button>
  </div>

<br>
<h4>  ¿ De donde desea realizar el d&eacute;bito ? </h4>
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