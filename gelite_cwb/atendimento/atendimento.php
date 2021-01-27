
<!-- <div class="main-content-inner" style="padding-bottom:70px;"> -->
<div class="" style="padding-bottom:70px;">

    <!-- <div class="hr dotted"></div> -->

		<div class="row">
    </div>

    <div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-3 hide">
					<div class="search-area well well-sm">
						<div class="search-filter-header bg-primary">
							<h5 class="smaller no-margin-bottom">
								<i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Localize a OS
							</h5>
						</div>

						<div class="space-10"></div>

						<form>
							<div class="row">
								<div class="col-xs-12 col-sm-11 col-md-10">
									<div class="input-group">
										<input type="text" class="form-control" name="keywords" placeholder="Look within results" />
										<div class="input-group-btn">
											<button type="button" class="btn btn-default no-border btn-sm">
												<i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</form>

						<div class="hr hr-dotted"></div>

						<h4 class="blue smaller">
							<i class="fa fa-tags"></i>
							Localidade
						</h4>

						<div class="tree-container">
							<ul id="cat-tree"></ul>
						</div>

						<div class="hr hr-dotted"></div>


						<div class="hr hr-dotted hr-24"></div>

						<div class="text-center">
							<button type="button" class="btn btn-default btn-round btn-sm btn-white">
								<i class="ace-icon fa fa-remove red2"></i>
								Reset
							</button>

							<button type="button" class="btn btn-default btn-round btn-white">
								<i class="ace-icon fa fa-refresh green"></i>
								Update
							</button>
						</div>

						<div class="space-4"></div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12">
					<div class="row">
						<div class="search-area well col-sm-6 col-xs-12">
							<div class="pull-left">

								<div id="toggle-result-format" class="btn-group btn-overlap" data-toggle="buttons">
                                    
                                    <input type="text" class="form-control input-sm" name="keywords" placeholder="Procurar por..." />
                                    
									<p>
                                        <a href="#os-modal" data-toggle="modal" class="btn btn-xs btn-success">
                                            OS
                                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                        </a>

                                        <button class="btn btn-xs btn-danger">
                                            Recibo
                                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                        </button>

                                        <button class="btn btn-xs btn-danger">
                                            Retirada
                                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                        </button>

                                        <button class="btn btn-xs btn-danger">
                                            CPF/CNPJ
                                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                        </button>

                                        <a href="#cliente-modal" data-toggle="modal" class="btn btn-xs btn-warning">
                                            Nome
                                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                        </button>

                                        &nbsp;
                                        <a href="#os-modal" data-toggle="modal" class="btn btn-sm btn-white pull-right">
                                        	<i class="ace-icon fa fa-bolt"></i>
	                                        Novo
	                                    </a>

                                    </p>

								</div>
							</div>
						</div>
					</div>

                    <div class="pull-right">
                        <b class="text-primary">Filtrar</b>
                        &nbsp;
                        <select>
                            <option>Abertas</option>
                            <option>Fechadas</option>
                            <option>Todas</option>
                        </select>
                    </div>

                    <hr>

					<div class="row" id="os_card" style="display: none;">
						<div class="col-xs-6 col-sm-4 col-md-3">
							<div class="thumbnail search-thumbnail">
								<span class="search-promotion label label-success arrowed-in arrowed-in-right">Sponsored</span>

								<img class="media-object" data-src="holder.js/100px200?theme=gray" />
								<div class="caption">
									<div class="clearfix">
										<span class="pull-right label label-grey info-label">London</span>

										<div class="pull-left bigger-110">
											<i class="ace-icon fa fa-star orange2"></i>

											<i class="ace-icon fa fa-star orange2"></i>

											<i class="ace-icon fa fa-star orange2"></i>

											<i class="ace-icon fa fa-star-half-o orange2"></i>

											<i class="ace-icon fa fa-star light-grey"></i>
										</div>
									</div>

									<h3 class="search-title">
										<a href="#" class="blue">Thumbnail label</a>
									</h3>
									<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
								</div>
							</div>
						</div>

						<div class="col-xs-6 col-sm-4 col-md-3">
							<div class="thumbnail search-thumbnail">
								<img class="media-object" data-src="holder.js/100px200?theme=gray" />
								<div class="caption">
									<div class="clearfix">
										<span class="pull-right label label-grey info-label">Tokyo</span>
									</div>

									<h3 class="search-title">
										<a href="#" class="blue">Thumbnail label</a>
									</h3>
									<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
								</div>
							</div>
						</div>

						<div class="col-xs-6 col-sm-4 col-md-3">
							<div class="thumbnail search-thumbnail">
								<img class="media-object" data-src="holder.js/100px200?theme=gray" />
								<div class="caption">
									<div class="clearfix">
										<span class="pull-right label label-grey info-label">Istanbul</span>
									</div>

									<h3 class="search-title">
										<a href="#" class="blue">Thumbnail label</a>
									</h3>
									<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
								</div>
							</div>
						</div>

						<div class="col-xs-6 col-sm-4 col-md-3">
							<div class="thumbnail search-thumbnail">
								<img class="media-object" data-src="holder.js/100px200?theme=social" />
								<div class="caption">
									<div class="clearfix">
										<span class="pull-right label label-grey info-label">Chicago</span>
									</div>

									<h3 class="search-title">
										<a href="#" class="blue">Thumbnail label</a>
									</h3>
									<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
								</div>
							</div>
						</div>
					</div>

					<div class="space-12"></div>

					<div class="row" id="os_lista" class="">
						<div class="col-xs-12">
							<div class="media search-media">
								<div class="media-left">
									<a href="#">
										<img class="media-object" style="width:72px;" src="./assets/images/produtos/iphone5.jpeg" />
									</a>
								</div>

								<div class="media-body">
									<div>
										<h4 class="media-heading">
											<a href="#" class="blue">[56506] Reinaldo de Mello [ Loja 7 - Curitiba ]</a>
										</h4>
									</div>
									<p>Descrição contida no campo observação da ordem de serviço. Cras sit amet nibh libero, in gravida nulla. </p>

									<div class="search-actions text-center">

										<span class="text-info">R$</span>

										<span class="blue bolder bigger-150">300,00</span>&nbsp;

										<div class="action-buttons bigger-125">
											<a href="#">
												<i class="ace-icon fa fa-print green"></i>
											</a>

											<a href="#">
												<i class="ace-icon fa fa-book red"></i>
											</a>

											<a href="#">
												<i class="ace-icon fa fa-pencil-square-o green"></i>
											</a>
										</div>
										<a class="search-btn-action btn btn-sm btn-block btn-success">Aberta</a>
									</div>
								</div>

								<div class="media-right">
									<span class="text-info">Status</span>
									<span class="blue bolder bigger-100">Editando(1)</span>&nbsp;
								</div>								

								<div class="media-right">
									<span class="text-info">Dt Entrada</span>
									<span class="blue bolder bigger-100">99/99/9999</span>&nbsp;
									<br />
									<span class="text-info">Dt Saída</span>
									<span class="blue bolder bigger-100">99/99/9999</span>
								</div>								
							</div>

                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" style="width:72px;" src="./assets/images/produtos/iphone7.jpeg" />
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div>
                                        <h4 class="media-heading">
                                            <a href="#" class="blue">[9999999] Nome do cliente</a>
                                        </h4>
                                    </div>
                                    <p>Descrição contida no campo observação da ordem de serviço. Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis ...</p>

                                    <div class="search-actions text-center">
                                        <span class="text-info">R$</span>

                                        <span class="blue bolder bigger-150">470,00</span>&nbsp;

                                        <div class="action-buttons bigger-125">
                                            <a href="#">
                                                <i class="ace-icon fa fa-pencil-square-o green"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-book red"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-laptop orange2"></i>
                                            </a>
                                        </div>
                                        <a class="search-btn-action btn btn-sm btn-block btn-grey disabled">Fechada</a>
                                    </div>
                                </div>
                            </div>


                            <div class="media search-media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" style="width:72px;" src="./assets/images/produtos/mackbookprosemtouch.jpeg" />
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div>
                                        <h4 class="media-heading">
                                            <a href="#" class="blue">[9999999] Nome do cliente</a>
                                        </h4>
                                    </div>
                                    <p>Descrição contida no campo observação da ordem de serviço. Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis ...</p>

                                    <div class="search-actions text-center">
                                        <span class="text-info">R$</span>

                                        <span class="blue bolder bigger-150">210,00</span>&nbsp;

                                        <div class="action-buttons bigger-125">
                                            <a href="#">
                                                <i class="ace-icon fa fa-pencil-square-o green"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-book red"></i>
                                            </a>

                                            <a href="#">
                                                <i class="ace-icon fa fa-laptop orange2"></i>
                                            </a>
                                        </div>
                                        <a class="search-btn-action btn btn-sm btn-block btn-info">Aberta</a>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>




