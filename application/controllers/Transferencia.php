<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transferencia extends CI_Controller {
	public function __construct(){
  	parent::__construct();
    $this->load->model('ComunModel','c',true);
    $this->load->model('TransferenciaModel','t',true);
	}

	public function index()
	{
				$datos['lugarOrigen']   = $this-> darLugarOrigen();
				$datos_page['page']   = $this->load->view('transferencia/body',$datos, true);
		    $this->load->view('menu/header');
		    $this->load->view('transferencia/header');
		    $this->load->view('menu/body',$datos_page, false);
		    $this->load->view('menu/footer');
		    $this->load->view('transferencia/footer');
	}

	public function darLugarOrigen(){
      $res = $this->t->darLugaresTransferencia();
      $html='<option></option>';
      foreach ($res as $key => $value) {
      	$html.='<option  value="'.$value->id_lugar.'">'.$value->nombre.'</option>';
      }
      	return $html;
  }

  public function darLugarOrigenJS(){
  	$res = $this->t->darLugaresTransferencia();
    $id_seleccion = $_POST['lugarSeleccionado'];
    $html='<option></option>';
	    foreach ($res as $key => $value) {
				if ($id_seleccion==$value->id_lugar) {
      		$html.='<option  style="text-decoration:line-through;background-color:#EAECF4" value="'.$value->id_lugar.'"disabled>'.$value->nombre.'</option>';
				}
				else{
      		$html.='<option style="cursor:pointer" value="'.$value->id_lugar.'">'.$value->nombre.'</option>';
				}
      }
  	echo json_encode($html);
  }

  public function guardarTransferencia(){
    $control=1;
	  date_default_timezone_set('America/Argentina/Buenos_Aires');
    $concepto 					 = $_POST['concepto'];
    $fecha_transferencia = date("Y-m-d");
    $guardar_movimiento_enc  = $this->t->guardarTransferencia($concepto,$fecha_transferencia);	   

    if ($guardar_movimiento_enc==1) {
        $monto= $_POST['montotransferir'];
        $ultimoMovimiento = $this->c->darUltimoMovEnc();  
        $mov_det_ingreso['id_movimiento_enc'] = $ultimoMovimiento[0]->id_movimiento_enc;
        $mov_det_ingreso['monto']     			  = $monto;
        $mov_det_ingreso['id_lugar']          = $_POST['id_destino'];
        $mov_det_ingreso['id_categoria']      = '1';
        $table = 'movimiento_det';
        $insertar_mov_det_ingreso = $this->c->insertarDatosTabla($mov_det_ingreso,$table);
        
        if ($insertar_mov_det_ingreso==1){
          $mov_det_egreso['id_movimiento_enc'] = $ultimoMovimiento[0]->id_movimiento_enc;
          $mov_det_egreso['monto']             = $monto*-1;
          $mov_det_egreso['id_lugar']          = $_POST['id_origen'];
          $mov_det_egreso['id_categoria']      = '1';
          $table = 'movimiento_det';
          $insertar_mov_det_egreso = $this->c->insertarDatosTabla($mov_det_egreso,$table);
          
            if ($insertar_mov_det_egreso==0){$control=0;}
        }else{$control=0;}
    }else{ $control=0;} 
    echo json_encode($control); 
  }

  public function consultarSaldo(){
    $monto 					 = $_POST['montotransferir'];
    $lugar 					 = $_POST['id_lugar'];
    $saldoDisponible  = $this->t->consultarSaldo($lugar);	   
   if ($saldoDisponible[0]->disponible >= $monto){
    	echo 1;
    }else{
    	echo 0;
    }
  }
}
