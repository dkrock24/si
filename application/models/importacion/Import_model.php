<?php
class Import_model extends CI_Model {

	const pos_agregar_code_barr = 'pos_agregar_code_barr';
    const producto = 'producto';
    const producto_atrib = 'producto_atributo';
    const producto_valor = 'producto_valor';
    const producto_detalle = 'producto_detalle';
    const pos_producto_bodega = 'pos_producto_bodega';
    const pos_sucursal = 'pos_sucursal';
    const pos_bodega = 'pos_bodega';
    const categoria = 'categoria';
    const categoria_producto = 'categoria_producto';
    const producto_general = 'producto_general';
    const pos_tipos_impuestos = 'pos_tipos_impuestos';
    const pos_impuesto_categoria = 'pos_impuesto_categoria';
	
	function getTablesDb(){
        $tables = $this->db->list_tables();
        return $tables;
    }

    function setForeignkey($relaciones){
        if(!empty($relaciones)){
            $this->db->query( $relaciones );
        }
    }

    function runFunctions($accion , $table){
        
        if($table!= "" && $accion != ""){
            $this->db->query( $accion .' '.$table );
            //$query->result();
        }
    }
    
    function insert( $data , $table ){

        $result = 0;

        $result = $this->db->insert($table, $data);
    }

    function insertProductoEncabezado( $producto ){

        $this->db->insert(self::producto, $producto ); 
        return $this->db->insert_id();
    }

    function insertProductoAttributo( $data_pa ){

        $this->db->insert(self::producto_atrib, $data_pa ); 
        return $this->db->insert_id();
    }

    function insertAttributoValor( $data_av){

        $this->db->insert(self::producto_valor, $data_av ); 
        return $this->db->insert_id();
    }

    function insertarPresentacion($detalle){
        $this->db->insert(self::producto_detalle, $detalle );
    }

    function insertProductoBodega($newProduct){

        $bodegas = array(1,2,3,53); //$this->getBodegas();

        foreach ($bodegas as $b) {

            $data = array(
                'Bodega' => $b,
                'Producto' => $newProduct,
                'Cantidad' => 10000,
                'Descripcion' => '',
                'pro_bod_creado' => date('Y-m-d H:i:s'),
                'pro_bod_estado' => 1
            );
            $this->db->insert(self::pos_producto_bodega, $data );
        }
    }

    function getBodegas(){

        $this->db->where('Empresa_Suc',1);
        $this->db->from(self::pos_bodega.' as b');
        $this->db->join(self::pos_sucursal. ' as s',' on s.id_sucursal = b.Sucursal');
        $result = $this->db->get();
        return $result->result();

    }

    function Generador( $cnt ){
        $product = $this->product();
        
        unset($product[0]['current_row']);
        unset($product[0]['id_entidad']);
        $product[0]['name_entidad'] = $cnt;

        $this->db->insert(self::producto, $product[0]);
        $newProduct = $this->db->insert_id();

        $detalle = array(
            'Producto' => $newProduct,
            'factor' => 1,
            'presentacion' => 'Unidad',
            'precio' => 100,
            'unidad' => 100,
            'Utilidad' => 50,
            'cod_barra' => rand(),
            'estado_producto_detalle' => 1,
            'fecha_creacion_producto_detalle' => date('Y-m-d H:i:s')
        );
        $this->db->insert(self::producto_detalle, $detalle );

        $sucursal = array(
            1,2,3,53
        );

        foreach ($sucursal as $value) {

            $data = array(
                'Bodega' => $value,
                'Producto' => $newProduct,
                'Cantidad' => 100,
                'Descripcion' => 'abc',
                'pro_bod_creado' => date('Y-m-d H:i:s'),
                'pro_bod_estado' => 1
            );
            $this->db->insert(self::pos_producto_bodega, $data );
        }

        $pa = $this->pa();

        foreach ($pa as $key => $value) {
            $data = array(
                'Atributo' => $value['Atributo'],
                'Producto' => $newProduct
            );
            $this->db->insert(self::producto_atrib, $data );
            $proAtr = $this->db->insert_id();

            $pav = $this->pav($value['id_prod_atrri']);

            $data = array(
                'id_prod_atributo' => $proAtr,
                'valor' => $pav[0]['valor']
            );
            $this->db->insert(self::producto_valor, $data );

        }
    }


    function product(){
        $this->db->where('id_entidad',1);
		$this->db->from(self::producto);
		$result = $this->db->get();
        return $result->result_array();
    }

