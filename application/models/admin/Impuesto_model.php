<?php
class Impuesto_model extends CI_Model {

    const impuesto          = 'pos_tipos_impuestos';
    const impuesto2         = 'pos_tipos_impuestos2';
    const impuesto_categoria= 'pos_impuesto_categoria';
    const impuesto_categoria2= 'pos_impuesto_categoria2';
    const impuesto_cliente  = 'pos_impuesto_cliente';
    const impuesto_cliente2  = 'pos_impuesto_cliente2';
    const impuesto_documento= 'pos_impuesto_documento';
    const impuesto_documento2= 'pos_impuesto_documento2';
    const impuesto_proveedor= 'pos_impuesto_proveedor';
    const impuesto_proveedor2= 'pos_impuesto_proveedor2';
    const pos_orden_estado  = 'pos_orden_estado';

    function getImpuesto($limit, $id, $filters){

        $this->db->select('*');
        $this->db->from(self::impuesto);  
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = pos_tipos_impuestos.imp_estado');
        $this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa);
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
        
        $this->db->where('imp_empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::impuesto);
        $result = $this->db->count_all_results();
        return $result;
    }

    function nuevo_impuesto( $impuesto ){

        $registros = $this->getAllImpuesto($impuesto['nombre']);
        if(!$registros){

            $data = array(
                'nombre' => $impuesto['nombre'],
                'mensaje' => $impuesto['mensaje'],
                'especial' => $impuesto['especial'],
                'porcentage' => $impuesto['porcentaje'],
                'condicion' => $impuesto['condicion'],
                'excluyente' => $impuesto['excluyente'],
                'imp_estado' => $impuesto['imp_estado'],
                'imp_empresa'=> $this->session->empresa[0]->id_empresa,
                'suma_resta_nada' => $impuesto['suma_resta_nada'],
                'condicion_valor' => $impuesto['c_valor'],
                'aplicar_a_cliente' => $impuesto['aplicar_a_cliente'],
                'condicion_simbolo' => $impuesto['c_simbolo'],
                'aplicar_a_producto' => $impuesto['aplicar_a_producto'],
                'aplicar_a_proveedor' => $impuesto['aplicar_a_proveedor'],
                'es_combustible' => $impuesto['es_combustible'],
                'aplicar_a_grab_brut_exent' => $impuesto['aplicar_a_grab_brut_exent'],
            );

            $result = $this->db->insert(self::impuesto, $data );
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
            'mensaje' => $impuesto['mensaje'],
            'especial' => $impuesto['especial'],
            'condicion' => $impuesto['condicion'],
            'porcentage' => $impuesto['porcentage'],
            'imp_estado' => $impuesto['imp_estado'],
            'excluyente' => $impuesto['excluyente'],
            'imp_empresa'=> $this->session->empresa[0]->id_empresa,
            'suma_resta_nada' => $impuesto['suma_resta_nada'],
            'condicion_valor' => $impuesto['c_valor'],
            'aplicar_a_cliente' => $impuesto['aplicar_a_cliente'],
            'condicion_simbolo' => $impuesto['c_simbolo'],
            'aplicar_a_producto' => $impuesto['aplicar_a_producto'],
            'aplicar_a_proveedor' => $impuesto['aplicar_a_proveedor'],
            'aplicar_a_grab_brut_exent' => $impuesto['aplicar_a_grab_brut_exent'],
        );
        $this->db->where('id_tipos_impuestos', $impuesto['id_tipos_impuestos']);
        $result = $this->db->update(self::impuesto, $data);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar($id){

         $data = array(
            'id_tipos_impuestos' => $id
        );

        $this->db->where('id_tipos_impuestos', $id);
        $this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa);
        $result = $this->db->delete(self::impuesto, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getAllImpuesto($impuesto = null){

        $this->db->select('*');
        $this->db->from(self::impuesto);
        $this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa);
        $this->db->where('imp_estado', 1);
        if($impuesto){
            $this->db->where('nombre', $impuesto);
        }
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
        $this->db->where('i.imp_empresa', $this->session->empresa[0]->id_empresa );
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
                $info['columna']=> $info['id'],
                'Impuesto'      => $info['impuesto']
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
            'impuesto'       => $info['impuesto']
        );
        $this->db->delete($info['tabla'], $data);
    }

    function updateImpuesto2($info){
        
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
        $this->db->where('i.imp_empresa', $this->session->empresa[0]->id_empresa );
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
        $this->db->where('i.imp_empresa', $this->session->empresa[0]->id_empresa );
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
        $this->db->where('i.imp_empresa', $this->session->empresa[0]->id_empresa );
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
        $this->db->where('i.imp_empresa', $this->session->empresa[0]->id_empresa );
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
        $this->db->delete(self::impuesto_documento, $data);

        return 1;
    }

    function insert_api($impuestos)
    {
        $this->db->truncate(self::impuesto2);

        $data = [];
        foreach ($impuestos as $key => $impuesto) {
            $data[] = $impuesto;
        }
        $this->db->insert_batch(self::impuesto2, $data);
    }


    function insert_id_api($impuesto_documentos)
    {
        $this->db->truncate(self::impuesto_documento2);

        $data = [];
        foreach ($impuesto_documentos as $key => $id) {
            $data[] = $id;
        }
        $this->db->insert_batch(self::impuesto_documento2, $data);
    }

    function insert_ic_api($impuesto_categoria)
    {
        $this->db->truncate(self::impuesto_categoria2);

        $data = [];
        foreach ($impuesto_categoria as $key => $ic) {
            $data[] = $ic;
        }
        $this->db->insert_batch(self::impuesto_categoria2, $data);
    }

    function insert_icli_api($impuesto_clientes)
    {
        $this->db->truncate(self::impuesto_cliente2);

        $data = [];
        foreach ($impuesto_clientes as $key => $icliente) {
            $data[] = $icliente;
        }
        $this->db->insert_batch(self::impuesto_cliente2, $data);
    }

    function insert_ip_api($impuesto_proveedor)
    {
        $this->db->truncate(self::impuesto_proveedor2);

        $data = [];
        foreach ($impuesto_proveedor as $key => $proveedor) {
            $data[] = $proveedor;
        }
        $this->db->insert_batch(self::impuesto_proveedor2, $data);
    }
}
