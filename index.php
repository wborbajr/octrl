<?php
/*
 * index principal
*/
    $lifetime = strtotime('+300 minutes', 0);
    session_set_cookie_params($lifetime); // 18000 = 5 horas | Set session cookie duration to 1 hour = 3600
    session_start();

    $_SESSION[sys][menu] = $_REQUEST['opc'] ? $_REQUEST['opc'] : 1;

    require_once("common.inc.php");

    require_once("conn.inc.php");

    loginValida();


    $bAdmin = $_SESSION[sys][login][admin];

	  // require( $_SESSION[sys][pagina][$iOpc] . '.inc.php' );

   // echo "<pre>";
   // print_r($_SESSION[sys][login]);
   // echo "</pre>";

?><!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title><?php echo "$appNome - $appVersao"?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- Bootstrap core CSS -->
        <!-- <link href="vendor/bootstrap/3.3.7/bootstrap.min.css" rel="stylesheet"> -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-blue.css"/>

        <!-- EOF CSS INCLUDE -->

        <!-- aqui colocaremos posteriormente a chamada para o angular -->
        <script src="vendor/angular/angular.js"></script>
        <!-- <script src="vendor/angular/angular-locale_pt-br.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.5.8/angular-locale_pt-br.js"></script> -->

        <!-- outros scripts que criaremos ficaram aqui -->
        <!-- <script src="vendor/angular-route.min.js"></script> -->

        <!-- rotas e controllers -->
        <script src="js/main.js"></script>

        <script src="<?php echo $_SESSION[sys][pagina][$iOpc] . '_controller.js'; ?>"></script>

        <script language="JavaScript">
            var processTimeModalInt = 0;
        </script>

    </head>

  <body ng-app="myApp" onload="mueveReloj()">


    <!-- MESSAGE BOX-->
    <div class="message-box message-box-danger animated fadeIn" data-sound="alert" id="mb-signout">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                <div class="mb-content">
                    <p>Você deseja realmente sair?</p>
                    <p>Todos os processos serão fechados e o sistema será encerrado.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <a href="login.php" class="btn btn-success btn-lg">Sim</a>
                        <button class="btn btn-default btn-lg mb-control-close">Não</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MESSAGE BOX-->


        <!-- START PAGE CONTAINER -->
        <div class="page-container" ng-controller="AppCtrl">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="./?opc=1"><?php echo $appNome?></a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="./?opc=1" class="profile-mini">
                            <img src="assets/images/users/<?php echo $_SESSION[sys][login][avatar]; ?>" alt=""/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="assets/images/users/<?php echo $_SESSION[sys][login][avatar]; ?>" alt=""/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $_SESSION[sys][login][usuario] . ' - #' . $_SESSION[sys][login][id]; ?></div>
                                <div class="profile-data-title"><?php echo $_SESSION[sys][login][funcao] . $_SESSION[sys][login][admin].  (($_SESSION[sys][login][admin]) ? " -> Admin" : '');?></div>
                            </div>
                            <div class="profile-controls hide">
                                <a href="#" class="profile-control-left" id="btProfile"><span class="fa fa-info"></span></a>
                                <a href="#" class="profile-control-right" id="btProfileRetirada"><span class="fa fa-upload"></span></a>
                            </div>
                        </div>
                    </li>
                    <!-- <li class="xn-title">Menu</li> -->
                    <?php
                      menu_sup($iOpc);
                    ?>
                    <li style="height:500px;">
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                      <p>&nbsp;</p>
                    </li>
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->


            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                    <li class="xn-search hide">
                        <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li>
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                    </li>
                    <!-- END SIGN OUT -->
                    <li class="pull-right">
                      <blockquote>
                        <p class="text-success">Logado em <cite title="Source Title"><?php echo $_SESSION[sys][login][localidade][cidade]; ?></cite></p>
                        <p id="timeout"></p>
                        <!-- <footer><?php echo $_SESSION[sys][login][acesso_em]; ?></footer> -->
                      </blockquote>
                    </li>

                </ul>
                <!-- END X-NAVIGATION VERTICAL -->

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="./?opc=1">Home</a></li>
                    <li class="active"><?php echo $_SESSION[aMenu_Opcoes][$iOpc][0]; ?></li>
                    <li>
                        <span class="pull-right" id="relogio"></span>
                    </li>
                    <li>
                        <span><?php echo $_SESSION[sys][login][localidade][db]; ?></span>
                    </li>
                    <li class="pull-right"> meu IP:
                        <?php echo $_SERVER['REMOTE_ADDR'];?>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->

                <!-- PAGE CONTENT IMPORT -->
                <div class="row" style="max-width:1080px;">
                  <?php
              			require( $_SESSION[sys][pagina][$iOpc] . '.php' );
              		?>
                </div> <!-- END PAGE CONTENT IMPORT -->

                <!--  -->
                <!-- Adicionar ítens na OS - Peças e Serviços - início -->
                <!--  -->
                <div class="modal fade" id="modal_itens_os" data-backdrop="static" z-index="-999" role="dialog">
                   <div class="modal-dialog modal-lg">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancelar</span></button>
                               <h3><span class="fa fa-arrow-circle-o-left"></span> Peças e Serviços
                               </h3>
                           </div>
                           <div class="modal-body row">

                             <form class="form-horizontal" id="formItemSeleciona">

                             <!-- <input type="hidden" ng-model="cItemTecnico_id" name="cItemTecnico_id" id="cItemTecnico_id" value=""> -->


                             <div class="col-md-7">
                               <div class="col-md-12">

                                 <div class="panel panel-default">
                                   <div class="panel-body">
                                     <p>Procure informando código ou parte da descrição</p>
                                       <div class="form-group">
                                         <div class="col-md-12">
                                           <div class="input-group">
                                             <div class="input-group-addon">
                                               <span class="fa fa-search"></span>
                                             </div>
                                             <input type="text" class="form-control" placeholder="O deseja encontrar?" ng-model="itemValor" id="itemValor"/>
                                             <div class="input-group-btn">
                                               <button class="btn" ng-click="itemBuscar(itemValor, 0)">Descrição</button>
                                             </div>
                                             <div class="input-group-btn">
                                               <button class="btn" ng-click="itemBuscar(itemValor, 9)">Código</button>
                                             </div>
                                           </div>
                                         </div>
                                       </div>
                                     <hr/>
                                     <h4>
                                       <span id="itemCodigo">{{oItemSelecionado.ID_IDENTIFICADOR}}</span> - <span id="itemDescricao">{{oItemSelecionado.PROD_SERV}}</span>
                                     </h4>
                                   </div>
                                 </div>

                               </div>

                               <div class="col-md-12">
                                   <div class="panel panel-default">

                                       <div class="panel-body panel-body-table">

                                           <table class="table table-responsive table-hover table-bordered table-actions">
                                               <thead>
                                                   <tr>
                                                       <th width="50" class="text-right">#</th>
                                                       <th>Produto / Serviço</th>
                                                       <th>Tipo</th>
                                                   </tr>
                                               </thead>
                                               <tbody>
                                                 <!-- oItemSelecionado = row[$index] -->
                                                 <tr ng-repeat="row in servicoLista" ng-click="itemSeleciona(row);">
                                                   <td class="text-right" ng-bind="row.ID_IDENTIFICADOR"></td>
                                                   <td ng-bind="row.PROD_SERV"></td>
                                                   <td ng-bind="row.tipo"></td>
                                                 </tr>
                                               </tbody>
                                           </table>

                                       </div>
                                 </div>
                               </div>

                             </div>

                             <!-- START RESPONSIVE TABLES -->
                             <div class="col-md-5">

                               <div class="col-md-12">

                                   <div class="panel panel-default">
                                     <div class="panel-body">
                                         <div class="col-md-12 col-xs-12 text-right">
                                           <label for="">Técnico</label>
                                         </div>
                                         <div class="col-md-12 col-xs-12 text-right">
                                           <select class="form-control" ng-model="cbItemTecnico" name="cbItemTecnico" id="cbItemTecnico" ng-change="tecnicoGet(this);">
                                           </select>
                                         </div>
                                     </div>
                                   </div>

                                </div>


                                 <div class="col-md-8 pull-right">
                                     <div class="panel panel-default">

                                         <div class="panel-body panel-body-table">
                                           <table class="table table-responsive table-hover table-bordered table-actions">
                                             <tbody>
                                               <tr>
                                                 <div class="form-group col-md-12">
                                                     <label class="control-label">Quantidade</label>
                                                     <div class="col-md-12">
                                                         <input type="text" class="form-control text-right" id="cItem_Qtd" name="cItem_Qtd" ng-model="cItem_Qtd" value="0" ng-blur="itemCalculaTotal()"/>
                                                     </div>
                                                 </div>
                                               </tr>
                                               <tr>
                                                 <div class="form-group col-md-12">
                                                     <label class="control-label">Unitário R$</label>
                                                     <!-- <span class="form-control text-right">
                                                         {{oItemSelecionado.PRC_VENDA | number:2}}
                                                     </span> -->
                                                     <input type="text" class="form-control text-right" id="PRC_VENDA" name="PRC_VENDA" ng-model="oItemSelecionado.PRC_VENDA"  ng-blur="itemCalculaTotal()"/>
                                                 </div>
                                               </tr>
                                               <tr>
                                                 <div class="form-group col-md-12">
                                                     <label class="control-label">Desconto R$</label>
                                                     <div class="col-md-12">
                                                         <input type="text" class="form-control text-right" id="cItem_Desconto" name="cItem_Desconto" ng-model="cItem_Desconto" value="0,00"  ng-blur="itemCalculaTotal()"/>
                                                     </div>
                                                 </div>
                                               </tr>
                                               <tr>
                                                 <div class="form-group col-md-12">
                                                     <label class="control-label">Total R$</label>
                                                     <span class="form-control text-right">
                                                       {{oItemSelecionado.ITEM_VALOR_TOTAL | number:2}}
                                                     </span>
                                                 </div>
                                               </tr>
                                             </tbody>
                                          </table>
                                         </div>
                                     </div>
                                 </div>

                             </div>
                             <!-- END RESPONSIVE TABLES -->

                           </form>
                           </div>
                           <div class="modal-footer">
                             <!-- <button class="btn btn-primary pull-right" data-dismiss="modal" onclick="javascript:gravaItemOSNovo()">Gravar e fechar</button> -->
                             <button class="btn btn-primary pull-right" data-dismiss="modal" ng-click="itemAdd(oItemSelecionado, '+')">Gravar e fechar</button>
                           </div>
                       </div>
                   </div>
                </div>
                <!--  -->
                <!-- Adicionar ítens na OS - Peças e Serviços - fim -->
                <!--  -->



                <!--  -->
                <!-- Editar OS - fim -->
                <!--  -->
                <div class="modal fade" id="modal_edita_os" data-backdrop="static" z-index="-999" role="dialog">
                   <div class="modal-dialog modal-lg">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancelar</span></button>
                               <h3><span class="fa fa-arrow-circle-o-left"></span> Edição da OS #<span id=ret_os_id>0000</span>
                               </h3>
                           </div>
                           <div class="modal-body row">

                             <div class="tab-pane1" id="tab-second1">
                               <div class="col-md-12">
                                 <input type="hidden" name="ret_os_objeto_id" id="ret_os_objeto_id" value="">
                                 <br/>
                                 <fieldset>
                                   <div class="form-group col-md-12">
                                       <label class="control-label">Produto - Descrição</label>
                                       <div class="col-md-12">
                                         <b><label class="form-control" id="ret_os_objeto_descricao" name="ret_os_objeto_descricao">Produto - Descrição</label></b>
                                       </div>
                                   </div>
                                 </fieldset>
                                 <fieldset>
                                     <div class="form-group col-md-4">
                                         <label class="control-label">Modelo</label>
                                         <div class="col-md-12">
                                             <input type="text" class="form-control" maxlength="40" placeholder="MODELO" id="ret_os_objeto_modelo" name="ret_os_objeto_modelo"/>
                                         </div>
                                     </div>
                                     <div class="form-group col-md-4">
                                         <label class="control-label">Serial</label>
                                         <div class="col-md-12">
                                             <input type="text" class="form-control" maxlength="40" placeholder="SERIAL" id="ret_os_objeto_serial" name="ret_os_objeto_serial"/>
                                         </div>
                                     </div>
                                     <div class="form-group col-md-4">
                                         <label class="control-label">Acessórios</label>
                                         <div class="col-md-12">
                                             <input type="text" class="form-control" maxlength="40" placeholder="ACESSORIOS" id="ret_os_objeto_acessorio" name="ret_os_objeto_acessorio"/>
                                         </div>
                                     </div>
                                   </fieldset>

                                   <fieldset>
                                     <div class="form-group col-md-6">
                                         <label class="control-label">Problema informado</label>
                                         <div class="col-md-12">
                                             <input type="text" class="form-control" maxlength="90" placeholder="Problema informado" id="ret_os_problema" name="ret_os_problema"/>
                                         </div>
                                     </div>
                                     <div class="form-group col-md-4">
                                         <label class="control-label">Adicional</label>
                                         <div class="col-md-12">
                                             <input type="text" class="form-control" maxlength="40" placeholder="ADICIONAL" id="ret_os_adicional" name="ret_os_adicional"/>
                                         </div>
                                     </div>
                                     <div class="form-group col-md-2">
                                         <label class="control-label">Prisma</label>
                                         <div class="col-md-12">
                                             <input type="text" class="form-control" maxlength="4" placeholder="PRISMA" id="ret_os_objeto_prisma" name="ret_os_objeto_prisma"/>
                                         </div>
                                     </div>
                                   </fieldset>

                                 </div>
                               </div>

                           <div class="modal-footer">
                             <!-- <button class="btn btn-primary pull-right" data-dismiss="modal" onclick="javascript:gravaItemOSNovo()">Gravar e fechar</button> -->
                             <button class="btn btn-primary pull-right" data-dismiss="modal" onclick="EditPostOS()">Gravar e fechar</button>
                           </div>
                       </div>
                   </div>
                </div>
                <!--  -->
                <!-- Editar OS - fim -->
                <!--  -->



                <a class="various" data-fancybox data-type="iframe" id="frame_os_print" href="#"></a>
                <a class="various pop_edit_obs" data-fancybox data-type="iframe" id="frame_os_cad"  title="" href="#"></a>


            </div> <!-- END PAGE CONTENT -->
        </div> <!-- END PAGE CONTAINER -->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->

        <!-- START SCRIPTS -->
          <!-- START PLUGINS -->
            <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
            <!-- <script type="text/javascript" src="js/plugins/jquery/jquery.userTimeout.js"></script> -->
            <!-- <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script> -->
            <script src="vendor/bootstrap/3.3.7/bootstrap.min.js"></script>
            <script src="vendor/bootbox.min.js"></script>

          <!-- END PLUGINS -->

          <script src="comum/index.js"></script>


          <!-- START THIS PAGE PLUGINS-->
            <!-- page specific plugin scripts -->
        		<?php
        			require( $_SESSION[sys][pagina][$iOpc] . '.dep' );
        		?>
          <!-- END THIS PAGE PLUGINS-->
        <!-- END SCRIPTS -->

        <!-- START TEMPLATE -->
          <script src="<?php echo $_SESSION[sys][pagina][$iOpc] . '.js'; ?>"></script>

          <!-- <script type="text/javascript" src="js/settings.js"></script> -->
          <!-- <script type="text/javascript" src="js/plugins.js"></script> -->
          <!-- <script type="text/javascript" src="js/actions.js"></script> -->

        <!-- END TEMPLATE -->

        <script language="JavaScript">

            function mueveReloj(){
            	momentoActual = new Date()
            	hora = momentoActual.getHours()
            	minuto = momentoActual.getMinutes()
            	segundo = momentoActual.getSeconds()

            	horaImprimible = hora + ":" + minuto + ":" + segundo

              document.getElementById('relogio').innerHTML = horaImprimible;

            	setTimeout("mueveReloj()",1000)
            }


            //
            function show_doc(print_opc){
              console.log('show_doc :=> print_opc: ', print_opc);
              $("#frame_os_print").attr("href", print_opc);

                console.log("modal relativo", $("#frame_os_print").attr("href"));

              $("#frame_os_print").click();
            }

            Number.prototype.padLeft = function(base,chr){
                var  len = (String(base || 10).length - String(this).length)+1;
                return len > 0? new Array(len).join(chr || '0')+this : this;
            }

            function timeOutCtrl(){

              // Set the date we're counting down to
              // var countDownDate = new Date("Jan 5, 2018 15:37:25").getTime();
              var countDownDate = new Date().getTime() ;

              // countDownDate = countDownDate+18000000; // 1800000 = 1/2 horas
              // countDownDate = countDownDate+1800000;
              countDownDate = countDownDate+1800000;

              // console.log('php-session', <?php //echo msession_timeout();?>);
              console.log(countDownDate);

              // Update the count down every 1 second
              var x = setInterval(function() {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24)).padLeft();
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).padLeft();
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).padLeft();
                var seconds = Math.floor((distance % (1000 * 60)) / 1000).padLeft();

                // Display the result in the element with id="demo"
                document.getElementById("timeout").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";

                var tempoOnline = document.getElementById("timeout").innerHTML;

                // console.log("processTimeModalInt", processTimeModalInt);

                if (processTimeModalInt < 150) {
                  processTimeModalInt = processTimeModalInt+1;
                  // timer de espera
                  $("#processTime").val( processTimeModalInt ).change();
                } else processTimeModalInt = 0;

                // If the count down is finished, write some text
                if (distance < 0) {
                  clearInterval(x);
                  document.getElementById("timeout").innerHTML = tempoOnline + " ***";// "EXPIRED";
                  window.open('./login.php', '_top');
                }
              }, 1000);
            }

            function gHoje(){

              // Exibindo data no input ao iniciar tarefa
              var d = new Date,
                  dformat = [ (d.getMonth()+1).padLeft(),
                              d.getDate().padLeft(),
                              d.getFullYear()
                            ].join('-') +
                            ' ' +
                            [ d.getHours().padLeft(),
                              d.getMinutes().padLeft(),
                              d.getSeconds().padLeft()
                            ].join(':');
              return dformat;
            }

            // **********
            timeOutCtrl(); // Inicia a contagem para logout automático

        </script>

</body>
</html>
