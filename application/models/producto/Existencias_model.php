<?php
class Existencias_model extends CI_Model {

	const pos_agregar_code_barr = 'pos_agregar_code_barr';
    const producto = 'producto';
        const atributo =  'atributo';
        const atributo_opcion =  'atributos_opciones';
        const categoria =  'categoria';
        const producto_valor =  'producto_valor';
        const categoria_producto =  'categoria_producto';       
        const producto_atributo =  'producto_atributo';
        const empresa_giro =  'giros_empresa';
        const giro_plantilla =  'giro_pantilla';
        const pos_linea = 'pos_linea';
        const proveedor = 'pos_proveedor';
        const producto_proveedor = 'pos_proveedor_has_producto';
        const marcas = 'pos_marca';
        const cliente = 'pos_cliente';
        const sucursal = 'pos_sucursal';
        const producto_detalle = 'prouducto_detalle';
        const impuestos = 'pos_tipos_impuestos';
        const producto_img = 'pos_producto_img';
        const pos_proveedor_has_producto = 'pos_proveedor_has_producto';
        const producto_bodega = 'pos_producto_bodega';
        const pos_ordenes = 'pos_ordenes';

        const pos_ordenes_detalle = 'pos_orden_detalle';
	

    function get_producto_completo($producto_id){
            
            $query = $this->db->query("select * from producto as p
                                left join pos_producto_bodega as pb on pb.Producto = p.id_entidad
                                left join pos_bodega as b on b.id_bodega = pb.Bodega
                                left join pos_sucursal as s on s.id_sucursal = b.Sucursal
                                left join producto_atributo pa on pa.Producto = p.id_entidad
                                left join producto_valor pv on pv.id_prod_atributo = pa.id_prod_atrri
                                where pa.Atributo =14
                and p.id_entidad = ". $producto_id);
                //echo $this->db->queries[1];
                return $query->result();

        }

        function get_producto_completo2($producto_id){
            
            $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
                    , A.nam_atributo, A.id_prod_atributo , pv2.valor as valor, b.nombre_bodega, pinv.id_inventario
                    , tipo_imp_prod.tipos_impuestos_idtipos_impuestos, impuestos.porcentage

                FROM `producto` as `P`
                LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`Producto`
                LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
                LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
                LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
                LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
                LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
                LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
                LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
                LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
                LEFT JOIN `pos_producto_bodega` as `pb` ON `pb`.`Producto` = `P`.`id_entidad`
                LEFT JOIN `pos_bodega` as `b` ON `b`.`id_bodega` = `pb`.`Bodega`
                LEFT JOIN producto_valor AS pv2 on pv2.id_prod_atributo = PA.id_prod_atrri
                LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
                LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
                LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos

                WHERE P.id_entidad = ". $producto_id);
                //echo $this->db->queries[1];
                return $query->result();

        }
}