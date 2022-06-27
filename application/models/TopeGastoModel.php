<?php 
class TopeGastoModel extends CI_Model {
  public function __construct() {parent::__construct();}

  public function darLugares(){
    $query = "SELECT id_lugar,nombre,img FROM lugar where activo=1";
    $query = $this->db->query($query);
    return $query->result();
  }  

  public function darCategoria(){
   $query = "SELECT id_categoria,nombre FROM categoria WHERE id_categoria<>1 AND id_categoria<>2";
   $query = $this->db->query($query);
         //  echo $this->db->last_query();
   return $query->result();
  } 
 
  public function consultarLimiteCategoria(){
    //$query = "SELECT categoria FROM limite_gasto WHERE desde <= '$desde' AND hasta >= '$hasta'";
    $query = "SELECT categoria FROM limite_gasto";
    $query = $this->db->query($query);
          //  echo $this->db->last_query();
    return $query->result();
  }

  public function consultarLimiteGasto(){
    $query = "SELECT id_limite_gasto,desde,hasta,monto_limite,categoria,lugar FROM limite_gasto";
    $query = $this->db->query($query);
          //  echo $this->db->last_query();
    return $query->result();
  }

  public function darConsumoDesdeHasta($desde,$hasta,$lugar,$categoria){
    $contadorLugar = count($lugar);
    $lugares = ' AND ( ';
    if($contadorLugar == 1){ $lugares.="md.id_lugar = '$lugar[0]')";}
    else{ 
        foreach ($lugar as $key => $valueLugar){
          $key=$key+1;
          if( $key < $contadorLugar){ $lugares.="md.id_lugar = '$valueLugar' OR ";}
          else{ $lugares.="md.id_lugar = '$valueLugar')";}
          }
      }
    
    $contadorCategoria = count($categoria);
    
    $categorias= ' AND ( ';

if($contadorCategoria == 1){ $categorias.="md.id_categoria = '$categoria[0]')";}
      else{ 
          foreach ($categoria as $key => $valueCategoria){
            $key=$key+1;
            if( $key < $contadorCategoria){ $categorias.="md.id_categoria = '$valueCategoria' OR ";}
            else{
              $categorias.="md.id_categoria = '$valueCategoria') ";
            }
          }
      }

    $query = "SELECT SUM(md.monto*-1) AS monto 
              FROM movimiento_det md INNER JOIN movimiento_enc me ON md.id_movimiento_enc=me.id_movimiento_enc 
              WHERE me.fecha_movimiento >= '$desde' AND 
              me.fecha_movimiento <= '$hasta' AND
              me.tipo_movimiento ='2' $categorias $lugares";
   $query = $this->db->query($query);
          //echo $this->db->last_query();
   return $query->result();
  }

  public function darCategoriaRestringidas($excluir){
    $consulta='AND';
    $contador = count($excluir);
    foreach ($excluir as $key => $value) {
      $key=$key+1;
      if($key < $contador) {
        $consulta.=" id_categoria<>'$value' AND";
      }
       else{
         if($key==$contador){
          $consulta.=" id_categoria<>'$value'";
         }
       }
    }
   $query= "SELECT id_categoria,nombre FROM categoria WHERE id_categoria<>1 AND id_categoria<>2 $consulta";
   $query = $this->db->query($query);
         // echo $this->db->last_query();
   return $query->result();
  } 

}