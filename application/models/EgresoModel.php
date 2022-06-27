<?php 
class EgresoModel extends CI_Model {
    public function __construct() {parent::__construct();}

  public function darLugares(){
    $query = "SELECT id_lugar,nombre,img FROM lugar where activo=1";
    $query = $this->db->query($query);
    return $query->result();
  }  
  
  public function consultarSaldo($lugar){
    $query = "SELECT SUM(md.monto) AS disponible FROM movimiento_det md WHERE id_lugar = '$lugar'";
    $query = $this->db->query($query);
          //  echo $this->db->last_query();
    return $query->result();
  }

  public function darCategoria(){
    $query = "SELECT id_categoria,nombre FROM categoria";
    $query = $this->db->query($query);
          //  echo $this->db->last_query();
    return $query->result();
  }

  public function guardarMovimiento_enc($tipo_movimiento,$concepto,$fecha_movimiento){
   $this->db->trans_begin();
       $mov_enc['tipo_movimiento']    =  $tipo_movimiento;
       $mov_enc['concepto']           =  $concepto;
       $mov_enc['fecha_movimiento']   =  $fecha_movimiento;
       $table='movimiento_enc';
       $insertar_mov_enc = $this->c->insertarDatosTabla($mov_enc,$table);
       
   if ($this->db->trans_status() === FALSE){      
      //Hubo errores en la consulta, entonces se cancela la transacción.   
      $this->db->trans_rollback();      
      return 0;    
    }else{      
         //Todas las consultas se hicieron correctamente.  
         $this->db->trans_commit();    
         return 1;    
    }  

  }
}