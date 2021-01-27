<?php
    session_start();

    // IP da localidade
    $ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] :
          ( $_SERVER['HTTP_X_FORWARDE‌​D_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );

    $_SESSION[sys][login] = array(
                                   'id' => 0,
                                   'usuario' => '',
                                   'nivel' => '0',
                                   'funcao' => '',
                                   'login' => '',
                                   'senha' => '',
                                   'acesso_em' => ''
                                 );

    require_once("common.inc.php");
?>
<!DOCTYPE html>
<html lang="br" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title><?php echo "$appNome - $appVersao"?></title>
        <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>

        <div class="login-container">

            <div class="login-box animated fadeInDown">
                <div class="login-logo"><img src="./img/logo.png" alt=""></div>
                <div class="login-body">
                    <div class="login-title"><strong>Omni Control</strong> - Mostre-se digno.</div>

                    <form class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" id="user" class="form-control" placeholder="Seu login"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" id="pass" class="form-control" placeholder="Sua senha"/>
                            </div>
                        </div>
                        <span class="help-block hide">Login e/ou senha inválido(s)</span>
                        <div class="form-group">
                            <div class="col-md-6 hide">
                              <button class="btn mb-control" data-box="#message-box-warning" id="teste">será?</button>
                            </div>
                            <div class="col-md-6">
                              <button class="btn btn-block btn-warning">Localidade</button>
                            </div>
                            <div class="col-md-6">
                              <button value="<?php echo $ip; ?>"class="btn btn-block btn-primary">Sua cidade</button>
                            </div>
                        </div>
                    </form>

                    <hr />

                    <div class="alert alert-warning" role="alert" id="msg">
                        <strong>Aguarde!</strong> Verificando as informações passadas...
                    </div>

                    <div class="alert alert-danger" role="alert" id="msgErro">
                        Login e/ou Senha não encontrados em <span id="showLocalidade"></span>!
                    </div>

                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        <?php echo $appVersao; ?>
                    </div>
                </div>
            </div>

        </div>

        <!-- warning -->
        <div class="message-box message-box-warning animated fadeIn" data-sound="alert" id="message-box-warning">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-warning"></span> Atenção!!</div>
                    <div class="mb-content">
                        <p>Selecione a localidade em que será autenticado.</p>
                    </div>
                    <div class="mb-footer">

                        <div class="localidade form-group pull-left">
                            <button type="button" class="btn btn-default btn-rounded" id="ctba"> Curitiba </button>&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger btn-rounded" id="lda"> Londrina </button>&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary btn-rounded" id="ntl"> &nbsp;&nbsp;Natal&nbsp;&nbsp;</button>
                        </div>

                        <button class="btn btn-default btn-lg pull-right mb-control-close">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end danger -->


        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->

        <!-- START SCRIPTS -->
            <!-- START PLUGINS -->
            <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
            <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
            <!-- END PLUGINS -->

            <!-- THIS PAGE PLUGINS -->
            <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
            <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

            <script type='text/javascript' src='js/plugins/noty/jquery.noty.js'></script>
            <!-- <script type='text/javascript' src='js/plugins/noty/layouts/topCenter.js'></script>
            <script type='text/javascript' src='js/plugins/noty/layouts/topLeft.js'></script>
            <script type='text/javascript' src='js/plugins/noty/layouts/topRight.js'></script> -->

            <!-- <script type='text/javascript' src='js/plugins/noty/themes/default.js'></script> -->
            <!-- END PAGE PLUGINS -->

            <!-- START TEMPLATE -->
            <!-- <script type="text/javascript" src="js/settings.js"></script> -->

            <script type="text/javascript" src="js/plugins.js"></script>
            <script type="text/javascript" src="js/actions.js"></script>
            <!-- END TEMPLATE -->
        <!-- END SCRIPTS -->


    </body>
</html>
<script type="text/javascript">
jQuery(function($) {

    $("#msg").hide();
    $("#msgErro").hide();

    $("#user").focus();

    var oObj = {};

    $(".localidade button").on('click', function(e){
      $("#msgErro").fadeOut('fast');
      oObj.localidade = this.id;
      oObj.login = $("#user").val();
      oObj.senha = $("#pass").val();

      // console.log( oObj );

      $("#showLocalidade").html( $(this).html() );

      $(".mb-control-close").click();

      $('form').slideUp('slow',function(){
          $("#msg").fadeIn('slow', function(){

            // Assign handlers immediately after making the request,
            // and remember the jqXHR object for this request
            var jqxhr = $.ajax( {
                                  type: "GET",
                                  url: 'login',
                                  dataType: 'json',
                                  async: false,
                                  data: {'acao': 'login', 'data': oObj}
                                }
              )
              .done(function(e) {
                console.log(e);
                $(".login-box").fadeIn('slow', function(){
                  // alert( "success" );
                  if (e !== null)
                    window.open('./', '_self');
                  else {
                    $("#msg").fadeOut('slow', function(){
                      $("#msgErro").fadeIn();
                    });
                  }
                });
              })
              .fail(function(e) {
                // alert( "error" );
                // console.log(e);
                $("#msg").fadeOut('slow', function(){
                  $("#msgErro").fadeIn();
                });
              })
              .always(function() {
                // alert( "complete" );
                $("#user").focus();
                $('form').slideDown('slow');
              });

            // Perform other work here ...

            // Set another completion function for the request above
            jqxhr.always(function(e) {
              // alert( "second complete" );
              console.log('e: ', e.responseText);
            });

          });
      });
    });

    $('form').submit(function(){
      $("#msgErro").fadeOut('fast');

      oObj.localidade = this.id;
      oObj.login = $("#user").val();
      oObj.pass = $("#pass").val();
      console.log( oObj );

      if (oObj.login == '' && oObj.pass == '') {
        $("#user").focus();
        // $("#message-box-warning").addClass('close');
        alert('Opa... sério que não vai nem tentar?!');
        return false;
      };

      $("#message-box-warning").addClass('open');
      return false;
    });


})
</script>
