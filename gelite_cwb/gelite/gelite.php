
<!-- <div class="main-content-inner" style="padding-bottom:70px;"> -->
<div class="" style="padding-bottom:70px;">

		<div class="row"></div>

		<div id="pag1" class="row">
				<div class="col-sm-7">
					<div class="widget-box transparent">
						<div class="widget-header widget-header-flat">
							<h4 class="widget-title lighter">
								<i class="ace-icon fa fa-star orange"></i>
								Ligações Telefônicas
							</h4>

							<div class="widget-toolbar">
								<div class="widget-menu">
									<a href="#" data-action="settings" data-toggle="dropdown">
										Carregar arquivos: <i class="ace-icon fa fa-gears"></i>
									</a>

									<ul class="dropdown-menu dropdown-menu-right dropdown-light-blue dropdown-caret dropdown-closer">
										<li ng-repeat="row in glt_dash_combos.Localidades">
											<a data-toggle="modal" href="#bottom-msg" ng-bind="row.desc" ng-click="loadFile(row)"></a>
										</li>
									</ul>
								</div>&nbsp;&nbsp;&nbsp;&nbsp;

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>

						<div class="widget-body">
							<div class="widget-main ">

								<div class="row">

										<div class="col-xs-3 col-sm-3">
											<label for="idRamal">Localidade </label>
											<br />
											<select class="form-control" ng-options="row.desc for row in glt_dash_combos.Localidades" ng-model="idLocalidade" name="idLocalidade" id="idLocalidade">
													<option value="">-- Todas --</option>
											</select>
										</div>


										<div ng-show="!dashResumoModo" class="col-xs-4 col-sm-4 no-padding">
											<label for="idData">Mensal</label>
											<br />
											<select class="form-control" ng-options="row.data for row in glt_dash_combos.Datas"
															ng-model="idData" name="idData" id="idData">
													<option value="">-- Todas --</option>
											</select>
										</div>

										<div ng-show="dashResumoModo" class="col-xs-4 no-padding">
											<label for="idData">Período</label>
											<br />
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-calendar bigger-110"></i>
												</span>

												<input class="form-control" type="text" name="date-range-picker" id="id-date-range-picker-1" />
											</div>
										</div>

										<div class="col-xs-5 col-sm-5">
											<label for="idRamal">Ramal </label>
											<br />
											<select class="form-control" ng-options="row.id + ' / ' + row.desc for row in glt_dash_combos.Ramais" ng-model="idRamal" name="idRamal" id="idRamal">
													<option value="" selected>-- Todas --</option>
											</select>
										</div>

										<!-- <div class="col-xs-12 col-sm-3">
											<label for="idRamal">Localidade: </label>
											<br />
											<select class="form-control" ng-options="row.desc for row in glt_dash_combos.Localidades" ng-model="idLocalidade" name="idLocalidade" id="idLocalidade">
													<option value="">-- Todas --</option>
											</select>
										</div> -->

								</div>



								<div class="row">

										<div class="col-xs-12 col-sm-12">
											<div class="widget-header padding-4">
												<div class="widget-menu">
													<h4 class="widget-title lighter"></h4>
												</div>

												<div class="widget-toolbar no-border">
													<ul class="nav nav-tabs" id="myTab2">
														<li class="hide">
															<label>
																<input name="switch-field-1" class="ace ace-switch btn-rotate" type="checkbox" ng-model="dashResumoModo" checked="on"/>
																<span class="lbl" data-lbl="SIM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO">&nbsp;&nbsp;Período&nbsp;</span>
															</label>
														</li>

														<li class="active">
															<a data-toggle="tab" href="#Geral">Geral</a>
														</li>

														<li>
															<a data-toggle="tab" href="#LigacoesEntrada">Recebidas</a>
														</li>

														<li>
															<a data-toggle="tab" href="#feitas">Feitas</a>
														</li>

														<li>
															<a data-toggle="tab" href="#Tipo">por Tipo</a>
														</li>
													</ul>
												</div>
											</div>
										</div>


										<div class="col-xs-12 col-sm-12">

											<div class="widget-body">
												<div class="widget-main padding-12 no-padding-left no-padding-right">
													<div class="tab-content padding-4">
														<div id="Geral" class="tab-pane in active">
															<h5>Filtros: Localidade, período e tipo de ligação</h5>

																<div class="table-header">
											  						<h5 class="title">
																			Total: <label ng-bind="glt_dash_resumo1.code"></label> || <label ng-bind="(glt_dash_resumo1.data |
																										 filter:row.periodo=idData.data |
																										 filter:row.glt10_ramal=idRamal.id |
																										 filter:row.sigla=idLocalidade.sigla).length"></label> filtrados.</h5>
																</div>

																	<table class="table table-striped table-bordered table-hover">
																		<thead>
																			<tr>
																				<th class="centro">#</th>
																				<th class="centro">Local</th>
																				<th class="centro">Período</th>
																				<th class="centro">Ramal / Atendente</th>
																				<th class="centro">Tipo Chamada</th>
																				<th class="centro" ng-click="glt_dash_resumo1_ordem = 'qtd'">Qtd</th>
																				<th>&nbsp;</th>
																			</tr>
																		</thead>
																		<tbody>
																				<tr ng-repeat="row in glt_dash_resumo1.data |
																											 filter:row.periodo=idData.data |
																											 filter:row.glt10_ramal=idRamal.id |
																											 filter:row.sigla=idLocalidade.sigla">
																					<td style="text-align:right;" ng-bind="$index+1"></td>
																					<td class="centro" ng-bind="row.sigla"></td>
																					<td class="centro" ng-bind="row.periodo"></td>
																					<td ng-bind="row.glt10_ramal + ' / ' + row.glt10_atendente"></td>
																					<td ng-bind="row.glt05_desc"></td>
																					<td style="text-align:right;" ng-bind="row.qtd"></td>
																					<td><span class="label label-warning arrowed-right arrowed-in"><a href="#modal-table_aux" data-toggle="modal" ng-click="loadRamalDetalhes(row);">VER</a></span></td>
																				</tr>
																		</tbody>
																	</table>

														</div> 						<!-- tab -->

														<div id="LigacoesEntrada" class="tab-pane">
															<h5>Filtros: Localidade, período, ramal e <b>CHAMADAS RECEBIDAS</b></h5>

															<div class="table-header">
																	<h5 class="title">
																		Total: <label ng-bind="glt_dash_resumo3a.code"></label> || <label ng-bind="(glt_dash_resumo3a.data |
																									 filter:row.periodo=idData.data |
																									 filter:row.glt10_ramal=idRamal.id |
																									 filter:row.sigla=idLocalidade.sigla).length"></label> filtrados.</h5>
															</div>

																<table class="table table-striped table-bordered table-hover">
																	<thead>
																		<tr>
																			<th class="centro">#</th>
																			<th class="centro">Local</th>
																			<th class="centro">Período</th>
																			<th class="centro">Ramal / Atendente</th>
																			<th class="centro">Qtd</th>
																			<th>&nbsp;</th>
																		</tr>
																	</thead>
																			<tr ng-repeat="row in glt_dash_resumo3a.data |
																										filter:row.periodo=idData.data |
																                    filter:row.glt10_ramal=idRamal.id |
																                    filter:row.sigla=idLocalidade.sigla">
																				<td style="text-align:right;" ng-bind="$index+1"></td>
																				<td class="centro" ng-bind="row.sigla"></td>
																				<td class="centro" ng-bind="row.periodo"></td>
																				<td ng-bind="row.glt10_ramal + ' / ' + row.glt10_atendente"></td>
																				<td style="text-align:right;" ng-bind="row.qtd"></td>
																				<!-- <td><a href="#modal-table_aux" data-toggle="modal" ng-click="loadRamalDetalhes(row);">VER</a></td> -->
																				<td><span class="label label-warning arrowed-right arrowed-in"><a href="#modal-table_aux" data-toggle="modal" ng-click="loadRamalDetalhes(row);">VER</a></span></td>

																			</tr>
																	<tbody>
																	</tbody>
																</table>

														</div>

														<div id="feitas" class="tab-pane">
															<h5>Filtros: Localidade, período, ramal e <b>CHAMADAS FEITAS</b></h5>

															<div class="table-header">
																	<h5 class="title">
																		Total: <label ng-bind="glt_dash_resumo3b.code"></label> || <label ng-bind="(glt_dash_resumo3b.data |
																									 filter:row.periodo=idData.data |
																									 filter:row.glt10_ramal=idRamal.id |
																									 filter:row.sigla=idLocalidade.sigla).length"></label> filtrados.</h5>
															</div>

																<table class="table table-striped table-bordered table-hover">
																	<thead>
																		<tr>
																			<th class="centro">#</th>
																			<th class="centro">Local</th>
																			<th class="centro">Período</th>
																			<th class="centro">Ramal / Atendente</th>
																			<th class="centro">Qtd</th>
																			<th>&nbsp;</th>
																		</tr>
																	</thead>
																			<tr ng-repeat="row in glt_dash_resumo3b.data |
																										filter:row.periodo=idData.data |
																                    filter:row.glt10_ramal=idRamal.id |
																                    filter:row.sigla=idLocalidade.sigla">
																				<td style="text-align:right;" ng-bind="$index+1"></td>
																				<td class="centro" ng-bind="row.sigla"></td>
																				<td class="centro" ng-bind="row.periodo_desc"></td>
																				<td ng-bind="row.glt10_ramal + ' / ' + row.glt10_atendente"></td>
																				<td style="text-align:right;" ng-bind="row.qtd"></td>
																				<td><span class="label label-warning arrowed-right arrowed-in"><a href="#modal-table_aux" data-toggle="modal" ng-click="loadRamalDetalhes(row);">VER</a></span></td>
																			</tr>
																	<tbody>
																	</tbody>
																</table>

														</div>

														<div id="Linha" class="tab-pane">
															<h4>Aqui é o Linha</h4>
														</div>

														<div id="Tipo" class="tab-pane">
															<h5>Filtros: Localidade, período e <b>TIPO DE CHAMADA</b></h5>

															<div class="table-header">
																	<h5 class="title">
																		Total: <label ng-bind="glt_dash_resumo2.code"></label> || <label ng-bind="(glt_dash_resumo2.data |
																									 filter:row.periodo=idData.data |
																									 filter:row.sigla=idLocalidade.sigla).length"></label> filtrados.</h5>
															</div>

															<table class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
																		<th class="centro">#</th>
																		<th class="centro">Local</th>
																		<th class="centro">Período</th>
																		<th class="centro">Tipo Chamada</th>
																		<th class="centro">Qtd</th>
																	</tr>
																</thead>
																		<tr ng-repeat="row in glt_dash_resumo2.data |
																									 filter:row.periodo=idData.data |
																									 filter:row.sigla=idLocalidade.sigla">
																			<td style="text-align:right;" ng-bind="$index+1"></td>
																			<td class="centro" ng-bind="row.sigla"></td>
																			<td class="centro" ng-bind="row.periodo"></td>
																			<td ng-bind="row.glt05_tipo + ' / ' + row.glt05_desc"></td>
																			<td style="text-align:right;" ng-bind="row.qtd"></td>
																		</tr>
																<tbody>
																</tbody>
															</table>

														</div>

													</div>
												</div>
											</div>
										</div>

								</div>			<!-- row -->


							</div><!-- /.widget-main -->
						</div><!-- /.widget-body -->
					</div><!-- /.widget-box -->
				</div><!-- /.col -->



				<!-- lado direito - graficos -->
				<div class="col-sm-5 no-padding">
					<div class="widget-box transparent">
						<div class="widget-header widget-header-flat">
							<h4 class="widget-title lighter">
								<i class="ace-icon fa fa-signal"></i>
								Total de ligações
							</h4>

							<div class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</div>
						</div>

						<div class="widget-body" ng-show="idLocalidade">
							<div class="widget-main">
								<span ng-repeat="row in glt_dash_resumo4.data |
															 filter:row.periodo=idData.data |
															 filter:row.sigla=idLocalidade.sigla">

										<hr ng-if="glt_dash_resumo4_separador(row.sigla);">

										<div class="infobox" ng-class="{'infobox-blue': row.glt05_tipo==1, 'infobox-green': row.glt05_tipo==2}">
											<div class="infobox-icon">
												<i ng-if="row.glt05_tipo==1" class="ace-icon fa fa-arrow-down"></i>
												<i ng-if="row.glt05_tipo==2" class="ace-icon fa fa-arrow-up"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number" ng-bind="row.qtd"></span>
												<div ng-if="row.glt05_tipo==1" class="infobox-content" ng-bind="'de Entrada'"></div>
												<div ng-if="row.glt05_tipo==2" class="infobox-content" ng-bind="'de Saída'"></div>
											</div>

											<span class="badge badge-blue" ng-bind="row.periodo_desc"></span>
										</div>
								</span>
							</div><!-- /.widget-main -->
						</div><!-- /.widget-body -->

						<div class="row hide">
							<div class="col-sm-5">
						
										<div class="widget-main no-padding">
											<table class="table table-bordered table-striped">
												<thead class="thin-border-bottom">
													<tr>
														<th>
															<i class="ace-icon fa fa-caret-right blue"></i>Período
														</th>

														<th>
															<i class="ace-icon fa fa-caret-right blue"></i>Tipo
														</th>

														<th class="hidden-480">
															<i class="ace-icon fa fa-caret-right blue"></i>Qtd
														</th>
													</tr>
												</thead>

												<tbody>
													<tr ng-repeat="row in glt_dash_resumo6.data">
														<td ng-bind="row.periodo"></td>
														<td ng-bind="row.tipo_desc"></td>
														<td class="hidden-480"><b class="blue" ng-bind="row.qtd"></b></td>
													</tr>

													<tr>
														<td>online.com</td>

														<td>
															<b class="blue">$16.45</b>
														</td>

														<td class="hidden-480">
															<span class="label label-success arrowed-in arrowed-in-right">approved</span>
														</td>
													</tr>

													<tr>
														<td>newnet.com</td>

														<td>
															<b class="blue">$15.00</b>
														</td>

														<td class="hidden-480">
															<span class="label label-danger arrowed">pending</span>
														</td>
													</tr>

													<tr>
														<td>web.com</td>

														<td>
															<small>
																<s class="red">$24.99</s>
															</small>
															<b class="green">$19.95</b>
														</td>

														<td class="hidden-480">
															<span class="label arrowed">
																<s>out of stock</s>
															</span>
														</td>
													</tr>

													<tr>
														<td>domain.com</td>

														<td>
															<b class="blue">$12.00</b>
														</td>

														<td class="hidden-480">
															<span class="label label-warning arrowed arrowed-right">SOLD</span>
														</td>
													</tr>
												</tbody>
											</table>
										</div><!-- /.widget-main -->
									
							</div><!-- /.col -->
						</div>

					</div><!-- /.widget-box -->
				</div><!-- /.col -->


			</div><!-- /.row -->

			<div class="hr hr32 hr-dotted"></div>


