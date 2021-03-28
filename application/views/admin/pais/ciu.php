<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/pais/dep/<?php echo $id_pais ?>" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Departamentos</button> </a>
            <a name="../dep/<?php echo $ciu[0]->id_pais;  ?>" style="top: 0px;position: relative; text-decoration: none">
                <?php $this->load->view('notificaciones/success'); ?>
        </h3>

        <div class="panel panel-default">
            <!-- START table-responsive-->
            <div class="">
                <table id="datatable1" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pais</th>
                            <th>Cod</th>
                            <th>Departamento</th>
                            <th>Cod</th>
                            <th>Ciudad</th>
                            <th>Creado</th>
                            <th>Actualizado</th>
                            <th>Estado</th>
                            <th>
                                <a name="admin/pais/nuevo_ciu/<?php echo $id_dep ?>" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">Nuevo</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contado = 1;
                        foreach ($ciu as $ciudad) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $contado; ?></th>
                                <td><?php echo $ciudad->nombre_pais; ?></td>
                                <td><?php echo $ciudad->codigo_departamento; ?></td>
                                <td><?php echo $ciudad->nombre_departamento; ?></td>
                                <td><?php echo $ciudad->codigo_ciudad; ?></td>
                                <td><?php echo $ciudad->nombre_ciudad; ?></td>
                                <td><?php echo $ciudad->fecha_ciudad_creacion; ?></td>
                                <td><?php echo $ciudad->fecha_ciudad_actualizacion; ?></td>
                                <td>
                                    <?php
                                    if ($ciudad->estado_ciudad == 1) {
                                    ?>
                                        <span class="label label-success">Activo</span>
                                    <?php
                                    } else {
                                    ?>
                                        <span class="label label-warning">Inactivo</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group mb-sm">
                                        <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-primary btn-xs">Opcion
                                            <span class="caret"></span>
                                        </button>
                                        <ul role="menu" class="dropdown-menu">
                                            <li><a name="admin/pais/editar_ciu/<?php echo $ciudad->id_ciudad; ?>" class="holdOn_plugin">Editar</a></li>
                                            <li class="divider"></li>
                                            <li><a href="../eliminar_ciu/<?php echo $ciudad->id_ciudad; ?>/<?php echo $ciudad->id_departamento; ?>">Eliminar</a></li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $contado++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>