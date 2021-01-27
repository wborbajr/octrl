
<!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-dashboard"></span> Dashboard / Resumo das Atividades</h2>
 </div>
 <!-- END PAGE TITLE -->

 <?php
    if ($_SERVER['REMOTE_ADDR'] !== '192.168.0.155')
     return false;
 ?>

 <!-- PAGE CONTENT WRAPPER -->
 <div class="page-content-wrap">

   <div class="row" style="max-width:1080px;">
     <div class="col-md-12">


       <div class="row">

         <ul>
           <dd>Retornar relação de:</dd>
           <li>Todas as OS FECHADAS, por mês/ano:
             <ul>
               <li>
                 <code>select count(id_os) as qtd, EXTRACT(MONTH from DT_FECHADO) as MES, EXTRACT(YEAR from DT_FECHADO) as ANO, sum(VLR_TOTAL) as total
from v_os
where DT_FECHADO is not null
group by EXTRACT(MONTH from DT_FECHADO), EXTRACT(YEAR from DT_FECHADO)
ORDER BY EXTRACT(YEAR from DT_FECHADO) DESC, EXTRACT(MONTH from DT_FECHADO) DESC</code>
               </li>
             </ul>
           </li>
           <li>Todas as OS ABERTAS, por mês/ano:
             <ul>
               <li>
                  <code>select count(id_os) as qtd, EXTRACT(MONTH from DT_OS) as MES, EXTRACT(YEAR from DT_OS) as ANO, sum(VLR_TOTAL) as total
from v_os
where DT_FECHADO is null
group by EXTRACT(MONTH from DT_OS), EXTRACT(YEAR from DT_OS)
ORDER BY EXTRACT(YEAR from DT_OS) DESC, EXTRACT(MONTH from DT_OS) DESC</code>
               </li>
             </ul>
           </li>
         </ul>

       </div>

<!-- ID_ORIGEM	ID_OS	DT_OS	HR_OS	DT_ENTREGA	COMPRADOR	ID_CLIENTE	CLIENTE	CNPJ_CPF	ID_VENDEDOR	VENDEDOR	APELIDO	ID_STATUS	DESCRICAO	RESERVA	OBSERVACAO	VLR_PECAS	VLR_SERVICOS	VLR_ITEM	VLR_TOTAL	ENTREGA	CHAVE	ID_FORNEC	NOME	VLR_FRETE	TIPO_FRETE	VAL	ID_OBJETO	OBJETO	DEFEITO	IDENT1	IDENT2	IDENT3	IDENT4	IDENT5	ID_MODULO	DT_GARANTIA	ID_OSATEND	ATENDIMENTO	ID_OBJETO_CONTRATO	DT_RETIRADA	OBS_INTERNA	ID_TECNICO_RESP	NOME_TECNICO_RESP	DT_FECHADO	IMPORTADO -->

       <div class="row">

         <div class="col-md-6">

             <!-- START PROJECTS BLOCK -->
             <div class="panel panel-default">
                 <div class="panel-heading">
                     <div class="panel-title-box">
                         <h3>Ordens de Serviços</h3>
                         <span>Ordens de Serviços, por Status, por Quantidade e desde o início.</span>
                     </div>

                     <ul class="panel-controls" style="margin-top: 2px;">
                         <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                         <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                         <li class="dropdown">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                             <ul class="dropdown-menu">
                                 <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                 <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                             </ul>
                         </li>
                     </ul>
                 </div>
                 <div class="panel-body panel-body-table">

                     <div class="table-responsive">
                         <table class="table table-bordered table-striped">
                             <thead>
                                 <tr>
                                     <th width="5%">Cód.</th>
                                     <th width="60%">Descrição</th>
                                     <th width="5%">Qtd</th>
                                     <th width="30%" style="text-align:center;">%</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td><strong>7661</strong></td>
                                     <td><span class="label label-danger">Alexandre Daniel</span></td>
                                     <td><strong>157</strong></td>
                                     <td>
                                         <div class="progress progress-small progress-striped">
                                             <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td><strong>00000</strong></td>
                                     <td><span class="label label-danger">Developing</span></td>
                                     <td>
                                         <div class="progress progress-small progress-striped active">
                                             <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td><strong>00000</strong></td>
                                     <td><span class="label label-warning">Updating</span></td>
                                     <td>
                                         <div class="progress progress-small progress-striped active">
                                             <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td><strong>00000</strong></td>
                                     <td><span class="label label-warning">Updating</span></td>
                                     <td>
                                         <div class="progress progress-small progress-striped active">
                                             <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td><strong>00000</strong></td>
                                     <td><span class="label label-success">Support</span></td>
                                     <td>
                                         <div class="progress progress-small progress-striped active">
                                             <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td><strong>00000</strong></td>
                                     <td><span class="label label-success">Support</span></td>
                                     <td>
                                         <div class="progress progress-small progress-striped active">
                                             <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                         </div>
                                     </td>
                                 </tr>

                             </tbody>
                         </table>
                     </div>

                 </div>
                 <div class="panel-footer">
                     <code>Trazer a relação de Tipos de Serviços da OS</code>
                 </div>
             </div>
             <!-- END PROJECTS BLOCK -->

         </div>
     </div>




     </div>
   </div>
 </div>


