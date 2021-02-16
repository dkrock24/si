<?php
class Cliente_model extends CI_Model
{
    const cliente               = 'pos_cliente';
    const cliente2              = 'pos_cliente2';
    const formas_pago           = 'pos_formas_pago';
    const sys_persona           = 'sys_persona';
    const cliente_tipo          = 'pos_cliente_tipo';
    const cliente_tipo2         = 'pos_cliente_tipo2';
    const pos_fp_cliente        = 'pos_formas_pago_cliente';
    const pos_formas_pago_cliente2        = 'pos_formas_pago_cliente2';
    const pos_formas_pago       = 'pos_formas_pago';
    const pos_formas_pago2       = 'pos_formas_pago2';
    const tipos_documentos      = 'pos_tipo_documento';
    const pos_orden_estado      = 'pos_orden_estado';
    const pos_tipo_documento    = 'pos_tipo_documento';
    const pos_formas_pago_cliente = 'pos_formas_pago_cliente';

    function get_cliente(){
        $this->db->select('id_cliente,nombre_empresa_o_compania,nrc_cli,nit_cliente,nombre_empresa_o_compania,direccion_cliente,aplica_impuestos,TipoDocumento,saldos');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos, ' on ' . self::cliente . '.TipoDocumento=' . self::tipos_documentos . '.id_tipo_documento');
        $this->db->join(self::formas_pago, ' on ' . self::cliente . '.TipoPago=' . self::formas_pago . '.id_modo_pago');
        $this->db->join(self::sys_persona . ' as p', ' on p.id_persona = Persona');
        $this->db->where(self::cliente . '.estado_cliente = 1');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_cliente_filtro($cliente_texto){
        $this->db->select('id_cliente,nombre_empresa_o_compania,nrc_cli,nit_cliente,nombre_empresa_o_compania,direccion_cliente,aplica_impuestos,TipoDocumento,saldos');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos, ' on ' . self::cliente . '.TipoDocumento=' . self::tipos_documentos . '.id_tipo_documento');
        $this->db->join(self::formas_pago, ' on ' . self::cliente . '.TipoPago=' . self::formas_pago . '.id_modo_pago');
        $this->db->join(self::sys_persona . ' as p', ' on p.id_persona = Persona');
        $this->db->where(self::cliente . '.estado_cliente = 1');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->where("(id_cliente LIKE '%$cliente_texto%' || lower(nombre_empresa_o_compania) LIKE lower('%$cliente_texto%') || nit_cliente LIKE '%$cliente_texto%' || dui_cli LIKE '%$cliente_texto%' || nrc_cli LIKE '%$cliente_texto%' || codigo_cliente LIKE '%$cliente_texto%' ) ");
        $query = $this->db->get();
        //echo $this->db->queries[4];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_cliente_by_id2($id){
        $this->db->select('id_cliente,nombre_empresa_o_compania,nrc_cli,nit_cliente,nombre_empresa_o_compania,direccion_cliente,aplica_impuestos,porcentage_descuentos,TipoDocumento,TipoPago');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos, ' on ' . self::cliente . '.TipoDocumento=' . self::tipos_documentos . '.id_tipo_documento');
        $this->db->join(self::formas_pago, ' on ' . self::cliente . '.TipoPago=' . self::formas_pago . '.id_modo_pago');
        $this->db->where(self::cliente . '.estado_cliente = 1');
        
        $this->db->where('id_cliente = ' . $id);
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_clientes_id($cliente_id){

        $this->db->select('*');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos, ' on ' . self::cliente . '.TipoDocumento=' . self::tipos_documentos . '.id_tipo_documento');
        $this->db->join(self::formas_pago, ' on ' . self::cliente . '.TipoPago=' . self::formas_pago . '.id_modo_pago');
        $this->db->join(self::sys_persona . ' as p', ' on p.id_persona = Persona');
        $this->db->join(self::cliente_tipo . ' as ct', ' on ct.id_cliente_tipo = ' . self::cliente . '.id_cliente_tipo');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        //$this->db->where('estado = 1');
        $this->db->where('id_cliente = ' . $cliente_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getCliente($clienteNombre = null){
        $this->db->select('*');
        $this->db->from(self::cliente . ' as c');
        $this->db->join(self::tipos_documentos.' as td', ' on c.TipoDocumento=td.id_tipo_documento');
        $this->db->join(self::formas_pago.' as fp', ' on c.TipoPago=fp.id_modo_pago');
        $this->db->join(self::sys_persona . ' as p', ' on p.id_persona = Persona');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        if($clienteNombre){
            $this->db->where('c.nombre_empresa_o_compania', $clienteNombre);
        }
        $query = $this->db->get();
        //echo $this->db->queries[2];
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getAllClientes($limit, $id  , $filters){
        $this->db->select('p.primer_nombre_persona,p.primer_apellido_persona,fp.codigo_modo_pago,c.nombre_empresa_o_compania,
        c.nrc_cli,c.nit_cliente,c.clase_cli,c.estado_cliente,c.id_cliente,td.nombre,saldos,
        c.porcentage_descuentos,es.*');
        $this->db->from(self::cliente.' as c');
        $this->db->join(self::tipos_documentos.' as td', ' on c.TipoDocumento=td.id_tipo_documento');
        $this->db->join(self::formas_pago.' as fp', ' on c.TipoPago=fp.id_modo_pago');
        $this->db->join(self::sys_persona. ' as p', ' on p.id_persona = Persona');
        $this->db->join(self::pos_orden_estado. ' as es', ' on es.id_orden_estado = c.estado_cliente');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function record_count($filter){
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::cliente . ' as c');
        $this->db->join(self::sys_persona . ' as p', ' on c.Persona = p.id_persona');
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear_cliente($datos){
        // Insertando Imagenes empresa
        $imagen = "";
        if($_FILES['logo_cli']['tmp_name']){

            $imagen = file_get_contents($_FILES['logo_cli']['tmp_name']);
            $imageProperties = getimageSize($_FILES['logo_cli']['tmp_name']);
        }

        $registros = $this->getCliente($datos['nombre_empresa_o_compania']);
        if(!$registros)
        {
            $data = array(
                'website_cli'       => $datos['website_cli'],
                'nrc_cli'           => $datos['nrc_cli'],
                'nit_cliente'       => $datos['nit_cliente'],
                'dui_cli'           => $datos['dui_cliente'],
                'clase_cli'         => $datos['clase_cli'],
                'mail_cli'          => $datos['mail_cli'],            
                'TipoPago'          => $datos['TipoPago'],
                'TipoDocumento'     => $datos['TipoDocumento'],
                'nombre_empresa_o_compania' => $datos['nombre_empresa_o_compania'],
                'numero_cuenta'     => $datos['numero_cuenta'],
                'aplica_impuestos'  => $datos['aplica_impuestos'],
                'direccion_cliente' => $datos['direccion_cliente'],
                'porcentage_descuentos'=> $datos['porcentage_descuentos'],
                'estado_cliente'    => $datos['estado'],
                'creado'            => date("Y-m-d h:i:s"),
                'Persona'           => $datos['Persona'],
                'natural_juridica'  => $datos['natural_juridica'],
                'id_cliente_tipo'   => $datos['id_cliente_tipo']
            );

            if( $imagen && $imageProperties){

                $data['logo_cli']  = $imagen;
                $data['logo_type']  = $imageProperties['mime'];

            }

            $result = $this->db->insert(self::cliente, $data);

            if(!$result){
                $result = $this->db->error();
            }
            $this->crearFpCliente($this->db->insert_id(),  $datos);

            return $result;
        }else{
            return $result = [
                'code' => 1,
                'message' => "El registro ya existe"
            ];
        }
    }

    function crearFpCliente($clienteId, $formas_pago){

        $pagos = $this->getPagos();        
        
        foreach ($pagos as $key => $value) {
            $data = array(
                'Cliente_form_pago' => $clienteId,
                'Forma_pago' => $value->id_modo_pago,
                'for_pag_emp_estado' => 0
            );
            $this->db->insert(self::pos_fp_cliente, $data);
        }
        
        foreach ($formas_pago as $key => $value) {

            $valor = (int) $key;

            if ($valor != 0) {

                $data = array(
                    'for_pag_emp_estado' => 1
                );

                $this->db->where('Forma_pago', $valor );
                $this->db->where('Cliente_form_pago', $clienteId );
                $this->db->update(self::pos_fp_cliente, $data);
            }
        }
        
    }

    function updateFpCliente($clienteId, $formas_pago){
        $getClienteFP = $this->getPagosClientes($clienteId, 1);

        if($getClienteFP){
            foreach ($getClienteFP as $key => $f_cliente) {

                if (array_key_exists($f_cliente->Forma_pago, $formas_pago)) {

                    $data = array(
                        'for_pag_emp_estado' => 1
                    );

                    $this->db->where('Forma_pago', $f_cliente->Forma_pago);
                    $this->db->where('Cliente_form_pago', $f_cliente->Cliente_form_pago);
                    $this->db->update(self::pos_formas_pago_cliente, $data);
                } else {

                    $data = array(
                        'for_pag_emp_estado' => 0
                    );

                    $this->db->where('Forma_pago', $f_cliente->Forma_pago);
                    $this->db->where('Cliente_form_pago', $f_cliente->Cliente_form_pago);
                    $this->db->update(self::pos_formas_pago_cliente, $data);

                }
            }
        }else{
            $this->crearFpCliente($clienteId, $formas_pago);
        }
    }

    function getPagosClientes($idCliente, $pago){
        $this->db->select('*');
        $this->db->from(self::pos_formas_pago_cliente . ' as fpc');
        $this->db->join(self::formas_pago . ' as fp', ' on fpc.Forma_pago=fp.id_modo_pago');
        $this->db->where('fpc.Cliente_form_pago', $idCliente);
        //$this->db->where('fpc.Forma_pago', $pago);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getPagosClientes2($idCliente){
        $this->db->select('*');
        $this->db->from(self::pos_formas_pago_cliente . ' as fpc');
        $this->db->join(self::formas_pago . ' as fp', ' on fpc.Forma_pago=fp.id_modo_pago');
        $this->db->where('fpc.Cliente_form_pago', $idCliente);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getPagos(){
        $this->db->select('*');        
        $this->db->from(self::formas_pago);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function update($datos){
        $data = array(
            'website_cli'       =>  $datos['website_cli'],
            'nrc_cli'           => $datos['nrc_cli'],
            'nit_cliente'       => $datos['nit_cliente'],
            'dui_cli'           => $datos['dui_cliente'],
            'clase_cli'         => $datos['clase_cli'],
            'mail_cli'          => $datos['mail_cli'],
            'TipoPago'          => $datos['TipoPago'],
            'TipoDocumento'     => $datos['TipoDocumento'],
            'nombre_empresa_o_compania' => $datos['nombre_empresa_o_compania'],
            'numero_cuenta'             => $datos['numero_cuenta'],
            'aplica_impuestos'          => $datos['aplica_impuestos'],
            'direccion_cliente'         => $datos['direccion_cliente'],
            'porcentage_descuentos'     => $datos['porcentage_descuentos'],
            'estado_cliente'            => $datos['estado'],
            'creado'                    => date("Y-m-d h:i:s"),
            'Persona'                   => $datos['Persona'],
            'natural_juridica'          => $datos['natural_juridica'],
            'id_cliente_tipo'           => $datos['id_cliente_tipo']
        );

        if (isset($_FILES['logo_cli']) && $_FILES['logo_cli']['tmp_name'] != null) {
            // Insertando Imagenes Cliente
            $imagen = "";
            $imagen = file_get_contents($_FILES['logo_cli']['tmp_name']);
            $imageProperties = getimageSize($_FILES['logo_cli']['tmp_name']);

            $data = array_merge($data, array('logo_cli' => $imagen, 'logo_type' => $imageProperties['mime']));
        }

        $this->db->where('id_cliente', $datos['id_cliente']);
        $result = $this->db->update(self::cliente, $data);

        $this->updateFpCliente($datos['id_cliente'],  $datos);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar( $cliente_id ){

        $data = array(
            'Cliente_form_pago' => $cliente_id
        );

        $this->db->where($data);
        $this->db->delete(self::pos_fp_cliente);

        $data = array(
            'id_cliente' => $cliente_id
        );        

        $this->db->where($data);
        $this->db->delete(self::cliente);

        return 1;

    }

    function insert_api($clienteTipos)
    {
        $this->db->truncate(self::cliente_tipo2);

        $data = [];
        foreach ($clienteTipos as $key => $clienteTipo) {
            $data[] = $clienteTipo;
        }
        $this->db->insert_batch(self::cliente_tipo2, $data);
        //var_dump($this->db->error());
    }

    function insert_api2($clientes)
    {
        $this->db->truncate(self::cliente2);

        $data = [];
        foreach ($clientes as $key => $cliente) {
            $cliente->logo_cli = base64_decode($cliente->logo_cli);
            $data[] = $cliente;
        }
        $this->db->insert_batch(self::cliente2, $data);
    }

    function insert_cp_api($clientePago)
    {
        $this->db->truncate(self::pos_formas_pago_cliente2);

        $data = [];
        foreach ($clientePago as $key => $pago) {
            $data[] = $pago;
        }
        $this->db->insert_batch(self::pos_formas_pago_cliente2, $data);
    }
}
