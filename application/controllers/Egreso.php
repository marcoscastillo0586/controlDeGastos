<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Egreso extends CI_Controller {
		   public function __construct(){
        parent::__construct();
              $this->load->model('ComunModel','c',true);
              $this->load->model('EgresoModel','e',true);
              $this->load->model('TopeGastoModel','t',true);
        }
	public function index()
	{
				$datos['lugares']   = $this-> darLugaresCardHtml();
				$datos_page['page']   = $this->load->view('egreso/body',$datos, true);
		    $this->load->view('menu/header');
		    $this->load->view('egreso/header');
		    $this->load->view('menu/body',$datos_page, false);
		    $this->load->view('menu/footer');
		    $this->load->view('egreso/footer');
	}

	public function cargarImagenLugarNuevo()
	{
		if (($_FILES["image"]["type"] == "image/pjpeg")|| ($_FILES["image"]["type"] == "image/jpeg")|| ($_FILES["image"]["type"] == "image/png")|| ($_FILES["image"]["type"] == "image/gif")) 
		{
			
			$check = getimagesize($_FILES["image"]["tmp_name"]);
    		//print_r($_FILES);
    		if($check !== false){
        		$image = $_FILES["image"]["tmp_name"];
				// Extensión de la imagen
					$type = pathinfo($image, PATHINFO_EXTENSION);
			 	// Cargando la imagen
					$data = file_get_contents($image);

				// Decodificando la imagen en base64
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				// Mostrando la imagen
				echo $base64;
			
			}else{ echo 0;}

			
		} else { echo 0;}
	}
	
	public function guardarLugarNuevo()
	{
		$nombreLugar = $_POST['nombre'];
		$check = getimagesize($_FILES["image"]["tmp_name"]);
   	$image = $_FILES["image"]["tmp_name"];
			// Extensión de la imagen
		$type = pathinfo($image, PATHINFO_EXTENSION);
		 	// Cargando la imagen
		$data = file_get_contents($image);
			// Decodificando la imagen en base64
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

   		$campo['nombre'] = $nombreLugar;
  		$campo['img'] = $base64;
        $table = 'lugar';
        $guardar_lugar = $this->c->insertarDatosTabla($campo,$table);
 		if ($guardar_lugar) {
			echo $base64;
		}else{ echo 0;}
	}

	public function darLugaresCardHtml(){
      $res = $this->e->darLugares();
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

  public function darCategoria(){
  	$res = $this->e->darCategoria();
    $html='<option></option>}';
	    foreach ($res as $key => $value) {
	    	if ($value->id_categoria!==1 ){
	      			$html.='<option value="'.$value->id_categoria.'">'.$value->nombre.'</option>';
	      	}
	    }
      return $html;
  }

  public function darCategoriasJS(){
    $res = $this->e->darCategoria();
    $html='<option></option>';
    foreach ($res as $key => $value) {
    	if (($value->id_categoria !=='1') && ($value->id_categoria !=='2')){
    		$html.='<option value="'.$value->id_categoria.'">'.$value->nombre.'</option>';
    	}
    }
    	echo json_encode($html);
  }
  public function guardarGasto(){
	    $lugar  = $_POST['id_lugar'];
	    $gasto  = $_POST['gasto'];
     	$control=1;
     		$tipo_movimiento = '2';
	   		$concepto  = $_POST['concepto'];
				$fecha = $_POST['fecha'];
					//acomodo la fecha 
					$f = explode("/",$fecha);
   			  $fecha_movimiento = $f[2]."-".$f[1]."-".$f[0];
        $guardar_movimiento_enc = $this->e->guardarMovimiento_enc($tipo_movimiento,$concepto,$fecha_movimiento);
			if ($guardar_movimiento_enc==1) {
					$ultimoMovimiento = $this->c->darUltimoMovEnc();  
			    $mov_det['id_movimiento_enc'] = $ultimoMovimiento[0]->id_movimiento_enc;
			    $table = 'movimiento_det';
				foreach ($gasto as $key => $value) {
			      $mov_det['monto'] = $value['monto']*-1;
			      $mov_det['id_lugar'] = $lugar;
			      $mov_det['id_categoria'] = $value['categoria'];
			      $insertar_mov_det = $this->c->insertarDatosTabla($mov_det,$table);
						if ($insertar_mov_det==0){$control=0;}
					}
			}
			echo json_encode($control);		
  }    

  public function verificarLimiteGasto(){
    $lugar  = $_POST['id_lugar'];
    $gasto  = $_POST['gasto'];
   	$control=1;
   		$fecha = $_POST['fecha'];
				//acomodo la fecha 
				$f = explode("/",$fecha);
 			  $fecha_movimiento = $f[2]."-".$f[1]."-".$f[0];
      $limiteCategoria = $this->t->consultarLimiteCategoria();
			$categorias='';
      foreach ($verificar_categoria_gasto as $value) {
      	$categorias.= $value->categoria.',';  
  		}
				$categorias = substr($categorias, 0, -1); 
      	$arrayCategorias = explode(',', $categorias);
		if ($limiteCategoria==1) {
				$ultimoMovimiento = $this->c->darUltimoMovEnc();  

		    $mov_det['id_movimiento_enc'] = $ultimoMovimiento[0]->id_movimiento_enc;
		   
		    $table = 'movimiento_det';
			foreach ($gasto as $key => $value) {
		      $mov_det['monto'] = $value['monto']*-1;
		      $mov_det['id_lugar'] = $lugar;
		      $mov_det['id_categoria'] = $value['categoria'];
		      $insertar_mov_det = $this->c->insertarDatosTabla($mov_det,$table);
					
					if ($insertar_mov_det==0){$control=0;}
				}
		}
		echo json_encode($control);		
  }

  public function guardarCategoria(){
      
      $data['nombre'] = $_POST['categoria'];
      $table = 'categoria';
      $guardar_actividad = $this->c->insertarDatosTabla($data,$table);
      echo $guardar_actividad;
  }

	public function consultarSaldo(){
		$monto 					 = $_POST['monto'];
		$lugar 					 = $_POST['id_lugar'];
	  $saldoDisponible  = $this->e->consultarSaldo($lugar);	   
		if ($saldoDisponible[0]->disponible >= $monto){
			echo 1;
		}else{
			echo 0;
		}
	}
}