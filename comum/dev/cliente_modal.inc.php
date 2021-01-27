<div class="modal fade" id="modal_cliente1" data-backdrop="static" z-index="-999" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancelar</span></button>
                <h3><span class="fa fa-arrow-circle-o-left"></span> Cadastro de Cliente -  #<span id="clienteID">00000</span>
                    <span class="pull-right col-md-2" id="clienteDataCad" name="clienteDataCad">00/00/0000</span>
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

                      <input type="hidden" id="DT_PRICOMP" name="DT_PRICOMP">
                      <input type="hidden" id="DT_ULTCOMP" name="DT_ULTCOMP">

                      <input type="hidden" id="LIMITE" name="LIMITE">
                      <input type="hidden" id="ID_TIPO" name="ID_TIPO">
                      <input type="hidden" id="ID_PAIS" name="ID_PAIS">

                      <!-- <input type="hidden" id="modo" name="modo"> -->
                      <input type="hidden" id="ID_FUNCIONARIO" name="ID_FUNCIONARIO" value="<?php echo $_SESSION[sys][login][id];?>">

                      <fieldset>
                          <div class="form-group has-feedback col-md-6">
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
                                  <!-- <div class="help-block with-errors"></div> -->
                              </div>
                          </div>

                          <div class="form-group col-md-3">
                              <label for="clie_rg" class="">RG / PASSAPORT / IE</label>
                              <div class="col-md-12">
                                  <input type="text" class="form-control" placeholder="R.G." id="RG_IE" name="RG_IE"/>
                              </div>
                          </div>

                          <div class="form-group col-md-3">
                            <label for="clie_rg" class="">Data Nascimento</label>
                            <div class="col-md-12">
                              <input type="text" placeholder="Data nascimento" name="DT_NASCTO" id="DT_NASCTO" class="form-control" value="" data-date-format="dd-mm-yyyy"/>
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
                                <!-- <div class="help-block with-errors"></div> -->
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
                                       minlength="9" maxlength="9"
                                       data-error="Apenas números."
                                       required />
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <!-- <div class="help-block with-errors"></div> -->
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">Tipo</label>
                            <div class="col-md-12">
                              <select class="form-control" id="END_TIPO" name="END_TIPO">
                                <option value="">** Selecione</option>
                                <option value = "Aeroporto">Aeroporto</option>
                                <option value = "Alameda">Alameda</option>
                                <option value = "&Aacute;rea">&Aacute;rea</option>
                                <option value = "Avenida">Avenida</option>
                                <option value = "Campo">Campo</option>
                                <option value = "Ch&aacute;cara">Ch&aacute;cara</option>
                                <option value = "Col&ocirc;nia">Col&ocirc;nia</option>
                                <option value = "Condom&iacute;nio">Condom&iacute;nio</option>
                                <option value = "Conjunto">Conjunto</option>
                                <option value = "Distrito">Distrito</option>
                                <option value = "Esplanada">Esplanada</option>
                                <option value = "Esta&ccedil;&atilde;o">Esta&ccedil;&atilde;o</option>
                                <option value = "Estrada">Estrada</option>
                                <option value = "Favela">Favela</option>
                                <option value = "Fazenda">Fazenda</option>
                                <option value = "Feira">Feira</option>
                                <option value = "Jardim">Jardim</option>
                                <option value = "Ladeira">Ladeira</option>
                                <option value = "Lago">Lago</option>
                                <option value = "Lagoa">Lagoa</option>
                                <option value = "Largo">Largo</option>
                                <option value = "Loteamento">Loteamento</option>
                                <option value = "Morro">Morro</option>
                                <option value = "N&uacute;cleo">N&uacute;cleo</option>
                                <option value = "Parque">Parque</option>
                                <option value = "Passarela">Passarela</option>
                                <option value = "P&aacute;tio">P&aacute;tio</option>
                                <option value = "Pra&ccedil;a">Pra&ccedil;a</option>
                                <option value = "Quadra">Quadra</option>
                                <option value = "Recanto">Recanto</option>
                                <option value = "Residencial">Residencial</option>
                                <option value = "Rodovia">Rodovia</option>
                                <option value = "Rua">Rua</option>
                                <option value = "Setor">Setor</option>
                                <option value = "S&iacute;tio">S&iacute;tio</option>
                                <option value = "Travessa">Travessa</option>
                                <option value = "Trecho">Trecho</option>
                                <option value = "Trevo">Trevo</option>
                                <option value = "Vale">Vale</option>
                                <option value = "Vereda">Vereda</option>
                                <option value = "Via">Via</option>
                                <option value = "Viaduto">Viaduto</option>
                                <option value = "Viela">Viela</option>
                                <option value = "Vila">Vila</option>
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
                              <input type="hidden" class="form-control" id="ID_CIDADE" name="ID_CIDADE"/>
                              <input type="text" class="form-control" placeholder="Município" id="CIDADE" name="CIDADE"/>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">UF</label>
                            <div class="col-md-12">
                              <select id=UF name=UF class="form-control">
                              <option value="">** Selecione</option>
                              <option value="AC">AC</option>
                              <option value="AL">AL</option>
                              <option value="AM">AM</option>
                              <option value="AP">AP</option>
                              <option value="BA">BA</option>
                              <option value="CE">CE</option>
                              <option value="DF">DF</option>
                              <option value="ES">ES</option>
                              <option value="GO">GO</option>
                              <option value="MA">MA</option>
                              <option value="MG">MG</option>
                              <option value="MS">MS</option>
                              <option value="MT">MT</option>
                              <option value="PA">PA</option>
                              <option value="PB">PB</option>
                              <option value="PE">PE</option>
                              <option value="PI">PI</option>
                              <option value="PR">PR</option>
                              <option value="RJ">RJ</option>
                              <option value="RN">RN</option>
                              <option value="RO">RO</option>
                              <option value="RR">RR</option>
                              <option value="RS">RS</option>
                              <option value="SC">SC</option>
                              <option value="SE">SE</option>
                              <option value="SP">SP</option>
                              <option value="TO">TO</option>
                              </select>
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
                              <!-- <div class="help-block with-errors"></div> -->
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
                              <textarea class="form-control" rows="2" id="MINHAOBSERVACAO" name="MINHAOBSERVACAO"></textarea>
                          </div>
                        </div>
                      </fieldset> <!-- emails -->


                      <fieldset>
                        <div class="form-group col-md-10">
                            <label class="control-label">Alerta</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Informações internas" id="MINHAMENSAGEM" name="MINHAMENSAGEM" value=""/>
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
              <button type="button" class="btn btn-primary pull-left" id="btnClieGrava" name="btnClieGrava">Gravar e fechar</button>
              <!-- <button type="button" id="btnClieGrava" class="btn btn-info pull-left" data-dismiss="modal" data-toggle="modal" data-target="#modal_os1">Apenas Gravar</button> -->
              <button type="button" class="btn btn-danger btn-rounded pull-right" data-dismiss="modal">Cancelar e fechar</button>
            </div>
        </div>
    </div>
</div>
