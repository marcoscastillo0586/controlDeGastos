<?php 
class MovimientoModel extends CI_Model {
    public function __construct() {parent::__construct();}

  public function darMovimientos(){
        $query="SET lc_time_names = 'es_ES';";
        $query = $this->db->query($query);
        $query = "SELECT
              md.id_movimiento_enc,l.nombre as lugar, 
           DATE_FORMAT(me.fecha_movimiento,'%Y-%m-%d') AS fecha,   
              me.concepto,
              SUM(md.monto) as monto 
              FROM
                movimiento_enc me 
                INNER JOIN movimiento_det md 
                  ON me.id_movimiento_enc = md.id_movimiento_enc INNER JOIN lugar l ON md.id_lugar=l.id_lugar GROUP BY  md.id_movimiento_enc order by fecha DESC LIMIT 30";
    
    $query = $this->db->query($query);
    return $query->result();
  }  
    public function darMovimientosDetalle(){
                $query="SET lc_time_names = 'es_ES';";
                $query = $this->db->query($query);
            $query = "SELECT
                        md.id_movimiento_enc AS movimiento, 
                        DATE_FORMAT(me.fecha_movimiento,'%Y-%m-%d') AS fecha,
                      me.concepto,
                      cat.nombre AS categoria,
                      SUM(md.monto) AS monto 
                    FROM
                      movimiento_enc me 
                      INNER JOIN movimiento_det md 
                        ON me.id_movimiento_enc = md.id_movimiento_enc 
                        INNER JOIN categoria cat ON cat.id_categoria=md.id_categoria
                    GROUP BY md.id_movimiento_det  ORDER BY fecha DESC
                    LIMIT 30";
            $query = $this->db->query($query);
            return $query->result();
  }  

  public function darMovimientosFecha($desde,$hasta){
        $query="SET lc_time_names = 'es_ES';";
        $query = $this->db->query($query);
      $query = "SELECT 
               md.id_movimiento_enc,l.nombre as lugar, DATE_FORMAT(me.fecha_movimiento,'%Y-%m-%d') AS fecha,   
              me.concepto,
              SUM(md.monto) as monto
              FROM
                movimiento_enc me 
                INNER JOIN movimiento_det md 
                  ON me.id_movimiento_enc = md.id_movimiento_enc INNER JOIN lugar l ON md.id_lugar=l.id_lugar WHERE fecha_movimiento BETWEEN '$desde' AND '$hasta'  GROUP BY  md.id_movimiento_enc ORDER BY fecha DESC";

    $query = $this->db->query($query);
                //  echo $this->db->last_query();
    return $query->result();
  }  


    
}