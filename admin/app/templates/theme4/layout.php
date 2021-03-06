<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Blog - ADMIN</title>

    {LIBRARIES}
    {HEAD}

    <!-- Google Fonts -->
    <link href="app/templates/{template}/plugins/node-waves/waves.css" rel="stylesheet"/>
    <link href="app/templates/{template}/plugins/animate-css/animate.css" rel="stylesheet"/>
    <link href="app/templates/{template}/css/style.css" rel="stylesheet">
    <link href="app/templates/{template}/css/themes/all-themes.css" rel="stylesheet"/>
    <link href="app/templates/{template}/css/sweetalert.css" rel="stylesheet">

    <script src="app/templates/{template}/plugins/moment/moment-with-locales.min.js" type="text/javascript"></script>
    <script src="app/templates/{template}/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"
            type="text/javascript"></script>
    <link rel="stylesheet"
          href="app/templates/{template}/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"/>

</head>

<body class="theme-blue">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Carregando...</p>
    </div>
</div>
<!-- #END# Page Loader -->

<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>

    <div id="envelope_search">
    </div>
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
               data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="index.php">ADMIN Blog</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i
                                class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->

                <!-- Notifications -->
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="app/templates/{template}/images/user.png" width="48" height="48" alt="User"/>
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{login}</div>
                <!-- <div class="email">{usermail}</div> -->
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="index.php?class=SystemProfileView"><i class="material-icons">person</i>Perfil</a>
                        </li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="index.php?class=LoginForm&method=reloadPermissions&static=1"><i
                                        class="material-icons">cached</i>Recarregar</a></li>
                        <li><a generator="adianti" href="index.php?class=LoginForm&method=onLogout&static=1"><i
                                        class="material-icons">input</i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu {}-->
        <div class="menu">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 398.433px;">
                <ul class="list" style="overflow: hidden; width: auto; height: 398.433px;">
                    <li class="active"></li>
                    <li class="header">MENU</li>
                    <li class="x">
                        <a href="#" class="menu-toggle waves-effect waves-block">
                            <i style="padding-right: 4px; margin-top: 8px;" class="fa fa-university fa-fw"></i>
                            <span>Administração</span>
                        </a>
                        <ul class="ml-menu level-2" style="display: none;">
                            <li><a href="index.php?class=CategoryFormList" generator="adianti"
                                   class=" waves-effect waves-block">
                                    <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-file-text-o fa-fw"></i>
                                    <span>Página</span>
                                </a>
                            </li>
                            <li><a href="index.php?class=ContentForm" generator="adianti"
                                   class=" waves-effect waves-block">
                                    <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-desktop fa-fw"></i>
                                    <span>_t{Content}</span>
                                </a>
                            </li>
                            <li><a href="index.php?class=PostList" generator="adianti"
                                   class=" waves-effect waves-block">
                                    <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-book fa-fw"></i>
                                    <span>_t{Post}</span>
                                </a>
                            </li>
                            <?php
                            if (\Functions\Util\Util::onCheckFeaturePage('contact')) {
                                ?>
                                <li><a href="index.php?class=ContactList" generator="adianti"
                                       class=" waves-effect waves-block">
                                        <i style="padding-right: 4px; margin-top: 5px;"
                                           class="fa fa-address-book fa-fw"></i>
                                        <span>Contato</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php
                            if (\Functions\Util\Util::onCheckFeaturePage('slideshow')) {
                                ?>
                                <li><a href="index.php?class=SlideShowList" generator="adianti"
                                       class=" waves-effect waves-block">
                                        <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-image fa-fw"></i>
                                        <span>Slide Show</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <!--
                            <li><a href="index.php?class=SystemUserList" generator="adianti"
                                   class=" waves-effect waves-block">
                                <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-user fa-fw"></i>
                                <span>Usuários</span>
                            </a>
                            </li>
                            <li><a href="index.php?class=SystemDatabaseExplorer" generator="adianti"
                                   class=" waves-effect waves-block">
                                <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-database fa-fw"></i>
                                <span>Database explorer</span>
                            </a>
                            </li>
                            <li><a href="index.php?class=SystemSQLPanel" generator="adianti"
                                   class=" waves-effect waves-block">
                                <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-table fa-fw"></i>
                                <span>Painel SQL</span>
                            </a>
                            </li>
                            -->
                        </ul>
                    </li>
                    <li class="x">
                        <a href="#" class="menu-toggle waves-effect waves-block">
                            <i style="padding-right: 4px; margin-top: 8px;" class="fa fa-sign-out fa-fw"></i>
                            <span>Logout</span>
                        </a>
                        <ul class="ml-menu level-2">
                            <li><a href="index.php?class=LoginForm&amp;method=onLogout&amp;static=1" generator="adianti"
                                   class=" waves-effect waves-block">
                                    <i style="padding-right: 4px; margin-top: 5px;" class="fa fa-sign-out fa-fw"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="slimScrollBar"
                     style="background: rgba(0, 0, 0, 0.5) none repeat scroll 0% 0%; width: 4px; position: absolute; top: -0.434px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px; height: 398.867px;"></div>
                <div class="slimScrollRail"
                     style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div>
            </div>

        </div>

        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2016 AdminBSB 1.0.4
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>

<section class="content">
    <div class="container-fluid">
        <div id="adianti_div_content">
        </div>
    </div>
    <div id="adianti_online_content"></div>
    <div id="adianti_online_content2"></div>
</section>

<!-- Select Plugin Js -->
<script src="app/templates/{template}/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="app/templates/{template}/plugins/node-waves/waves.js"></script>
<script src="app/templates/{template}/js/admin.js"></script>
<script src="app/templates/{template}/js/custom.js"></script>
<script src="app/templates/{template}/js/sweetalert.min.js"></script>

</body>
</html>
