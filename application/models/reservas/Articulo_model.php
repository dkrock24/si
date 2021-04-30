<?php
class Articulo_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const articulo = 'reserva_articulo';

    function get_all_articulos( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::articulo.' as articulo' );
        $this->db->join( self::sucursal.' as s', ' on articulo.Sucursal = s.id_sucursal' );
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
        $this->db->where('articulo.Sucursal', $this->session->usuario[0]->Sucursal. ' '. $filter);
        $this->db->from( self::articulo.' as articulo');
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear($articulo){

        $articulo['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $insert = $this->db->insert(self::articulo, $articulo);  
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_articulo($articulo){
    	$this->db->select('*');
        $this->db->from( self::articulo.' as articulo');
        $this->db->join( self::sucursal.' as s', ' on articulo.Sucursal = s.id_sucursal' );
        $this->db->where('articulo.id_reserva_articulo', $articulo );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($articulo){

    	$this->db->where('id_reserva_articulo', $articulo['id_reserva_articulo']);  
        $result = $this->db->update(self::articulo, $articulo);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function get_articulos(){;
        $this->db->select('*');
        $this->db->from( self::articulo.' as articulo' );
        $this->db->join( self::sucursal.' as s', ' on articulo.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    

    function eliminar($id)
    {
        $this->db->where('id_reserva_articulo', $id);  
        $result = $this->db->delete(self::articulo);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}
