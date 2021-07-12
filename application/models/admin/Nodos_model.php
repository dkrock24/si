<?php
class Nodos_model extends CI_Model {

    const nodos = 'pos_ordenes_nodos';
    const ordenes = 'pos_ordenes';
    const orden_detalle = 'pos_orden_detalle';
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const pos_empresa = 'pos_empresa';
    const categoria = 'categoria';
    const pos_orden_estado = 'pos_orden_estado';
    const nodos_categoria = 'pos_ordenes_nodos_categoria';
    const orden_nodo_comanda = 'pos_ordenes_nodos_comandas';

    function getNodos(  $limit, $id , $filters){
    	$this->db->select('*');
        $this->db->from(self::nodos.' as nodo');
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = nodo.nodo_estado');
        $this->db->join(self::sucursal.' as s', 'on s.id_sucursal = nodo.Sucursal');
        
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

    function getAllNodos(){
        $this->db->select('*');
        $this->db->from(self::nodos);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::nodos);
    }

    function save($nodo){

        $nodo['nodo_key'] = md5(microtime().rand());
        $nodo['nodo_url'] = base_url().'nodo/index/'.$nodo['nodo_key'];

        $result = $this->db->insert(self::nodos, $nodo ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getNodoId( $nodo ){
        $this->db->select('*');
        $this->db->from(self::nodos);
        $this->db->where('id_nodo', $nodo );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($nodo){

        $nodoId = $nodo['id_nodo'];
        unset($nodo['id_nodo']);
        
        $this->db->where('id_nodo', $nodoId );
        $result =  $this->db->update(self::nodos, $nodo ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function asociarNodoCategoria($data)
    {
        $result = $this->checkIfNodoCategoriaExist($data);

        $nodo = [
            'id_categoria' => $data['categoria'],
            'id_nodo' => $data['nodo']
        ];

        if (!$result) {

            $result = $this->db->insert(self::nodos_categoria, $nodo ); 
    
            if(!$result){
                $result = $this->db->error();
            }
        } else {

            $this->db->where('id_nodo', $nodo['id_nodo']);
            $this->db->where('id_categoria', $nodo['id_categoria']);
            $result =  $this->db->delete(self::nodos_categoria, $nodo );

            if(!$result){
                $result = $this->db->error();
            }
        }
        return $result;
    }

    function checkIfNodoCategoriaExist($data)
    {
        $this->db->select('*');
        $this->db->from(self::nodos_categoria);
        $this->db->where('id_nodo', $data['nodo']);
        $this->db->where('id_categoria', $data['categoria']);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getNodoCategoriaByNodo($nodo)
    {
        $this->db->select('id_categoria');
        $this->db->from(self::nodos_categoria);
        $this->db->where('id_nodo', $nodo);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function eliminar( $nodo ){
        
        $data = array(
            'id_nodo' => $nodo
        );

        $this->db->where('id_nodo', $nodo);
        $result =  $this->db->delete(self::nodos, $data );

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }


    // Commandas Calls 

    public function get_ordenes_by_key($key, $filter)
    {
        $nodo = $this->get_nodo_by_key($key);
        $categorias = $this->get_nodo_categories($nodo);
        $ordenes = $this->get_orden_to_nodo($nodo);
        $ordenes = $this->order_format($ordenes);

        return array(
            'nodo' => $nodo,
            'ordenes' => $ordenes,
            'categorias' => $categorias
        );
    }

    public function get_nodo_by_key($key)
    {
        $this->db->select('*');
        $this->db->from(self::nodos.' as nodo');
        $this->db->join(self::sucursal.' as s', 'on s.id_sucursal = nodo.Sucursal');
        $this->db->where('nodo.nodo_key', $key);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_nodo_categories($nodo)
    {
        $this->db->select('categoria.id_categoria');
        $this->db->from(self::nodos_categoria.' as categoria_nodo');
        $this->db->join(self::categoria.' as categoria', ' on categoria_nodo.id_categoria = categoria.id_categoria_padre');
        $this->db->where('categoria_nodo.id_nodo', $nodo[0]->id_nodo);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    private function order_format($ordenes)
    {
        if($ordenes) {
            foreach ($ordenes as $key => $orden) {
                $detalle = $this->get_order_detail($orden);

                $ordenes[$key]->detalle = $detalle;
            }
        }
        return $ordenes;
    }

    public function get_orden_to_nodo($nodo)
    {
        $this->db->select('orden.*');
        $this->db->from(self::ordenes.' as orden');
        //$this->db->join(self::orden_detalle.' as detalle', 'on detalle.id_orden = orden.id','left');
        $this->db->join(self::orden_nodo_comanda.' as comanda', 'on comanda.orden_comanda = orden.id','left');
        $this->db->join(self::nodos.' as nodo', 'on nodo.id_nodo = comanda.nodo_comanda','left');
        $this->db->where('orden.id_sucursal', $nodo[0]->Sucursal);
        //$this->db->where('detalle.id_orden_detalle = comanda.producto_comanda');
        $this->db->where('orden.orden_estado',1);
        //$this->db->group_by('orden.id');
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    private function get_order_detail($orden)
    {
        $this->db->select('*');
        $this->db->from(self::orden_detalle. ' as detalle');
        $this->db->join(self::orden_nodo_comanda.' as comanda', 'on comanda.producto_comanda = detalle.id_orden_detalle','left');
        $this->db->where('id_orden',$orden->id);
        $this->db->where('comanda.producto_comanda IS NULL');
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function moverComanda(array $data)
    {

        foreach ($data['items'][150]['detalle'] as $items) {
            $nodoComanda = array(
                'orden_comanda' => $data['comandaId'],
                'nodo_comanda' => $data['comandaNodo'],
                'producto_comanda' => $items['id_orden_detalle']
            );

            $this->db->insert(self::orden_nodo_comanda, $nodoComanda);
        }        
    }
}
