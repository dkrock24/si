<!DOCTYPE html>
<html lang="en">
<html>

<head>

   <!-- Font Icons CSS-->
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/fontawesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/simple-line-icons/css/simple-line-icons.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/animate.css/animate.min.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/whirl/dist/whirl.css">

   <!-- DATATABLES-->
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/datatables-colvis/css/dataTables.colVis.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/datatables/media/css/dataTables.bootstrap.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/dataTables.fontAwesome/index.css">

   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/sweetalert/dist/sweetalert.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/bootstrap.css" id="bscss">

   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/select2-bootstrap-theme/dist/select2-bootstrap.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/select2/dist/css/select2.css">


   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/app.css" id="maincss">

   <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/js/HoldOn.min.js"></script>
   <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/HoldOn.min.css">

   <script src="<?php echo base_url(); ?>../asstes/js/device-uuid.js"></script>

   <link href="<?php echo base_url(); ?>../asstes/css/calendar/calendar.css" rel='stylesheet'>
   </link>
   <script src="<?php echo base_url(); ?>../asstes/js/calendar/calendar.js"></script>
   <script type="text/javascript">
      window.addEventListener("load", function() {
         /*
        HoldOn.open({
            theme:"sk-bounce"
          });
*/
         //loading();
      });

      function loading() {
         HoldOn.close();
      }

      /**
       * MENUS
       */
      $(document).on("click", ".holdOn_plugin", function(event) {
         event.preventDefault();
         var url_pagina = $(this).attr('name');
         document.cookie = "url = " + url_pagina;

         if ((url_pagina != "producto/orden/nuevo")) {
            $.ajax({
               type: "post",
               url: "<?php echo base_url(); ?>" + url_pagina,
               success: function(result) {
                  $(".loadViews").html(result);
               }
            });
         } else {
            window.location.href = "<?php echo base_url(); ?>" + url_pagina;
         }
      });

      $(document).on('keypress', '#buscar_pantalla', function() {
         if (event.which == 13) {
            var buscar_pantalla = $("#buscar_pantalla").val();

            $.ajax({
               type: "post",
               url: "<?php echo base_url(); ?>admin/home/buscar",
               data: {
                  buscar: buscar_pantalla
               },
               success: function(result) {
                  document.cookie = "url = " + result;
                  loadPantalla(result);
                  $("#buscar_pantalla").val("");
               }
            });
         }
      });

      function loadPantalla(url) {
         $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>" + url,
            success: function(result) {
               $(".loadViews").html(result);
            }
         });
      }

      $(document).on('keydown', '.filtro-input', function(e) {

         if (e.which == 13) {
            url_pagina = getCookie("url");
            var form = $(this);
            console.log(form);
            var data = {
               name: $(this).val()
            };
            e.preventDefault();
            $.ajax({
               type: "post",
               //data: $('form#filtros').serialize(),
               data: form,
               url: "<?php echo base_url(); ?>" + url_pagina,
               success: function(result) {
                  $(".loadViews").html(result);
               }
            });
         }
      });

      /**
       * MENUS INTERNOS
       */
      $(document).on("click", ".accion_superior", function() {

         var url_accion = $(this).attr('name');
         var url_id = $(this).attr('id');
         url_pagina = getCookie("url");
         var folder = url_pagina.split('/')[0];
         var controller = url_pagina.split('/')[1];
         var action = url_pagina.split('/')[2];
         var btn_data = $(this).attr('data');
         if (btn_data == "eliminar") {
            var confirm = askForRemoveItem(url_accion, url_id);
            return;
         }

         url_accion = folder + "/" + controller + "/" + url_accion;
         if (action == 'index') {}
         if ((url_pagina != "producto/orden/nuevo") && (url_pagina != "producto/orden/index")) {
            loadJsFiles();
            $.ajax({
               type: "post",
               url: "<?php echo base_url(); ?>" + url_accion,
               success: function(result) {
                  $(".loadViews").html(result);
               }
            });
         } else {
            window.location.href = "<?php echo base_url(); ?>" + url_accion;
         }
      });

      /**
       * FORMULARIOS
       */
      $(document).on("click", ".enviar_data", function() {

         var url_pagina = $(this).attr('name');
         var form = $('#' + $(this).attr('data'))[0];
         var data = new FormData(form);

         $.ajax({
            type: "post",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            data: data,
            url: url_pagina,
            success: function(result) {
               $(".loadViews").html(result);
            }
         });
      });

      /**
       * PAGINACION 
       */
      $(document).on("click", ".link_paginacion", function() {
         var url_pagina = $(this).attr('name');
         $.ajax({
            type: "post",
            url: url_pagina,
            success: function(result) {
               $(".loadViews").html(result);
            }
         });
      });

      function getCookie(cname) {
         var name = cname + "=";
         var decodedCookie = decodeURIComponent(document.cookie);
         var ca = decodedCookie.split(';');
         for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
               c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
               return c.substring(name.length, c.length);
            }
         }
         return "";
      }

      function loadJsFiles() {
         url_pagina = getCookie("url");
         var folder = url_pagina.split('/')[0];
         var controller = url_pagina.split('/')[1];
         var action = url_pagina.split('/')[2];
      }
   </script>

   <style type="text/css">
      .holdOn_plugin {
         cursor: pointer;
      }

      .content-wrapper {
         margin-top: 100px !important;
      }

      .link_paginacion {
         cursor: pointer;
      }

      .menuTop {
         background: none;
         color: black;
         font-family: Arial, Helvetica, sans-serif;
         font-weight: 900;
         border: 0px solid black;

      }

      .menuContent {
         background: none;
         border-top: 4px solid #4974a7;
         border-bottom: 2px solid #68af93;

      }

      .polaroid {
         width: 80%;
         background-color: white;
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }

      div.img_logo {
         text-align: left;
         padding: 10px 20px;
      }

      /* Formularios, botones y lineas style*/

      .lineas_formulario {
         display: inline-block;
         float: right;
      }

      .lineas_top_formulario {
         color: #4974a7;
      }

      .background_inputs {
         background: #68af93
      }

      /** Botones */
      .btn-success {
         background: #4974a7;
      }

      .btn-info {
         background: #68af93
      }

      .img-thumbnail {
         height: none !important;
      }

      #buscar_pantalla {
         margin-top: 10px;
      }
   </style>

