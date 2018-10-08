<?php
class Pais_model extends CI_Model {
	
	const pais =  'sys_pais';
	const pais_d =  'sys_pais_departamento';
	const pais_d_c =  'sys_pais_departamento_ciudad';


	function index(){
		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	// EDITAR PAIS //
	function pais_edit( $id_pais ){
		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->where('p.id_pais',$id_pais ); 
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	// UPDATE PAIS //
	public function pais_update( $pais ){

		$data = array(
           'nombre_pais' => $pais['nombre_pais'],
            'codigo_pais' => $pais['codigo_pais'],
            'moneda_pais' => $pais['moneda_pais'],
            'fecha_actualizacion_pais' => date("Y-m-d"),
            'estado_pais' => $pais['estado_pais']
        );
        $this->db->where('id_pais', $pais['id_pais']);
        $this->db->update(self::pais, $data);  
	}

	// Delete Pais con Departamento y Ciudades 
	public function pais_delete( $id_pais ){
		
	}

	function get_pais_dep( $id_pais ){
		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::pais_d.' as pd',' on p.id_pais = pd.id_pais');
        //$this->db->join(self::pais_d_c .' as pdc',' on pdc.id_departamento = pd.id_depa'); 
        $this->db->where('p.id_pais',$id_pais ); 
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	function get_pais_dep_ciu( $id_dep ){
		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::pais_d.' as pd',' on p.id_pais = pd.id_pais');
        $this->db->join(self::pais_d_c .' as pdc',' on pdc.id_departamento = pd.id_depa'); 
        $this->db->where('pd.id_depa',$id_dep ); 
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	//function nuevo(){}

	function crear( $pais ){

		$data = array(
           'nombre_pais' => $pais['nombre_pais'],
            'codigo_pais' => $pais['codigo_pais'],
            'moneda_pais' => $pais['moneda_pais'],
            'fecha_creacion_pais' => date("Y-m-d"),
            'estado_pais' => $pais['estado_pais']
        );
		$this->db->insert(self::pais, $data ); 
	}

	// DEPARTAMENTOS ---------------------------------------------------------------------

	function crear_dep( $departamento ){
		$data = array(
           'nombre_depa' => $departamento['nombre_depa'],
            'estado_depa' => $departamento['estado_depa'],
            'fecha_creacion_depa' => date("Y-m-d"),
            'id_pais' => $departamento['id_pais']
        );
		$this->db->insert(self::pais_d, $data ); 
	}

	function editar_dep( $id_dep ){
		$this->db->select('*');
        $this->db->from(self::pais.' as p');
        $this->db->join(self::pais_d.' as pd',' on p.id_pais = pd.id_pais');
        //$this->db->join(self::pais_d_c .' as pdc',' on pdc.id_departamento = pd.id_depa'); 
        $this->db->where('pd.id_depa',$id_dep ); 
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function update_dep( $departamento ){
		$data = array(
           'nombre_depa' => $departamento['nombre_depa'],
            'estado_depa' => $departamento['estado_depa'],
            'fecha_actuqalizacion_depa' => date("Y-m-d"),
        );
        $this->db->where('id_depa', $departamento['id_depa']);
		$this->db->update(self::pais_d, $data ); 
	}
}

?>

