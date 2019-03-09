<?php
class Giros_model extends CI_Model {
	
	const giros =  'pos_giros';
    const plantillas = 'giro_pantilla';
    const atributos = 'atributo';
    const empresa = 'pos_empresa';
    const empresa_plantilla = 'giros_empresa';


	function get_giros( $limit, $id ){;
		$this->db->select('*');
        $this->db->from(self::giros);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[2];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

    function getAllgiros(){;
        $this->db->select('*');
        $this->db->from(self::giros);
        $query = $this->db->get(); 
        //echo $this->db->queries[2];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        return $this->db->count_all(self::giros);
    }

    function get_empresa(){
        $this->db->select('*');
        $this->db->from(self::empresa);
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
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

	function crear_giro( $nuevo_giro ){

		$data = array(
            'nombre_giro' => $nuevo_giro['nombre_giro'],
            'descripcion_giro' => $nuevo_giro['descripcion_giro'],
            'tipo_giro' => $nuevo_giro['tipo_giro'],
            'codigo_giro' => $nuevo_giro['codigo_giro'],
            'estado_giro' => $nuevo_giro['estado_giro'],
            'fecha_giro_creado' => date("Y-m-d h:i:s")
        );
		$insert = $this->db->insert(self::giros, $data ); 

        return $insert;

	}

	function get_giro_id( $id_giro ){ 

		$this->db->select('*');
        $this->db->from(self::giros);
        $this->db->where('id_giro ='. $id_giro );
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
        return $insert;
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
                //var_dump($estado);

                if($estado != 1 and is_numeric($key)){
                    $data = array(
                        'Empresa' => $empresa,
                        'Giro' => $key,
                        'nombre_plantilla' => "Demo" ,
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

    function get_empresa_giro( $empresa ){
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
                    $this->db->delete(self::empresa_plantilla, $data ); 
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
}