<?php
  session_start();
?>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->
    <div class="row">
        <div class="col-md-6 col-md-6">

            <!-- START TIMELINE FILTER -->
            <div class="panel panel-default">
                <div class="panel-body">
                  <h3>Procurar por...</h3>
                    <form class="form-horizontal" role="form">
                        <div class="row">
                          <div class="form-group">
                            <div class="col-md-4 col-md-4">
                              <select class="form-control select" name="varSysLocalidade">
                                <?php
                                    foreach ($_SESSION[sys][FBConn] as $key => $value) {
                                      $sSelected = ( $_SESSION[sys][login][localidade][cidade] == $_SESSION[sys][FBConn][$key][cidade] ? "selected=''" : '' );
                                      echo "<option value='$key' $sSelected>".$_SESSION[sys][FBConn][$key][cidade]."</option>";
                                    }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-8 col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                    <input type="text" class="form-control" placeholder="Procurar por..."/>
                                </div>
                            </div>
                          </div>
                        </div>

                        <hr />

                        <div class="row">
                          <div class="form-group">
                              <div class="col-md-8 col-md-8">
                                  <div class="clie_busca btn-group btn-group-justified">
                                      <a href="#" class="btn btn-primary btn-rounded" ng-click="clie_busca('OS');">OS</a>
                                      <a href="#" class="btn btn-info btn-rounded" ng-click="clie_busca('RECIBO');">Recibo</a>
                                      <a href="#" class="btn btn-primary btn-rounded" ng-click="clie_busca('RETIRADA');">Retirada</a>
                                      <a href="#" class="btn btn-info btn-rounded" ng-click="clie_busca('DOC');">Doc</a>
                                      <a href="#" class="btn btn-primary btn-rounded" ng-click="clie_busca('NOME');">Nome</a>
                                  </div>
                              </div>
                              <div class="col-md-4 col-md-4">
                                  <div class="pull-right">
                                      <button class="btn btn-success btn-rounded"  data-toggle="modal" data-target="#modal_os1"><span class="fa fa-refresh"></span> NOVO</button>
                                  </div>
                              </div>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END TIMELINE FILTER -->
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">

            <!-- START MODAL SIZES -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Resultado: 15 O.S.  Ordem: Mais atual em primeiro</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                      <p>Reinaldo dos Santos Guth <code>[Loja Curitiba]</code></p>
                    </div>
                    <div class="col-md">
                      <!-- CONTACT ITEM -->
                         <div class="panel panel-default">
                               <div class="panel-body">
                                   <div class="contact-info">
                                       <p><small>Mobile</small><br/>(555) 555-55-55</p>
                                       <p><small>Email</small><br/>nadiaali@domain.com</p>
                                       <p><small>Address</small><br/>123 45 Street San Francisco, CA, USA</p>
                                   </div>
                               </div>
                         </div>
                     <!-- END CONTACT ITEM -->
                   </div>
                </div>

            </div>
        </div>
        <!-- END MODAL SIZES -->

    </div>



</div>


