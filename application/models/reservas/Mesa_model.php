<?php
class Mesa_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const mesa = 'reserva_mesa';

    function get_all_articulos( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::mesa.' as mesa' );
        $this->db->join( self::sucursal.' as s', ' on mesa.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filter){
        $this->db->where('habitacion.Sucursal', $this->session->usuario[0]->Sucursal. ' '. $filter);
        $this->db->from( self::mesa.' as habitacion');
        $result = $this->db->count_all_results();
        return $result;
    }

    public function get_mesa_sucursal()
    {
        $this->db->select('*');
        $this->db->from( self::mesa.' as mesa' );
        $this->db->join( self::sucursal.' as s', ' on mesa.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
       
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function crear($mesa){

        $mesa['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $numero_mesa = (int) $mesa['numero_mesa'];
        $incrementar = (int) $mesa['incrementar'];
        $cc = 1;
        $incremento_mesa = $mesa['codigo_mesa'];
        unset($mesa['numero_mesa']);
        unset($mesa['incrementar']);

        for($cc = 1; $cc <= $numero_mesa; $cc++) {
            if ($incrementar == 1) {
                $mesa['codigo_mesa'] = $incremento_mesa;
            }
            $insert = $this->db->insert(self::mesa, $mesa);
            $incremento_mesa++;
        }

        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_mesa($mesa){
    	$this->db->select('*');
        $this->db->from( self::mesa.' as mesa');
        $this->db->join( self::sucursal.' as s', ' on mesa.Sucursal = s.id_sucursal' );
        $this->db->where('mesa.id_reserva_mesa', $mesa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($habitacion){

    	$this->db->where('id_reserva_mesa', $habitacion['id_reserva_mesa']);  
        $result = $this->db->update(self::mesa, $habitacion);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar($id)
    {
        $this->db->where('id_reserva_mesa', $id);  
        $result = $this->db->delete(self::mesa);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}
