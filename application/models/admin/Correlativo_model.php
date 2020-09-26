<?php
class Correlativo_model extends CI_Model {

    const empleado      =  'sys_empleado';
    const sucursal      =  'pos_sucursal';
    const documento     =  'pos_tipo_documento';
    const correlativos  =  'pos_correlativos';  
    const pos_orden_estado = 'pos_orden_estado';  

	public function get_correlativo_sucursal($documento  , $sucursal ){

        $this->db->select('*');
        $this->db->from(self::correlativos.' as c');
        $this->db->join(self::sucursal.' as s', 'on c.Sucursal = s.id_sucursal');
        $this->db->join(self::documento.' as d', 'on d.id_tipo_documento = c.TipoDocumento');
        $this->db->where('c.TipoDocumento', $documento );
        $this->db->where('c.Sucursal', $sucursal );
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }    

    public function get_by_id( $sucursal ){

        $this->db->select('*');
        $this->db->from(self::correlativos.' as c');
        $this->db->where('c.Sucursal', $sucursal);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function getCorrelativos( $limit, $id , $filters ){

        $this->db->select('*');
        $this->db->from(self::correlativos.' as c');
        $this->db->join(self::sucursal.' as s',' on c.Sucursal = s.id_sucursal');   
        $this->db->join(self::documento.' as d',' on c.TipoDocumento = d.id_tipo_documento'); 
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = c.correlativo_estado');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->order_by('s.id_sucursal','asc');
        $this->db->order_by('d.nombre','asc');
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function record_count($filter){
        //return $this->db->count_all(self::correlativos);
        $this->db->where('s.Empresa_Suc',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::correlativos.' as c');
        $this->db->join(self::sucursal.' as s',' on c.Sucursal = s.id_sucursal');
        $result = $this->db->count_all_results();
        return $result;
    }

    public function save( $correlativos ){

        $registros = $this->get_correlativo_sucursal($correlativos['TipoDocumento'],$correlativos['Sucursal']);

        if(!$registros){

            $data = array(
                'valor_inical'      => $correlativos['valor_inical'],
                'valor_final'       => $correlativos['valor_final'],
                'siguiente_valor'   => $correlativos['siguiente_valor'],
                'fecha_creacion'    => date("Y-m-d H:i:s"),
                'prefix'            => $correlativos['prefix'],
                'Sucursal'          => $correlativos['Sucursal'],
                'TipoDocumento'     => $correlativos['TipoDocumento'],
                'numero_de_serire'  => $correlativos['numero_de_serire'],
                'correlativo_estado'=> $correlativos['correlativo_estado'],
            );

            $result = $this->db->insert(self::correlativos, $data );

            if(!$result){
                $result = $this->db->error();
            }

            return $result;
        }else{
            return $result = [
                'code' => 1,
                'message' => "El registro ya existe"
            ];
        }
    }

    public function editar( $correlativos_id ){

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

    public function update( $correlativos ){

        $registros = $this->get_correlativo_sucursal($correlativos['TipoDocumento'],$correlativos['Sucursal']);

        if(!$registros){

            $data = array(
                'prefix'            => $correlativos['prefix'],
                'Sucursal'          => $correlativos['Sucursal'],
                'valor_final'       => $correlativos['valor_final'],
                'valor_inical'      => $correlativos['valor_inical'],
                'TipoDocumento'     => $correlativos['TipoDocumento'],
                'siguiente_valor'   => $correlativos['siguiente_valor'],
                'numero_de_serire'  => $correlativos['numero_de_serire'],            
                'correlativo_estado'=> $correlativos['correlativo_estado'],
            );
            $this->db->where('id_correlativos', $correlativos['id_correlativos'] );
            $result = $this->db->update(self::correlativos, $data );

            if(!$result){
                $result = $this->db->error();
            }
        }else{
            return $result = [
                'code' => 1,
                'message' => "El registro ya existe"
            ];
        }

        return $result;
    }

    public function delete( $id_correlativos ){

        $data = array(
            'id_correlativos' =>  $id_correlativos
        );
        
        $this->db->where('id_correlativos', $id_correlativos );
        $result = $this->db->delete(self::correlativos, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}