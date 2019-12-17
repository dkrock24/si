<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Acceso_model extends CI_Model
{
    const libreria  = 'sys_librerias';
    const configuracion = 'sys_config';
    const menu      = 'sys_menu';
    const empresa   = 'sys_empresa';
    const usuarios  = 'sys_usuarios';
    const roles     = 'sys_role';
    const cargos    = 'sys_cargos';
    const vistas =  'sys_vistas';
    const vista_acceso = 'sys_vistas_acceso';
    const sys_menu_submenu  = 'sys_menu_submenu';
    const submenu_acceso    = 'sys_submenu_acceso';
    const sys_menu    = 'sys_menu';
    const sys_vistas = 'sys_vistas';
    const sys_vistas_acceso = 'sys_vistas_acceso';
    const sys_vistas_componentes = 'sys_vistas_componentes';
    const sys_componentes = 'sys_componentes';

    public function __construct()
    {
        parent::__construct();
    }
    //Actualizar Roles
    public function updateRol()
    {
        $data = array(
            'nombre_rol' => $_POST['nombre']
        );
        $this->db->where('id_rol', $_POST['id_rol']);
        $this->db->update(self::roles, $data);
        //echo $this->db->queries[0];   
    }
    //Delete Rol
    public function deleteRol()
    {
        $data = array(
            'id_rol' => $_POST['id_rol']
        );
        $this->db->delete(self::roles, $data);
        //echo $this->db->queries[0];   
    }

    //Actualizar Cargos
    public function updateCargo()
    {
        $data = array(
            'nombre_cargo' => $_POST['nombre']
        );
        $this->db->where('id_cargo', $_POST['id_cargo']);
        $this->db->update(self::cargos, $data);
        //echo $this->db->queries[0];   
    }

    //Delete Cargos
    public function deleteCargo()
    {
        $data = array(
            'id_cargo' => $_POST['id_cargo']
        );
        $this->db->delete(self::cargos, $data);
        //echo $this->db->queries[0];   
    }


    public function getAccesoRol($data)
    {
        $this->db->select('*');
        $this->db->from(self::roles);
        $this->db->where('pages_config', $location);
        $this->db->where('estado_config', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function get_menu_acceso($rol, $menu, $referencia)
    {
        $this->db->select('*');
        $this->db->from(self::submenu_acceso . ' as sma');
        $this->db->join(self::sys_menu_submenu . ' as sm ', ' on sm.id_submenu = sma.id_submenu');
        $this->db->join(self::sys_menu . ' as m ', ' on m.id_menu = sm.id_menu');
        $this->db->join(self::roles . ' as r ', ' on r.id_rol = sma.id_role');
        $this->db->where('sma.id_role', $rol);
        $this->db->where('m.id_menu', $menu);
        $this->db->where('sm.estado_referencia is null');
        $query = $this->db->get();
        //echo $this->db->queries[0];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function get_menu_internos($rol, $menu)
    {
        $this->db->select('*');
        $this->db->from(self::submenu_acceso . ' as sma');
        $this->db->join(self::sys_menu_submenu . ' as sm ', ' on sm.id_submenu = sma.id_submenu');
        $this->db->join(self::sys_menu . ' as m ', ' on m.id_menu = sm.id_menu');
        $this->db->join(self::roles . ' as r ', ' on r.id_rol = sma.id_role');
        $this->db->where('sma.id_role', $rol);
        $this->db->where('m.id_menu', $menu);
        $this->db->where('sm.estado_referencia', 1);
        $query = $this->db->get();
        //echo $this->db->queries[1];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    // Permisos Vistas Compoenetes
    public function get_vista_componentes($rol, $menu)
    {
        $this->db->select('*');
        $this->db->from(self::sys_vistas . ' as v');
        $this->db->join(self::sys_vistas_componentes . ' as vc ', ' on vc.Vista = v.id_vista');
        $this->db->join(self::sys_componentes . ' as c ', ' on c.id_vista_componente = vc.Componente');
        $this->db->join(self::sys_vistas_acceso . ' as va ', ' on va.id_vista_componente = vc.id');
        $this->db->join(self::sys_menu_submenu . ' as submenu ', ' on submenu.id_vista = v.id_vista');
        $this->db->join(self::menu . ' as menu ', ' on menu.id_menu = submenu.id_menu');
        $this->db->join(self::roles . ' as r ', ' on r.id_rol = va.id_role');
        $this->db->where('va.id_role', $rol);
        $this->db->where('menu.id_menu', $menu);
        $query = $this->db->get();
        //echo $this->db->queries[0];

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function sincronizar_componentes($id_rol, $id_menu)
    {

        $vista_comp = $this->get_vista_component($id_menu);
        $vista_accs = 0;

        if ($vista_comp) {
            foreach ($vista_comp as $componente) {
                $vista_accs = $this->get_vista_acceso($id_rol, $componente->id);

                if (!$vista_accs) {
                    $data = array(
                        'id_role' => $id_rol,
                        'id_vista_componente' => $componente->id,
                        'vista_acceso_creado' => date("Y-m-d H:i:s"),
                        'vista_acceso_estado' => 0
                    );
                    $this->db->insert(self::sys_vistas_acceso, $data);
                }
            }
        }
    }

    function get_vista_component($vista)
    {

        $this->db->select('*');
        $this->db->from(self::sys_vistas_componentes);
        $this->db->where('vista', $vista);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_vista_acceso($id_rol, $componente)
    {

        $this->db->select('*');
        $this->db->from(self::sys_vistas_acceso);
        $this->db->where('id_role', $id_rol);
        $this->db->where('id_vista_componente', $componente);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    // Actualizar el Accesos Para el  Rol
    public function update_acceso_menu($datos)
    {

        $accesos_rol = $this->get_menu_acceso($datos['id_role'], $datos['id_menu'], $var = null);

        foreach ($accesos_rol as $ac) {

            if (array_key_exists($ac->id_submenu_acceso, $datos)) {

                $data = array('submenu_acceso_estado' => 1);
                $this->db->where('id_role', $datos['id_role']);
                $this->db->where('id_submenu_acceso', $ac->id_submenu_acceso);
                $this->db->update(self::submenu_acceso, $data);
            } else {

                $data = array('submenu_acceso_estado' => 0);
                $this->db->where('id_role', $datos['id_role']);
                $this->db->where('id_submenu_acceso', $ac->id_submenu_acceso);
                $this->db->update(self::submenu_acceso, $data);
            }
        }
    }

    // Actualizar el Accesos Para el  Rol
    public function update_acceso_menu_interno($datos)
    {

        $accesos_rol = $this->get_menu_acceso($datos['id_role'], $datos['id_menu'], 1);

        foreach ($accesos_rol as $ac) {
            if (array_key_exists($ac->id_submenu_acceso, $datos)) {
                $data = array('submenu_acceso_estado' => 1);

                $this->db->where('id_role', $datos['id_role']);
                $this->db->where('id_submenu_acceso', $ac->id_submenu_acceso);
                $this->db->update(self::submenu_acceso, $data);
            } else {
                $data = array('submenu_acceso_estado' => 0);
                $this->db->where('id_role', $datos['id_role']);
                $this->db->where('id_submenu_acceso', $ac->id_submenu_acceso);
                $this->db->update(self::submenu_acceso, $data);
            }
        }
    }

    public function accesos_componentes($id_rol, $menu)
    {

        $this->db->select('*');
        $this->db->from(self::sys_vistas_acceso . ' as a');
        $this->db->join(self::sys_vistas_componentes . ' as vc', ' on a.id_vista_componente = vc.id');
        $this->db->join(self::sys_componentes . ' as c', ' on c.id_vista_componente = vc.componente');
        $this->db->join(self::sys_vistas . ' as v', ' on v.id_vista = vc.vista');
        $this->db->join(self::sys_menu_submenu . ' as ms', ' on ms.id_vista=v.id_vista');
        $this->db->join(self::menu . ' as m', ' on m.id_menu = ms.id_menu');
        $this->db->where('a.id_role', $id_rol);
        $this->db->where('m.id_menu', $menu);
        $query = $this->db->get();
        //echo $this->db->queries[13];
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    // Acceso a componntes
    public function accesos_componenes($datos)
    {

        $accesos_rol = $this->get_vista_componentes($datos['id_role'], $datos['id_menu']);


        if ($accesos_rol) {
            foreach ($accesos_rol as $ac) {
                if (array_key_exists($ac->id_vista_acceso, $datos)) {
                    $data = array('vista_acceso_estado' => 1);

                    $this->db->where('id_role', $datos['id_role']);
                    $this->db->where('id_vista_componente', $ac->id_vista_componente);
                    $this->db->update(self::sys_vistas_acceso, $data);
                } else {
                    $data = array('vista_acceso_estado' => 0);
                    $this->db->where('id_role', $datos['id_role']);
                    $this->db->where('id_vista_componente', $ac->id_vista_componente);
                    $this->db->update(self::sys_vistas_acceso, $data);
                }
            }
        }
    }

    // Obtener Los Accesos Por Rol
    public function get_access_by_rol($id_rol)
    {
        $this->db->select('*');
        $this->db->from(self::submenu_acceso . ' as a');
        $this->db->where('a.id_role =' . $id_rol);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getMenu()
    {
        $this->db->select('*');
        $this->db->from(self::menu);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getRoles()
    {
        $this->db->select('*');
        $this->db->from(self::roles . ' as r');
        $this->db->where('r.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function getCargos()
    {
        $this->db->select('*');
        $this->db->from(self::cargos);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    public function login($usuario, $password)
    {
        $pass = $this->encrypt($password);
        $this->db->select('*');
        $this->db->from(self::usuarios);
        $this->db->where('usuario', $usuario);
        $this->db->where('password', $pass);
        $query = $this->db->get();
        //echo $this->db->queries[0];   
        //exit(); 

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    public function delete_acceso($rol_id)
    {
        $data = array(
            'id_rol' => $rol_id
        );
        $this->db->delete('sys_menu_acceso', $data);
    }

    function vistas_components()
    {

        $this->db->select('*');
        $this->db->from(self::sys_vistas_componentes);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function sincAccionesRoles()
    {
        $result = array();

        $cnt = 0;

        $roles = $this->getRoles();

        $vista_compo = $this->vistas_components();    

        foreach ($roles as $key => $r) {

            foreach ($vista_compo as $vc) {

                $data = $this->get_vista_acceso($r->id_rol, $vc->id);

                if (!$data) {

                    $registros = array(
                        'id_role' => $r->id_rol,
                        'id_vista_componente' => $vc->id,
                        'vista_acceso_creado'=> date('Y-m-d H:i:s'),
                        'vista_acceso_estado' => 0
                    );

                    $result[$cnt] = $registros;

                    $this->db->insert(self::sys_vistas_acceso, $registros);
                    
                    $cnt++;
                }
            }
        }

        $sys_menu_submenu  = $this->sys_menu_submenu();

        foreach ($roles as $key => $r) {

            foreach ($sys_menu_submenu as $sm) {

                $acceso_rol = $this->get_rol_acceso($r->id_rol, $sm->id_submenu);

                if (!$acceso_rol) {

                    $registros = array(
                        'id_submenu' => $sm->id_submenu,
                        'id_role' => $r->id_rol,
                        'submenu_acceso_estado' => 0
                    );

                    $this->db->insert(self::submenu_acceso, $registros);

                }

            }

        }
        
    }

    public function get_rol_acceso( $rol , $menu ){

        $this->db->select('*');
        $this->db->from(self::submenu_acceso);

        $this->db->where('id_submenu', $menu );
        $this->db->where('id_role', $rol );

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }

    }

    public function sys_menu_submenu(){

        $this->db->select('*');
        $this->db->from(self::sys_menu_submenu);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    
}
/*
 * end of application/models/consultas_model.php
 */
