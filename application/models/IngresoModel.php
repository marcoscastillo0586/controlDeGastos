<?php 
class IngresoModel extends CI_Model {
    public function __construct() {parent::__construct();}

  public function darLugares(){
    $query = "SELECT id_lugar,nombre,img FROM lugar where activo=1";
    $query = $this->db->query($query);
    return $query->result();
  }  


    
}