</head>
<title>
   <?php
   if (isset($title)) {
      echo $title;
   } else {
      echo "Administracion";
   }
   ?>
</title>

<body>
   <div class="wrapper">
      <!-- top navbar-->
      <header class="topnavbar-wrapper">
         <!-- START Top Navbar-->
         <nav role="navigation" class="navbar topnavbar">
            <!-- START navbar header-->
            <div class="navbar-header">
               <a href="#/" class="navbar-brand">
                  <div class="brand-logo" style="padding: 0px 0px !important;">
                     <h1 style="margin-top: 0px; color: black; font-size:25px;">
                        <?php
                        if (isset($this->session->empresa)) {
                           echo $this->session->empresa[0]->nombre_comercial;
                        }
                        ?>
                     </h1>
                     <!--
                     <img src="<?php echo base_url(); ?>../asstes/img/logo.png" alt="App Logo" class="img-responsive"> -->
                  </div>
                  <div class="brand-logo-collapsed">
                     <i alt="App Logo" class="img-responsive" style="color:black;font-size:28px;margin-top:15px;">IBS</i>
                  </div>
               </a>
            </div>
            <!-- END navbar header-->
            <!-- START Nav wrapper-->
            <div class="nav-wrapper linea_superior2">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a href="#" data-trigger-resize="" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
                  <!-- START User avatar toggle-->
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a id="user-block-toggle" href="<?php echo base_url() . 'admin/home/seleccionar_empresa'; ?>">
                        <em class="icon-home"></em>
                     </a>
                  </li>
                  <!-- END User avatar toggle-->
                  <!-- START lock screen-->

                  <!-- END lock screen-->
               </ul>

               <!-- END Left navbar-->
               <!-- START Right Navbar-->
               <ul class="nav navbar-nav navbar-right">
                  <!-- Search icon-->
                  <li>
                     <span data-search-open="" id="time-part" style="font-size: 30px; color: grey;">
                     </span>
                     <span id="format-date" style="top: -10px; position: relative; color: grey;"> </span>
                     <span style="font-size: 30px; color: grey;"> | </span>
                  </li>
                  <li>
                     <a href="#" data-search-open="">
                        <em class="icon-magnifier"></em>
                     </a>
                  </li>

                  <li>
                     <input type="text" placeholder="Buscar" name="buscar" autocomplete="off" id="buscar_pantalla" class="form-control">
                  </li>

                  <!-- Fullscreen (only desktops)-->
                  <li class="visible-lg">
                     <a href="#" data-toggle-fullscreen="">
                        <em class="fa fa-expand"></em>
                     </a>
                  </li>

                  <!-- START Alert menu-->
                  <li class="dropdown dropdown-list">

                     <div class="user-block-picture" data-toggle="dropdown">
                        <div class="user-block-status">
                           <?php
                           $type = $this->session->usuario[0]->t;
                           $code = $this->session->usuario[0]->c;
                           ?>
                           <img src="data: <?php echo $type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($code) ?>" width="60" height="60" class="img-thumbnail img-circle" style="height:60px;">
                           <div class="circle circle-success circle-lg"></div>
                        </div>
                     </div>

                     <!-- START Dropdown menu-->
                     <ul class="dropdown-menu animated flipInX">
                        <li>user-block-status
                           <!-- START list group-->
                           <div class="list-group">
                              <!-- list item-->
                              <a href="<?php echo base_url(); ?>login/logout" class="list-group-item">
                                 <div class="user-block-info">
                                    <span class="user-block-name">Hola,
                                       <?php
                                       if (isset($this->session->usuario[0]->nombre_usuario)) {
                                          echo $this->session->usuario[0]->nombre_usuario;
                                       }
                                       ?>
                                    </span>
                                    <span class="user-block-role">
                                       <?php
                                       if (isset($this->session->usuario[0]->role)) {
                                          echo $this->session->usuario[0]->role;
                                       }
                                       ?>
                                    </span>
                                 </div>
                              </a>

                              <a href="<?php echo base_url(); ?>login/logout" class="list-group-item">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-lock fa-2x text-info"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">Salir</p>
                                       <p class="m0 text-muted">
                                          <small>Cerrar Sessión</small>
                                       </p>
                                    </div>
                                 </div>
                              </a>
                              <!-- list item-->
                              <!--<a href="#" class="list-group-item">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-user fa-2x text-warning"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">Perfil</p>
                                       <p class="m0 text-muted">
                                          <small>Información Personal</small>
                                       </p>
                                    </div>
                                 </div>
                              </a>
                              <!-- list item-->
                              <!--<a href="#" class="list-group-item">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-cog fa-2x text-success"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">Inicio</p>
                                       <p class="m0 text-muted">
                                          <small>Dashboard</small>
                                       </p>
                                    </div>
                                 </div>
                              </a> -->
                              <!-- last list item-->
                              <a href="#" class="list-group-item">
                                 <small>Notificación</small>
                                 <span class="label label-danger pull-right">0</span>
                              </a>
                           </div>
                           <!-- END list group-->
                        </li>
                     </ul>
                     <!-- END Dropdown menu-->
                  </li>
                  <!-- END Alert menu-->
                  <!-- START Offsidebar button-->
                  <li>
                     <a href="#" data-toggle-state="offsidebar-open" data-no-persist="true">
                        <em class="icon-notebook"></em>
                     </a>
                  </li>


                  <!-- END Offsidebar menu-->
               </ul>
               <!-- END Right Navbar-->
            </div>
            <!-- END Nav wrapper-->
            <!-- START Search form-->
            <!--<form role="search" class="navbar-form">
               <div  class="form-group has-feedback">
                  <input type="text" placeholder="Buscar" name="buscar" id="buscar_pantalla" class="form-control">
               </div>
            </form>
            -->
            <!-- END Search form-->
         </nav>
         <!-- END Top Navbar-->
      </header>
      <!-- sidebar-->
      <aside class="aside">
         <!-- START Sidebar (left)-->
         <div class="aside-inner">
            <nav data-sidebar-anyclick-close="" class="sidebar">
               <!-- START sidebar nav-->
               <ul class="nav">
                  <br>

                  <?php
                  $id_menu = 0;
                  if (isset($menu)) {
                     foreach ($menu as $menus) {
                        if ($id_menu != $menus->id_menu) {
                           $id_menu = $menus->id_menu;
                  ?>
                           <li class=" ">
                              <a href="#<?php echo $menus->nombre_menu; ?>" title="<?php echo $menus->nombre_menu; ?>" data-toggle="collapse">
                                 <em class="<?php echo $menus->icon_menu; ?>"></em>
                                 <span data-localize="sidebar.nav.DASHBOARD"><?php echo $menus->nombre_menu; ?></span>
                              </a>
                              <ul id="<?php echo $menus->nombre_menu; ?>" class="nav sidebar-subnav collapse">
                                 <?php
                                 foreach ($menu as $submenu) {
                                    if ($submenu->id_menu == $menus->id_menu && $submenu->estado_referencia != 1) {
                                 ?>

                                       <li class="holdOn_plugin" name="<?php echo $submenu->url_submenu; ?>">
                                          <?php
                                          if ($submenu->nueva_pagina == 1) {
                                          ?>
                                             <a name="<?php echo $submenu->url_submenu; ?>" title="<?php echo $submenu->nombre_submenu; ?>" target="_blank">
                                                <span><?php echo $submenu->nombre_submenu; ?></span>
                                             </a>
                                          <?php
                                          } else {
                                          ?>
                                             <a name="<?php echo $submenu->url_submenu; ?>" title="<?php echo $submenu->nombre_submenu; ?>">
                                                <span><?php echo $submenu->nombre_submenu; ?></span>
                                             </a>
                                          <?php
                                          }
                                          ?>

                                       </li>

                                 <?php
                                    }
                                 }
                                 ?>

                              </ul>
                           </li>
                  <?php
                        }
                     }
                  } else {
                  }
                  ?>





                  <!-- 
                  <li class=" ">
                     <a href="#multilevel" title="Multilevel" data-toggle="collapse">
                        <em class="fa fa-folder-open-o"></em>
                        <span>Multilevel</span>
                     </a>
                     <ul id="multilevel" class="nav sidebar-subnav collapse">
                        <li class="sidebar-subnav-header">Multilevel</li>
                        <li class=" ">
                           <a href="#level1" title="Level 1" data-toggle="collapse">
                              <span>Level 1</span>
                           </a>
                           <ul id="level1" class="nav sidebar-subnav collapse">
                              <li class="sidebar-subnav-header">Level 1</li>
                              <li class=" ">
                                 <a href="multilevel-1.html" title="Level1 Item">
                                    <span>Level1 Item</span>
                                 </a>
                              </li>
                              <li class=" ">
                                 <a href="#level2" title="Level 2" data-toggle="collapse">
                                    <span>Level 2</span>
                                 </a>
                                 <ul id="level2" class="nav sidebar-subnav collapse">
                                    <li class="sidebar-subnav-header">Level 2</li>
                                    <li class=" ">
                                       <a href="#level3" title="Level 3" data-toggle="collapse">
                                          <span>Level 3</span>
                                       </a>
                                       <ul id="level3" class="nav sidebar-subnav collapse">
                                          <li class="sidebar-subnav-header">Level 3</li>
                                          <li class=" ">
                                             <a href="<?php echo base_url(); ?>login/logout" title="Level3 Item">
                                                <span>Sign Out</span>
                                             </a>
                                          </li>
                                       </ul>
                                    </li>
                                 </ul>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </li>
                  -->
               </ul>
               <!-- END sidebar nav-->
            </nav>
         </div>
         <!-- END Sidebar (left)-->
      </aside>
      <!-- offsidebar-->
      <aside class="offsidebar hide">
         <!-- START Off Sidebar (right)-->
         <nav>
            <div role="tabpanel">
               <!-- Nav tabs-->
               <ul role="tablist" class="nav nav-tabs nav-justified">
                  <li role="presentation" class="active">
                     <a href="#app-settings" aria-controls="app-settings" role="tab" data-toggle="tab">
                        <em class="icon-equalizer fa-lg"></em>
                     </a>
                  </li>
                  <li role="presentation">
                     <a href="#app-chat" aria-controls="app-chat" role="tab" data-toggle="tab">
                        <em class="icon-user fa-lg"></em>
                     </a>
                  </li>
               </ul>
               <!-- Tab panes-->
               <div class="tab-content">
                  <div id="app-settings" role="tabpanel" class="tab-pane fade in active">
                     <h3 class="text-center text-thin">Settings</h3>
                     <div class="p">
                        <h4 class="text-muted text-thin">Themes</h4>
                        <div class="table-grid mb">
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-a.css">
                                    <input type="radio" name="setting-theme" checked="checked">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-info"></span>
                                       <span class="color bg-info-light"></span>
                                    </span>
                                    <span class="color bg-white"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-b.css">
                                    <input type="radio" name="setting-theme">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-green"></span>
                                       <span class="color bg-green-light"></span>
                                    </span>
                                    <span class="color bg-white"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-c.css">
                                    <input type="radio" name="setting-theme">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-purple"></span>
                                       <span class="color bg-purple-light"></span>
                                    </span>
                                    <span class="color bg-white"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-d.css">
                                    <input type="radio" name="setting-theme">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-danger"></span>
                                       <span class="color bg-danger-light"></span>
                                    </span>
                                    <span class="color bg-white"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="table-grid mb">
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-e.css">
                                    <input type="radio" name="setting-theme">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-info-dark"></span>
                                       <span class="color bg-info"></span>
                                    </span>
                                    <span class="color bg-gray-dark"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-f.css">
                                    <input type="radio" name="setting-theme">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-green-dark"></span>
                                       <span class="color bg-green"></span>
                                    </span>
                                    <span class="color bg-gray-dark"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-g.css">
                                    <input type="radio" name="setting-theme">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-purple-dark"></span>
                                       <span class="color bg-purple"></span>
                                    </span>
                                    <span class="color bg-gray-dark"></span>
                                 </label>
                              </div>
                           </div>
                           <div class="col mb">
                              <div class="setting-color">
                                 <label data-load-css="css/theme-h.css">
                                    <input type="radio" name="setting-theme">
                                    <span class="icon-check"></span>
                                    <span class="split">
                                       <span class="color bg-danger-dark"></span>
                                       <span class="color bg-danger"></span>
                                    </span>
                                    <span class="color bg-gray-dark"></span>
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="p">
                        <h4 class="text-muted text-thin">Layout</h4>
                        <div class="clearfix">
                           <p class="pull-left">Fixed</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-fixed" type="checkbox" data-toggle-state="layout-fixed">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">Boxed</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-boxed" type="checkbox" data-toggle-state="layout-boxed">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">RTL</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-rtl" type="checkbox">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                     </div>
                     <div class="p">
                        <h4 class="text-muted text-thin">Aside</h4>
                        <div class="clearfix">
                           <p class="pull-left">Collapsed</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-collapsed" type="checkbox" data-toggle-state="aside-collapsed">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">Collapsed Text</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-collapsed-text" type="checkbox" data-toggle-state="aside-collapsed-text">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">Float</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-float" type="checkbox" data-toggle-state="aside-float">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">Hover</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-hover" type="checkbox" data-toggle-state="aside-hover">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix">
                           <p class="pull-left">Show Scrollbar</p>
                           <div class="pull-right">
                              <label class="switch">
                                 <input id="chk-hover" type="checkbox" data-toggle-state="show-scrollbar" data-target=".sidebar">
                                 <span></span>
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="app-chat" role="tabpanel" class="tab-pane fade">
                     <h3 class="text-center text-thin">Connections</h3>
                     <ul class="nav">
                        <!-- START list title-->
                        <li class="p">
                           <small class="text-muted">ONLINE</small>
                        </li>
                        <!-- END list title-->
                        <li>
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-success circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php //echo base_url(); 
                                             ?>" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Juan Sims</strong>
                                    <br>
                                    <small class="text-muted">Designeer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-success circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php //echo base_url(); 
                                             ?>" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Maureen Jenkins</strong>
                                    <br>
                                    <small class="text-muted">Designeer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-danger circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php //echo base_url(); 
                                             ?>" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Billie Dunn</strong>
                                    <br>
                                    <small class="text-muted">Designeer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-warning circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php //echo base_url(); 
                                             ?>" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Tomothy Roberts</strong>
                                    <br>
                                    <small class="text-muted">Designer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                        </li>
                        <!-- START list title-->
                        <li class="p">
                           <small class="text-muted">OFFLINE</small>
                        </li>
                        <!-- END list title-->
                        <li>
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php //echo base_url(); 
                                             ?>" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Lawrence Robinson</strong>
                                    <br>
                                    <small class="text-muted">Developer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                           <!-- START User status-->
                           <a href="#" class="media-box p mt0">
                              <span class="pull-right">
                                 <span class="circle circle-lg"></span>
                              </span>
                              <span class="pull-left">
                                 <!-- Contact avatar-->
                                 <img src="<?php //echo base_url(); 
                                             ?>" alt="Image" class="media-box-object img-circle thumb48">
                              </span>
                              <!-- Contact info-->
                              <span class="media-box-body">
                                 <span class="media-box-heading">
                                    <strong>Tyrone Owens</strong>
                                    <br>
                                    <small class="text-muted">Designer</small>
                                 </span>
                              </span>
                           </a>
                           <!-- END User status-->
                        </li>
                        <li>
                           <div class="p-lg text-center">
                              <!-- Optional link to list more users-->
                              <a href="#" title="See more contacts" class="btn btn-purple btn-sm">
                                 <strong>Load more..</strong>
                              </a>
                           </div>
                        </li>
                     </ul>
                     <!-- Extra items-->
                     <div class="p">
                        <p>
                           <small class="text-muted">Tasks completion</small>
                        </p>
                        <div class="progress progress-xs m0">
                           <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-success progress-80">
                              <span class="sr-only">80% Complete</span>
                           </div>
                        </div>
                     </div>
                     <div class="p">
                        <p>
                           <small class="text-muted">Upload quota</small>
                        </p>
                        <div class="progress progress-xs m0">
                           <div role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-warning progress-40">
                              <span class="sr-only">40% Complete</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </nav>
         <!-- END Off Sidebar (right)-->
      </aside>

      <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
      <section class="loadViews">
         </<section>