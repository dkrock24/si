<?php
class Paquete_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const articulo = 'reserva_articulo';
    const paquete = 'reserva_paquete';

    function get_all_articulos( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::paquete.' as paquete' );
        $this->db->join( self::sucursal.' as s', ' on paquete.Sucursal = s.id_sucursal' );
        $this->db->join( self::estados.' as estados', ' on estados.id_reserva_estados = paquete.estado_reserva_paquete' );
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
        $this->db->where('paquete.Sucursal', $this->session->usuario[0]->Sucursal. ' '. $filter);
        $this->db->from( self::paquete.' as paquete');
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear($paquete){

        $imagen="";
        $imageProperties="";
        if (!empty($_FILES['imagen_paquete']['tmp_name'])) {
            $imagen = @file_get_contents($_FILES['imagen_paquete']['tmp_name']);
            $imageProperties = @getimageSize($_FILES['imagen_paquete']['tmp_name']);
        }

        $paquete['imagen_paquete'] = @$imagen;
        $paquete['imagen_tipo'] = @$imageProperties['mime'];

        $paquete['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $insert = $this->db->insert(self::paquete, $paquete);  
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_paquete($paquete){
    	$this->db->select('*');
        $this->db->from( self::paquete.' as paquete');
        $this->db->join( self::sucursal.' as s', ' on paquete.Sucursal = s.id_sucursal' );
        $this->db->where('paquete.id_reserva_paquete', $paquete );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_paquete_lista(){
    	$this->db->select('*');
        $this->db->from( self::paquete.' as paquete');
        $this->db->join( self::sucursal.' as s', ' on paquete.Sucursal = s.id_sucursal' );
        $this->db->where('paquete.estado_reserva_paquete', 7 );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($paquete){

        if (!empty($_FILES['imagen_paquete']['tmp_name'])) {
            $imagen = @file_get_contents($_FILES['imagen_paquete']['tmp_name']);
            $imageProperties = @getimageSize($_FILES['imagen_paquete']['tmp_name']);

            $paquete['imagen_paquete'] = @$imagen;
            $paquete['imagen_tipo'] = @$imageProperties['mime'];
        } else {
            unset($paquete['imagen_paquete']);
            unset($paquete['imagen_tipo']);
        }
        $id_reserva_paquete = $paquete['id_reserva_paquete'];
        unset($paquete['id_reserva_paquete']);

        $paquete['habitacion']      = isset($paquete['habitacion']) ? 1 : 0;
        $paquete['estadia_paquete'] = isset($paquete['estadia_paquete']) ? 1 : 0;
        $paquete['comida_paquete']  = isset($paquete['comida_paquete']) ? 1 : 0;
        $paquete['solo_imagen']     = isset($paquete['solo_imagen']) ? 1 : 0;

    	$this->db->where('id_reserva_paquete', $id_reserva_paquete);
        $result = $this->db->update(self::paquete, $paquete);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function get_articulos(){;
        $this->db->select('*');
        $this->db->from( self::paquete.' as paquete' );
        $this->db->join( self::sucursal.' as s', ' on paquete.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function eliminar($paquete)
    {
        $this->db->where('id_reserva_paquete', $paquete);  
        $result = $this->db->delete(self::paquete);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}
