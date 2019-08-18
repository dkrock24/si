<?php
class Proveedor_model extends CI_Model {

    const sys_persona =  'sys_persona';
    const pos_proveedor = 'pos_proveedor';
    const pos_linea = 'pos_linea';

	function getAllProveedor(){
		$this->db->select('*');
        $this->db->from(self::pos_proveedor.' as pro');
        $this->db->join(self::sys_persona.' as p',' on p.id_persona = pro.Persona_Proveedor');
        $this->db->where('pro.Empresa_id', $this->session->empresa[0]->Empresa_Suc);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_proveedor( $limit, $id ){
        $this->db->select('*');
        $this->db->from(self::pos_proveedor.' as pro');
        $this->db->join(self::sys_persona.' as p',' on p.id_persona = pro.Persona_Proveedor');
        $this->db->join(self::pos_linea.' as l',' on l.id_linea = pro.lineas');
        $this->db->where('pro.Empresa_id', $this->session->empresa[0]->Empresa_Suc);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        $this->db->where('Empresa_id',$this->session->empresa[0]->Empresa_Suc);
        $this->db->from(self::pos_proveedor);
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear($datos){

         // Insertando Imagenes empresa
        $imagen="";
        $imagen = file_get_contents($_FILES['logo']['tmp_name']);
        $imageProperties = getimageSize($_FILES['logo']['tmp_name']);

        $data = array(
            'empresa' =>  $datos['empresa'],
            'titular_proveedor' => $datos['titular_proveedor'],
            'nrc' => $datos['nrc'],
            'nit_empresa' => $datos['nit_empresa'],
            'giro' => $datos['giro'],
            'logo' => $imagen,
            'logo_type' => $imageProperties['mime'],
            'direc_empresa' => $datos['direc_empresa'],
            'tel_empresa'=> $datos['tel_empresa'],
            'cel_empresa'=> $datos['cel_empresa'],
            'website' => $datos['website'],
            'lineas' => $datos['lineas'],
            'Empresa_id' => $this->session->empresa[0]->Empresa_Suc,
            'Persona_Proveedor' => $datos['Persona_Proveedor'],
            'natural_juridica' => $datos['natural_juridica'],
            'estado' => $datos['estado'],
            'creado' => date("Y-m-d h:i:s")
        );
        
        $result = $this->db->insert(self::pos_proveedor, $data);  
        return $result;
    }

    function get_proveedor_id( $proveedor_id ){

        $this->db->select('*');
        $this->db->from(self::pos_proveedor.' as pro');
        $this->db->join(self::sys_persona.' as p',' on p.id_persona = pro.Persona_Proveedor');
        $this->db->join(self::pos_linea.' as l',' on l.id_linea = pro.lineas');
        $this->db->where('pro.id_proveedor', $proveedor_id);
        $this->db->where('pro.Empresa_id', $this->session->empresa[0]->Empresa_Suc);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($datos){

        $data = array(
            'empresa' =>  $datos['empresa'],
            'titular_proveedor' => $datos['titular_proveedor'],
            'nrc' => $datos['nrc'],
            'nit_empresa' => $datos['nit_empresa'],
            'giro' => $datos['giro'],
            'direc_empresa' => $datos['direc_empresa'],
            'tel_empresa'=> $datos['tel_empresa'],
            'cel_empresa'=> $datos['cel_empresa'],
            'website' => $datos['website'],
            'lineas' => $datos['lineas'],
            'Persona_Proveedor' => $datos['Persona_Proveedor'],
            'natural_juridica' => $datos['natural_juridica'],
            'estado' => $datos['estado'],
            'actualizado' => date("Y-m-d h:i:s")
        );

        if(isset($_FILES['logo']) && $_FILES['logo']['tmp_name']!=null){
             // Insertando Imagenes Empresa
            $imagen="";
            $imagen = file_get_contents($_FILES['logo']['tmp_name']);
            $imageProperties = getimageSize($_FILES['logo']['tmp_name']);

            $data = array_merge( $data,array('logo' => $imagen, 'logo_type'=> $imageProperties['mime'] ));
        }

        $this->db->where('id_proveedor', $datos['id_proveedor'] ); 
        $result = $this->db->update(self::pos_proveedor, $data ); 
        return $result;
    }
}