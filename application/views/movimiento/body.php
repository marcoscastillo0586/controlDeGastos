<h4>Historial de Movimientos</h4>
<hr/>
<form>
     <div class="form-row ml-5 mr-5" style="justify-content: center;">
    <div class="form-group col-md-4">
      <label for="montoIngresar">Desde </label>
          <input type="text" id="from" name="from">
    </div>
    <div class="form-group col-md-3">
      <label for="concepto">Hasta</label>
  <input type="text" id="to" name="to">
    </div>
    <div class="form-group col-md-3" style="display: flex;align-items: center;justify-content: center;">
      
    <button type="button" class="btn btn-outline-success" id="btnBuscar" disabled>Buscar</button>
    </div>
    
  </div>
  
<br>
<h5>  Ultimos Movimientos </h5>
<br>
<div class="container">
<table class="table table-striped table-bordered">
  <thead class="text-center bg-success text-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Fecha</th>
      <th scope="col">Lugar</th>
      <th scope="col">Concepto</th>
      <th scope="col">Monto</th>
    </tr>
  </thead>
  <tbody class="text-dark">
  </tbody>
</table>
</div>
</form>
</div><!-- div que cierra el main del body menu-->