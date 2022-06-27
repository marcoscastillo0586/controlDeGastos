<h5>Registro de Ingresos</h5>
<hr/>
<form>
     <div class="form-row ml-5 mr-5" style="justify-content: center;">
        <div class="form-group col-md-4">
        <label for="concepto"> Fecha</label>
            <input type="text" id="from" name="from" class="form-control text-uppercase">
      </div>

    <div class="form-group col-md-3">
      <label for="concepto">Concepto</label>

      <input type="text" class="form-control" id="concepto" placeholder="Procedencia del ingreso">
    </div>
        <div class="form-group col-md-4">
      <label for="montoIngresar">Monto a Ingresar </label>
      <input type="text" class="form-control" id="montoIngresar" placeholder="Utilice un punto solo para los decimales">
    </div>

  </div>

<br>
<h4>  ¿ Donde desea realizar el ingreso ? </h4>
<br>
  <div class="row row-cols-1 row-cols-md-3 divLugares" >
    <?php echo($lugares)?>
  </div> 
  <br> 
  <div  style="position: relative;width: 100%;bottom: 1px;"> 
    <p class="lead">
      Si no existe el lugar donde desea realizar el ingreso, puedes crear uno desde <span id="altaLugar" role="button" class="badge rounded-pill color-success bg-dark text-light"> Aqui </span>
    </p>
<div class="float-right mr-5">
    <button type="button" class="btn btn-outline-success" id="btnGuardarIngreso">Guardar Ingreso</button>
    </div>
  </div>
</form>
<!-- Modal --> 
<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

</div>


</div><!-- div que cierra el main del body menu-->