<?php
    // Data no passado
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    // Sempre modificado
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    // HTTP/1.1
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);


    // HTTP/1.0
    header("Pragma: no-cache");


    session_start();

    $bLiberado = false;

    // curitiba
    if ($_SESSION[login][localid] == 7){
        require( 'conn.inc.php' );
        $bLiberado = ($_SESSION[login][id] == 61);
        $bAdmin    = in_array($_SESSION[login][id], array(12, 61, 53));
    }

    // londrina
    if ($_SESSION[login][localid] == 9){
        require( 'conn-9.inc.php' );
        $bAdmin    = in_array($_SESSION[login][id], array(12, 61, 53));
    }

    // natal
    if ($_SESSION[login][localid] == 1){
      require( 'conn-1.inc.php' );
      $bAdmin    = in_array($_SESSION[login][id], array(2, 61, 1));
    }


    if ($_SESSION[login][id] == null){
        $aRtn =  Array(code => -1, data => [], msg => "A sessao expirou. Faça login novamente.");  // $sql !! ($sLogin . $sSenha)

        //echo json_encode( $aRtn );
        ?>
        <script>window.open("index.html", "_top");</script>
        <?php
        exit;
    }


?><!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="expires" content = "-1" />

        <title>Hook v1.0a - 2015</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Ion Slider
        <link href="css/ionslider/ion.rangeSlider.css" rel="stylesheet" type="text/css" />
        -->
        <!-- ion slider Nice
        <link href="css/ionslider/ion.rangeSlider.skinNice.css" rel="stylesheet" type="text/css" />
        -->
        <!-- bootstrap slider
        <link href="css/bootstrap-slider/slider.css" rel="stylesheet" type="text/css" />
        -->

        <!-- Morris chart
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        -->
        <!-- jvectormap
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        -->
        <!-- fullCalendar -->
        <link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        -->
        <!-- DATA TABLES
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        -->
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />



        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>

        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>

        <!-- Add fancyBox -->
        <link rel="stylesheet" href="lib/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <script type="text/javascript" src="lib/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <style>
            .hide{
                display: none;
            }
        </style>

        <script type="text/javascript">
        /*
            $(function() {
                var var_global_tecnico_id   = <?php echo $_SESSION[login][id];?>;
                var var_global_tecnico_func = 'ID_TECNICO_RESP';
            });
            */
        </script>

    </head>
    <body class="skin-blue">


        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="./" target="_top" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="img/hook.png" width="35px;"/>
                Hook v1.0a
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>


                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="#"><?php echo $_SESSION[login][localnome]?></a></li>

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo (($_SESSION[login][apelido]) ? $_SESSION[login][apelido] : $_SESSION[login][nome]) . ' - ' .
                                                 (($_SESSION[login][funcao]) ? $_SESSION[login][funcao] : (($_SESSION[login][cargo]) ? $_SESSION[login][cargo] : 'Cargo?'));?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="./img/user-avatar-default.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $_SESSION[login][nome];?>
                                        <small><?php echo $_SESSION[login][funcao] ? $_SESSION[login][funcao] : (($_SESSION[login][cargo]) ? $_SESSION[login][cargo] : 'Cargo?');?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body hide">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat hide">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="./" target="_top" class="btn btn-default btn-flat">Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li><a href="#"><span id="time">00:00:00</span></a></li>

                    </ul>
                </div>
            </nav>
        </header>


        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel hide">
                        <div class="pull-left image">
                            <img src="img/o.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><span id="user_id">00</span> - <span id="user_name">Generico</span></p>

                            <a href="./index.html" target="_top"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form hide">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">

                        <li>
                            <a href="#" id="main_dashboard" alt="Painel de Controle">
                                <i class="fa fa-apple"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" id="main_vendas" alt="Area de Vendas e Retiradas">
                                <i class="fa fa-share"></i> <span>Vendas/Atendimento</span>
                            </a>
                        </li>

                        <li <?php echo ( $_SESSION[login][tecnico] ? '' : "class='hide'" );?>>
                            <a href="#" id="main_suporte" alt="Suporte Tecnico">
                                <i class="fa fa-wrench"></i> <span>Suporte</span>
                            </a>
                        </li>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>


            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

		        <div data-alerts="alerts" data-titles="{'warning': '<em>Warning!</em>'}" data-ids="myid" data-fade="3000"></div>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span>Dashboard</span>
                        <small>Painel de Controle</small>
                    </h1>
                    <ol class="breadcrumb hide">
                        <li><a href="#" data-toggle="modal" id="id_modal_controle_ranking" data-target="#modal_controle_ranking"><i class="fa fa-bar-chart-o"></i> Ranking</a></li>
                        <li class="active hide">Blank page</li>
                    </ol>

                </section>


                <!-- Main content -->
                <section class="content">
                    <div class='row'>
                        <div class='col-xs-12'>

                            <div id="div-main_dashboard" style="display:;">

                                    <div class="col-md-12">
                                        <!-- Default box -->
                                        <div class="box box-danger">
                                            <div class="box-header">
                                              <!-- tools box -->
                                              <div class="pull-right box-tools">
                                                  <button class=" btn btn-danger btn-sm refresh-btn" data-toggle="tooltip" title="Reload" id="dash_refresh"><i class="fa fa-refresh"></i></button>

                                                  <button class="hide btn btn-info btn-sm" data-toggle="modal" data-target="#dash_valorelemento_help" data-widget='help' data-toggle="tooltip" title="Sobre a composiçao dos valores"><i class="fa fa-question"></i></button>

                                                  <button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                              </div><!-- /. tools -->
                                              <i class="fa fa-signal"></i>
                                              <h3 class="box-title">Mapa de serviços

                                                  <div class="btn-group">
                                                      <button type="button" class="btn btn-primary btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                          Funcionário &nbsp;<span class="caret"></span>
                                                      </button>
                                                      <ul class="dropdown-menu <?php echo $bAdmin ? '' : 'hide';?>" role="menu" id="dash_menu">
                                                            <?php
                                                                //
                                                                $sql = "SELECT r.ID_FUNCIONARIO, r.NOME, r.SETOR,
                                                                               r.CARGO, r.APELIDO, r.OBSERVACAO, STATUS
                                                                        FROM V_FUNCIONARIOS r
                                                                        WHERE STATUS <> 'I'
                                                                        ORDER BY r.NOME";

                                                                $res  = ibase_query ($dbh, $sql);
                                                                while ($data = ibase_fetch_assoc($res, IBASE_TEXT)){
                                                                    echo "<li data-id='$data[ID_FUNCIONARIO]'><a href='#'>".$data[NOME]." ($data[ID_FUNCIONARIO])</a></li>\n";
                                                                }
                                                            ?>
                                                      </ul>&nbsp;
                                                      <small><code id='dash_user'><?php echo $_SESSION[login][nome] . ' ('. $_SESSION[login][id] . ')';?></code></small>
                                                  </div>

                                                  <div class="btn-group">
                                                      <button type="button" class="btn btn-info btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                          Função &nbsp;<span class="caret"></span>
                                                      </button>
                                                      <ul class="dropdown-menu" role="menu" id="dash_user_func">
                                                        <li data-id='ID_TECNICO_RESP'><a href='#'>Técnico Responsável</a></li>
                                                        <li data-id='ID_VENDEDOR'><a href='#'>Vendedor / Atendente</a></li>
                                                      </ul>&nbsp;
                                                      <small><code id='dash_user_func_desc'>Técnico Responsável</code></small>
                                                  </div>


                                                  <div class="btn-group">
                                                      <button type="button" class="btn btn-warning btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                                          Periodo &nbsp;<span class="caret"></span>
                                                      </button>
                                                      <ul class="dropdown-menu" role="menu" id="dash_user_periodo">
                                                        <li data-id='0'><a href='#'>Periodo Atual</a></li>
                                                        <li data-id='1'><a href='#'>Periodo Anterior</a></li>
                                                      </ul>&nbsp;
                                                      <small><code id='dash_user_periodo_desc'>Periodo Atual</code></small>
                                                  </div>


                                              </h3>

                                            </div><!-- /.box-header -->
                                            <div class="">
                                                <div class="box-body no-padding">

                                                    <div class="row">
                                                    <div class="col-sm-12" style="font-size:8pt;" id="dash_body">
                                                    <?php /*
                                                        if ($_SESSION[login][id] == 61)
                                                            include('dashboard2.inc.php');
                                                        else*/
                                                            include('dashboard.inc.php');
                                                    ?>
                                                    </div>
                                                    </div><!-- /.row - inside box -->

                                                </div>
                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->

                                    </div>
                            </div>



                            <!-- Área de vendas //-->
                            <div id="div-main_vendas" style="display:none;">

                                <div class="col-md-6">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">Ordens de Serviços e Recibo</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">

                                            <form class="form-inline" role="form" id="form_os_busca">

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-edit"></i>
                                                        </div>
                                                        <input type="text" id="os_busca" placeholder="Informe o critério" class="form-control" class="form-control input-sm"/>
                                                    </div><!-- /.input group -->
                                                </div><!-- /.form group -->

                                                <div id="div_os_print"></div>

                                                <div data-role="controlgroup" data-type="horizontal" data-inline="true">
                                                    <div class="form-group">
                                                          <select class="form-control input-sm btn-success" name="select_os_origem" id="select_os_origem">
                                                          <?php
                                                            if ($_SESSION[login][localid] == 7){
                                                          ?>
                                                                <option value="11">Antiga</option>
                                                                <option value="7" selected>Curitiba</option>
                                                          <?php };
                                                            if ($_SESSION[login][localid] == 9){
                                                          ?>
                                                                <option value="9">Londrina</option>
                                                          <?php };
                                                            if ($_SESSION[login][localid] == 1){
                                                            ?>
                                                                  <option value="1">Natal</option>
                                                            <?php }; ?>
                                                          </select>

                                                      <button type="button" class="btn btn-sm btn-primary" rel="os" data-inset="true" data-icon="eye" data-iconpos="right">OS</button>
                                                      <button type="button" class="btn btn-sm btn-info btn_manut_1" rel="recibo" data-inset="true" data-icon="eye" data-iconpos="right">RECIBO</button>
                                                      <button type="button" class="btn btn-sm btn-warning btn_manut_1" rel="retirada" data-inset="true" data-icon="action" data-iconpos="right">RETIRADA</button>

                                                      <button type="button" class="btn btn-sm bg-navy" rel="DOC">CPF/CNPJ</button>
                                                      <button type="button" class="btn btn-sm btn-normal" rel="NOME">NOME</button>

                                                    </div>
                                                </div>

                                            </form><br>

                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->

                                </div><!-- /.col -->

                                <div id="vendas_os_div" class="container col-md-12">Resultado da pesquisa</div>

                            </div> <!-- fim da área de vendas //-->



                            <!-- Área de manutenção //-->
                            <div id="div-main_suporte" style="display:none;">


                                <div class="col-md-6">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">Ordens de Serviços e Recibo</h3>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">

                                            <form class="form-inline" role="form" id="form_cliente_busca">

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-edit"></i>
                                                        </div>
                                                        <input type="text" class="form-control input-sm" id="cliente_busca" data-inline="true" placeholder="Informe o critério">
                                                    </div><!-- /.input group -->
                                                </div><!-- /.form group -->

                                                <div data-role="controlgroup" data-type="horizontal" data-inline="true">
                                                     <select class="form-control input-sm btn-success" name="select_manutencao_os_origem" id="select_manutencao_os_origem">
                                                       <?php
                                                         if ($_SESSION[login][localid] == 7){
                                                       ?>
                                                             <option value="11">Antiga</option>
                                                             <option value="7" selected>Curitiba</option>
                                                       <?php };
                                                         if ($_SESSION[login][localid] == 9){
                                                       ?>
                                                             <option value="9">Londrina</option>
                                                       <?php };
                                                         if ($_SESSION[login][localid] == 1){
                                                         ?>
                                                               <option value="1">Natal</option>
                                                         <?php }; ?>
                                                      </select>

                                                      <button type="button" class="btn btn-sm btn-primary" rel="OS">OS</button>
                                                      <button type="button" class="btn btn-sm bg-navy" rel="DOC">CPF/CNPJ</button>
                                                      <button type="button" class="btn btn-sm btn-normal" rel="NOME">NOME</button>
                                                      <?php
                                                          //if ($bLiberado){
                                                      ?>
                                                      <button type="button" class="btn btn-sm btn-warning" rel="SERIAL">SERIAL</button>
                                                      <?php
                                                          //}
                                                      ?>
                                                </div>

                                                <div id="div_cliente_print">Informe o critério de busca.</div>

                                            </form>



                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->

                                </div><!-- /.col -->

                                <div id="cliente_os_div" class="container col-md-12"></div>

                            </div> <!-- fim da área de manutenção //-->


                            <a class="various" data-fancybox-type="iframe" id="frame_os_print"  title="" href="os_imprimir.php"></a>
                            <a class="pop_edit_obs" data-fancybox-type="iframe" id="frame_os_cad"  title="" href="#"></a>
                            <a class="pop_edit_os" data-fancybox-type="iframe" id="pop_edit_os"  title="" href="#"></a>


                      </div>

                    </div>
                </section><!-- /.content -->

            </aside><!-- /.right-side -->

        </div><!-- ./wrapper -->



        <!-- MODAL -->
        <!-- COMPOSE MESSAGE MODAL
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true"> -->
        <div class="modal fade" id="formAux" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Formulário Auxiliar </h4>
                    </div>

                    <div class="modal-body">
                      <p>Formulário Auxiliar</p>
                    </div>
                    <div class="modal-footer clearfix">

                        <button type="button" class="btn btn-danger"
                            data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>

                    </div>

                  </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->






        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>

		<script src="js/jquery.bsAlerts.min.js"></script>

        <script src="lib/sweet-alert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="lib/sweet-alert.css">


        <!-- InputMask -->
        <script src="js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
        <!-- Morris.js charts
        <script src="js/raphael-min.js"></script>
        <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
        -->
        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <!-- script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script -->
        <!-- fullCalendar -->
        <!-- script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script -->
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <!-- script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script -->
        <!-- iCheck
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        -->

        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

        <!--
        <script type="text/javascript" src="lib/jquery-plugins/freeow/jquery.freeow.min.js"></script>
        -->

         <!-- Ambiance Plugin Assets
         <link href="lib/jquery-plugins/ambiance/jquery.ambiance.css" rel="stylesheet" type="text/css">
         <script src="lib/jquery-plugins/ambiance/jquery.ambiance.js" type="text/javascript"></script>
         -->

         <script src="lib/frases/frase.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>-->


        <!-- Ion Slider -->
        <script src="js/plugins/ionslider/ion.rangeSlider.min.js" type="text/javascript"></script>

        <!-- Bootstrap slider -->
        <script src="js/plugins/bootstrap-slider/bootstrap-slider.js" type="text/javascript"></script>


     <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>

        <script type="text/javascript">

            //var i = 0;

            $(function() {

                // Apresenta pensamentos a cada periodo informado
                window.setInterval(ver, (30 * 60 * 1000)); // min * seg * mili seg

                $("[data-mask]").inputmask();

                $(".warn-me").click(function() {
                  $(document).trigger("add-alerts", [
                  {
                    'message': "Exemplo de mensagem.",
                    'priority': 'success'
                }
                ]);
              });

            });


            // Apresenta pensamentos na tela, de tempo em tempo
            function ver(){
                info('Pensamentos', makeQuote(), 'aviso', 30);
            }



            // Formata mensagens do tipo flutuante no canto superior direito
            // auto closing.
            function info(sTitulo, sMensagem, sTipo, iTempo){
                if (! sTitulo) sTitulo = 'Sem Tiulo';
                if (! sMensagem) sMensagem = 'Sem Mensagem';
                if (! sTipo) sTipo = 'default';
                if (! iTempo) iTempo = 10;

                if (sTipo == 'ok') sTipo = 'success';
                if (sTipo == 'erro') sTipo = 'error';


                switch (sTipo){
                    case 'success': sTitulo = "<i class='fa fa-thumbs-o-up'></i> " + sTitulo; sTipo = 'success'; break;
                    case 'error': sTitulo = "<i class='fa fa-thumbs-o-down'></i> " + sTitulo; sTipo = 'error'; break;
                    default:
                    sTitulo = "<i class='fa fa-comment-o'></i> " + sTitulo; sTipo = 'default'; break;
                };

                $.ambiance({  title: sTitulo,
                  message: sMensagem,
                  type: sTipo,
                  width: 650,
                  timeout: iTempo});


            };

            // Botoes de exemplo de mensagens float
            // Estao no dashboard
                $(".confiance-default").click(function(){
                    info('Aviso', 'mensagem', '');
                });


                $(".confiance-success").click(function(){
                    info('Sucesso', makeQuote(), 'ok');
                })


                $(".confiance-error").click(function(){
                    info('Erro', makeQuote(), 'erro');
                })
            /// ------------



        </script>

    </body>
</html>
<!-- page script -->
        <script type="text/javascript">
                var var_global_tecnico_id   = <?php echo $_SESSION[login][id];?>;
                var var_global_tecnico_func = 'ID_TECNICO_RESP';
                var var_global_dataini = '0';
                var var_global_datafim = '0';
            $(function() {
                startTime();
                /*
                $(".center").center();
                $(window).resize(function() {
                    $(".center").center();
                });
                */

                /*
                 *  Simple image gallery. Uses default settings
                 */

                $('.fancybox').fancybox();

                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();

                //Date range picker
                $('#reservation').daterangepicker();
            });

            /*  */
            function startTime()
            {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();

                // add a zero in front of numbers<10
                m = checkTime(m);
                s = checkTime(s);

                //Check for PM and AM
                var day_or_night = (h > 11) ? "PM" : "AM";

                //Convert to 12 hours system
                if (h > 12)
                    h -= 12;

                //Add time to the headline and update every 500 milliseconds
                $('#time').html(h + ":" + m + ":" + s + " " + day_or_night);
                setTimeout(function() {
                    startTime()
                }, 500);
            }

            function checkTime(i)
            {
                if (i < 10)
                {
                    i = "0" + i;
                }
                return i;
            }

        </script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
