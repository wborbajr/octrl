<?php
  session_start();
?>
<!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-barcode"></span> Ordem de Serviço / Venda</h2>
 </div>
 <!-- END PAGE TITLE -->

 <!-- PAGE CONTENT WRAPPER -->
 <div class="page-content-wrap">

   <div class="row" style="max-width:1080px;">
     <div class="col-md-12">

       <form class="form-horizontal" data-toggle="validator" id="formOS" name="formOS">

         <input type="hidden" name="IDCLIENTE" id="IDCLIENTE" value="">
         <!-- <input type="hidden" name="CPF_CNPJ" id="CPF_CNPJ" value=""> -->
         <input type="hidden" name="DT_OS" id="DT_OS" value="">
         <input type="hidden" name="HR_OS" id="HR_OS" value="">
         <input type="hidden" name="ID_MODULO" id="ID_MODULO" value="22">
         <input type="hidden" name="OS_CPF_CNPJ" id="OS_CPF_CNPJ" value="">
         <input type="hidden" name="OS_CLIE_NOME" id="OS_CLIE_NOME" value="">

         <input type="hidden" name="OS_ITENS_GRAVAR" id="OS_ITENS_GRAVAR" value="0" />

         <div class="panel panel-default tabs1">
           <ul class="nav nav-tabs hide" role="tablist">
             <li class="active"><a href="#tab-first" role="tab" data-toggle="tab">Cliente</a></li>
             <li><a href="#tab-second" role="tab" data-toggle="tab">Ordem de Serviço</a></li>
             <li><a href="#tab-third" role="tab" data-toggle="tab">Peças e Serviços</a></li>
             <li>Última OS #<h3 id="id_os_cad_nao-usado">0000</h3></li>
             <li class="pull-right">
               <button class="btn btn-primary pull-right" id="btOSGravaold">Salvar <span class="fa fa-floppy-o fa-right"></span></button>
             </li>
           </ul>
           <div class="panel-body tab-content1">
             <div class="tab-pane active" id="tab-first">
                 <div class="col-md-12">
                   <span class="text-right">
                    <span class="pull-right"><a href="#" id="lastOSs">Últimas OS</a> - Geral: <span id="id_os_geral">0000000000</span>
                    <br/>Sua: <a href="#"><span id="id_os_vendedor">0000000000</span></a></span>
                  </span>
                   <h3><span class="fa fa-arrow-circle-o-left"></span> Dados do Cliente
                   <!-- <span class="text-right">
                     <button class="btn btn-primary pull-right" id="btOSGrava">Salvar <span class="fa fa-floppy-o fa-right"></span></button>
                   </span> -->
                  </h3>
                   <hr />

                   <div class="table-responsive col-md-12">

                        <div class="col-md-4">
                          <label>CPF ou CNPJ</label>
                          <div class="input-group form-group has-feedback">
                              <span class="input-group-addon" data-dismiss="modal"
                                     data-toggle="modal" data-target="#modal_cliente1"
                                     id="btnClieNovo1" onclick="frmCliente.reset()"><span class="fa fa-bolt"></span></span>
                              <!-- <input type="text" id="cpClieDoc" class="form-control"/> -->
                              <input type="text"
                                    class="form-control"
                                    pattern="^[0-9]{1,}$"
                                    name="cpClieDoc" id="cpClieDoc"
                                    minlength="11" maxlength="18" style="width:100%;"
                                    placeholder="Documento"
                                    data-error="CPF: 11 dígitos - CNPJ: 14 dígitos. Apenas números."
                                    required/>
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                          </div>
                        </div>
                        <div class="col-md-2 text-center">
                          <label for=""> &nbsp;</label>
                          <div class="input-group">
                            <button class="btn btn-default" id="btnCliePesquisar" ng-click="oItemSelecionados=[]; item_valor_total_os = 0"><i class="glyphicon glyphicon-search"></i></button>
                          </div>
                        </div>

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-4">
                          <label for="">Atendente</label>
                          <div class="form-group">
                            <select class="form-control" ng-model="cbAtendente" name="cbAtendente" id="cbAtendente">
                            </select>
                          </div>
                        </div>
                   </div>


                   <div class="table-responsive col-md-12 ClientePanel">
                     <p></p>
                     <table class="tablel">
                       <tr>
                         <td colspan="3">
                            <small>Cliente</small><br/>
                            <span id="lblID_CLIENTE" class="panel-title">00000</span><span class="panel-title">&nbsp;-&nbsp;</span><span id="lblNOME" class="panel-title"></span>
                         </td>
                         <td colspan="100%" style="width:40%"><small>Contato</small><br/><h6 id="lblCONTATO"></h6></td>
                       </tr>

                       <tr>
                         <td>
                           <small>Solicitante</small><br/>&nbsp;
                           <span id="lblCOMPRADOR" class="panel-title"></span>
                         </td>
                         <td style="width:25%">
                           <small>CNPJ/CPF</small><br/>&nbsp;
                           <span id="lblCPF_CNPJ" class="panel-title"></span>
                         </td>
                         <td style="width:20%">
                           <small>RG/IE</small><br/>&nbsp;
                           <span id="lblRG_IE" class="panel-title"></span>
                         </td>
                         <td style="width:20%">
                           <small>Insc.Municipal</small><br/>&nbsp;
                           <span id="lblINSC_MUNIC" class="panel-title"></span>
                         </td>
                       </tr>
                     </table>
                     <table class="table">
                       <tr>
                         <td style="width:15%">
                           <small>CEP</small><br/>
                           <span id="lblEND_CEP" class="panel-title"></span>
                         </td>
                         <td style="width:15%">
                           <small>Tipo</small><br/>
                           <span id="lblEND_TIPO" class="panel-title"></span>
                         </td>
                         <td style="width:60%">
                           <small>Logradouro</small><br/>
                           <span id="lblEND_LOGRAD" class="panel-title"></span>
                         </td>
                         <td>
                           <small>Número</small><br/>
                           <span id="lblEND_NUMERO" class="panel-title"></span>
                         </td>
                       </tr>
                     </table>
                     <table class="table">
                       <tr>
                         <td style="width:50%">
                           <small>Complemento</small><br/>
                           <span id="lblEND_COMPLE" class="panel-title"></span>
                         </td>
                         <td style="width:20%">
                           <small>Bairro</small><br/>
                           <span id="lblEND_BAIRRO" class="panel-title"></span>
                         </td>
                         <td style="width:20%">
                           <small>Cidade</small><br/>
                           <span id="lblCIDADE" class="panel-title"></span>
                         </td>
                         <td>
                           <small>UF</small><br/>
                           <span id="lblUF" class="panel-title"></span>
                         </td>
                       </tr>
                     </table>
                     <table class="table">
                       <tr>
                         <td style="width:20%">
                           <small>Fone Comercial</small><br/>
                           <span id="lblDDD_COMER" class="panel-title"></span><span class="panel-title">&nbsp;-&nbsp;</span><span id="lblFONE_COMER" class="panel-title"></span>
                         </td>
                         <td style="width:20%">
                           <small>Fone Celular</small><br/>
                           <span id="lblDDD_CELUL" class="panel-title"></span><span class="panel-title">&nbsp;-&nbsp;</span><span id="lblFONE_CELUL" class="panel-title"></span>
                         </td>
                         <td style="width:20%">
                           <small>Fone Residencial</small><br/>
                           <span id="lblDDD_RESID" class="panel-title"></span><span class="panel-title">&nbsp;-&nbsp;</span><span id="lblFONE_RESID" class="panel-title"></span>
                         </td>
                         <td>
                           <small>E-Mail</small><br/>
                           <span id="lblEMAIL_CONT" class="panel-title"></span>
                         </td>
                       </tr>
                     </table>
                   </div>

                </div>
             </div>


            <!-- Ordem de serviço -->

             <div class="tab-pane" id="tab-second">
               <div class="col-md-12">
                   <br />
                   <h3><span class="fa fa-arrow-circle-o-left"></span> Ordem de Serviço</h3>
                   <hr />

                   <fieldset>
                     <div class="form-group col-md-3">
                         <label class="control-label">Produto - Descrição</label>
                         <div class="col-md-12">
                           <select class="form-control" id="cbObjeto" name="cbObjeto"></select>
                         </div>
                     </div>
                     <div class="form-group col-md-3">
                         <label class="control-label">Modelo</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" maxlength="40" placeholder="MODELO" id="MODELO" name="MODELO"/>
                         </div>
                     </div>
                     <div class="form-group col-md-3">
                         <label class="control-label">Serial</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" maxlength="40" placeholder="SERIAL" id="SERIAL" name="SERIAL"/>
                         </div>
                     </div>
                     <div class="form-group col-md-3">
                         <label class="control-label">Acessórios</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" maxlength="40" placeholder="ACESSORIOS" id="ACESSORIOS" name="ACESSORIOS"/>
                         </div>
                     </div>
                   </fieldset>

                   <fieldset>
                     <div class="form-group col-md-6">
                         <label class="control-label">Defeito informado</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" maxlength="90" placeholder="DEFEITO" id="DEFEITO" name="DEFEITO"/>
                         </div>
                     </div>
                     <div class="form-group col-md-4">
                         <label class="control-label">Adicional</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" maxlength="40" placeholder="ADICIONAL" id="ADICIONAL" name="ADICIONAL"/>
                         </div>
                     </div>
                     <div class="form-group col-md-2">
                         <label class="control-label">Prisma</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" maxlength="4" placeholder="PRISMA" id="PRISMA" name="PRISMA"/>
                         </div>
                     </div>
                   </fieldset>

                   <fieldset>
                     <div class="form-group col-md-4">
                         <label class="control-label">Técnico responsável:</label>
                         <div class="col-md-12">
                           <select class="form-control" id="cbTecnico" name="cbTecnico"></select>
                         </div>
                     </div>
                     <div class="form-group col-md-4">
                         <label class="control-label">Tipo atendimento</label>
                         <div class="col-md-12">
                             <select class="form-control" id="cbTipoAtendimento" name="cbTipoAtendimento"></select>
                         </div>
                     </div>
                     <div class="form-group col-md-4">
                         <label class="control-label">Localização</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control readonly" placeholder="LOCALIZACAO" id="LOCALIZACAO" name="LOCALIZACAO"/>
                         </div>
                     </div>
                   </fieldset>

                   <br/>
                   <!-- <div class="col-md-12"> -->
                       <h3><span id="itens_limpa" class="fa fa-arrow-circle-o-left"></span> Peças e Serviços</h3>
                       <span class="pull-right">
                         <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modal_itens_os" class="btn btn-primary ">Adicionar Itens <span class="fa fa-plus"></span></a>
                       </span>
                       <!-- <h3><span id="itens_limpa" ng-click="oItemSelecionados = []; item_valor_total_os = 0" class="fa fa-arrow-circle-o-left"></span> Peças e Serviços</h3> -->
                       <hr />
                       <div class="table-responsive push-up-12 col-md-12">
                           <table class="table table-bordered table-striped table-actions">
                               <thead>
                                   <tr>
                                       <th width="30">Ident.</th>
                                       <th>Descrição</th>
                                       <th width="30">Qtd.</th>
                                       <th width="80">Vlr Unit.</th>
                                       <th width="50">Desc.</th>
                                       <th width="90">Vlr Total</th>
                                       <th width="140">Técnico</th>
                                       <th width="50">&nbsp;</th>
                                   </tr>
                               </thead>
                               <tbody class="">
                                     <tr ng-repeat="row in oItemSelecionados track by $index" ng-init="$parent.item_valor_total_os = $parent.item_valor_total_os + row.ITEM_VALOR_TOTAL">
                                     <td class="text-right" ng-bind="row.ID_IDENTIFICADOR"></td>
                                     <td ng-bind="row.PROD_SERV"></td>
                                     <td class="text-right">{{row.ITEM_QTD | number:0}}</td>
                                     <td class="text-right">{{row.PRC_VENDA | number:2}}</td>
                                     <td class="text-right">{{row.ITEM_VALOR_DESC | number:2}}</td>
                                     <td class="text-right">{{row.ITEM_VALOR_TOTAL | number:2}}</td>
                                     <td ng-bind="row.ITEM_TECNICO_NOME"></td>
                                     <td class="text-right">
                                       <button class="btn btn-default btn-rounded btn-sm hide"><span class="fa fa-pencil"></span></button>
                                       <button class="btn btn-danger btn-rounded btn-sm" ng-click="itemDel($index);"><span class="fa fa-times"></span></button>
                                     </td>
                                   </tr>
                                   <tr>
                                     <td colspan="100%" class="text-right">Total: R$ {{item_valor_total_os | number: 2}}</td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>

                   <!-- </div> -->

                   <br>
                   <br>
                   <br>
                   <hr/>
                   <h4><span class="fa fa-arrow-circle-o-left"></span> Informações adicionais</h4>
                   <hr/>

                   <fieldset>
                     <div class="form-group col-md-3">
                         <label class="control-label">Previsão Entrega</label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" value="" id="DT_ENTREGA" name="DT_ENTREGA" />
                         </div>
                     </div>
                     <div class="form-group col-md-3">
                         <label class="control-label">Garantia</label>
                         <div class="col-md-12">
                             <input type="text" placeholder="" id="DT_GARANTIA" name="DT_GARANTIA" class="form-control" value="" data-date-format="dd-mm-yyyy"/>
                         </div>
                     </div>
                     <div class="form-group col-md-4">
                         <label class="control-label">Situação</label>
                         <div class="col-md-12">
                           <select class="form-control" id="cbSituacao" name="cbSituacao"></select>
                         </div>
                     </div>
                   </fieldset>

                   <hr />

                   <fieldset>
                     <div class="form-group col-md-12">
                       <label class="control-label">OBS <small>(SERÁ IMPRESSA NA O.S. DO CLIENTE)</small></label>
                       <div class="col-md-12">
                           <textarea class="form-control" placeholder="OBSERVAÇÃO" rows="2" id="OS_OBSERVACAO" name="OS_OBSERVACAO">Cliente relata que: </textarea>
                       </div>
                     </div>

                     <div class="form-group col-md-6 hide">
                         <label class="control-label">Alerta <small>(MENSAGEM INTERNA)</small></label>
                         <div class="col-md-12">
                             <input type="text" class="form-control" placeholder="Informações internas" id="OS_MENSAGEM" name="OS_MENSAGEM"/>
                             <label class="hide">
                               <div class="check">
                                 <input type="checkbox" class="icheckbox" id="OS_STATUS" name="OS_STATUS" value="A" checked/> Ativo
                               </div>
                             </label>
                         </div>

                     </div>
                   </fieldset>

               </div>
             </div>

           </div>
           <div class="panel-footer">
             <button class="btn btn-primary pull-right" id="btOSGrava">Incluir OS <span class="fa fa-floppy-o fa-right"></span></button>
           </div>
         </div>

       </form>

     </div>
   </div>

 </div>

 <!-- <a class="various" data-fancybox data-type="iframe" id="frame_os_print" href="#"></a> -->


 <?php
  include_once("./comum/cliente_modal.inc.php");
 ?>
 <!-- END PAGE CONTENT WRAPPER -->

<!--</div>-->
<!-- END PAGE CONTENT -->
<!--</div>-->
<!-- END PAGE CONTAINER -->
