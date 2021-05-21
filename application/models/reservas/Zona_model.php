<?php
class Zona_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const zona = 'reserva_zona';

    function get_all_articulos( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::zona.' as zona' );
        $this->db->join( self::sucursal.' as s', ' on zona.Sucursal = s.id_sucursal' );
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
        $this->db->where('zona.Sucursal', $this->session->usuario[0]->Sucursal. ' '. $filter);
        $this->db->from( self::zona.' as zona');
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear($zona){

        if(isset($zona['evento'])){
            $zona['evento'] = 1;
        }

        $zona['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $insert = $this->db->insert(self::zona, $zona);  
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_articulo($zona){
    	$this->db->select('*');
        $this->db->from( self::zona.' as zona');
        $this->db->join( self::sucursal.' as s', ' on zona.Sucursal = s.id_sucursal' );
        $this->db->where('zona.id_reserva_zona', $zona );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_eventos_lista($empresa_id){
        $this->db->select('*');
        $this->db->from( self::zona.' as zona');
        $this->db->join( self::sucursal.' as s', ' on zona.Sucursal = s.id_sucursal' );
        $this->db->where('s.Empresa_Suc', $empresa_id );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($zona){

        if(isset($zona['evento'])){
            $zona['evento'] = 1;
        } else {
            $zona['evento'] = 0;
        }

    	$this->db->where('id_reserva_zona', $zona['id_reserva_zona']);  
        $result = $this->db->update(self::zona, $zona);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar($id)
    {
        $this->db->where('id_reserva_zona', $id);  
        $result = $this->db->delete(self::zona);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    public function get_zona_sucursal()
    {
        $this->db->select('*');
        $this->db->from( self::zona.' as zona' );
        $this->db->join( self::sucursal.' as s', ' on zona.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
       
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}
