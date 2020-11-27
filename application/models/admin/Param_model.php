<?php
class Param_model extends CI_Model {

	const conf   = 'sys_conf';
	const modulo = 'sys_modulo';

	public function get_modulos( ){
		$this->db->select('*');
	    $this->db->from(self::modulo.' as m');
	    $query = $this->db->get(); 
	    //echo $this->db->queries[0];
	    
	    if($query->num_rows() > 0 )
	    {
	        return $query->result();
	    }
	}

	public function record_count(){

		$this->db->from(self::conf);
		$result = $this->db->count_all_results();
    	return $result;
    }

	public function get_modulos_conf( $index ){
		$this->db->select('*');
	    $this->db->from(self::modulo.' as m');
	    $this->db->join(self::conf.' as c',' on m.id_modulo = c.modulo_conf');
	    $this->db->where('m.id_modulo', $index );
	    $query = $this->db->get(); 
	    //echo $this->db->queries[0];
	    
	    if($query->num_rows() > 0 )
	    {
	        return $query->result();
	    }
	}

	public function save_params($param){
		$data = array();
		
		foreach ($param as $key => $value) {
			@$data[$value['name']] .= $value['value'] ;
		}

		$data['creado_conf'] = date("Y-m-d h-i-s");

		$this->db->insert(self::conf, $data ); 
	}

	public function update_params($param){
		$data = array();
		
		foreach ($param as $key => $value) {
			@$data[$value['name']] .= $value['value'] ;
		}

		@$data['actualizado_conf'] .= date("Y-m-d h-i-s");
		$this->db->where(self::conf.'.id_conf', $data['id_conf']);
		$this->db->update(self::conf, $data ); 
	}

	public function delete_params($param){
		
		$this->db->delete(self::conf, array('id_conf' => $param[0]['value']) ); 
	}

	public function get_params($id){
		$this->db->select('*');
	    $this->db->from(self::modulo.' as m');
	    $this->db->join(self::conf.' as c',' on m.id_modulo = c.modulo_conf');
	    $this->db->where('c.id_conf', $id );
	    $query = $this->db->get(); 
	    //echo $this->db->queries[0];
	    
	    if($query->num_rows() > 0 )
	    {
	        return $query->result();
	    }
	}

	public function save_modulo($param){
		$data = array();
		
		foreach ($param as $key => $value) {
			@$data[$value['name']] .= $value['value'] ;
		}

		$this->db->insert(self::modulo, $data ); 
	}

	public function get_modulos_id($id){
		$this->db->select('*');
	    $this->db->from(self::modulo.' as m');
	    $this->db->where('m.id_modulo', $id );
	    $query = $this->db->get(); 
	    //echo $this->db->queries[0];
	    
	    if($query->num_rows() > 0 )
	    {
	        return $query->result();
	    }
	}

	public function update_modulo($param){
		$data = array();
		
		foreach ($param as $key => $value) {
			@$data[$value['name']] .= $value['value'] ;
		}

		$this->db->where(self::modulo.'.id_modulo', $data['id_modulo']);
		$this->db->update(self::modulo, $data ); 
	}

	/**
	 * Retornar la configuracionparametros para un modulo/seccion especifico
	 *
	 * @param integer $codigo
	 * @return $query
	 */
	public function get_config_code(int $codigo){

		$this->db->select('*');
	    $this->db->from(self::conf);
	    $this->db->where('condicion_conf', $codigo );
	    $query = $this->db->get(); 
	    
	    if($query->num_rows() > 0 )
	    {
	        return $query->result();
	    }
	}
}
