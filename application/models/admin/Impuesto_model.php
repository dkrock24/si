<?php
class Impuesto_model extends CI_Model {

    const impuesto = 'pos_tipos_impuestos';
    const impuesto_categoria = 'pos_impuesto_categoria';
    const impuesto_cliente = 'pos_impuesto_cliente';
    const impuesto_documento = 'pos_impuesto_documento';
    const impuesto_proveedor = 'pos_impuesto_proveedor';

    function getImpuesto($limit, $id){

        $this->db->select('*');
        $this->db->from(self::impuesto);  
        $this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa);
        $this->db->limit($limit, $id);          
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        
        $this->db->where('imp_empresa',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::impuesto);
        $result = $this->db->count_all_results();
        return $result;
    }

    function nuevo_impuesto( $impuesto ){

        $data = array(
            'nombre' => $impuesto['nombre'],
            'porcentage' => $impuesto['porcentaje'],
            'suma_resta_nada' => $impuesto['suma_resta_nada'],
            'aplicar_a_producto' => $impuesto['aplicar_a_producto'],
            'aplicar_a_cliente' => $impuesto['aplicar_a_cliente'],
            'aplicar_a_proveedor' => $impuesto['aplicar_a_proveedor'],
            'aplicar_a_grab_brut_exent' => $impuesto['aplicar_a_grab_brut_exent'],
            'especial' => $impuesto['especial'],
            'excluyente' => $impuesto['excluyente'],
            'condicion' => $impuesto['condicion'],
            'condicion_valor' => $impuesto['c_valor'],
            'mensaje' => $impuesto['mensaje'],
            'imp_empresa'=> $this->session->empresa[0]->id_empresa,
            'imp_estado' => $impuesto['imp_estado'],
        );

        $result = $this->db->insert(self::impuesto, $data );
        return $result;
    }

    function getImpuestoById( $documento_id ){

        $this->db->select('*');
        $this->db->from(self::impuesto);   
        $this->db->where('id_tipos_impuestos', $documento_id ); 
        $this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function updateImpuesto( $impuesto ){

        $data = array(
            'nombre' => $impuesto['nombre'],
            'porcentage' => $impuesto['porcentage'],
            'suma_resta_nada' => $impuesto['suma_resta_nada'],
            'aplicar_a_producto' => $impuesto['aplicar_a_producto'],
            'aplicar_a_cliente' => $impuesto['aplicar_a_cliente'],
            'aplicar_a_proveedor' => $impuesto['aplicar_a_proveedor'],
            'aplicar_a_grab_brut_exent' => $impuesto['aplicar_a_grab_brut_exent'],
            'especial' => $impuesto['especial'],
            'excluyente' => $impuesto['excluyente'],
            'condicion' => $impuesto['condicion'],
            'condicion_valor' => $impuesto['c_valor'],
            'mensaje' => $impuesto['mensaje'],
            'imp_empresa'=> $this->session->empresa[0]->id_empresa,
            'imp_estado' => $impuesto['imp_estado'],
        );
        $this->db->where('id_tipos_impuestos', $impuesto['id_tipos_impuestos']);
        $result = $this->db->update(self::impuesto, $data);
        return $result;
    }

    function eliminar($id){
         $data = array(
            'id_tipos_impuestos' => $id
        );
        $this->db->where('id_tipos_impuestos', $id);
        $result = $this->db->delete(self::impuesto, $data);
        return $result;
    }

    function getAllImpuesto(){

        $this->db->select('*');
        $this->db->from(self::impuesto);
        $this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa);
        $this->db->where('imp_estado', 1);
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getImpuestoDatos( $table_intermedia ,$tabla_destino , $columna1, $columna2 , $columna3 , $field){
        $this->db->select('i.* , destino.'.$field.' as valor_field  ,inter.'.$columna2.' as eId, inter.'.$columna1.' as iId , inter.estado');
        $this->db->from(self::impuesto .' as i');
        $this->db->join($table_intermedia . ' as inter', 'on inter.'.$columna1.' = i.id_tipos_impuestos');
        $this->db->join($tabla_destino . ' as destino', 'on destino.'.$columna3.' = inter.'.$columna2);
        $this->db->where('i.imp_estado', 1);
        $this->db->order_by('valor_field','asc');
        $query = $this->db->get();
        //echo $this->db->queries[0];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function asociar($info){

        $val = $this->asociarExiste($info);

        if(!$val){

            $data =array(
                $info['columna'] => $info['id'],
                'Impuesto' => $info['impuesto']
            );

            $this->db->insert($info['tabla'], $data );
        }
    }

    function asociarExiste($info){
        // Verificar que exista un registro para los valores enviados;
        $this->db->select('*');
        $this->db->from($info['tabla']);
        $this->db->where($info['columna'], $info['id']);
        $this->db->where('Impuesto', $info['impuesto']);
        $query = $this->db->get();
        echo $this->db->queries[0];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function deleteImpuesto($info){

        // Delete genrico
        $data = array(
            $info['columna'] => $info['entidad'],
            'impuesto' => $info['impuesto']
        );
        $this->db->delete($info['tabla'], $data);
    }

    function updateImpuesto2($info){
        var_dump($info);
        $entero = 0;
        $val = $this->selectImpCatStatus($info);
        
        if( $val[0]->estado == 0 ){
            $entero = 1;
        }else{
            $entero = 0;
        }
        
        $data = array(
            'estado' => $entero
        );
        $this->db->where($info['columna'], $info['entidad']);
        $this->db->where('impuesto', $info['impuesto']);
        $this->db->update($info['tabla'], $data);
    }

    function selectImpCatStatus( $info ){

        $this->db->select('*');
        $this->db->from($info['tabla']);
        $this->db->where($info['columna'], $info['entidad']);
        $this->db->where('impuesto', $info['impuesto']);
        $query = $this->db->get();
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAllImpCat(){
        $this->db->select('*');
        $this->db->from(self::impuesto .' as i');
        $this->db->join(self::impuesto_categoria.' as c',' on i.id_tipos_impuestos = c.Impuesto');
        $this->db->where('i.imp_estado',1);
        $this->db->where('c.estado',1);
        $query = $this->db->get();
        //$this->db->queries[0];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAllImpCli(){
        $this->db->select('*');
        $this->db->from(self::impuesto .' as i');
        $this->db->join(self::impuesto_cliente.' as c',' on i.id_tipos_impuestos = c.Impuesto');
        $this->db->where('i.imp_estado',1);
        $query = $this->db->get();
        //$this->db->queries[0];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAllImpDoc(){
        $this->db->select('*');
        $this->db->from(self::impuesto .' as i');
        $this->db->join(self::impuesto_documento.' as d',' on i.id_tipos_impuestos = d.Impuesto');
        $this->db->where('i.imp_estado',1);
        $query = $this->db->get();
        //$this->db->queries[0];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAllImpProv(){
        $this->db->select('*');
        $this->db->from(self::impuesto .' as i');
        $this->db->join(self::impuesto_proveedor.' as p',' on i.id_tipos_impuestos = p.Impuesto');
        $this->db->where('i.imp_estado',1);
        $query = $this->db->get();
        //$this->db->queries[0];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    


    

    // No usados abajos

    

    function delete_documento( $role_id ){

        $data = array(
            'id_rol' => $role_id
        );
        $this->db->delete('sys_menu_acceso', $data);
        
        $data = array(
            'id_rol' => $role_id
        );
        $this->db->delete(self::documento, $data);

        return 1;
    }
}

?>