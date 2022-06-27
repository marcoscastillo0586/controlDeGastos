<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ingreso extends CI_Controller {
		   public function __construct(){
        parent::__construct();
              $this->load->model('ComunModel','c',true);
              $this->load->model('IngresoModel','i',true);
        }
	public function index()
	{
				$datos['lugares']   = $this-> darLugaresCardHtml();
				$datos_page['page']   = $this->load->view('ingreso/body',$datos, true);
		    $this->load->view('menu/header');
		    $this->load->view('ingreso/header');
		    $this->load->view('menu/body',$datos_page, false);
		    $this->load->view('menu/footer');
		    $this->load->view('ingreso/footer');
	}

	public function cargarImagenLugarNuevo()
	{
		if (($_FILES["image"]["type"] == "image/pjpeg")|| ($_FILES["image"]["type"] == "image/jpeg")|| ($_FILES["image"]["type"] == "image/png")|| ($_FILES["image"]["type"] == "image/gif")) 
		{
			
			$check = getimagesize($_FILES["image"]["tmp_name"]);
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
      $res = $this->i->darLugares();
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

  public function darLugaresCardJS(){
      $res = $this->i->darLugares();
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
      	echo json_encode($html);
  }

  public function guardarIngreso(){
	  date_default_timezone_set('America/Argentina/Buenos_Aires');
	  $data_mov_enc['tipo_movimiento'] = 1;
	  $data_mov_enc['concepto'] = $_POST['concepto'];
 		$fecha = $_POST['fecha'];
		$f = explode("/",$fecha);
	  $data_mov_enc['fecha_movimiento'] = $f[2]."-".$f[1]."-".$f[0];
	  $table = 'movimiento_enc';
	  $guardar_movimiento_enc = $this->c->insertarDatosTabla($data_mov_enc,$table);
	  
	  if ($guardar_movimiento_enc == 1){
		  $ultimo_id_guardado = $this->c->darUltimoRegistro("id_movimiento_enc","movimiento_enc");
		  $id_movimiento_enc = $ultimo_id_guardado[0]->ultimo_registro;
		  $data_mov_det['id_movimiento_enc'] = $id_movimiento_enc;
		  $data_mov_det['monto'] = $_POST['monto'];
	  	$data_mov_det['id_lugar'] = $_POST['id_lugar'];
	 		$table = 'movimiento_det';
	 	  $guardar_movimiento_det = $this->c->insertarDatosTabla($data_mov_det,$table);
		 echo $guardar_movimiento_det;
	  }
	  else echo 0;

  }

}