</div>


<div id="modal-table_aux" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					Relatório analítico
					<label>
						<input name="switch-field-1" class="ace ace-switch btn-rotate" ng-click="dash_resumo5_ordem(glt_dash_resumo5_selecao)"
									type="checkbox" ng-model="dashResumo_Ordem_Inversa"/>
						<span class="lbl" data-lbl="SIM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NÃO">&nbsp;&nbsp;Ordem decrescente&nbsp;</span>
					</label>
				</div>
			</div>

			<div class="modal-body no-padding">
				<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
					<thead>
						<tr>
							<th ng-click="dash_resumo5_ordem('')">#</th>
							<th ng-click="dash_resumo5_ordem('tipo_desc')">Tipo</th>
							<th ng-click="dash_resumo5_ordem('data')"><i ng-show="glt_dash_resumo5_selecao == 'data'" class="ace-icon blue fa fa-caret-right"></i> Data</th>
							<th ng-click="dash_resumo5_ordem('hora')"><i ng-show="glt_dash_resumo5_selecao == 'hora'" class="ace-icon blue fa fa-caret-right"></i> Hora</th>
							<th ng-click="dash_resumo5_ordem('ring')"><i ng-show="glt_dash_resumo5_selecao == 'ring'" class="ace-icon blue fa fa-caret-right"></i> Ring</th>
							<th ng-click="dash_resumo5_ordem('duracao')"><i ng-show="glt_dash_resumo5_selecao == 'duracao'" class="ace-icon blue fa fa-caret-right"></i> Tempo</th>
							<th ng-click="dash_resumo5_ordem('fone')"><i ng-show="glt_dash_resumo5_selecao == 'fone'" class="ace-icon blue fa fa-caret-right"></i> Número</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="row in glt_dash_resumo5.data | orderBy: glt_dash_resumo5_ordem">
							<td class="dir" ng-bind="$index+1"></td>
							<td class="dir" ng-bind="row.tipo_desc"></td>
							<td class="centro">{{row.data | date:'dd-MM-yyyy'}}</td>
							<td class="centro" ng-bind="row.hora"></td>
							<td class="centro" ng-bind="row.ring"></td>
							<td class="centro" ng-bind="row.duracao"></td>
							<td class="dir" ng-bind="row.fone"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
