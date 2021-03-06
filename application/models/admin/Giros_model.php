<?php
class Giros_model extends CI_Model {
	
    const giros             =  'pos_giros';
    const giros2             =  'pos_giros2';
    const empresa           = 'pos_empresa';
    const atributos         = 'atributo';
    const plantillas        = 'giro_pantilla';
    const plantillas2        = 'giro_pantilla2';
    const pos_orden_estado  = 'pos_orden_estado';
    const empresa_plantilla = 'giros_empresa';
    const empresa_plantilla2 = 'giros_empresa2';

	function get_giros( $limit, $id , $filters ){;
		$this->db->select('*');
        $this->db->from(self::giros);
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = pos_giros.estado_giro');
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);  
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[2];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

    function getAllgiros($giro = null, $codigo_giro = null){;
        $this->db->select('*');
        $this->db->from(self::giros);
        $this->db->where(self::giros.'.Empresa', $this->session->empresa[0]->id_empresa);
        if($giro){
            $this->db->where(self::giros.'.nombre_giro', $giro);
            $this->db->where(self::giros.'.codigo_giro', $codigo_giro);
        }
        $query = $this->db->get(); 
        //echo $this->db->queries[0];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::giros);
        $result = $this->db->count_all_results();
        return $result;
    }

    function get_empresa(){
        $this->db->select('*');
        $this->db->from(self::empresa);
        $this->db->where('id_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_empresa2(){
        $this->db->select('id_empresa,nombre_razon_social');
        $this->db->from(self::empresa);
        $this->db->where('id_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

	function crear_giro( $nuevo_giro ){

        $registros = $this->getAllgiros($nuevo_giro['nombre_giro'], $nuevo_giro['codigo_giro']);

        if(!$registros){
            $data = array(
                'nombre_giro'       => $nuevo_giro['nombre_giro'],
                'descripcion_giro'  => $nuevo_giro['descripcion_giro'],
                'tipo_giro'         => $nuevo_giro['tipo_giro'],
                'codigo_giro'       => $nuevo_giro['codigo_giro'],
                'Empresa'           => $this->session->empresa[0]->id_empresa,
                'estado_giro'       => $nuevo_giro['estado_giro'],
                'fecha_giro_creado' => date("Y-m-d h:i:s")
            );
            $insert = $this->db->insert(self::giros, $data ); 
    
            if (!$insert) {
                $insert = $this->db->error();
            }
            return $insert;
        }else{
            return $result = [
                'code' => 1,
                'message' => "El registro ya existe"
            ];
        }
	}

	function get_giro_id( $id_giro ){ 

		$this->db->select('*');
        $this->db->from(self::giros);
        $this->db->where('id_giro ='. $id_giro );
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function actualizar_giro( $giro ){
		$data = array(
            'nombre_giro' => $giro['nombre_giro'],
            'descripcion_giro' => $giro['descripcion_giro'],
            'tipo_giro' => $giro['tipo_giro'],
            'codigo_giro' => $giro['codigo_giro'],
            'estado_giro' => $giro['estado_giro'],
            'fecha_giro_actualizado' => date("Y-m-d h:i:s")
        );

        $this->db->where('id_giro', $giro['id_giro']);
        $insert = $this->db->update(self::giros, $data);  

        if(!$insert){
            $insert = $this->db->error(); ;
        }

        return $insert;
	}

    function eliminar_giro($id){
        $data = array(
            'id_giro' => $id
        );

        $this->db->where('id_giro', $id);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        $result = $this->db->delete(self::giros, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function insert_plantilla( $plantilla ){

        $msj = "";
        $contador_insertados=0;
        $contador_existentes=0;
        $giro = $plantilla['giro'];

        foreach ($plantilla as $key => $value) {
            //echo $key;
            if(is_numeric((int)$key)){
                //echo $key;
                $estado = $this->validar_existencia( $key , $giro );
                //var_dump($estado);

                if($estado != 1 and is_numeric($key)){
                    $data = array(
                        'Giro' => $giro,
                        'Atributo' => $key,
                        'estado_giro_plantilla' => 1,
                        'creado_giro_plantilla' => date("Y-m-d h:i:s")
                    );
                    $this->db->insert(self::plantillas, $data ); 
                    $contador_insertados+=1;
                }else{
                    //echo "No";
                    $contador_existentes+=1;
                }
            }else{
                echo "Fallo. No es numerico";
            }
        }
        $data['contador_insertados'] = $contador_insertados;
        $data['contador_existentes'] = $contador_existentes;
        return $data;        
    }

    function validar_existencia( $id_atributo, $id_giro ){
        $this->db->select('*');
        $this->db->from(self::plantillas);
        $this->db->where('Giro ='. $id_giro );
        $this->db->where('Atributo ='. $id_atributo );
        $query = $this->db->get(); 
        //echo $this->db->queries[9];
        
        if($query->num_rows() > 0 )
        {
            return 1;
        }
    }

    function get_plantilla( $id_giro ){

        $this->db->select('*');
        $this->db->from(self::plantillas.' as p ');
        $this->db->join(self::atributos.' as a ',' on p.Atributo = a.id_prod_atributo');
        $this->db->where('p.Giro ='. $id_giro );        
        $query = $this->db->get(); 
        //echo $this->db->queries[9];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_total_plantilla_giro( $giro ){

        $this->db->select('count(*) as atributos_total');
        $this->db->from(self::plantillas.' as p ');
        $this->db->join(self::atributos.' as a ',' on p.Atributo = a.id_prod_atributo');
        $this->db->where('p.Giro ='. $giro );        
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function eliminar_plantilla( $plantilla ){
        $msj = "";
        $contador_insertados=0;
        $contador_existentes=0;
        $giro = $plantilla['giro'];

        foreach ($plantilla as $key => $value) {

            if(is_numeric((int)$key)){

                if(is_numeric($key)){

                    $data = array(
                        'id_giro_pantilla' => $key
                    );
                    $this->db->delete(self::plantillas, $data ); 
                    $contador_insertados+=1;
                }else{
                    //echo "No";
                    $contador_existentes+=1;
                }
            }else{
                echo "Fallo. No es numerico";
            }
        }
        $data['contador_insertados'] = $contador_insertados;
        $data['contador_existentes'] = $contador_existentes;
        return $data; 
    }

    // GIRO EMPRESA

    function insert_giro_empresa( $giro ){
        $msj = "";
        $contador_insertados=0;
        $contador_existentes=0;
        $empresa = $giro['empresa'];

        foreach ($giro as $key => $value) {
            //echo $key;
            if(is_numeric((int)$key)){
                //echo $key;
                $estado = $this->validar_existencia_giro_empresa( $key , $empresa );

                if($estado != 1 and is_numeric($key)){
                    $data = array(
                        'Empresa' => $empresa,
                        'Giro' => $key,
                        'nombre_plantilla' => "General" ,
                        'creado_giro_empresa' => date("Y-m-d h:i:s")
                    );
                    $this->db->insert(self::empresa_plantilla, $data ); 
                    $contador_insertados+=1;
                }else{
                    //echo "No";
                    $contador_existentes+=1;
                }
            }else{
                echo "Fallo. No es numerico";
            }
        }
        $data['contador_insertados'] = $contador_insertados;
        $data['contador_existentes'] = $contador_existentes;
        return $data;  
    }

    function validar_existencia_giro_empresa( $giro, $empresa ){
        $this->db->select('*');
        $this->db->from(self::empresa_plantilla);
        $this->db->where('Empresa ='. $empresa );
        $this->db->where('Giro ='. $giro );
        $query = $this->db->get(); 
        //echo $this->db->queries[9];
        
        if($query->num_rows() > 0 )
        {
            return 1;
        }
    }

    function get_empresa_giro2( ){
        
        $this->db->select('*');
        $this->db->from(self::empresa_plantilla.' as ep');
        $this->db->join(self::giros.' as g',' on g.id_giro = ep.Giro');
        $this->db->where('ep.Empresa ='. $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[10];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_empresa_giro( $empresa = null){

        $this->db->select('*');
        $this->db->from(self::empresa_plantilla.' as ep');
        $this->db->join(self::giros.' as g',' on g.id_giro = ep.Giro');
        $this->db->where('ep.Empresa ='. $empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[10];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_total_empresa_giro( $empresa ){

        $this->db->select('count(*) as total_empresa_giro ');
        $this->db->from(self::empresa_plantilla.' as ep');        
        $this->db->where('ep.Empresa ='. $empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[10];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function eliminar_giro_empresa( $giro_empresa ){
        $msj = "";
        $contador_insertados=0;
        $contador_existentes=0;
        $empresa = $giro_empresa['empresa'];

        foreach ($giro_empresa as $key => $value) {
            
            if(is_numeric((int)$key)){
                
                if(is_numeric($key)){
                    $data = array(
                        'Giro' => $key,
                        'Empresa' => $empresa 
                    );
                    $result = $this->db->delete(self::empresa_plantilla, $data ); 
                    $contador_insertados+=1;
                }else{
                    //echo "No";
                    $contador_existentes+=1;
                }
            }else{
                echo "Fallo. No es numerico";
            }
        }
        $data['contador_insertados'] = $contador_insertados;
        $data['contador_existentes'] = $contador_existentes;
        return $data; 
    }

    function get_giros_empresa( $empresa ){
        
        $this->db->select('*');
        //$this->db->from(self::empresa_plantilla.' as ep');
        $this->db->from(self::giros.' as g',' on g.id_giro = ep.Giro');
        $this->db->where('g.Empresa ='. $empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[10];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function insert_api($giros)
    {
        $this->db->truncate(self::giros2);

        $data = [];
        foreach ($giros as $key => $giro) {
            $data[] = $giro;
        }
        $this->db->insert_batch(self::giros2, $data);
    }

    function insert_empresa_api($giros_empresa)
    {
        $this->db->truncate(self::empresa_plantilla2);

        $data = [];
        foreach ($giros_empresa as $key => $giros_empresa) {
            $data[] = $giros_empresa;
        }
        $this->db->insert_batch(self::empresa_plantilla2, $data);
    }

    function insert_plantilla_api($giros_plantillas)
    {
        $this->db->truncate(self::plantillas2);

        $data = [];
        foreach ($giros_plantillas as $key => $giro_plantilla) {
            $data[] = $giro_plantilla;
        }
        $this->db->insert_batch(self::plantillas2, $data);
    }
}