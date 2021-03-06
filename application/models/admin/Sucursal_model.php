<?php
class Sucursal_model extends CI_Model
{

    const pos_sucursal  = 'pos_sucursal';
    const sucursal2     = 'pos_sucursal2';
    const pos_bodega    = 'pos_bodega';
    const pos_bodega2    = 'pos_bodega2';
    const pos_empresa   = 'pos_empresa';
    const sys_usuario   = 'sys_usuario';
    const sys_empleado      = 'sys_empleado';
    const pos_orden_estado  = 'pos_orden_estado';
    const sys_empleado_sucursal = 'sys_empleado_sucursal';
    const sys_empleado_sucursal2 = 'sys_empleado_sucursal2';
    const sys_ciudad = 'sys_ciudad';
    const sys_departamento = 'sys_departamento';
    const sys_pais = 'sys_pais';
    const pos_temp_sucursal2 = 'pos_temp_sucursal2';
    const pos_corte_config2 = 'pos_corte_config2';

    function getSucursal()
    {

        $this->db->select('DISTINCT(s.id_sucursal) , s.*');
        $this->db->from(self::pos_sucursal . ' as s');
        $this->db->join(self::pos_bodega . ' as b', ' On s.id_sucursal = b.Sucursal', 'right');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getSucursalEmpleado($id_usuario)
    {

        $this->db->select('*');
        $this->db->from(self::pos_sucursal . ' as s');
        $this->db->join(self::sys_empleado_sucursal . ' as es', ' on s.id_sucursal = es.es_sucursal');
        $this->db->join(self::sys_usuario . ' as u', ' u.Empleado = es.es_empleado');
        $this->db->join(self::pos_empresa . ' as e', ' e.id_empresa = s.Empresa_Suc');
        $this->db->where('u.id_usuario', $id_usuario);
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        //echo $this->db->queries[2];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getAllSucursalEmpresa()
    {

        $this->db->select('*');
        $this->db->from(self::pos_sucursal . ' as b');
        $this->db->where('b.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->order_by('nombre_sucursal', 'asc');
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getSucursalEmpresa($empresa_id)
    {

        $this->db->select('*');
        $this->db->from(self::pos_sucursal . ' as b');
        $this->db->where('b.Empresa_Suc', $empresa_id);
        $this->db->order_by('b.nombre_sucursal', 'asc');
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getSucursalId($empresa_id)
    {

        $this->db->select('*');
        $this->db->from(self::pos_sucursal . ' as b');
        $this->db->where('b.id_sucursal', $empresa_id);
        $this->db->where('b.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getAllSucursal($limit, $id, $filters)
    {

        $this->db->select('s.*,es.*,e.nombre_comercial, e.id_empresa,c.*,d.*,p.*');
        $this->db->from(self::pos_sucursal . ' as s');
        $this->db->join(self::pos_empresa . ' as e', ' on s.Empresa_Suc = e.id_empresa');
        $this->db->join(self::sys_ciudad . ' as c', ' on s.Ciudad_Suc = c.id_ciudad');
        $this->db->join(self::sys_departamento . ' as d', ' on d.id_departamento = c.departamento');
        $this->db->join(self::sys_pais . ' as p', ' on p.id_pais = d.pais');
        $this->db->join(self::pos_orden_estado . ' as es', 'on es.id_orden_estado = s.sucursal_estado');
        //$this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->order_by('p.id_pais', 'asc');
        $this->db->order_by('e.id_empresa', 'asc');
        $this->db->order_by('s.nombre_sucursal', 'asc');
        if ($filters != "") {
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getSucursalByEmployee($empleado)
    {

        $this->db->select('s.*');
        $this->db->from(self::pos_sucursal . ' as s');
        $this->db->join(self::sys_empleado . ' as em', ' on s.id_sucursal = em.Sucursal');
        $this->db->where('em.id_empleado', $empleado);
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function record_count($filter)
    {

        $this->db->where('Empresa_Suc', $this->session->empresa[0]->id_empresa . ' ' . $filter);
        $this->db->from(self::pos_sucursal);
        $result = $this->db->count_all_results();

        return $result;
    }

    function crear_sucursal($datos)
    {
        $result   = $this->db->insert(self::pos_sucursal, $datos);
        $id       = $this->db->insert_id();
        $empleado = $this->session->userdata['usuario'][0]->id_empleado;

        if ($id) {
            $this->insert_empleado_sucursal($empleado, $id);
        }

        if (!$result) {
            $result = $this->db->error();
        }

        return $result;
    }

    function insert_empleado_sucursal($empleado, $sucursal)
    {

        $data = array(
            'es_empleado'   => $empleado,
            'es_sucursal'   => $sucursal,
            'es_creado'     => date("Y-m-d h:i:s"),
            'es_estado'     => 1
        );
        $result = $this->db->insert(self::sys_empleado_sucursal, $data);

        if (!$result) {
            $result = $this->db->error();
        }

        return $result;
    }

    function actualizar($datos)
    {
        $this->db->where('id_sucursal', $datos['id_sucursal']);
        $result = $this->db->update(self::pos_sucursal, $datos);
        if (!$result) {
            $result = $this->db->error();
        }

        return $result;
    }

    function delete($id)
    {

        $data   = array(
            'es_sucursal' => $id
        );

        $result = $this->db->delete(self::sys_empleado_sucursal, $data);

        $data   = array(
            'id_sucursal' => $id
        );

        $result = $this->db->delete(self::pos_sucursal, $data);

        if (!$result) {
            $result = $this->db->error();
        }

        return $result;
    }

    function insert_api($sucursales)
    {
        $this->db->truncate(self::sucursal2);

        $data = [];
        foreach ($sucursales as $key => $sucursal) {
            $data[] = $sucursal;
        }
        $this->db->insert_batch(self::sucursal2, $data);
    }

    function insert_st_api($sucursales_template)
    {
        $this->db->truncate(self::pos_temp_sucursal2);

        $data = [];
        foreach ($sucursales_template as $key => $template) {
            $data[] = $template;
        }
        $this->db->insert_batch(self::pos_temp_sucursal2, $data);
    }

    function insert_em_api($sucursales_empleado)
    {
        $this->db->truncate(self::sys_empleado_sucursal2);

        $data = [];
        foreach ($sucursales_empleado as $key => $template) {
            $data[] = $template;
        }
        $this->db->insert_batch(self::sys_empleado_sucursal2, $data);
        //var_dump($this->db->error());
    }

    function insert_sb_api($sucursales_bodega)
    {
        $this->db->truncate(self::pos_bodega2);

        $data = [];
        foreach ($sucursales_bodega as $key => $bodega) {
            $data[] = $bodega;
        }
        $this->db->insert_batch(self::pos_bodega2, $data);
    }

    function insert_sc_api($corte_config)
    {
        $this->db->truncate(self::pos_corte_config2);

        $data = [];
        foreach ($corte_config as $key => $config) {
            $data[] = $config;
        }
        $this->db->insert_batch(self::pos_corte_config2, $data);
    }
}
