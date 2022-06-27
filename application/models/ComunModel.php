<?php 
    class ComunModel extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

  public function insertarDatosTabla($data,$tabla) {
            $query = $this->db->insert($tabla, $data);
            if ($this->db->affected_rows()>0){
            return 1;
            }
            else
            {
            return 0;
            }
  }

  public function dar_login($username,$password){
            $qry="SELECT u.password,u.id_usuario,u.nombre_usuario AS usuario,
                                u.id_privilegio 
                                FROM
                                usuario u 
                                WHERE u.nombre_usuario='$username' AND u.password='$password'";
            $res = $this->db->query($qry);
              $resultado = $res->row();

            if (isset($resultado)){
               
                $username = $resultado->usuario;    
                $id_user  = $resultado->id_usuario;    
                $password = $resultado->password;    
                $tipo_usuario = $resultado->id_privilegio;    
                $this->session->set_userdata('usuario',$username);
                $this->session->set_userdata('id_usuario',$id_user);
                $this->session->set_userdata('pass',$password);
                $this->session->set_userdata('tipo_usuario',$tipo_usuario);
                return 1;  
            }else{
                return 0;
           }
   }


   function datoUsuarioLogin($usuario){      
            $query = "SELECT u.nombre, u.apellido, u.grado, g.abreviatura FROM usuarios u LEFT JOIN grados g on g.id_grado=u.grado WHERE username = '$usuario'";
            $query = $this->db->query($query);
            return $query->result();
   }

   function darUltimoRegistro($campo,$tabla){      
            $query = "SELECT MAX($campo) AS ultimo_registro FROM $tabla";
            $query = $this->db->query($query);
            return $query->result();
   }

   function verificarContrasena($usuario,$pass){  
     $qry = "SELECT id_usuario FROM usuario WHERE id_usuario='$usuario' AND password ='$pass'";
     $res = $this->db->query($qry);
     //echo $this->db->last_query();
     $resultado = $res->row();
     if (isset($resultado)){
        return 1;  
     }else{
          return 0;
     }
   }


    public function eliminar($data,$tabla) {
             $query = $this->db->delete($tabla, $data);
                //echo $this->db->last_query();die;
            if ($this->db->affected_rows()>0){
            return true;
            }
            else
            {
            return false;
            }
  }

  public function eliminarLimiteGasto() {
            
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaHoy = date("Y-m-d");
        $query = "DELETE FROM limite_gasto WHERE hasta <= '$fechaHoy' ";
        $query = $this->db->query($query);
      if ($this->db->affected_rows()>0){
            return true;
            }
            else
            {
            return false;
            }
  }

  public function darMontoLugar(){
    $query = "SELECT 
                  SUM(md.monto) AS monto,
                  l.nombre,
                  l.img 
                FROM
                  movimiento_det md 
                  RIGHT JOIN lugar l 
                    ON md.id_lugar = l.id_lugar 
                    WHERE l.activo=1
                   GROUP BY l.id_lugar ";
    $query = $this->db->query($query);
    return $query->result();
  }

  public function darUltimoMovEnc(){
    $query = "SELECT MAX(id_movimiento_enc)AS id_movimiento_enc FROM movimiento_enc";
    $query = $this->db->query($query);
    return $query->result();
  }

  public function darGastosPorCategoria($desde,$hasta){
    $query= "SELECT 
              SUM(monto*-1) AS monto,
              c.nombre AS categoria 
            FROM
              movimiento_det md 
              INNER JOIN movimiento_enc me 
                ON md.id_movimiento_enc = me.id_movimiento_enc 
                INNER JOIN categoria c ON md.id_categoria=c.id_categoria
               WHERE me.tipo_movimiento = 2 AND me.fecha_movimiento BETWEEN $desde AND $hasta GROUP BY c.id_categoria ORDER BY monto DESC";
                $query = $this->db->query($query);
    return $query->result();
  }  
  
  public function darGastosMensualesPorCategoria(){
      $query= "SELECT
          md.id_categoria,c.nombre AS categoria,  ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '1' THEN md.monto ELSE 0 END))  AS Enero,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '2' THEN md.monto ELSE 0 END))  AS Febrero,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '3' THEN md.monto ELSE 0 END)) AS Marzo,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '4' THEN md.monto ELSE 0 END))   AS Abril,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '5' THEN md.monto ELSE 0 END))  AS Mayo,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '6' THEN md.monto ELSE 0 END))   AS Junio,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '7' THEN md.monto ELSE 0 END))   AS Julio,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '8' THEN md.monto ELSE 0 END))   AS Agosto,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '9' THEN md.monto ELSE 0 END))  AS Septiembre,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '10' THEN md.monto ELSE 0 END))  AS Octubre,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '11' THEN md.monto ELSE 0 END ))  AS Noviembre,
            ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '12' THEN md.monto ELSE 0 END)) AS Diciembre 
          FROM
            movimiento_enc me INNER JOIN movimiento_det md ON me.id_movimiento_enc = md.id_movimiento_enc INNER JOIN categoria c ON c.id_categoria= md.id_categoria
          WHERE
            1 = 1
            AND DATE_FORMAT( me.fecha_movimiento, '%Y' ) = 2022 AND  me.tipo_movimiento = 2 GROUP BY id_categoria";
                $query = $this->db->query($query);
         //   echo $this->db->last_query();
        return $query->result();
    }    

    public function darGastosMensuales(){
             $query= "SELECT
              ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '1' THEN md.monto ELSE 0 END ))  AS Enero,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '2' THEN md.monto ELSE 0 END ))  AS febrero,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '3' THEN md.monto ELSE 0 END )) AS Marzo,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '4' THEN md.monto ELSE 0 END ))   AS Abril,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '5' THEN md.monto ELSE 0 END ))  AS Mayo,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '6' THEN md.monto ELSE 0 END ))   AS Junio,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '7' THEN md.monto ELSE 0 END ))   AS Julio,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '8' THEN md.monto ELSE 0 END ))   AS Agosto,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '9' THEN md.monto ELSE 0 END ))  AS Septiembre,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '10' THEN md.monto ELSE 0 END ))  AS Octubre,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento) WHEN '11' THEN md.monto ELSE 0 END ))  AS Noviembre,
              ABS(SUM( CASE MONTH ( me.fecha_movimiento ) WHEN '12' THEN md.monto ELSE 0 END )) AS Diciembre 
            FROM
               movimiento_enc  me INNER JOIN movimiento_det md ON me.id_movimiento_enc = md.id_movimiento_enc
            WHERE
              1 = 1 
              AND DATE_FORMAT( me.fecha_movimiento, '%Y' ) = 2022 AND  me.tipo_movimiento = 2 ";
                $query = $this->db->query($query);
        return $query->result();
    }
   
    public function darGastosTotal($desde,$hasta){
      $query= "SELECT 
                SUM(monto*-1) AS total
              FROM
                movimiento_det md 
                INNER JOIN movimiento_enc me 
                  ON md.id_movimiento_enc = me.id_movimiento_enc 
                  INNER JOIN categoria c ON md.id_categoria=c.id_categoria
                 WHERE me.tipo_movimiento = 2 AND me.fecha_movimiento BETWEEN $desde AND $hasta";
                  $query = $this->db->query($query);
            //  echo $this->db->last_query();
      return $query->result();
   }  

   public function darNombreCategoria($id_cat){
      $query= "SELECT nombre from categoria where id_categoria='$id_cat'";
                $query = $this->db->query($query);
      return $query->result();
   }

   public function darNombreLugar($id_lugar){
    $query= "SELECT nombre from lugar where id_lugar='$id_lugar' and activo=1";
    $query = $this->db->query($query);
     //  echo $this->db->last_query();
    return $query->result();
   }
  
}
?>