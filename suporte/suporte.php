<?php
  session_start();
?>
<!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-barcode"></span> Ordem de Serviço / Suporte</h2>
 </div>
 <!-- END PAGE TITLE -->

 <!-- PAGE CONTENT WRAPPER -->
 <div class="page-content-wrapnada" ng-init="selCidade='Londrina'">

   <div class="row" style="max-width:1080px;">
     <div class="col-md-12">

        <!-- START SEARCH -->
        <div class="panel panel-default">


            <?php
              // Se não for técnico, não tem autorização para acessar
              if ( ! $_SESSION[sys][login][funcao] ){
                ?>
                            <div class="panel-heading">
                                <h3 class="panel-title">Disponível apenas para Técnicos.</h3>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php
                exit;
              }
            ?>

            <div class="panel-heading">
                <h3 class="panel-title">Informe o que deseja encontrar, selecione a localidade e pressione o botão referente.</h3>
            </div>
            <div class="panel-body">
              <div class="row stacked">

                <div class="row">
                  <div class="col-md-8">
                      <div class="input-group push-down-10">
                          <span class="input-group-addon"><span class="fa fa-search"></span></span>
                          <input type="text" class="form-control" id="os_busca" name="os_busca" placeholder="Procurar por..." value=""/>
                      </div>
                      <span class="" id="div_cliente_print">Informe o critério de busca.</span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <select class="form-control select select_origem" name="select_os_origem" id="select_os_origem">
                        <?php
                          $aBase = $_SESSION[sys][FBConn];
                          // print_r($aBase);
                          while (list($key, $val) = each($aBase)) {
                            $sSelected = (($_SESSION[sys][login][localidade][cidade] == $aBase[$key]['cidade']) ? 'selected' : '');

                            if (! $bAdmin)
                              if ($sSelected == '')
                                continue;

                            echo "<option value='$key' $sSelected>".$aBase[$key]['cidade']."</option>";
                          }
                        ?>
                    </select>
                  </div>
                  <form class="form-inline" role="form" id="form_busca">
                    <div class="col-md-10">
                      <button class="btn btn-default" rel="OS"><span class="fa fa-search"></span> O.S.</button>
                      <button class="btn btn-default" rel="DOC"><span class="fa fa-search"></span> CPF/CNPJ</button>
                      <button class="btn btn-default" rel="NOME"><span class="fa fa-search"></span> NOME</button>
                      <button class="btn btn-default" rel="SERIAL"><span class="fa fa-search"></span> SERIAL</button>
                    </div>
                  </form>
                </div>


              </div>
            </div>
        </div>
        <!-- END SEARCH -->

        <!-- <a data-fancybox data-type="iframe" id="frame_os_print" href="javascript:;"></a> -->
        <a class="various" data-fancybox data-type="iframe" id="frame_os_print"  title="" href="os_imprimir.php"></a>
        <a class="various pop_edit_os" data-fancybox data-type="iframe" id="pop_edit_os"  title="" href="#"></a>

        <div class="panel panel-default">
            <div class="panel-body">
              <div id="cliente_os_div" class="container col-md-12"></div>
            </div>
        </div>

     </div>
   </div>

</div> <!-- fim da área de vendas //-->


<!-- Modal -->
<div class="modal fade" id="processTimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Processo em andamento</h5>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Acessando base de dados. Aguarde...</h3>
        <div class="text-center">
            <input id="processTime" class="knob" data-width="150" data-max="150" value="0" data-cursor=true data-fgColor="#FEC558"/>
        </div>
      </div>
    </div>
  </div>
</div>
