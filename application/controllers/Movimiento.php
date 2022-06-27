<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Movimiento extends CI_Controller {
		   public function __construct(){
        parent::__construct();
              $this->load->model('ComunModel','c',true);
              $this->load->model('MovimientoModel','m',true);
        }
	public function index()
	{
  	$datos_page['page']   = $this->load->view('movimiento/body','', true);
    $this->load->view('menu/header');
    $this->load->view('movimiento/header');
    $this->load->view('menu/body',$datos_page, false);
    $this->load->view('menu/footer');
    $this->load->view('movimiento/footer');
	}

	public function darMovimientos(){
  	if (isset($_POST['desde'])) {
	 	 $desde = $_POST['desde'];
		 $hasta = $_POST['hasta'];
		 $movimientos = $this->m->darMovimientosFecha($desde,$hasta);
		}else{$movimientos = $this->m->darMovimientos();}
		
    $movimientosDetalle = $this->m->darMovimientosDetalle();
    $renglon=''; 
    $html='';
    foreach ($movimientos as $key => $value){
      $f = explode("-",$value->fecha);
      $fecha = $f[2]."-".$f[1]."-".$f[0];
	  	$key++;
	  	$html.='<tr>
            	<th scope="row">'.$key.'</th>
            	<td>'.$fecha.'</td>
            	<td>'.$value->lugar.'</td>
            	<td>'.$value->concepto.'</td>';
      $detalle='';
      $ultimoRenglon='';
      foreach ($movimientosDetalle as $keyDet => $valueDet){ 
        if ($value->id_movimiento_enc == $valueDet->movimiento){ 
          $ultimoRenglon='<td>'.$value->monto.' <i class="fas fa-angle-double-down mostrarmas" style="cursor: pointer;" data-id='.$value->id_movimiento_enc.'></i><i class="fas fa-angle-double-up mostrarmas up_'.$value->id_movimiento_enc.'" style="cursor: pointer;display:none" "></i></td>';
          $detalle.='
                    <tr class="mitdoculto_'.$value->id_movimiento_enc.' bg-warning" style="display: none;">
                    	<td></td>
                    	<td></td>
                    	<td>CATEGORIA</td>
                    	<td>'.$valueDet->categoria.'</td>
                    	<td>'.$valueDet->monto.'</td>
                    </tr>';
        }
      }
      if (empty($detalle)){$ultimoRenglon='<td>'.$value->monto.'</td>';}else{$ultimoRenglon.=$detalle;}
        $html.=$ultimoRenglon;
		}       
	   echo $html;
	}

}
