<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TopeGasto extends CI_Controller {
		   public function __construct(){
        parent::__construct();
              $this->load->model('ComunModel','c',true);
              $this->load->model('TopeGastoModel','t',true);
        }
	public function index()
	{
				$datos['lugares']   = $this-> darLugaresCardHtml();
				$datos_page['page']   = $this->load->view('topeGasto/body',$datos, true);
		    $this->load->view('menu/header');
		    $this->load->view('topeGasto/header');
		    $this->load->view('menu/body',$datos_page, false);
		    $this->load->view('menu/footer');
		    $this->load->view('topeGasto/footer');
	}

	public function darLugaresCardHtml(){
	  $res = $this->t->darLugares();
	  $html='';
	  foreach ($res as $key => $value) {
	  	$html.='
	  				<summary class="col md-2" style="display:flex; justify-content:center;">
							<div class="card imgCard" style="width: 10rem;" data-imgLugar="'.$value->id_lugar.'" data-nombreLugar="'.$value->nombre.'">
	  						<img src="'.$value->img.'" class="card-img-top" alt="'.$value->nombre.'">
	  						<div class="card-body"> 
	    						<h5 class="card-title">'.$value->nombre.'</h5>
	  						</div>
							</div>
						</summary>';
	  }
	  	return $html;
    }

    public function darCategoriasJS(){
      $res = $this->t->darCategoria();
      $html='<option></option>';
      foreach ($res as $key => $value) {
      	if (($value->id_categoria !=='1') && ($value->id_categoria !=='2')){
      		$html.='<option value="'.$value->id_categoria.'">'.$value->nombre.'</option>';
      	}
      }
      	echo json_encode($html);
    }




    public function guardarLimiteGasto(){
    	//SELECT * FROM limite_gasto WHERE desde <= '2022-03-1' AND hasta >= '2022-03-1' AND categoria LIKE '%3%' AND lugar LIKE'%2%'

	    $desdeSF      = $_POST['desde'];
	    $hastaSF      = $_POST['hasta'];
	    $monto      	= $_POST['monto'];
	    $lugar      	= $_POST['lugar'];
	    $categoria  	= $_POST['categoria'];
     	$control=1;
    
					//acomodo la fecha desde
					$d = explode("/",$desdeSF);
   			  $desde = $d[2]."-".$d[1]."-".$d[0];
					
					//acomodo la fecha hasta
					$h = explode("/",$hastaSF);
   			  $hasta = $h[2]."-".$h[1]."-".$h[0];
   			
   			  $data['desde']= $desde;
   			  $data['hasta']= $hasta;
   			  $data['monto_limite']= $monto;
   			  $data['categoria']= $categoria;
   			  $data['lugar']= $lugar;
   			  $table='limite_gasto';	
        $guardar_limite_gasto = $this->c->insertarDatosTabla($data,$table);
				if ($guardar_limite_gasto!==1){$control=0;}
				echo json_encode($control);		
    }
  public function verificarCatLim()
  {
	    $desdeSF      = $_POST['desde'];
	    $hastaSF      = $_POST['hasta'];
	    $control=1;
					//acomodo la fecha desde
					$d = explode("/",$desdeSF);
   			  $desde = $d[2]."-".$d[1]."-".$d[0];
					
					//acomodo la fecha hasta
					$h = explode("/",$hastaSF);
   			  $hasta = $h[2]."-".$h[1]."-".$h[0];
   		
          $verificar_categoria_gasto = $this->t->consultarLimiteCategoria();
        		$categorias='';
        			foreach ($verificar_categoria_gasto as $value) {$categorias.= $value->categoria.',';  }
							$categorias = substr($categorias, 0, -1); 
  						$arrayCategorias = explode(',', $categorias);
				 	    $categorias = $this->t->darCategoriaRestringidas($arrayCategorias);
					    $html='<option></option>';
							foreach ($categorias as $key => $value){
	  		    		$html.='<option value="'.$value->id_categoria.'">'.$value->nombre.'</option>';
					    }
				echo json_encode($html);
  }
}