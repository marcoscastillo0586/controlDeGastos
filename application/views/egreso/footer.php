  <!-- Jquery STEP-->
   <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/jquery-ui/jquery-ui.css">

<script src="<?=base_url()?>/assets/vendor/jquery-ui/jquery-ui.js"></script>
    <style>   .card:hover{background-color: #099a9f;color: #fff;}   .imgCard{background-color: #fff;margin:5px;padding:5px;}   .imgCard-selected{border: 6px solid #099a9f;margin:5px;padding:5px;}    </style>
<script>
$(document).ready(function(){
$("#from").datepicker({ dateFormat: "dd/mm/yy" }).datepicker("setDate", "0");
$( function() {
      var dateFormat = "dd/mm/yy",
      from = $( "#from" ).datepicker({
        closeText: 'Cerrar',
        setDate:new Date(),
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
         // defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
 
    function getDate( element ) { var date; try {date = $.datepicker.parseDate( dateFormat, element.value );} catch( error ) { date = null;} return date;}});

  cargarCategoria();
  $(document).on("click",".imgCard",function(){
    //comprobamos si existe una imagen seleccionada
    if ( $( ".imgCard" ).hasClass( "imgCard-selected" ) ) {
      /*en el caso que exista ya una imagen seleccionada la eliminamos para que únicamente solo se tenga una imagen seleccionada*/
      $(".imgCard").removeClass("imgCard-selected");
    }
      //añadimos la clase de la imagen seleccionada
    $(this).addClass("imgCard-selected");
  });


////////////   AGREGAR CATEGORIA /////////////////////
  $(document).on("click",".agregarCategoria",function(){
    $('div .modal').html(`
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-info text-white text-center p-2">
            <p class="modal-title text-center" id="staticBackdropLabel">Categoria Nueva</p>
          </div>
          
          <div class="modal-body"><br>
            <label>Nombre Categoria</label>
            <input type="text" class="form-control" id="nuevaCategoria" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">Ingrese un nombre para la nueva categoria</small>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btncancelar" data-dismiss="modal">Cancelar</button>
            <button id="btnConfirmarCategoria" type="button" class="btn btn-primary">Confirmar Categoria</button>
          </div>
        </div>
      </div>`);
      $('#modal').modal("show");
  });

  var cantRenglones = 0;
        ////////////   AGREGAR RENGLON /////////////////////
  $(document).on("click",".agregarRenglon",function(){
    cantRenglones++;
    var url = '<?php echo(base_url());?>Egreso/darCategoriasJS';
    $.post(url).done(function(resp){
      var res= JSON.parse(resp);
      var cmb=`<select class="form-control text-uppercase press cmbcategoria"  name="categoria" id="cmbcategoria_`+cantRenglones+`">
                `+res+`
              </select>`
      $('#principal form').append(`
          <div class="form-row ml-5 mr-5" >
             <div class="form-group col-md-3" style="top: 2.25em;text-align: end;">
              <i class="fas fa-trash text-danger fs-1 eliminar"style="cursor:pointer;"></i>
            </div>
            <div class="form-group col-md-3">
              <label for="montoIngresar"> Monto a Debitar </label>
              <input type="number" class="form-control press montoIngresar" id="montoIngresar_`+cantRenglones+`" placeholder="">
            </div>
            <div class="form-group col-md-3">
              <label for="concepto"> Categoria </label>
                          `+cmb+`            
            </div>
        </div>
     `);
     $(".agregarRenglon").prop("disabled","disabled");
    });
  });

  $('#formPrincipal').on("change",".press",function(){ 
    var form = $(this).parents("form#formPrincipal ");
        check = checkCampos(form);
        if(check) {$(".agregarRenglon").prop("disabled", false);}
        else {$(".agregarRenglon").prop("disabled", "disabled");}
  })

  //Función para comprobar los campos de texto
  function checkCampos(obj) {
    var inputRellenados = true;
    var selectRellenados = true;
    obj.find("input").each(function(){
      var $this = $(this);
      if ( $this.hasClass('press')){if( $this.val().length <= 0  ) {inputRellenados = false;}}
    });

    obj.find("select").each(function(){
    var $this = $(this);
      if ($this.hasClass('press')){if($this.find('option:selected').text()=='') {selectRellenados = false;}}
    });

    if( inputRellenados == false || selectRellenados == false ){return false;}else {return true;}
  }

  $(document).on("click","#btnConfirmarCategoria",function(){
    var categoria = $('#nuevaCategoria').val();
        datos= {categoria:categoria};
        url = '<?php echo(base_url());?>Egreso/guardarCategoria';
        $.post(url,datos).done(function(resp){
          if (resp==1){
            $('div .modal').html(`
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-info text-white text-center p-2">
                      <p class="modal-title text-center " id="staticBackdropLabel">Nueva Categoria</p>
                    </div>
                    
                    <div class="modal-body"><br>
                      <div class="form-group">
                              <label class="text-primary" >Alta De Categoria Exitosa.</label>
                      </div>
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btncancelar" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
            </div>`);
            cargarCategoria();
            $('#modal').modal("show");
            $('#montoIngresar').val('');
            $('#concepto').val('');
            $('#cmbcategoria :selected').val('');
            $( ".imgCard-selected" ).removeClass('imgCard-selected');
          }else{ alert('Algo salio mal');}
        });
  });

  function cargarCategoria(){
    url = '<?php echo(base_url());?>Egreso/darCategoriasJS';
    $.post(url).done(function(resp){
      var res= JSON.parse(resp); 
        $('#cmbcategoria_0').html(res);
    });
  }

            /////BTN DE REGISTRAR GASTO //////
  $(document).on("click","#btnRegistrarGasto",function(){
    if( $(".imgCard").hasClass("imgCard-selected") && $('#concepto').val()) 
    {
      var arrayMonto = [];
          arrayCategoria = [];
          arrayNomCat = [];
          objNomCat = {};
          objMonto = {};
          objCategoria = {};
          comprobante = '1';
          /* Obtenemos todos los tr del Body*/
          renglones = $("#formPrincipal").find('.form-row');
          $("form#formPrincipal").find(".montoIngresar").each(function(){
            var $thisMonto = $(this);
              if ($thisMonto.hasClass('montoIngresar')){
                monto = $thisMonto.val();  
              }
              if (monto==''){
                comprobante='0';
                   }else{
                    objMonto = {monto:monto};  
                    arrayMonto.push(objMonto);
                   }
                });

                $("form#formPrincipal").find(".cmbcategoria").each(function(){
                  var $thisCategoria = $(this);
                  if ($thisCategoria.hasClass('cmbcategoria')){
                    catId = $thisCategoria.attr("id");  
                    categoria = $("#"+catId+" option:selected").text();
                  }
                  if (categoria==''){
                    comprobante='0';
                   }else{
                    objCategoria = {categoria:categoria};  
                    arrayCategoria.push(objCategoria);
                   }
                });
                var montoTotal=0;
                for (var i = 0; i < arrayMonto.length; i++){
                    var montoParcial = arrayMonto[i].monto;
                        montoTotal = montoTotal+parseFloat(montoParcial);
      
                }; 

                for (var i = 0; i < arrayCategoria.length; i++){
                 arrayNomCat+= arrayCategoria[i].categoria+', ';
      
                };
                 nombreCategoria = arrayNomCat.substring(0, arrayNomCat.length -2);
            if (comprobante=='0'){
                $('div .modal').html(`
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header bg-info text-white text-center p-2">
                        <p class="modal-title text-center " id="staticBackdropLabel">Datos Ingresados</p>
                      </div>
                      
                      <div class="modal-body"><br>
                        <div class="form-group">
                          <h3 class="text-danger" >Debe Completar Todos Los Datos.</h3>
                        </div>
                      </div>
                      
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btncancelar" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                </div>`);
                $('#modal').modal("show");
            }else
            {
              var concepto      = $('#concepto').val();
              id_lugar      = $(".imgCard-selected").attr('data-imglugar');
              nombreLugar   = $(".imgCard-selected").attr('data-nombreLugar');
              datos         = {monto:montoTotal,id_lugar:id_lugar};
              url           = '<?php echo(base_url());?>Egreso/consultarSaldo';
              $.post(url,datos).done(function(resp){
              if ( resp==1){
                $('div .modal').html(`
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header bg-info text-white text-center p-2">
                        <p class="modal-title text-center " id="staticBackdropLabel">Datos a Debitar</p>
                      </div>
                      <div class="modal-body">
                      <br>
                      <div class="form-group ">  
                          <label class="text-primary" for="imgLugarNuevo">Monto: $`+montoTotal+`</label>
                      </div>
                      <div class="form-group">
                              <label class="text-primary" for="imgLugarNuevo">Concepto: `+concepto+`</label>
                      </div>
                      <div class="form-group">
                              <label class="text-primary" for="imgLugarNuevo">Categoria/s: `+nombreCategoria+`</label>
                      </div>
                      <div class="form-group">
                              <label class="text-primary" for="imgLugarNuevo">Lugar de Debito: `+nombreLugar+`</label>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btncancelar" data-dismiss="modal">Cancelar</button>
                      
                      <button id="btnConfirmarGasto" type="button" class="btn btn-primary">Confirmar Gasto</button>
                    </div>
                  </div>
                </div>`);
                $('#modal').modal("show");
              }else{
                  $('div .modal').html(`
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header bg-info text-white text-center p-2">
                          <p class="modal-title text-center " id="staticBackdropLabel">Datos de Debito</p>
                        </div>
                        
                        <div class="modal-body"><br>
                          <div class="form-group">
                            <h3 class="text-danger" >No dispone de $`+montoTotal+` en `+nombreLugar+`.</h3>
                          </div>
                        </div>
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btncancelar" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                  </div>`);
                  $('#modal').modal("show");
              }
            });
            }
    }else{

                $('div .modal').html(`    
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header bg-info text-white text-center p-2">
                    <p class="modal-title text-center " id="staticBackdropLabel">Faltan Datos </p>
                  </div>  
          
                  <div class="modal-body"><br>
                    <div class="form-group">
                            <label class="text-primary" >Debe completar Todos Los campos</label>
                    </div>
                  </div>
          
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnFinalizarRegistro" data-dismiss="modal">Cerrar</button>
                  </div>
              </div>
            </div>`);
             $('#modal').modal("show");
    }
  });


    /////BTN DE CONFIRMAR GASTO //////
  $(document).on("click","#btnConfirmarGasto",function(){
         

         var  totalRegistros=0;
              arrayGasto=[];
              objGasto = {}; 
              var arrayMonto = [];
          arrayCategoria = []; 
          $("form#formPrincipal").find(".montoIngresar").each(function(){
            totalRegistros++;
            var $thisMonto = $(this);
              if ($thisMonto.hasClass('montoIngresar')){
                monto = $thisMonto.val();  
              }
              if (monto==''){
                comprobante='0';
                   }else{
                    objMonto = {monto:monto};  
                    arrayMonto.push(objMonto);
                   }
          });

                $("form#formPrincipal").find(".cmbcategoria").each(function(){
                  var $thisCategoria = $(this);
                  if ($thisCategoria.hasClass('cmbcategoria')){
                    catId = $thisCategoria.attr("id");  
                    categoria = $("#"+catId+" option:selected").val();
                  }
                  if (categoria==''){
                    comprobante='0';
                   }else{
                    objCategoria = {categoria:categoria};  
                    arrayCategoria.push(objCategoria);
                   }
                });
   
   for (var i = 0; i < arrayMonto.length; i++){
    var gastoMonto = arrayMonto[i].monto;
          gastoCategoria = arrayCategoria[i].categoria;   
          objGasto = { monto:gastoMonto,categoria:gastoCategoria };
          arrayGasto.push(objGasto); 
   }

                var montoTotal=0;
                for (var i = 0; i < arrayMonto.length; i++){
                    var montoParcial = arrayMonto[i].monto;
                        montoTotal = montoTotal+parseFloat(montoParcial);
                }; 
      var concepto      = $('#concepto').val();
          id_lugar      = $(".imgCard-selected" ).attr('data-imglugar');
          
            fecha = $("#from").val();
            if (fecha=''){
                  $("#from").datepicker({ dateFormat: "dd/mm/yy" }).datepicker("setDate", "0");
                   fecha = $("#from").val();
            }else{
                   fecha = $("#from").val();
            }
          

          datos = {concepto:concepto,id_lugar:id_lugar,gasto:arrayGasto,fecha:fecha};
          url = '<?php echo(base_url());?>Egreso/guardarGasto';
      $.post(url,datos).done(function(resp){
        
     /*     datos = {gasto:arrayGasto,fecha:fecha};
          url = '<?php echo(base_url());?>Egreso/guardarGasto';
      $.post(url,datos).done(function(resp){
        });*/
        

        if (resp==1){
            $('div .modal').html(`    
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header bg-info text-white text-center p-2">
                    <p class="modal-title text-center " id="staticBackdropLabel">Datos Ingresados</p>
                  </div>  
          
                  <div class="modal-body"><br>
                    <div class="form-group">
                            <label class="text-primary" >El Gasto Se Registro De Manera Exitosa.</label>
                    </div>
                  </div>
          
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnFinalizarRegistro" data-dismiss="modal">Cerrar</button>
                  </div>
              </div>
            </div>`);
             $('#modal').modal("show");
             $('#montoIngresar').val('');
             $('#concepto').val('');
             $('#cmbcategoria :selected').val('');
             $( ".imgCard-selected" ).removeClass('imgCard-selected');
          }else{alert('Algo salio mal');    }
        });
  })


  // Evento que selecciona la fila y la elimina 
  $(document).on("click",".btnFinalizarRegistro",function(){

    $('#formPrincipal').trigger("reset");
    $('.card').removeClass("imgCard-selected");
  });
  $(document).on("click",".eliminar",function(){
        //selecciono el elemento padre, el elemento padre es quien contine al elemento que deseo eliminar
    $(this).closest('.form-row').remove();
    $(".agregarRenglon").prop("disabled", false);
        //reccorro el formulario principal para encontrar todos los input con la clase press y validar susu datos
    $("form#formPrincipal").find("input").each(function(){
      var $this = $(this);
        if ($this.hasClass('press')){
          if($this.val().length <= 0 ){
            $this.closest('.form-row').remove();
          }
        }
    }); 

    $("form#formPrincipal").find("select").each(function(){
      var $this = $(this);
        if ($this.hasClass('press')){
          if($this.find('option:selected').text()=='') {
            $this.closest('.form-row').remove();
          }
        }
    });
  });

});
</script>