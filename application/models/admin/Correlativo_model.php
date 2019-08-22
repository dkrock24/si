<?php
class Correlativo_model extends CI_Model {

	const correlativos =  'pos_correlativos';
    const empleado =  'sys_empleado';
    const sucursal =  'pos_sucursal';
    const documento =  'pos_tipo_documento';

    

	function get_correlativo_sucursal(){
        $this->db->select('*');
        $this->db->from(self::correlativos.' as c');
        $this->db->join(self::sucursal.' as s', 'on c.Sucursal = s.id_sucursal');
        //$this->db->where('s.Empresa_Suc',$this->session->empresa[0]->Empresa_Suc);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_by_id( $sucursal ){
        $this->db->select('*');
        $this->db->from(self::correlativos.' as c');
        $this->db->where('c.Sucursal', $sucursal);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getCorrelativos( $limit, $id ){
        $this->db->select('*');
        $this->db->from(self::correlativos.' as c');
        $this->db->join(self::sucursal.' as s',' on c.Sucursal = s.id_sucursal');   
        $this->db->join(self::documento.' as d',' on c.TipoDocumento = d.id_tipo_documento');  
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::correlativos);
        $this->db->where('s.Empresa_Suc',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::correlativos.' as c');
        $this->db->join(self::sucursal.' as s',' on c.Sucursal = s.id_sucursal');
        $result = $this->db->count_all_results();
        return $result;
    }

    function save( $correlativos ){

        $data = array(
            'valor_inical' => $correlativos['valor_inical'],
            'valor_final' => $correlativos['valor_final'],
            'siguiente_valor' => $correlativos['siguiente_valor'],
            'fecha_creacion' => date("Y-m-d H:i:s"),
            'prefix' => $correlativos['prefix'],
            'Sucursal' => $correlativos['Sucursal'],
            'TipoDocumento' => $correlativos['TipoDocumento'],
            'numero_de_serire' => $correlativos['numero_de_serire'],            
            'correlativo_estado' => $correlativos['correlativo_estado'],
        );

        $this->db->insert(self::correlativos, $data );
    }

    function editar( $correlativos_id ){

        $this->db->select('*');
        $this->db->from(self::correlativos.' as c');
        $this->db->join(self::sucursal.' as s',' on c.Sucursal = s.id_sucursal');   
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->where('c.id_correlativos', $correlativos_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update( $correlativos ){

        $data = array(
            'valor_inical' => $correlativos['valor_inical'],
            'valor_final' => $correlativos['valor_final'],
            'siguiente_valor' => $correlativos['siguiente_valor'],
            'prefix' => $correlativos['prefix'],
            'Sucursal' => $correlativos['Sucursal'],
            'TipoDocumento' => $correlativos['TipoDocumento'],
            'numero_de_serire' => $correlativos['numero_de_serire'],            
            'correlativo_estado' => $correlativos['correlativo_estado'],
        );
        $this->db->where('id_correlativos', $correlativos['id_correlativos'] );
        $this->db->update(self::correlativos, $data );
    }

    function delete( $id_correlativos ){

        $data = array(
            'id_correlativos'     =>  $id_correlativos
        );
        
        $this->db->where('id_correlativos', $id_correlativos );
        $result = $this->db->delete(self::correlativos, $data);
        return $result;
    }
}