<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap hide">

    <!-- START WIDGETS -->
    <div class="row">

        <div class="col-md-3">

            <!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel">
                <div class="owl-carousel" id="owl-example">
                    <div>
                        <div class="widget-title">Vendas Mës</div>
                        <div class="widget-subtitle">Suas</div>
                        <div class="widget-int">3.548</div>
                    </div>
                    <div>
                        <div class="widget-title">Vendas Mës</div>
                        <div class="widget-subtitle">Quem vendeu menos</div>
                        <div class="widget-int">1.695</div>
                    </div>
                    <div>
                        <div class="widget-title">Vendas Mës</div>
                        <div class="widget-subtitle">Quem vendeu MAIS</div>
                        <div class="widget-int">1.977</div>
                    </div>
                </div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>
            <!-- END WIDGET SLIDER -->

        </div>
        <div class="col-md-3">

            <!-- START WIDGET MESSAGES -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-messages.html';">
                <div class="widget-item-left">
                    <span class="fa fa-envelope"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int num-count">48</div>
                    <div class="widget-title">Editando</div>
                    <div class="widget-subtitle">mais antiga 12/09/2017</div>
                </div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>
            <!-- END WIDGET MESSAGES -->

        </div>
        <div class="col-md-3">

            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-address-book.html';">
                <div class="widget-item-left">
                    <span class="fa fa-user"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-int num-count">375</div>
                    <div class="widget-title">Registred users</div>
                    <div class="widget-subtitle">On your website</div>
                </div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>
            <!-- END WIDGET REGISTRED -->

        </div>
        <div class="col-md-3">

            <!-- START WIDGET CLOCK -->
            <div class="widget widget-info widget-padding-sm">
                <div class="widget-big-int plugin-clock">00:00</div>
                <div class="widget-subtitle plugin-date">Loading...</div>
                <div class="widget-controls">
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
                <div class="widget-buttons widget-c3">
                    <div class="col">
                        <a href="#"><span class="fa fa-clock-o"></span></a>
                    </div>
                    <div class="col">
                        <a href="#"><span class="fa fa-bell"></span></a>
                    </div>
                    <div class="col">
                        <a href="#"><span class="fa fa-calendar"></span></a>
                    </div>
                </div>
            </div>
            <!-- END WIDGET CLOCK -->

        </div>
    </div>
    <!-- END WIDGETS -->



    <div class="row">

      <div class="col-md-5">

          <!-- START PROJECTS BLOCK -->
          <div class="panel panel-default">
              <div class="panel-heading">
                  <div class="panel-title-box">
                      <h3>Ligações feitas</h3>
                      <span>Ligações feitas no período</span>
                  </div>

                  <ul class="panel-controls" style="margin-top: 2px;">
                      <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                      <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                          <ul class="dropdown-menu">
                              <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                              <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
              <div class="panel-body panel-body-table">

                  <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th width="5%">Ramal</th>
                                  <th width="60%">Nome</th>
                                  <th width="5%">Qtd</th>
                                  <th width="30%" style="text-align:center;">%</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td><strong>7661</strong></td>
                                  <td><span class="label label-danger">Alexandre Daniel</span></td>
                                  <td><strong>157</strong></td>
                                  <td>
                                      <div class="progress progress-small progress-striped">
                                          <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td><strong>00000</strong></td>
                                  <td><span class="label label-danger">Developing</span></td>
                                  <td>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td><strong>00000</strong></td>
                                  <td><span class="label label-warning">Updating</span></td>
                                  <td>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td><strong>00000</strong></td>
                                  <td><span class="label label-warning">Updating</span></td>
                                  <td>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td><strong>00000</strong></td>
                                  <td><span class="label label-success">Support</span></td>
                                  <td>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td><strong>00000</strong></td>
                                  <td><span class="label label-success">Support</span></td>
                                  <td>
                                      <div class="progress progress-small progress-striped active">
                                          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                      </div>
                                  </td>
                              </tr>

                          </tbody>
                      </table>
                  </div>

              </div>
              <div class="panel-footer">
                  <ul class="pagination pagination-sm pull-right">
                      <li><a href="#">&laquo;</a></li>
                      <li class="active"><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">4</a></li>
                      <li><a href="#">&raquo;</a></li>
                  </ul>
              </div>
          </div>
          <!-- END PROJECTS BLOCK -->

      </div>
  </div>





    <div class="row">
        <div class="col-md-3">

            <!-- START USERS ACTIVITY BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Users Activity</h3>
                        <span>Users vs returning</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
                </div>
            </div>
            <!-- END USERS ACTIVITY BLOCK -->

        </div>
        <div class="col-md-3">

            <!-- START VISITORS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Visitors</h3>
                        <span>Visitors (last month)</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div class="chart-holder" id="dashboard-donut-1" style="height: 200px;"></div>
                </div>
            </div>
            <!-- END VISITORS BLOCK -->

        </div>