    function get_productos(){

        $this->db->select('*');
        $this->db->from(self::producto);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function pa(){
        $this->db->where('Producto',1);
		$this->db->from(self::producto_atrib);
		$result = $this->db->get();
        return $result->result_array();
    }

    function pav($id){
        $this->db->where('id_prod_atributo',$id);
		$this->db->from(self::producto_valor);
		$result = $this->db->get();
        return $result->result_array();
    }

    function get_detalle_pivote( $codigo_producto ){
        
        $this->db->select('*');
        $this->db->from(self::producto_general);
        $this->db->where('codigo', $codigo_producto);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function insertCategoriaProducto( $id_producto , $id_subcategoria , $padre ){

       $categoria = $this->getSubCategoria( $id_subcategoria , $padre );

        if($categoria[0]['id_categoria']){
            $data = array(
            'id_categoria' => $categoria[0]['id_categoria'],
            'id_producto' => $id_producto
            );

            $this->db->insert(self::categoria_producto, $data );
        }

    }

    function getSubCategoria( $id_subcategoria , $id_padre ){

        $this->db->select('id_categoria');
        $this->db->from(self::categoria);
        $this->db->where('codigo_subcategoria', $id_subcategoria);
        $this->db->where('codigo_categoria_padre', $id_padre);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function generar_impuestos_categorias($filtro){

        /*
        / Esta funciona es dinamica en el sentido que toma parametros para llamar tablas y hacer condiciones
        / dependiendo de lo que resibe y procesa la insercion, sincronizacion de los impoestos
        / asociados a las tablas que almacenan sus relaciones
        */

        $parametros = array(
            'id_categoria','id_tipo_documento','id_cliente','id_proveedor'
        );
        
        $param1 = "";
        $param2 = "";
        $campo = ""  ;   
        $campo2 = ""  ;      
        $table = "";
        $tabla_imp = "";
        $valor= "";

        if( $filtro['categoria'] != '-' ){
            $param1 = "id_categoria_padre";
            $param2 = $parametros[0];
            $table = "categoria";
            $valor = $filtro['categoria'];
            $campo = "Categoria";
            $tabla_imp = "pos_impuesto_categoria";
            $campo2 = "id_imp_cat";
        }
        if( $filtro['cliente'] != '-' ){
            $param1 = $parametros[2];
            $param2 = $parametros[2];
            $table = "pos_cliente";
            $valor = $filtro['cliente'];
            $campo = "Cliente";
            $tabla_imp = "pos_impuesto_cliente";
            $campo2 = "id_imp_cli";
        }
        if( $filtro['documento'] != '-' ){
            $param1 = $parametros[1];
            $param2 = $parametros[1];
            $table = "pos_tipo_documento";
            $valor = $filtro['documento'];
            $campo = "Documento";
            $tabla_imp = "pos_impuesto_documento";
            $campo2 = "id_imp_doc";
        }
        if( $filtro['proveedor'] != '-' ){
            $param1 = $parametros[3];
            $param2 = $parametros[3];
            $table = "pos_proveedor";
            $valor = $filtro['proveedor'];
            $campo = "Proveedor";
            $tabla_imp = "pos_impuesto_proveedor";
            $campo2 = "id_imp_prov";
        }

        $categorias = $this->getData( $param1 , $param2 , $valor , $table);

        foreach ($categorias as $key => $value) {

            $exits = $this->getImpCat($valor , $filtro['impuesto'] , $table, $param1 , $param2 , $campo, $tabla_imp);

            if(!$exits){

                $data = array(
                    $campo => $value[$param2] ,
                    'Impuesto' => $filtro['impuesto'],
                    'estado' => $filtro['activo']
                );
        
                $this->db->insert($tabla_imp, $data );
            }else{

                if($filtro['actualizar'] == 1){
                    
                    $data = array(
                        $campo => $value[$param2] ,
                        'Impuesto' => $filtro['impuesto'],
                        'estado' => $filtro['activo']
                    );
            
                    $this->db->update($tabla_imp, array($campo2 => $exits[0]->$campo2 ) );
                }
            }
        }

        
    }

    function getImpCat($valor , $imp , $table, $param1 , $param2 , $campo , $tabla_imp){

        $this->db->select('*');
        $this->db->from($tabla_imp);
        $this->db->where( $campo, $valor );
        $this->db->where('Impuesto', $imp);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }

    }

    function getImpuestos(){

        $this->db->select('*');
        $this->db->from(self::pos_tipos_impuestos);
        $this->db->where('id_tipos_impuestos', 1);  
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function getData( $param1 , $param2 , $valor , $table){

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($param1.' !=""'); 
        if($valor!=0){
            $this->db->where($param2, $valor); 
        }   
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
}