<div class="modal fade" id="modal_cliente1" data-backdrop="static" z-index="-999" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancelar</span></button>
                <h3><span class="fa fa-arrow-circle-o-left"></span> Cadastro de Cliente -  #<span id="clienteID">00000</span>
                    <span class="pull-right" id="clienteDataCad" name="clienteDataCad">00/00/0000</span>
                </h3>
            </div>
            <div class="modal-body">

              <div class="row">

                <!-- START DEFAULT FORM ELEMENTS -->
                <div class="block">
                    <form name="frmCliente" id="frmCliente" data-toggle="validator"
                          class="form-horizontal" role="form">

                      <input type="hidden" id="ID_CLIENTE" name="ID_CLIENTE">
                      <input type="hidden" id="DT_CADASTRO" name="DT_CADASTRO">
                      <input type="hidden" id="modo" name="modo">
                      <input type="hidden" id="ID_FUNCIONARIO" name="ID_FUNCIONARIO" value="<?php echo $_SESSION[sys][login][id];?>">

                      <fieldset>
                          <div class="form-group has-feedback col-md-4">
                              <label for="cpfcnpj" class="control-label">CPF / CNPJ</label>
                              <div class="col-md-12">
                                  <input type="text"
                                        class="form-control"
                                        pattern="^[0-9]{1,}$"
                                        name="CPF_CNPJ" id="CPF_CNPJ"
                                        minlength="11" maxlength="14" style="width:100%;"
                                        placeholder="Documento"
                                        data-error="CPF: 11 dígitos - CNPJ: 14 dígitos. Apenas números."
                                        required/>
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  <div class="help-block with-errors"></div>
                              </div>
                          </div>

                          <div class="form-group col-md-4">
                              <label for="clie_rg" class="">RG / PASSAPORT / IE</label>
                              <div class="col-md-12">
                                  <input type="text" class="form-control" placeholder="R.G." id="RG_IE" name="RG_IE"/>
                              </div>
                          </div>

                          <div class="form-group col-md-4">
                            <label for="clie_rg" class="">Data Nascimento</label>
                            <div class="col-md-12">
                              <input type="text" class="form-control" placeholder="Data nascimento" name="DT_NASCTO" id="DT_NASCTO"/>
                            </div>
                          </div>

                      </fieldset>

                      <fieldset>
                        <div class="form-group has-feedback col-md-6">
                            <label class="control-label">Nome</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Nome" value=""
                                data-error="Informe o nome do cliente" id="NOME" name="NOME"
                                required/>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Contato</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Contato" id="CONTATO" name="CONTATO"/>
                            </div>
                        </div>
                      </fieldset>

                      <fieldset>
                        <div class="form-group col-md-6">
                            <label class="control-label">País</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Brasil" id="NOME_PAIS" name="NOME_PAIS"/>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">CEP</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="CEP"
                                       pattern="^[0-9]{1,}$"
                                       ng-model="formData.clie_cep" id="END_CEP" name="END_CEP"
                                       minlength="8" maxlength="8"
                                       data-error="Apenas números."
                                       required />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label">Tipo</label>
                            <div class="col-md-12">
                              <select class="form-control select" id="END_TIPO" name="END_TIPO">
                                  <option value="TV">TV</option>
                                  <option value="R">R</option>
                                  <option value="AV">AV</option>
                                  <option value="PÇ">PÇ</option>
                              </select>
                            </div>
                        </div>
                      </fieldset>

                      <fieldset>
                        <div class="form-group col-md-9">
                          <label class="control-label">Logradouro</label>
                          <div class="col-md-12 no-padding">
                              <input type="text" class="form-control" placeholder="Logradouro" id="END_LOGRAD" name="END_LOGRAD"/>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">Número</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Número" id="END_NUMERO" name="END_NUMERO"/>
                            </div>
                        </div>
                      </fieldset>

                      <fieldset>
                        <div class="form-group col-md-6">
                            <label class="control-label">Complemento</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Complemento" id="END_COMPLE" name="END_COMPLE"/>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Bairro</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Bairro" id="END_BAIRRO" name="END_BAIRRO"/>
                            </div>
                        </div>
                      </fieldset>

                      <fieldset>
                        <div class="form-group col-md-9">
                            <label class="control-label">Município</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Município" id="ID_CIDADE" name="ID_CIDADE"/>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">UF</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="UF" id="UF" name="UF"/>
                            </div>
                        </div>
                      </fieldset>

                      <fieldset>
                        <div class="form-group col-md-4">
                          <div class="form-group col-md-5">
                            <label class="control-label col-md-12 text-left">DDD</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="DDD" id="DDD_RESID" name="DDD_RESID"/>
                            </div>
                          </div>
                          <div class="form-group col-md-7">
                            <label class="control-label">Fone Residencial</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Nr Telefone" id="FONE_RESID" name="FONE_RESID"/>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-4">
                          <div class="form-group col-md-5">
                            <label class="control-label col-md-12 text-left">DDD</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="DDD" id="DDD_COMER" name="DDD_COMER"/>
                            </div>
                          </div>
                          <div class="form-group col-md-7">
                            <label class="control-label">Fone Comercial</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Nr Telefone" id="FONE_COMER" name="FONE_COMER"/>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-4">
                          <div class="form-group col-md-5">
                            <label class="control-label col-md-12 text-left">DDD</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="DDD" id="DDD_CELUL" name="DDD_CELUL"/>
                            </div>
                          </div>
                          <div class="form-group col-md-7">
                            <label class="control-label">Fone Celular</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Nr Telefone" id="FONE_CELUL" name="FONE_CELUL"/>
                            </div>
                          </div>
                        </div>

                      </fieldset>

                      <fieldset>
                        <div class="form-group has-feedback col-md-6">
                          <label class="control-label">E-Mail #1</label>
                          <div class="col-md-12">
                              <input type="email" class="form-control"
                                     ng-model="EMAIL_CONT" name="EMAIL_CONT" id="EMAIL_CONT"
                                     placeholder="E-Mail principal"
                                     data-error="Informe o email principal"
                                     required/>
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                              <div class="help-block with-errors"></div>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label class="control-label">E-Mail #2</label>
                          <div class="col-md-12">
                              <input type="text" class="form-control" placeholder="E-Mail opcional" id="EMAIL_ADIC" name="EMAIL_ADIC"/>
                          </div>
                        </div>
                      </fieldset> <!-- emails -->

                      <fieldset>
                        <div class="form-group has-feedback col-md-6">
                          <label class="control-label">E-Mail&nbsp;NFe</label>
                          <div class="col-md-12">
                              <input type="text" class="form-control" placeholder="E-Mail Fiscal" id="EMAIL_NFE" name="EMAIL_NFE" value="{{EMAIL_CONT}}"/>
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label class="control-label">OBS</label>
                          <div class="col-md-12">
                              <textarea class="form-control" rows="2" id="OBSERVACAO" name="OBSERVACAO"></textarea>
                          </div>
                        </div>
                      </fieldset> <!-- emails -->


                      <fieldset>
                        <div class="form-group col-md-10">
                            <label class="control-label">Alerta</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Informações internas" id="MENSAGEM" name="MENSAGEM"/>
                            </div>
                        </div>
                        <div class="form-group col-md-2 text-right">
                          <br>
                          <label class="">
                            <div class="check">
                              <input type="checkbox" class="icheckbox" id="STATUS" name="STATUS" value="A" checked/> Ativo
                            </div>
                          </label>
                        </div>
                      </fieldset>

                    </form>
                </div>
                <!-- END DEFAULT FORM ELEMENTS -->

              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary pull-left"
                      data-dismiss="modal" data-toggle="modal" data-target="#modal_os1">Gravar e seguir</button>
              <button type="button" id="btnClieGrava" class="btn btn-info pull-left">Apenas Gravar</button>
              <button type="button" class="btn btn-danger btn-rounded pull-right" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>








