<!DOCTYPE html>
<html>
  <head>
    
    <!-- Font Icons CSS-->
    <link rel="stylesheet" href="/si/asstes/Backend/html/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/si/asstes/Backend/html/assets/css/animate.min.css">
    <link rel="stylesheet" href="/si/asstes/Backend/html/assets/css/app.css">
    <link rel="stylesheet" href="/si/asstes/Backend/html/assets/css/demo.min.css">
    <link rel="stylesheet" href="/si/asstes/Backend/html/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/si/asstes/Backend/html/assets/css/pe-icon-7-stroke.css">

  </head>
  <title>
      <?php
      if(isset($title)){ echo $title; }else{ echo "Administracion"; }
      ?>
  </title>
  <body>

    <div class="animsition">
        <!--
        [3. Sidebar Menu]
        -->
        <div class="sidebar menu">
            <div class="sidebar-header">
                <div class="header-brand">
                    <div class="brand-logo">
                        <img src="../../../asstes/Backend/images/logo-empresa.png" alt="Yima - Admin Web App" />
                    </div>
                    <div class="brand-slogan">
                        <div class="slogan-title">Sistema Integrado</div>
                    </div>
                </div>

            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <?php
                    $id_menu = 0;
                    foreach ($menu as $menus) {
                        
                        if($id_menu != $menus->id_menu){
                            $id_menu = $menus->id_menu;
                        
                        ?>
                        <li>
                            <a>
                                <i class="<?php echo $menus->icon_menu; ?>"></i>
                                <span><?php echo $menus->nombre_menu; ?></span>
                            </a>
                            <ul>
                                <li class="submenu-title">
                                    <span>Data</span>
                                </li>
                                
                                <?php
                                foreach ($menu as $submenu) {
                                    if($submenu->id_menu == $menus->id_menu){
                                        ?>
                                        <li >
                                            <a href="<?php echo $submenu->url_submenu; ?>">
                                                <i class="<?php echo $submenu->icon_submenu; ?>"></i>
                                                <span><?php echo $submenu->nombre_submenu; ?></span>
                                            </a>
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
                    ?>
                    
                </ul>
            </div>
            <div class="sidebar-footer">
                <div class="footer-avatar">
                    <img src="../../../asstes/Backend/html/assets/img/avatars/andy.jpg" alt="Fabian Mellan Jr." />
                </div>
                <div class="footer-user">
                    <a href="Profile.html">
                        <?php
                        echo $this->session->usuario['info'][0]->nombres;
                        echo " ";
                        echo $this->session->usuario['info'][0]->apellidos;
                        ?>
                    </a>
                </div>
                <div class="footer-links">
                    <a href="<?php echo base_url(); ?>login/logout" class="links-logout">
                        <i class="pe-7s-power"></i>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
        <!--
        [4. Sidebar Form]
        -->
        <div class="sidebar form collapsed">
        </div>
        <!--
        [5. Main Page Content]
        -->
        <div class="main-content">
            <!--
            [5.1. Page Header]
            -->
            <div class="content-header">
                <!--
                [5.1.1. BreadCrumb]
                -->
                <div class="content-nav">
                <div class="navbar navbar-default content-nav-navbar">
         
                    <div id="navbar-collapse-2" class="navbar-collapse collapse">

                         <ul class="nav navbar-nav header-actions navbar-left">
                              
                            <li class="actions-stretch-menu" id="action-stretch-menu">
                                <div class="icon"></div>
                            </li>
                            <li id="action-menu-collapse">
                                <a>
                                    <i class="pe-7s-menu"></i>
                                </a>
                            </li>
     
                            
                   
                        </ul>
                        <ul class="nav navbar-nav">
                            <li class="dropdown content-nav-navbar-fw">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Services<i class="dropdown-caret pe-7s-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="content-nav-navbar-content p-b-0">
                                            <ul class="thumbnail-links row">
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-users"></i>
                                                        <div class="link-title">User Management</div>
                                                        <p>Manage Your Users Online</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-settings"></i>
                                                        <div class="link-title">Configuration</div>
                                                        <p>Set Application settings</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-mail-open-file"></i>
                                                        <div class="link-title">Messages</div>
                                                        <p>See your messages</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-shield"></i>
                                                        <div class="link-title">Security Management</div>
                                                        <p>Secure your application</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-edit"></i>
                                                        <div class="link-title">Sound</div>
                                                        <p>Sound Settings</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-paint-bucket"></i>
                                                        <div class="link-title">Skins</div>
                                                        <p>Change your skins</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-headphones"></i>
                                                        <div class="link-title">Support</div>
                                                        <p>Call Support Center</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-map-marker"></i>
                                                        <div class="link-title">Location</div>
                                                        <p>Enable Location</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-4">
                                                    <a href="">
                                                        <i class="pe-7s-help1"></i>
                                                        <div class="link-title">Help Center</div>
                                                        <p>Browse Help Center</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown content-nav-navbar-fw">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Categories<i class="dropdown-caret pe-7s-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="content-nav-navbar-content p-b-0">
                                            <ul class="categories-links row">
                                                <li class="col-sm-4">
                                                    <div class="category-title">
                                                        App Management
                                                    </div>
                                                    <ul>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-monitor"></i>
                                                                Dashboards
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-users"></i>
                                                                Users
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-graph1"></i>
                                                                Charts and Graphs
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-id"></i>
                                                                Profile and User Info
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-edit"></i>
                                                                Forms Settings
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-map-marker"></i>
                                                                Navigations
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-mail"></i>
                                                                Inbox
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="col-sm-4">
                                                    <div class="category-title">
                                                        User Configuration
                                                    </div>
                                                    <ul>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-alarm"></i>
                                                                Time Monitored
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-albums"></i>
                                                                Albums
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-attention"></i>
                                                                Notifications
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-ball"></i>
                                                                Sport Activitis
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-bicycle"></i>
                                                                Round Trips
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-gleam"></i>
                                                                UI Elements
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-cup"></i>
                                                                Entertainment
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="col-sm-4">
                                                    <div class="category-title">
                                                        Security Console
                                                    </div>
                                                    <ul>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-coffee"></i>
                                                                JavaScript
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-calculator"></i>
                                                                Calculator
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-file"></i>
                                                                Files and Folders
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-camera"></i>
                                                                Pictures
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-display1"></i>
                                                                Forms and Dashboards
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-science"></i>
                                                                Reaction
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="">
                                                                <i class="pe-7s-date"></i>
                                                                Calendar
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown content-nav-navbar-fw">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Products<i class="dropdown-caret pe-7s-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="content-nav-navbar-content p-b-0">
                                            <ul class="gallery-links row">
                                                <li class="col-sm-3">
                                                    <a href="">
                                                        <img src="assets/img/products/p1.png" alt="Mac Pro"/>
                                                        <div class="link-title">Mac Pro</div>
                                                        <p>Built for creativity on an epic scale</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-3">
                                                    <a href="">
                                                        <img src="assets/img/products/p2.png" alt="Apple Watch"/>
                                                        <div class="link-title">Apple Watch</div>
                                                        <p>The watch that works like your PC</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-3">
                                                    <a href="">
                                                        <img src="assets/img/products/p3.png" alt="Surface Pro 4"/>
                                                        <div class="link-title">Surface Pro 4</div>
                                                        <p>Make the most of your 24 hours</p>
                                                    </a>
                                                </li>
                                                <li class="col-sm-3">
                                                    <a href="">
                                                        <img src="assets/img/products/p4.png" alt="Iphone 6"/>
                                                        <div class="link-title">Iphone 6</div>
                                                        <p>Best Smart Phone Ever</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                       
                    </div>
                </div>
            </div>
                <!--
                [5.1.2. Header Buttons]
                -->

            </div>

            <!--
            [5.2. Page Navbar]
            -->

            <!--
            [5.3. Page Body]
            -->
            
    
    
   
