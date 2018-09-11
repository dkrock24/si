<!DOCTYPE html>
<html>
  <head>
    
    <!-- Font Icons CSS-->
    <link rel="stylesheet" href="../../../asstes/Backend/html/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../asstes/Backend/html/assets/css/animate.min.css">
    <link rel="stylesheet" href="../../../asstes/Backend/html/assets/css/app.css">
    <link rel="stylesheet" href="../../../asstes/Backend/html/assets/css/demo.min.css">
    <link rel="stylesheet" href="../../../asstes/Backend/html/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../../asstes/Backend/html/assets/css/pe-icon-7-stroke.css">

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
                        <img src="../../../asstes/Backend/html/assets/img/logo.png" alt="Yima - Admin Web App" />
                    </div>
                    <div class="brand-slogan">
                        <div class="slogan-title">Multi-Platform Web App</div>
                    </div>
                </div>
                <div class="header-notification">
                    <a class="notification" href="Inbox.html">
                        <i class="icon pe-7s-mail"></i>
                        <span class="text">You've Got 3 New Mails!</span>
                        <div class="more">
                            <span class="more-text">Go to Inbox</span>
                            <i class="more-icon pe-7s-right-arrow"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li >
                        <a>
                            <i class="pe-7s-monitor"></i>
                            <span>Dashboards</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>Data</span>
                            </li>
                            <li >
                                <a href="DashboardMultipleBox.html">
                                    <i class="pe-7s-box2"></i>
                                    <span>Simple</span>
                                </a>
                            </li>
                            <li >
                                <a href="DashboardMinimal.html">
                                    <i class="pe-7s-graph1"></i>
                                    <span>Minimal</span>
                                </a>
                            </li>
                            <li >
                                <a href="DashboardRealtime.html">
                                    <i class="pe-7s-refresh-2"></i>
                                    <span>Real-time</span>
                                </a>
                            </li>
                            <li >
                                <a href=DashboardMultipleBoxContrast.html>
                                    <i class="pe-7s-sun"></i>
                                    <span>High Contrast</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>Social (Soon)</span>
                            </li>
                            <li>
                                <a>
                                    <i class="pe-7s-photo"></i>
                                    <span>Gallery</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <i class="pe-7s-add-user"></i>
                                    <span>Social Profile</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>Management (Soon)</span>
                            </li>
                            <li>
                                <a>
                                    <i class="pe-7s-bookmarks"></i>
                                    <span>Kanban</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <i class="pe-7s-ribbon"></i>
                                    <span>Projects</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li >
                        <a>
                            <i class="pe-7s-box2"></i>
                            <span>Widgets</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>Widget Types</span>
                            </li>
                            <li >
                                <a href=WidgetBox.html>
                                    <i class="fa fa-bar-chart"></i>
                                    <span>Boxes</span>
                                </a>

                            </li>
                            <li >
                                <a href=WidgetPanel.html>
                                    <i class="pe-7s-box2"></i>
                                    <span>Panels</span>
                                </a>
                            </li>
                            <li >
                                <a href=WidgetComplex.html>
                                    <i class="fa fa-line-chart"></i>
                                    <span>Complex Widgets</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li >
                        <a href="Inbox.html">
                            <i class="pe-7s-mail"></i>
                            <span>Mail</span>
                        </a>
                        <ul>
                            <li >
                                <a href="Inbox.html">
                                    <span>Inbox (3)</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>Important</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>Sent</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>Drafts</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>Trash</span>
                                </a>
                            </li>
                            <li class="submenu-divider"></li>
                            <li class="submenu-title">
                                <span>Labels</span>
                            </li>
                            <li>
                                <a>
                                    <span>Dribbble</span>
                                    <span class="mail-label pink"></span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>Work</span>
                                    <span class="mail-label blue"></span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <span>University Docs</span>
                                    <span class="mail-label green"></span>
                                </a>
                            </li>
                            <li class="submenu-divider"></li>
                            <li class="submenu-title">
                                <span>Contacts</span>
                            </li>
                            <li>
                                <a>
                                    <img class="contact-avatar online" src="../../../asstes/Backend/html/assets/img/avatars/jsa.jpg" alt="Adam King" />
                                    <span>Adam King</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <img class="contact-avatar online" src="../../../asstes/Backend/html/assets/img/avatars/adelle.jpg" alt="Adelle Donsmerak" />
                                    <span>Adelle Donsmerak</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <img class="contact-avatar online" src="../../../asstes/Backend/html/assets/img/avatars/andy.jpg" alt="Andy Allen" />
                                    <span>Andy Allen</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <img class="contact-avatar away" src="../../../asstes/Backend/html/assets/img/avatars/allison.jpg" alt="Allison McArthur" />
                                    <span>Allison McArthur</span>
                                </a>
                            </li>
                            <li>
                                <a>
                                    <img class="contact-avatar away" src="../../../asstes/Backend/html/assets/img/avatars/jared.jpg" alt="David Cronenberg" />
                                    <span>David Cronenberg</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li >
                        <a href=Calendar.html>
                            <i class="pe-7s-date"></i>
                            <span>Calendar</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span class="p-l-0 align-center">Current Month Overview</span>
                            </li>
                            <li class="mini-calendar-container">
                                <div class="mini-calendar"></div>
                            </li>
                            <li class="submenu-title">
                                <span>Remove Event After Drag</span>
                            </li>
                            <li>
                                <label class="p-l-30">
                                    <input class="switch toggle switch-primary" id="drop-remove" checked="checked" type="checkbox">
                                    <span class="text"></span>
                                </label>
                            </li>
                            <li class="calendar-event">
                                <a>
                                    <span>Lunch with Mary</span>
                                </a>
                            </li>
                            <li class="calendar-event event-warning">
                                <a>
                                    <span>Session in Office</span>
                                </a>
                            </li>
                            <li class="calendar-event event-info">
                                <a>
                                    <span>Jane's Birthday</span>
                                </a>
                            </li>
                            <li class="calendar-event event-danger">
                                <a>
                                    <span>Shopping Time</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li >
                        <a href=Profile.html>
                            <i class="pe-7s-id"></i>
                            <span>Profile</span>
                        </a>
                        <ul>
                            <li class="profile-picture">
                                <a href="">
                                    <img src="../../../asstes/Backend/html/assets/img/profile/profile-cover.jpg" alt="Andrea LeFeave" />
                                </a>
                            </li>
                            <li class="profile-name">
                                <a href="">
                                    <span>Andrea LeFeave</span>
                                </a>

                            </li>
                            <li class="profile-title">
                                <a href="">
                                    <span>UX/UI Designer</span>
                                </a>
                            </li>

                            <li class="profile-percent">
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
                                    </div>
                                </div>
                                <span>
                                    Activity Level: <strong>73%</strong>
                                </span>
                            </li>
                            <li class="submenu-divider"></li>
                            <li>
                                <a href="">
                                    <i class="pe-7s-bicycle"></i>
                                    <span>Activities</span>
                                </a>

                            </li>
                            <li>
                                <a href="">
                                    <i class="pe-7s-graph2"></i>
                                    <span>Profile Views</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="pe-7s-users"></i>
                                    <span>Friends</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="pe-7s-comment"></i>
                                    <span>Messages</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="pe-7s-photo"></i>
                                    <span>Pictures</span>
                                </a>
                            </li>
                            <li class="submenu-divider"></li>
                            <li class="profile-links">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <a href="">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </div>
                                    <div class="col-xs-3">
                                        <a href="">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </div>
                                    <div class="col-xs-3">
                                        <a href="">
                                            <i class="fa fa-dribbble"></i>
                                        </a>
                                    </div>
                                    <div class="col-xs-3">
                                        <a href="">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="profile-follow">
                                <button class="btn btn-primary btn-block">
                                    Follow
                                </button>
                            </li>

                        </ul>
                    </li>
                    <li >
                        <a>
                            <i class="pe-7s-graph1"></i>
                            <span>Charts</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>Charts</span>
                            </li>
                            <li >
                                <a href=FlotChart.html>
                                    <i class="fa fa-bar-chart"></i>
                                    <span>Flot Charts</span>
                                </a>

                            </li>
                            <li >
                                <a href=Chartist.html>
                                    <i class="pe-7s-graph2"></i>
                                    <span>Chartist</span>
                                </a>
                            </li>
                            <li >
                                <a href=ChartJs.html>
                                    <i class="fa fa-line-chart"></i>
                                    <span>Chart.js</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>Inline Charts</span>
                            </li>
                            <li >
                                <a href=Sparkline.html>
                                    <i class="fa fa-area-chart"></i>
                                    <span>Sparkline Charts</span>
                                </a>
                            </li>
                            <li >
                                <a href=EasyPieChart.html>
                                    <i class="pe-7s-graph"></i>
                                    <span>Easy Pie Chart</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>Big Data Charts</span>
                            </li>
                            <li >
                                <a href=ECharts.html>
                                    <i class="pe-7s-graph3"></i>
                                    <span>E-Charts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="active open">
                        <a>
                            <i class="pe-7s-paint-bucket"></i>
                            <span>UI Elements</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>‌Elements</span>
                            </li>
                            <li >
                                <a href=Elements.html>
                                    <i class="pe-7s-ticket"></i>
                                    <span>Basic Elements</span>
                                </a>
                            </li>
                            <li >
                                <a href=Buttons.html>
                                    <i class="pe-7s-plus"></i>
                                    <span>Buttons</span>
                                </a>
                            </li>
                            <li >
                                <a href=Notifications.html>
                                    <i class="pe-7s-bell"></i>
                                    <span>Notifications</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Icons</span>
                            </li>
                            <li >
                                <a href=StrokeIcons.html>
                                    <i class="pe-7s-arc"></i>
                                    <span>7 Stroke Icons</span>
                                </a>
                            </li>
                            <li >
                                <a href=FontAwesome.html>
                                    <i class="fa fa-rocket"></i>
                                    <span>FontAwesome Icons</span>
                                </a>
                            </li>
                            <li >
                                <a href=Glyphicons.html>
                                    <i class="glyphicon glyphicon-apple"></i>
                                    <span>Glyphicons</span>
                                </a>
                            </li>

                            <li class="submenu-title">
                                <span>‌Containers</span>
                            </li>
                            <li >
                                <a href=Panels.html>
                                    <i class="pe-7s-browser"></i>
                                    <span>Panels &amp; Accordions</span>
                                </a>
                            </li>
                            <li >
                                <a href=Tabs.html>
                                    <i class="pe-7s-folder"></i>
                                    <span>Tabs</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href=Modals.html>
                                    <i class="pe-7s-chat"></i>
                                    <span>Modals</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Hierarchy</span>
                            </li>
                            <li >
                                <a href=NestableList.html>
                                    <i class="pe-7s-menu"></i>
                                    <span>Nestable Lists</span>
                                </a>
                            </li>
                            <li >
                                <a href=Tree.html>
                                    <i class="pe-7s-plus"></i>
                                    <span>Tree</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li >
                        <a>
                            <i class="pe-7s-note"></i>
                            <span>Forms</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>‌Form Elements</span>
                            </li>
                            <li >
                                <a href=FormInputs.html>
                                    <i class="pe-7s-ticket"></i>
                                    <span>Form Inputs</span>
                                </a>
                            </li>
                            <li >
                                <a href=FormAdvancedInputs.html>
                                    <i class="pe-7s-plus"></i>
                                    <span>Advanced Inputs</span>
                                </a>
                            </li>
                            <li >
                                <a href=FormInputMask.html>
                                    <i class="pe-7s-bell"></i>
                                    <span>Input Masks</span>
                                </a>
                            </li>
                            <li >
                                <a href=FormEditors.html>
                                    <i class="pe-7s-edit"></i>
                                    <span>Editors</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Form Structures</span>
                            </li>
                            <li >
                                <a href=FormLayouts.html>
                                    <i class="pe-7s-photo-gallery"></i>
                                    <span>Form Layouts</span>
                                </a>
                            </li>
                            <li >
                                <a href=FormValidation.html>
                                    <i class="pe-7s-shield"></i>
                                    <span>Form Validation</span>
                                </a>
                            </li>
                            <li >
                                <a href=FormWizard.html>
                                    <i class="pe-7s-play"></i>
                                    <span>Form Wizard</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li >
                        <a>
                            <i class="pe-7s-keypad"></i>
                            <span>Tables</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>‌Table Look</span>
                            </li>
                            <li >
                                <a href=Tables.html>
                                    <i class="pe-7s-paint-bucket"></i>
                                    <span>Tables Styles</span>
                                </a>
                            </li>
                            <li >
                                <a href=ResponsiveTables.html>
                                    <i class="pe-7s-exapnd2"></i>
                                    <span>Responsive Tables</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Data Tables</span>
                            </li>
                            <li >
                                <a href=DatatablesInit.html>
                                    <i class="pe-7s-display2"></i>
                                    <span>Layouts</span>
                                </a>
                            </li>
                            <li >
                                <a href=DatatablesSearch.html>
                                    <i class="pe-7s-search"></i>
                                    <span>Search</span>
                                </a>
                            </li>
                            <li >
                                <a href=DatatablesExport.html>
                                    <i class="pe-7s-print"></i>
                                    <span>Export and Print</span>
                                </a>
                            </li>
                            <li >
                                <a href=DatatablesCrud.html>
                                    <i class="pe-7s-pen"></i>
                                    <span>Data Manipulation</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li >
                        <a>
                            <i class="pe-7s-map-marker"></i>
                            <span>Maps</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>‌Google Maps</span>
                            </li>
                            <li >
                                <a href=GMaps.html>
                                    <i class="pe-7s-map-2"></i>
                                    <span>GMaps</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Vector Maps</span>
                            </li>
                            <li >
                                <a href=JqvMap.html>
                                    <i class="pe-7s-world"></i>
                                    <span>JQV Map</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li >
                        <a>
                            <i class="pe-7s-display1"></i>
                            <span>Pages</span>
                        </a>
                        <ul>
                            <li class="submenu-title">
                                <span>‌Social</span>
                            </li>
                            <li >
                                <a href=Timeline.html>
                                    <i class="pe-7s-clock"></i>
                                    <span>Timeline</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Membership</span>
                            </li>
                            <li >
                                <a href=Login.html>
                                    <i class="pe-7s-users"></i>
                                    <span>Login/Register</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Errors</span>
                            </li>
                            <li >
                                <a href=Error500.html>
                                    <i class="pe-7s-server"></i>
                                    <span>500</span>
                                </a>
                            </li>
                            <li >
                                <a href=Error404.html>
                                    <i class="pe-7s-attention"></i>
                                    <span>404</span>
                                </a>
                            </li>
                            <li >
                                <a href=Error401.html>
                                    <i class="pe-7s-user"></i>
                                    <span>401</span>
                                </a>
                            </li>
                            <li class="submenu-title">
                                <span>‌Miscellaneous</span>
                            </li>
                            <li >
                                <a href=Blank.html>
                                    <i class="pe-7s-browser"></i>
                                    <span>Blank Page</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <div class="footer-avatar">
                    <img src="../../../asstes/Backend/html/assets/img/avatars/andy.jpg" alt="Fabian Mellan Jr." />
                </div>
                <div class="footer-user">
                    <a href="Profile.html">Fabian Mellan Jr.</a>
                </div>
                <div class="footer-links">
                    <a href="Login.html" class="links-logout">
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
                <ul class="breadcrumb">
                    <li>
                        <a href="#">
                            <i class="pe-7s-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="pe-7s-paint-bucket"></i>
                            <span>UI Elements</span>
                        </a>
                    </li>
                    <li class="active">
                        <i class="pe-7s-chat"></i>
                        <span>Modals</span>
                    </li>
                </ul>
                <!--
                [5.1.2. Header Buttons]
                -->
                <ul class="header-actions">
                    <li class="actions-stretch-menu" id="action-stretch-menu">
                        <div class="icon"></div>
                    </li>
                    <li class="actions-notification">
                        <a class="dropdown-toggle" data-toggle="dropdown" title="Mails" href="#">
                            <i class="pe-7s-mail"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-arrow pull-right">
                            <li>
                                <div class="notification-header">
                                    <div class="header-title">
                                        Messages
                                    </div>
                                </div>
                                <div class="notification-upperbody bg-danger">
                                    <div class="widget bg-danger">
                                        <div class="row">
                                            <div class="col-lg-6 h-70 w-70 p-5 align-center">
                                                <div>
                                                    <img src="../../../asstes/Backend/html/assets/img/avatars/andy.jpg" class="w-60 h-60" alt="Donald Tennyson">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 h-70 w-m-70 p-5 p-t-10">
                                                <div class="">
                                                    <strong class="f-13">
                                                        Donald Tennyson
                                                    </strong>
                                                </div>
                                                <div class="f-11">
                                                    Senior Android Developer
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-message">
                                        <div class="message-title">
                                            I'd like to add you to my professional network on LinkedIn.
                                        </div>
                                        <div class="message-time">
                                            <i class="pe-7s-clock v-a-middle"></i>
                                            1 day ago
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-lowerbody">
                                    <div class="notification-message">
                                        <div class="message-title">
                                            I really appreciate all your help in getting the restaurant ready for opening night.
                                        </div>
                                        <div class="message-time">
                                            <i class="pe-7s-clock v-a-middle"></i>
                                            1 min ago
                                        </div>
                                    </div>
                                    <div class="notification-message">
                                        <div class="message-title">
                                            I am a friend of Emily Little and she encouraged me to forward my resume to you.
                                        </div>
                                        <div class="message-time">
                                            <i class="pe-7s-clock v-a-middle"></i>
                                            2 hours ago
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-footer">
                                    <a class="pull-left" href="">
                                        <i class="pe-7s-angle-left-circle f-25"></i>
                                    </a>
                                    <a class="pull-right" href="">
                                        <i class="pe-7s-angle-right-circle f-25"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li id="action-search">
                        <a>
                            <i class="pe-7s-search"></i>
                        </a>
                    </li>
                    <li id="action-settings">
                        <a>
                            <i class="pe-7s-settings"></i>
                        </a>
                    </li>
                    <li id="action-menu-collapse">
                        <a>
                            <i class="pe-7s-menu"></i>
                        </a>
                    </li>
                    <li id="action-chat">
                        <a>
                            <i class="pe-7s-comment"></i>
                        </a>
                    </li>
                    <li id="action-help">
                        <a>
                            <i class="pe-7s-help1"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!--
            [5.2. Page Navbar]
            -->
            <div class="content-nav">
                <div class="navbar navbar-default content-nav-navbar">
                    <div class="navbar-header">
                        <a data-toggle="collapse" data-target="#navbar-collapse-2" class="navbar-toggle collapsed">
                            <div class="icon"></div>
                        </a>
                        <a href="#" class="navbar-brand">Modals</a>
                    </div>
                    <div id="navbar-collapse-2" class="navbar-collapse collapse">
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
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">FeedBack<i class="dropdown-caret pe-7s-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="content-nav-navbar-content">
                                            <form style="min-width: 400px;">
                                                <div class="form-group">
                                                    <input id="inputName" type="text" placeholder="Name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input id="inputEmail" type="password" placeholder="Email" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <textarea placeholder="Write your message.." rows="5" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--
            [5.3. Page Body]
            -->
            
    
    
   
