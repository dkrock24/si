<?php
class Marca_model extends CI_Model {

    const marca = 'pos_marca';
    const categoria = 'categoria';
    const marca_categoria = 'pos_marca_categoria';


    function getMarca($limit, $id){

        $this->db->select('*');
        $this->db->from(self::marca);  
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->limit($limit, $id);          
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllMarca(){

        $this->db->select('*');
        $this->db->from(self::marca);   
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);      
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::marca);
        $result = $this->db->count_all_results();
        return $result;
    }

    function getMarcaById( $marca_id ){

        $this->db->select('*');
        $this->db->from(self::marca);   
        $this->db->where('id_marca', $marca_id ); 
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);      
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function get_marca_categoria( $id_categoria ){

        $this->db->select('*');
        $this->db->from(self::categoria.' as c');   
        $this->db->join(self::marca_categoria.' as mc', 'mc.Categoria = c.id_categoria');
        $this->db->join(self::marca.' as m', 'm.id_marca = mc.Marca');
        $this->db->where('mc.Categoria', $id_categoria);
        $query = $this->db->get();
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function delete_categoria_marca($id){
        $data = array(
            'id_mar_cat' => $id,
        );

        $this->db->delete(self::marca_categoria, $data); 
    }

    function get_marcas( ){

        $this->db->select('*');
        $this->db->from(self::categoria.' as c');   
        $this->db->where('c.id_categoria_padre', null);
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function eliminar_marca($id){
        $data = array(
            'id_marca' => $id,
        );

        return $result = $this->db->delete(self::marca, $data); 
    }

    function marca_categoria( ){

        $this->db->select('*');
        $this->db->from(self::categoria.' as c');   
        $this->db->join(self::marca_categoria.' as mc', 'mc.Categoria = c.id_categoria');
        $this->db->join(self::marca.' as m', 'm.id_marca = mc.Marca');
        $this->db->order_by('c.nombre_categoria','ASC');
        $this->db->order_by('mc.id_mar_cat','DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function save_categoria_marca($datos){

        $val = $this->get_lista_marca_categoria($datos);
        $flag= false;

        if(!$val){
            $data = array(
                'Marca' => $datos['marca'],
                'Categoria' => $datos['categoria'],
            );
            $this->db->insert(self::marca_categoria, $data);
            $flag = true;
        }
        return $flag;
    }

    function get_lista_marca_categoria($datos){
        $this->db->select('*');
        $this->db->from(self::marca_categoria.' as c');   
        $this->db->where('c.Categoria', $datos['categoria']);
        $this->db->where('c.Marca', $datos['marca']);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function setMarca( $marca ){

        $data = array(
            'nombre_marca' => $marca['nombre_marca'],
            'descripcion_marca' => $marca['descripcion_marca'],
            'fecha_atualizado_marca' => date("Y-m-d h:i:s"),          
            'estado_marca' => $marca['estado_marca'],
        );
        $this->db->where('id_marca', $marca['id_marca']);
        $result = $this->db->update(self::marca, $data);  
        return $result;
    }

    function nuevo_marca( $marca ){

        $data = array(
            'nombre_marca' => $marca['nombre_marca'],
            'descripcion_marca' => $marca['descripcion_marca'],
            'fecha_creado_marca' => date("Y-m-d h:i:s"),          
            'Empresa'=> $this->session->empresa[0]->id_empresa,
            'estado_marca' => $marca['estado'],
        );

        $result = $this->db->insert(self::marca, $data );

        $data = array(
            'marca' => $this->db->insert_id(),
            'categoria' => $marca['categoria'],
        );

        $this->save_categoria_marca( $data );


        return $result;
    }

    function delete_marca( $role_id ){

        $data = array(
            'id_rol' => $role_id
        );
        $this->db->delete('sys_menu_acceso', $data);
        
        $data = array(
            'id_rol' => $role_id
        );
        $result = $this->db->delete(self::marca, $data);

        return $result;
    }
}

?>