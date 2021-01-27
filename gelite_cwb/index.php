<?php
    session_start();

	  require_once("conn.inc.php");

    require_once("common.inc.php");

	  // require( $_SESSION[sys][pagina][$iOpc] . '.inc.php' );

//    echo "<pre>";
//    print_r($_SESSION);

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo "$appNome - $appVersao"?></title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

    <link rel="stylesheet" href="assets/css/monge.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->

    <script src="./assets/js/angular/angular.js"></script>

    <script src="<?php echo $_SESSION[sys][pagina][$iOpc] . '_controller.js'; ?>"></script>

	</head>

	<body class="no-skin" ng-app="rwApp" style="">
		<div id="navbar" class="navbar navbar-default    navbar-collapse       ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="./" class="navbar-brand">
						<small class="pull-left">
							<!-- <i class="fa fa-apple"></i> -->
              <img src="assets/images/logo.jpg" class="logo" style="text-align:center">
							<?php echo " $appCliente"?>
						</small>
					</a>

          <ul class="nav navbar-nav pull-left">
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							    <i class="ace-icon fa fa-desktop">&nbsp;</i>
								<?php echo $_SESSION[sys][unidade];?>&nbsp;
								<i class="ace-icon fa fa-angle-down bigger-110"></i>
							</a>

							<ul class="dropdown-menu dropdown-light-blue dropdown-caret">
								<li>
									<a href="./?unidade=CWB">
										<i class="ace-icon fa fa-desktop bigger-110 blue"></i>
										Curitiba
									</a>
								</li>

								<li>
									<a href="./?unidade=LND">
										<i class="ace-icon fa fa-desktop bigger-110 blue"></i>
										Londrina
									</a>
								</li>

								<li>
									<a href="./?unidade=NTL">
										<i class="ace-icon fa fa-desktop bigger-110 blue"></i>
										Natal
									</a>
								</li>

							</ul>
						</li>
						<li class="hide">
							<a href="#" class="sidebar-collapse" data-target="#sidebar">
								Menu Compacto
							</a>
						</li>
					</ul>

          <!-- <h3 class="pull-right"> -->
            <!-- <a href="./" class="navbar-brand"> -->
              <!-- <img src="assets/images/logo.jpg" class="logo"> -->
              <!-- <label style="margin: 0 auto;">OMNI Informática‎</label> -->
            <!-- </a> -->
          <!-- </h3> -->

					<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons">
						<span class="sr-only">Toggle user menu</span>

						<img src="assets/images/avatars/user.jpg" alt="Jason's Photo" />
					</button>
				</div>

				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">

            <!-- profile -->
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/images/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Guth,</small>
									Reinaldo
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Configurações
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Seus dados
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="login.html">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>  <!-- profile -->
					</ul>
				</div>

        <nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">

					<form class="navbar-form navbar-left form-search hide" role="search">
						<div class="form-group">
							<input type="text" placeholder="search" />
						</div>

						<button type="button" class="btn btn-mini btn-info2">
							<i class="ace-icon fa fa-search icon-only bigger-110"></i>
						</button>
					</form>
				</nav>


			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				// try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					// try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success" data-toggle="modal" href="#modal-gelite-busca">
							<i class="ace-icon glyphicon glyphicon glyphicon-phone-alt"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>
						<span class="btn btn-info"></span>
						<span class="btn btn-warning"></span>
						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
					<li class="<?php echo (($iOpc == 1) ? 'active open' : '');?>">
						<a href="./?opc=1">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>

          <li class="<?php echo (($iOpc == 2) ? 'active open' : '');?>">
						<a href="./?opc=2">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text">Atendimento</span>
						</a>

						<b class="arrow"></b>
					</li>

          <li class="<?php echo (($iOpc == 3) ? 'active open' : '');?>">
						<a href="./?opc=3">
							<i class="menu-icon fa fa-laptop"></i>
							<span class="menu-text"> Suporte </span>
						</a>

						<b class="arrow"></b>
					</li>

          <li class="<?php echo (($iOpc == 4) ? 'active open' : '');?>">
						<a href="./?opc=4">
							<i class="menu-icon fa fa-tty"></i>

							<span class="menu-text">
								GeLiTe
							</span>
						</a>

						<b class="arrow"></b>
					</li>

				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content" ng-controller="rwCtrl">

            <div class="page-header">
              <h1><?php echo $_SESSION[aMenu_Opcoes][$iOpc][0]?>
                <sub class="breadcrumb"><?php echo $_SESSION[aMenu_Opcoes][$iOpc][1]?></sub class="breadcrumb">

              <div class="pull-right <?php echo $iOpc==44 ? '' : 'hide';?>">
                <button class="btn" id="btn1">
                  <i class="ace-icon fa fa-calendar align-top bigger-125"></i>
                  Modo 1
                </button>

                <button class="btn btn-primary" id="btn2">
                  <i class="ace-icon fa fa-tachometer align-top bigger-125"></i>
                  Modo 2
                </button>

                <button class="btn btn-info" id="btn3">
                  <i class="ace-icon fa fa-bar-chart-o  align-top bigger-125 icon-on-right"></i>
                  Modo 3
                </button>
              </div>
            </h1>

						</div><!-- /.page-header -->

            <?php
              // Pag de conteudo
              require( $_SESSION[sys][pagina][$iOpc] . '.php' );
            ?>


            <!-- painel inferior para apresentação de mensagens -->
            <div id="bottom-msg" class="modal aside" data-fixed="false" data-placement="bottom" data-background="true" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body container">
									<div class="row">
								<div class="col-sm-5 col-sm-offset-1 white">
									<h3 class="lighter" ng-bind="msgTitulo"></h3>

						            <span ng-bind="msgTexto"></span>

						            <div class="progress progress-striped active">
										<div class="progress-bar progress-bar-success" style="width: {{iGaugeAux}}%"></div>
									</div>

						            <!-- <div>{{countDown}} </div> -->

            						<!-- <timer countdown="30" interval="1000"><div class="progress progress-striped active {{displayProgressActive}}"style="height: 30px;"> Remaining time : {{countdown}} second{{secondsS}} ({{progressBar}}%). Activity? {{displayProgressActive}} <div class="bar" style="min-width: 2em;width: {{progressBar}}%;"></div> </div></timer>  -->
								</div>
							</div>
						</div>
					</div><!-- /.modal-content -->

					<button ng-show="iGaugeAux > 50" class="btn btn-yellow btn-app btn-xs ace-settings-btn aside-trigger" data-target="#bottom-msg" data-toggle="modal" type="button">
						<i data-icon2="fa-chevron-down" data-icon1="fa-chevron-up" class="ace-icon fa fa-chevron-up bigger-110 icon-only"></i>
					</button>

				</div><!-- /.modal-dialog -->
			</div>
            <!-- painel inferior para apresentação de mensagens -->


            <div id="modal-gelite-busca" class="modal fade" tabindex="-1">
            	<div class="modal-dialog">
            		<div class="modal-content">
            			<div class="modal-header no-padding">
            				<div class="table-header">
            					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            						<span class="white">&times;</span>
            					</button>
            					Pesquisa analitica de ligações
            				</div>
            			</div>

            			<div class="modal-body no-padding">

										<div class="widget-box transparent" class="col-sm-6 widget-container-col">
											<div class="widget-header">
												<h4 class="widget-title lighter"></h4>

												<div class="widget-toolbar no-border">
                          <div class="nav-search" id="nav-search">
                            <form class="form-search">
                              <span class="input-icon">
                                <input type="text" placeholder="Entre com o nr ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                              </span>
                            </form>
                          </div><!-- /.nav-search -->

												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-6 no-padding-left no-padding-right">

												</div>
											</div>
										</div>

            				<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            					<thead>
            						<tr>
            							<th>#</th>
            							<th>Tipo</th>
            							<th><i class="ace-icon blue fa fa-caret-right"></i> Data</th>
            							<th><i class="ace-icon blue fa fa-caret-right"></i> Hora</th>
            							<th><i class="ace-icon blue fa fa-caret-right"></i> Ring</th>
            							<th><i class="ace-icon blue fa fa-caret-right"></i> Tempo</th>
            							<th><i class="ace-icon blue fa fa-caret-right"></i> Numero</th>
            						</tr>
            					</thead>
            					<tbody>
            						<tr ng-repeat="row in glt_dash_resumo6.data">
            							<td style="text-align:right;" ng-bind="$index+1"></td>
            							<td style="text-align:right;" ng-bind="row.tipo_desc"></td>
            							<td style="text-align:right;">{{row.data | date:'dd-MM-yyyy'}}</td>
            							<td ng-bind="row.hora"></td>
            							<td ng-bind="row.ring"></td>
            							<td ng-bind="row.duracao"></td>
            							<td style="text-align:right;" ng-bind="row.fone"></td>
            						</tr>
            					</tbody>
            				</table>
            			</div>
            		</div>
            	</div>
            </div>

					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

    <div class="footer">
      <div class="footer-inner">
        <div class="footer-content">
          <span class="bigger-120">
            <img src="assets/images/logo-rwplus-150x150.png" class="logo">
            <span class="blue bolder"><?php echo "$appNome"?></span> -
            <?php echo "$appVersao"?>
            <br>
            Desenvolvido por <a href="https://about.me/reinaldo.guth" target="_blank">Reinaldo S Guth</a> - rwPlus ID
          </span>

          &nbsp; &nbsp;
          <span class="action-buttons hide">
            <a href="#">
              <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
            </a>

            <a href="#">
              <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
            </a>

            <a href="#">
              <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
            </a>
          </span>
        </div>
      </div>
    </div>

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
      <script src="assets/js/jquery-1.11.3.min.js"></script>
    <![endif]-->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<?php
			require( $_SESSION[sys][pagina][$iOpc] . '.dep' );
		?>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
    <!-- inline scripts related to this page -->
    		<script type="text/javascript">
    			jQuery(function($) {
    				//make content sliders resizable using jQuery UI (you should include jquery ui files)
    				//$('#right-menu > .modal-dialog').resizable({handles: "w", grid: [ 20, 0 ], minWidth: 200, maxWidth: 600});
            $( "#btn1" ).click(function() {
						  $( "#pag1" ).fadeIn( "slow", function() {
						    // Animation complete.
						  });
						});

            $( "#btn2" ).click(function() {
						  $( "#pag1" ).fadeOut( "slow", function() {
						    // Animation complete.
						  });
						});

            $( "#btn3" ).click(function() {
						  $( "#pag1" ).slideUp( "slow", function() {
						    // Animation complete.
						  });
						});
    			})
    		</script>
	</body>
</html>
