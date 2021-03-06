<?php
class Pais_model extends CI_Model {
	
    const pais =  'sys_pais';
    const pais2 =  'sys_pais2';
    const pais_d =  'sys_departamento';
    const pais_d2 =  'sys_departamento2';
    const pais_d_c =  'sys_ciudad';
    const pais_d_c2 =  'sys_ciudad2';
	const sys_moneda = 'sys_moneda';
	const sys_departamento = 'sys_departamento';
    const pos_orden_estado = 'pos_orden_estado';

	function get_pais( $limit, $id , $filters ){

		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::sys_moneda.' as m','on '. 'm.id_moneda = p.id_moneda');
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = p.estado_pais');
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

	function record_count(){
        return $this->db->count_all(self::pais);
    }

	// EDITAR PAIS //
	function edit_pais( $id_pais ){

		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::sys_moneda.' as m','on '. 'm.id_moneda = p.id_moneda');
        $this->db->where('p.id_pais',$id_pais ); 
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	// UPDATE PAIS //
	function update_pais( $pais ){

		$data = array(
            'nombre_pais' => $pais['nombre_pais'],
            'zip_code' => $pais['zip_code'],
            'id_moneda' => $pais['moneda_pais'],
            'fecha_actualizacion_pais' => date("Y-m-d h:i:s"),
            'estado_pais' => $pais['estado_pais']
        );

        $this->db->where('id_pais', $pais['id_pais']);
		$result = $this->db->update(self::pais, $data);  
		
		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

	// Delete Pais
	function pais_delete( $id_pais ){
        $this->db->where('id_pais', $id_pais);
        $result = $data = $this->db->delete(self::pais);
        
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

	function crear_pais( $pais ){

		$data = array(
            'nombre_pais' => $pais['nombre_pais'],
            'zip_code' => $pais['zip_code'],
            'id_moneda' => $pais['moneda_pais'],
            'fecha_creacion_pais' => date("Y-m-d h:i:s"),
            'estado_pais' => $pais['estado_pais']
        );
		$result = $this->db->insert(self::pais, $data ); 

		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

// DEPARTAMENTOS ---------------------------------------------------------------------

	function get_dep( $id_pais ){

		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::sys_departamento.' as d',' on p.id_pais = d.pais');
        $this->db->where('p.id_pais',$id_pais ); 

        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	function crear_dep( $departamento ){

		$data = array(
            'nombre_departamento' 	=> $departamento['nombre_depa'],
            'estado_departamento' 	=> $departamento['estado_depa'],
            'fecha_creacion_depa' => date("Y-m-d"),
            'pais' 		=> $departamento['id_pais']
        );

		$result = $this->db->insert(self::pais_d, $data ); 
		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

	function editar_dep( $id_dep ){

		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::pais_d.' as pd',' on p.id_pais = pd.pais');
        $this->db->where('pd.id_departamento',$id_dep ); 

        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function update_dep( $departamento ){

		$data = array(
           'nombre_departamento' 	=> $departamento['nombre_departamento'],
			'estado_departamento' 	=> $departamento['estado_departamento'],
			'codigo_departamento' 	=> $departamento['codigo_departamento'],
			'zona_departamento' 	=> $departamento['zona_departamento'],
            'fecha_actualizacion_depa' => date("Y-m-d"),
        );

        $this->db->where('id_departamento', $departamento['id_departamento']);
		$result = $this->db->update(self::pais_d, $data );

		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

	function eliminar_dep($id){
		$data = array(
           'id_departamento' 	=> $id
        );

        $this->db->where('id_departamento', $id);
		$result = $this->db->delete(self::sys_departamento, $data ); 

		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

// END

// Ciudad **********************************************************************

	function get_ciu_by( $id_dep ){

			$this->db->select('*');
	        $this->db->from(self::pais.' as p');
	        $this->db->join(self::pais_d.' as pd',' on p.id_pais = pd.pais');
	        $this->db->join(self::pais_d_c .' as pdc',' on pdc.departamento = pd.id_departamento'); 
	        $this->db->where('pd.id_departamento',$id_dep ); 
	        
	        $query = $this->db->get(); 
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        } 
	}

	function crear_ciu( $ciudad ){

		$data = array(
           'nombre_ciudad' 	=> $ciudad['nombre_ciu'],
            'departamento' 	=> $ciudad['id_departamento'],
			'estado_ciudad' => $ciudad['estado_ciu'],
			'codigo_ciudad' => $ciudad['codigo_ciu'],
            'fecha_ciudad_creacion'=> date("Y-m-d"),
        );
		$result = $this->db->insert(self::pais_d_c, $data );
		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

	function get_ciu( $id_ciu ){

		$this->db->select('*');
        $this->db->from(self::pais_d_c.' as c');
        $this->db->where('c.id_ciudad',$id_ciu ); 

        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	function update_ciu( $ciudad ){

		$data = array(
           'nombre_ciudad' 	=> $ciudad['nombre_ciu'],
			'estado_ciudad' 	=> $ciudad['estado_ciu'],
			'codigo_ciudad' => $ciudad['codigo_ciu'],
            'fecha_ciudad_actualizacion' => date("Y-m-d h:i:s"),
        );

        $this->db->where('id_ciudad', $ciudad['id_ciu']);
		$result = $this->db->update(self::pais_d_c, $data );
		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

	function eliminar_ciu($id){
		$data = array(
           'id_ciudad' 	=> $id
        );

        $this->db->where('id_ciudad', $id);
		$result = $this->db->delete(self::pais_d_c, $data );
		if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

// END

	function get_moneda(){
		$this->db->select('*');
	        $this->db->from(self::sys_moneda);
	        $this->db->where('moneda_estado =1'); 

	        $query = $this->db->get(); 
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        } 
    }
    
    function insert_pais_api($paises)
    {
        $this->db->truncate(self::pais2);
        $data = [];
        foreach ($paises as $key => $pais) {
            $data[] = $pais;
        }

        $this->db->insert_batch(self::pais2, $data);
        //var_dump($this->db->error());
    }

    function insert_departamento_api($departamentos)
    {
        $this->db->truncate(self::pais_d2);
        $data = [];
        foreach ($departamentos as $key => $departamento) {
            $data[] = $departamento;
        }

        $this->db->insert_batch(self::pais_d2, $data);
        //var_dump($this->db->error());
    }

    function insert_municipio_api($municipios)
    {
        $this->db->truncate(self::pais_d_c2);
        $data = [];
        foreach ($municipios as $key => $municipio) {
            $data[] = $municipio;
        }

        $this->db->insert_batch(self::pais_d_c2, $data);
        //var_dump($this->db->error());
    }

}