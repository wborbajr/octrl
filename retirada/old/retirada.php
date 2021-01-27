<?php
  session_start();
?>
<!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-barcode"></span> Reimpressão de OS e Receibo / Retirada / Atendimento</h2>
 </div>
 <!-- END PAGE TITLE -->

 <!-- PAGE CONTENT WRAPPER -->
 <div class="page-content-wrapnada" ng-init="selCidade='Londrina'">

   <div class="row" style="max-width:1080px;">
     <div class="col-md-8">

        <!-- START SEARCH -->
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Ordem de Serviço / Recibo / Reimpressão / Retirada</h3>
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
                      <button class="btn btn-default" rel="RECIBO"><span class="fa fa-search"></span> RECIBO</button>
                      <button class="btn btn-default" rel="DOC"><span class="fa fa-search"></span> CPF/CNPJ</button>
                      <button class="btn btn-default" rel="NOME"><span class="fa fa-search"></span> NOME</button>
                    </div>
                  </form>
                  <p></p>
                </div>

              </div>
            </div>
        </div>
        <!-- END SEARCH -->

        <!-- <a data-fancybox data-type="iframe" id="frame_os_print" href="javascript:;"></a> -->
        <a class="various" data-fancybox data-type="iframe" id="frame_os_print"  title="" href="os_imprimir.php"></a>

     </div>

     <div class="col-md-4 pull-right">
           <!-- START PANEL WITH REFRESH CALLBACKS -->
           <div class="panel panel-warning">
               <div class="panel-heading">
                   <h3 class="panel-title">Retirada / Fechamento de OS</h3>
               </div>
               <div class="panel-body">
                 <input type="text" class="form-control" id="retirada_os" data-model="retirada_os" placeholder="OS a fechar" required/>
               </div>
               <div class="panel-footer">
                <a href="#" class="btn mb-control pull-right" onclick="validaOS();"><span class="fa fa-sign-out"></span> RETIRAR</a>
               </div>
           </div>
           <!-- END PANEL WITH REFRESH CALLBACKS -->
     </div>

     <div class="row">
       <div class="panel panel-default">
           <div class="panel-body">
             <div id="cliente_os_div" class="container col-md-12"></div>
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


<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="modal_retirada">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> A Ordem de Serviço #<label id="retirar_os"></label> será <strong>ENCERRADA</strong>! Confirma ?</div>
            <div class="mb-content">
                <p>Encerramento / Baixa de Ordem de Serviço</p>
                <p>Processo de entrega de mercadoria e fechamento da OS. Não tem volta.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right modal_retirada">
                  <a class="btn btn-default btn-lg mb-control-close" onclick="">=> Não encerrar</a>
                  <a href="#" class="btn btn-warning btn-lg mb-control-close" rel="RETIRADA" id="btRetirada" name="btRetirada">ENCERRAR!</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->