<div id="modal-wizard" class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="modal-wizard-container">
				<div class="modal-header">
					<ul class="steps">
						<li data-step="1" class="active">
							<span class="step">1</span>
							<span class="title">Validation states</span>
						</li>

						<li data-step="2">
							<span class="step">2</span>
							<span class="title">Alerts</span>
						</li>

						<li data-step="3">
							<span class="step">3</span>
							<span class="title">Payment Info</span>
						</li>

						<li data-step="4">
							<span class="step">4</span>
							<span class="title">Other Info</span>
						</li>
					</ul>
				</div>

				<div class="modal-body step-content">
					<div class="step-pane active" data-step="1">
						<div class="center">
							<h4 class="blue">Step 1</h4>
						</div>
					</div>

					<div class="step-pane" data-step="2">
						<div class="center">
							<h4 class="blue">Step 2</h4>
						</div>
					</div>

					<div class="step-pane" data-step="3">
						<div class="center">
							<h4 class="blue">Step 3</h4>
						</div>
					</div>

					<div class="step-pane" data-step="4">
						<div class="center">
							<h4 class="blue">Step 4</h4>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer wizard-actions">
				<button class="btn btn-sm btn-prev">
					<i class="ace-icon fa fa-arrow-left"></i>
					Prev
				</button>

				<button class="btn btn-success btn-sm btn-next" data-last="Finish">
					Next
					<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
				</button>

				<button class="btn btn-danger btn-sm pull-left" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Cancel
				</button>
			</div>
		</div>
	</div>