<div class="col-md-6">

            <!-- START PROJECTS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Bloco de Notas</h3>
                        <span>Anotações Gerais / Processos</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body panel-body-table">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20%">Grupo</th>
                                    <th width="50%">Projeto</th>
                                    <th width="20%">Criado em</th>
                                    <th width="20%">Alterado</th>
                                    <th width="20%">Status</th>
                                    <th width="30%">Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Indefinido</td>
                                    <td><strong>Joli Admin</strong></td>
                                    <td>00/00/0000</td>
                                    <td>00/00/0000</td>
                                    <td><span class="label label-danger">Developing</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Indefinido</td>
                                    <td><strong>Gemini</strong></td>
                                    <td>00/00/0000</td>
                                    <td>00/00/0000</td>
                                    <td><span class="label label-warning">Updating</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                  <td>Indefinido</td>
                                  <td><strong>Taurus</strong></td>
                                  <td>00/00/0000</td>
                                  <td>00/00/0000</td>
                                    <td><span class="label label-warning">Updating</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                  <td>Indefinido</td>
                                  <td><strong>Leo</strong></td>
                                  <td>00/00/0000</td>
                                  <td>00/00/0000</td>
                                    <td><span class="label label-success">Support</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                  <td>Indefinido</td>
                                  <td><strong>Virgo</strong></td>
                                  <td>00/00/0000</td>
                                  <td>00/00/0000</td>
                                    <td><span class="label label-success">Support</span></td>
                                    <td>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- END PROJECTS BLOCK -->

        </div>
    </div>

    <div class="row">
<div class="col-md-8">

            <!-- START SALES BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Sales</h3>
                        <span>Sales activity by period you selected</span>
                    </div>
                    <ul class="panel-controls panel-controls-title">
                        <li>
                            <div id="reportrange" class="dtrange">
                                <span></span><b class="caret"></b>
                            </div>
                        </li>
                        <li><a href="#" class="panel-fullscreen rounded"><span class="fa fa-expand"></span></a></li>
                    </ul>

                </div>
                <div class="panel-body">
                    <div class="row stacked">
                        <div class="col-md-4">
                            <div class="progress-list">
                                <div class="pull-left"><strong>In Queue</strong></div>
                                <div class="pull-right">75%</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">75%</div>
                                </div>
                            </div>
                            <div class="progress-list">
                                <div class="pull-left"><strong>Shipped Products</strong></div>
                                <div class="pull-right">450/500</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">90%</div>
                                </div>
                            </div>
                            <div class="progress-list">
                                <div class="pull-left"><strong class="text-danger">Returned Products</strong></div>
                                <div class="pull-right">25/500</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">5%</div>
                                </div>
                            </div>
                            <div class="progress-list">
                                <div class="pull-left"><strong class="text-warning">Progress Today</strong></div>
                                <div class="pull-right">75/150</div>
                                <div class="progress progress-small progress-striped active">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                                </div>
                            </div>
                            <p><span class="fa fa-warning"></span> Data update in end of each hour. You can update it manual by pressign update button</p>
                        </div>
                        <div class="col-md-8">
                            <div id="dashboard-map-seles" style="width: 100%; height: 200px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SALES BLOCK -->

        </div>

        <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-content">
            <ul class="list-inline item-details">
              <li><a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin templates</a></li>
              <li><a href="http://themescloud.org">Bootstrap themes</a></li>
            </ul>
          </div>
        </div>

        <div class="col-md-4">

            <!-- START SALES & EVENTS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Sales & Event</h3>
                        <span>Event "Purchase Button"</span>
                    </div>
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="panel-body padding-0">
                    <div class="chart-holder" id="dashboard-line-1" style="height: 200px;"></div>
                </div>
            </div>
            <!-- END SALES & EVENTS BLOCK -->

        </div>
    </div>

    <!-- START DASHBOARD CHART -->
      <div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
      <div class="block-full-width"></div>
    <!-- END DASHBOARD CHART -->

</div>
<!-- END PAGE CONTENT WRAPPER -->
