<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
		   public function __construct(){
        parent::__construct();
          $this->load->model('ComunModel','c',true);
          $this->load->model('TopeGastoModel','t',true);
        }
	public function index()
	{
		$this->eliminarLimiteGastos();
 	  $datos['montoLugares']   = $this->c->darMontoLugar();
		$total=0;
		foreach($datos['montoLugares'] as $key => $value){
		$total+=$value->monto;
			$value->monto = $this->your_money_format($value->monto);
		}
		$datos['sumaTotal']= $total;
		$datos_page['page'] = $this->load->view('dashboard/body',$datos, true);
		$this->load->view('menu/header');
		$this->load->view('menu/body',$datos_page, false);
		$this->load->view('dashboard/footer');
		$this->load->view('menu/footer');
	}

	function your_money_format($value) {
  return '$' . number_format( $value,$decimals = 2,$dec_point = ",",$thousands_sep = ".");
 }
	
	public function darGraficoCategoria(){
				$mes = $_POST['mes'];
 
				if ($mes=="mesActual"){
					$desde = "(SELECT DATE_ADD(CURDATE(), INTERVAL - DAY(CURDATE()) + 1 DAY))";
					$hasta = "(SELECT LAST_DAY(CURDATE()))";
				}

				if ($mes=='mesAnterior') {
				  $desde = "  (SELECT DATE_ADD( CURDATE() - DAY(CURDATE()) + 1, INTERVAL - 1 MONTH)) ";
					$hasta = "(SELECT  LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH))) ";
				}	

				if ($mes=='ultimosDos') {
				  $desde = "(select date_add(curdate()-day(curdate())+1,interval -1 month)) ";
					$hasta = "(SELECT LAST_DAY(CURDATE())) ";
				}

				$categorias= $this->c->darGastosPorCategoria($desde,$hasta);
				$totalDeGasto= $this->c->darGastosTotal($desde,$hasta);
				$datos['categorias']=array();
				$datos['monto']=array();
				$datos['color']=array();
				$datos['colorHover']=array();
				$pos=0;
				foreach ($categorias as $key => $value) {
			 		$paletaColores = array('#FF0303','#FF4C03','#FF4C03','#FF7903','#FF9803','#FFD103','#FFE003','#FFF703','#FBFF03','#E8FF03','#C6FF03','#AFFF03','#81FF03','#5FFF03','#0BFF03','#03FF1A','#03FFC2','#03FBFF','#0338FF','#1A03FF');
			 	  $datos['color'][].= $paletaColores[$key];
			 	  $datos['colorHover'][].= $paletaColores[$key];
				  $sumador = round((20/count($categorias))); 
					$pos = $pos+$sumador;
					$datos['categorias'][].=$value->categoria;
					$datos['monto'][].=$value->monto;
				}
				$datos['totalConsumo']= $totalDeGasto[0]->total;
				 echo json_encode($datos);
	}	
	public function darGraficoMensual(){
		$datos= $this->c->darGastosMensualesPorCategoria();
	  echo json_encode($datos);
	}

	public function eliminarLimiteGastos(){$res = $this->c->eliminarLimiteGasto();}

  public function darGraficoLimitesGasto(){
		$limitesDeGastos= $this->t->consultarLimiteGasto();
	  $datos = new stdClass();
	  $renglones = array();
		foreach ($limitesDeGastos as $key => $value) {
			$lugares = explode(",",$value->lugar);	
			$categorias = explode(",",$value->categoria);	
			$nombreCategorias ='';
			$nombreLugares ='';
			
			for ($i=0; $i < count($categorias); $i++){ 
				$nombreCategoria = $this->c->darNombreCategoria($categorias[$i]);
				$nombreCategorias.=$nombreCategoria[0]->nombre.', ';	
			}
			$value->nombreCategoria = substr($nombreCategorias, 0, -2); 

			for ($i=0; $i < count($lugares); $i++){ 
				$id_lugar = $lugares[$i];
				$nombreLugar = $this->c->darNombreLugar($id_lugar);
				$nombreLugares.=$nombreLugar[0]->nombre.', ';	
			}
			$value->nombreLugar = substr($nombreLugares, 0, -2); 
			$desde = $value->desde; 
	    $hasta = $value->hasta; 
	    $lugar = $value->lugar; 
	    $categoria = $value->categoria; 

			$consumo_actual = $this->t->darConsumoDesdeHasta($desde,$hasta,$lugares,$categorias);

	    $monto_limite 				=   $value->monto_limite;
			$monto_consumo_actual = 	$consumo_actual[0]->monto;
			$resto = $monto_limite-$monto_consumo_actual;	
			$porcentaje = bcdiv( ($monto_consumo_actual*100)/$monto_limite, '1', 2);
			
					$value->monto_consumo_actual = $monto_consumo_actual;
					$value->monto_limite = $monto_limite;
					$value->resto = $resto;
					$value->porcentaje = $porcentaje;
		}
				echo json_encode($limitesDeGastos);
	}
}