</div><!-- PAGE CONTENT ENDS -->







<div id="cliente-modal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="smaller lighter blue no-margin">Cadastro de Clientes</h3>
			</div>

			<div class="modal-body">

    <div class="card">
      <div class="card-content">
        <form>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group label-floating">
                <label class="control-label">CPF</label>
                <input type="text" class="form-control cpf input-sm" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group label-floating">
                <label class="control-label">RG</label>
                <input type="text" class="form-control rg input-sm" >




              </div>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group label-floating">
                <label class="control-label">Nome Completo</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group label-floating">
                <label class="control-label">Contato</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>


          </div>




          <div class="row">
            <div class="col-md-2">
              <div class="form-group label-floating">
                <label class="control-label">CEP</label>
                <input type="text" class="form-control cep input-sm" >
              </div>
            </div>



            <div class="col-md-2">
              <div class="form-group label-floating">
                <div>
                  <label class="control-label">Tipo</label>
                  <select class="form-control input-sm">
                    <option value=""></option>
                    <option value="AL">Rua</option>
                    <option value="AL">Avenida</option>
                  </select>
                </div>
              </div>
            </div>




            <div class="col-md-7">
              <div class="form-group label-floating">
                <label class="control-label">Logradouro</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group label-floating">
                <label class="control-label">Número</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <div class="form-group label-floating">
                <label class="control-label">Complemento</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group label-floating">
                <label class="control-label">Bairro</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>

            <div class="col-md-5">
              <div class="form-group label-floating">
                <div>
                  <label class="control-label">Cidade</label>
                  <select class="form-control input-sm">
                    <option value=""></option>
                    <option value="AL">Curitiba</option>
                    <option value="AL">São José dos Pinhais</option>
                  </select>
                </div>
              </div>
            </div>




            <div class="col-md-1">
              <div class="form-group label-floating">
                <div>
                  <label class="control-label">UF</label>
                  <select class="form-control input-sm">
                    <option value=""></option>
                    <option value="AL">PR</option>
                    <option value="AL">SC</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            

            <div class="col-md-4">
              <div class="form-group label-floating">
                <label class="control-label">Telefo Fixo</label>
                <input type="text" class="form-control telefone input-sm" >
              </div>
            </div>




            <div class="col-md-4">
              <div class="form-group label-floating">
                <label class="control-label">Telefone Comercial</label>
                <input type="text" class="form-control telefone input-sm" >
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group label-floating">
                <label class="control-label">Telefone Celular</label>
                <input type="text" class="form-control telefone input-sm" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group label-floating">
                <label class="control-label">E-mail 1</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group label-floating">
                <label class="control-label">E-mail 2</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>                 
          </div>
      
          <div class="clearfix"></div>
        </form>
      </div>
    </div>

			</div>

			<div class="modal-footer">
		        <button type="submit" class="btn btn-primary pull-right">Gravar</button>

				<button class="btn btn-sm btn-danger pull-right hide" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Close
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>








<div id="os-modal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="smaller lighter blue no-margin">Cadastro da Ordem de Serviço</h3>
			</div>

			<div class="modal-body">

        <form>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group label-floating">
                <div>
                  <label class="control-label">Tipo</label>
                  <select class="form-control input-sm">
                    <option value=""></option>
                    <option value="AL">Apple Acessórios</option>
                    <option value="AL">Apple iPhone 6S</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group label-floating">
                <label class="control-label">Modelo</label>
                <input type="text" class="form-control input-sm"  >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group label-floating">
                <label class="control-label">Serial</label>
                <input type="email" class="form-control input-sm" >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group label-floating">
                <label class="control-label">Acessório</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group label-floating">
                <label class="control-label">Prisma</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group label-floating">
                <label class="control-label">Defeito Reclamado</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group label-floating">
                <div>
                  <label class="control-label">Téc.Resp.</label>
                  <select class="form-control input-sm">
                    <option value=""></option>
                    <option value="AL">Thiago Soares</option>
                    <option value="AL">Pedro Ciquel</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group label-floating">
                <label class="control-label">Peças e Serviços</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group label-floating">
                <label class="control-label">Situação</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group label-floating">
                <label class="control-label">Observações</label>
                <input type="text" class="form-control input-sm" >
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </form>

			</div>

			<div class="modal-footer">
		        <button type="submit" class="btn btn-primary pull-right">Gravar</button>

				<button class="btn btn-sm btn-danger pull-right hide" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Close
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>




