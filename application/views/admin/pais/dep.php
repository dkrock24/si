<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/pais/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Lista Pais</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Departamentos</button>
        </h3>
        <?php $this->load->view('notificaciones/success'); ?>
        <div class="panel panel-default">


            <div class="">
                <table id="datatable1" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pais</th>
                            <th>Departamento</th>
                            <th>Codigo</th>
                            <th>Zona</th>
                            <th>Creado</th>
                            <th>Actualizado</th>
                            <th>Estado</th>
                            <th>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Opcion</button>
                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">
                                        <span class="caret"></span>
                                        <span class="sr-only">default</span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a name="admin/pais/nuevo_dep/<?php echo $id_departamento; ?>" class="holdOn_plugin">Nuevo</a></li>
                                        <li><a href="#">Exportar</a> </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Otros</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contado = 1;
                        if ($depart != null) {
                            foreach ($depart as $departamento) {
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $contado; ?></th>
                                    <td><?php echo $departamento->nombre_pais; ?></td>
                                    <td><?php echo $departamento->nombre_departamento; ?></td>

                                    <td><?php echo $departamento->codigo_departamento; ?></td>
                                    <td><?php echo $departamento->zona_departamento; ?></td>

                                    <td><?php echo $departamento->fecha_creacion_depa; ?></td>
                                    <td><?php echo $departamento->fecha_actualizacion_depa; ?></td>
                                    <td>
                                        <?php
                                        if ($departamento->estado_departamento == 1) {
                                        ?>
                                            <span class="label label-success">Activo</span>
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
                                                <li><a name="admin/pais/ciu/<?php echo $departamento->id_departamento; ?>/<?php echo $departamento->pais; ?>" class="holdOn_plugin">Ver</a></li>
                                                <li><a name="admin/pais/editar_dep/<?php echo $departamento->id_departamento; ?>" class="holdOn_plugin">Editar</a></li>

                                                <li class="divider"></li>
                                                <li><a name="admin/pais/eliminar_dep/<?php echo $departamento->id_departamento; ?>/<?php echo $departamento->pais; ?>" class="holdOn_plugin">Eliminar</a></li>

                                            </ul>
                                        </div>

                                    </td>
                                </tr>
                        <?php
                                $contado++;
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</section>