<?php
class Pais_model extends CI_Model {
	
	const pais =  'sys_pais';
	const pais_d =  'sys_departamento';
	const pais_d_c =  'sys_ciudad';
	const sys_moneda = 'sys_moneda';
	const sys_departamento = 'sys_departamento';


	function get_pais( $limit, $id  ){

		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::sys_moneda.' as m','on '. 'm.id_moneda = p.id_moneda');
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
        $this->db->update(self::pais, $data);  
	}

	// Delete Pais
	function pais_delete( $id_pais ){
		
	}

	function crear_pais( $pais ){

		$data = array(
            'nombre_pais' => $pais['nombre_pais'],
            'zip_code' => $pais['zip_code'],
            'id_moneda' => $pais['moneda_pais'],
            'fecha_creacion_pais' => date("Y-m-d h:i:s"),
            'estado_pais' => $pais['estado_pais']
        );
		$this->db->insert(self::pais, $data ); 
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
            'nombre_depa' 	=> $departamento['nombre_depa'],
            'estado_depa' 	=> $departamento['estado_depa'],
            'fecha_creacion_depa' => date("Y-m-d"),
            'id_pais' 		=> $departamento['id_pais']
        );

		$this->db->insert(self::pais_d, $data ); 
	}

	function editar_dep( $id_dep ){

		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::pais_d.' as pd',' on p.id_pais = pd.id_pais');
        $this->db->where('pd.id_depa',$id_dep ); 

        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function update_dep( $departamento ){

		$data = array(
           'nombre_depa' 	=> $departamento['nombre_depa'],
            'estado_depa' 	=> $departamento['estado_depa'],
            'fecha_actuqalizacion_depa' => date("Y-m-d"),
        );

        $this->db->where('id_depa', $departamento['id_depa']);
		$this->db->update(self::pais_d, $data ); 
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
	           'nombre_ciudad' 		=> $ciudad['nombre_ciu'],
	            'departamento' 	=> $ciudad['id_departamento'],
	            'estado_ciudad' 		=> $ciudad['estado_ciu'],
	            'fecha_ciudad_creacion'=> date("Y-m-d"),
	        );
			$this->db->insert(self::pais_d_c, $data );
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
	            'fecha_ciudad_actualizacion' => date("Y-m-d h:i:s"),
	        );

	        $this->db->where('id_ciudad', $ciudad['id_ciu']);
			$this->db->update(self::pais_d_c, $data );
	}

// END

	function get_moneda(){
		$this->db->select('*');
	        $this->db->from(self::sys_moneda);
	        $this->db->where('estado =1'); 

	        $query = $this->db->get(); 
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        } 
	}

}

?>