<div class="modal fade" id="modal_os1" data-backdrop="static" z-index="-999" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal_cliente1"><i class="fa fa-arrow-left"></i></button>

                <button type="button" class="btn btn-danger btn-rounded pull-right" data-dismiss="modal">Cancelar</button>

                <h4 class="modal-title" id="modal_os1_ModalHead">&nbsp; Cadastro de Ordem de Serviço - #<span>00000</span></h4>

                <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancelar</span></button> -->
            </div>
            <div class="">
              <div class="panel panel-default tabs">
                <ul class="nav nav-tabs pull-right" role="tablist">
                    <li class="active"><a href="#tab-cliente" role="tab" data-toggle="tab">Cliente</a></li>
                    <li><a href="#tab-os" role="tab" data-toggle="tab">OS</a></li>
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="tab-cliente">

                <!-- START DEFAULT FORM ELEMENTS -->
                <div class="block">
                  <h3><span class="fa fa-arrow-circle-o-left"></span> Dados do Cliente</h3>

                  <form name="frmCliente" id="frmCliente" data-toggle="validator"
                        class="form-horizontal" role="form">

                    <input type="hidden" id="ID_CLIENTE" name="ID_CLIENTE">
                    <input type="hidden" id="DT_CADASTRO" name="DT_CADASTRO">
                    <input type="hidden" id="modo" name="modo">
                    <input type="hidden" id="ID_FUNCIONARIO" name="ID_FUNCIONARIO" value="<?php echo $_SESSION[sys][login][id];?>">

                    <div class="form-group">
                      <div class="col-md-7 col-xs-12">
                        <div class="col-md-6 col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon" data-dismiss="modal" data-toggle="modal" data-target="#modal_cliente1" id="btnClieNovo1"><span class="fa fa-bolt"></span></span>
                                <input type="text" id="cpClieDoc" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-1">
                          <button class="btn btn-default" id="btnCliePesquisar"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                      </div>

                      <div class="col-md-5 col-xs-12 text-right">
                        <div class="col-md-3 col-xs-3 text-right">
                          <label for="">Atendente</label>
                        </div>
                        <div class="col-md-9 col-xs-9 text-right">
                          <select class="combobox form-control" ng-model="cbAtendente">
                            <option></option>
                            <option value="PA">Pennsylvania</option>
                            <option value="CT">Connecticut</option>
                            <option value="NY">New York</option>
                            <option value="MD">Maryland</option>
                            <option value="VA">Virginia</option>
                          </select>
                        </div>
                        <!-- <span><?php echo $_SESSION[sys][login][usuario];?></span>
                        <button class="btn btn-default" id="btnAtendentePesquisar"><i class="glyphicon glyphicon-search"></i></button> -->
                      </div>

                    </div>


                  </form>

                  <div class="panel-body">

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <td colspan="2"><small>Cliente</small><br/><span id="lblID_CLIENTE">00000</span> - <span id="lblNOME"></span></td>
                          <td colspan="100%" style="width:40%"><small>Contato</small><br/><span id="lblCONTATO"></span></td>
                        </tr>

                        <tr>
                          <td style="width:40%">
                            <small>Solicitante</small><br/>
                            <span id="lblCOMPRADOR"></span>
                          </td>
                          <td style="width:20%">
                            <small>CNPJ/CPF</small><br/>
                            <span id="lblCPF_CNPJ"></span>
                          </td>
                          <td style="width:20%">
                            <small>RG/IE</small><br/>
                            <span id="lblRG_IE"></span>
                          </td>
                          <td>
                            <small>Insc.Municipal</small><br/>
                            <span id="lblINSC_MUNIC"></span>
                          </td>
                        </tr>
                      </table>
                      <table class="table">
                        <tr>
                          <td style="width:15%">
                            <small>CEP</small><br/>
                            <span id="lblEND_CEP"></span>
                          </td>
                          <td style="width:15%">
                            <small>Tipo</small><br/>
                            <span id="lblEND_TIPO"></span>
                          </td>
                          <td style="width:60%">
                            <small>Logradouro</small><br/>
                            <span id="lblEND_LOGRAD"></span>
                          </td>
                          <td>
                            <small>Número</small><br/>
                            <span id="lblEND_NUMERO"></span>
                          </td>
                        </tr>
                      </table>
                      <table class="table">
                        <tr>
                          <td style="width:50%">
                            <small>Complemento</small><br/>
                            <span id="lblEND_COMPLE"></span>
                          </td>
                          <td style="width:20%">
                            <small>Bairro</small><br/>
                            <span id="lblEND_BAIRRO"></span>
                          </td>
                          <td style="width:20%">
                            <small>Cidade</small><br/>
                            <span id="lblCIDADE"></span>
                          </td>
                          <td>
                            <small>UF</small><br/>
                            <span id="lblUF"></span>
                          </td>
                        </tr>
                      </table>
                      <table class="table">
                        <tr>
                          <td style="width:20%">
                            <small>Fone Comercial</small><br/>
                            <span id="lblDDD_COMER"></span> - <span id="lblFONE_COMER"></span>
                          </td>
                          <td style="width:20%">
                            <small>Fone Celular</small><br/>
                            <span id="lblDDD_CELUL"></span> - <span id="lblFONE_CELUL"></span>
                          </td>
                          <td style="width:20%">
                            <small>Fone Residencial</small><br/>
                            <span id="lblDDD_RESID"></span> - <span id="lblFONE_RESID"></span>
                          </td>
                          <td>
                            <small>E-Mail</small><br/>
                            <span id="lblEMAIL_CONT"></span>
                          </td>
                        </tr>
                      </table>
                    </div>

                  </div>

                </div>

              </div>
              <div class="tab-pane" id="tab-os">
                <div class="block">
                  <h3><span class="fa fa-arrow-circle-o-left"></span> Ordem de Serviço</h3>

                  <form name="frmOS1" id="frmOS1" data-toggle="validator"
                        class="form-horizontal" role="form">
                  </form>
                </div>
              </div>


            </div>
          </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnClieGravaContinua1" class="btn btn-primary pull-right"
                      data-dismiss="modal" data-toggle="modal" data-target="#modal_os2">Gravar e seguir</button>
              <button type="button" class="btn btn-info pull-right">Apenas Gravar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="modal_basic" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Basic Modal</h4>
            </div>
            <div class="modal-body">
                Some content in modal example
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
