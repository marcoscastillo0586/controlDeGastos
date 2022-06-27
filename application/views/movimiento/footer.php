<link rel="stylesheet" href="<?=base_url()?>/assets/vendor/jquery-ui/jquery-ui.css">
<script src="<?=base_url()?>assets/vendor/jquery/jquery.js"></script>
<script src="<?=base_url()?>/assets/vendor/jquery-ui/jquery-ui.js"></script>
<script>
$(document).ready(function(){
darMovimientos();
function darMovimientos(){
   var url = '<?php echo(base_url());?>/Movimiento/darMovimientos';
     $.post(url).done(function(resp){
      $('table tbody').html(resp);
    });

}
    $( function() {
      var dateFormat = "dd/mm/yy",
      from = $( "#from" ).datepicker({
        closeText: 'Cerrar',
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
        }).on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
          to.datepicker( "option", "disabled", false );
   if($("#from").datepicker("getDate") === null || $("#to").datepicker("getDate") === null) { 
               $("#btnBuscar").prop("disabled", "disabled");
      }else{ 
          $("#btnBuscar").prop("disabled", false);
      }

        }),
      to = $( "#to" ).datepicker({
        closeText: 'Cerrar',
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
        numberOfMonths: 1,
        disabled :true
      }).on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      if($("#from").datepicker("getDate") === null || $("#to").datepicker("getDate") === null) { 
               $("#btnBuscar").prop("disabled", "disabled");
      }else{ 
          var desde = $.datepicker.formatDate('yy-mm-dd', from.datepicker("getDate"));
          var hasta = $.datepicker.formatDate('yy-mm-dd', to.datepicker("getDate"));
          $("#btnBuscar").prop("disabled", false);
      }
      });
 
    function getDate( element ) { var date; try {date = $.datepicker.parseDate( dateFormat, element.value );} catch( error ) { date = null;} return date;}});
    

    $(document).on("click","#btnBuscar",function(){
      var desde = $.datepicker.formatDate('yy-mm-dd', $( "#from" ).datepicker("getDate"));
      var hasta = $.datepicker.formatDate('yy-mm-dd', $( "#to" ).datepicker("getDate"));
      var datos = {desde:desde,hasta:hasta};
     var url = '<?php echo(base_url());?>/Movimiento/darMovimientos';
     $.post(url,datos).done(function(resp){
      $('table tbody').html(resp);
    });
  });
  $(document).on("click",".mostrarmas",function(){
    var id = $(this).data('id');
      $(".mitdoculto_"+id).toggle();
  });

});
</script>