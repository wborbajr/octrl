<div id="div-main_vendas" style="max-width:1080px;" ng-init="selCidade='Londrina'">

    <div class="row">
      <div class="col-md-12">

          <!-- START SEARCH -->
          <div class="panel panel-default">
              <div class="panel-body">
                  <div class="row stacked">

                    <form class="form-inline" role="form" id="form_os_busca">

                      <div class="col-md-8">
                          <div class="input-group push-down-10">
                              <span class="input-group-addon"><span class="fa fa-search"></span></span>
                              <input type="text" class="form-control" id="os_busca" name="os_busca" placeholder="Procurar por..." value=""/>
                          </div>
                      <!-- </div>
                      <div class="col-md-7"> -->

                          <div class="pull-right push-down-10">
                              <div class="form-group">
                                <div class="col-md-9">
                                    <select class="form-control select" name="select_os_origem" id="select_os_origem">
                                      <?php
                                        $aBase = $_SESSION[sys][FBConn];
                                        // print_r($aBase);
                                        while (list($key, $val) = each($aBase)) {
                                          $sSelected = (($_SESSION[sys][login][localidade][cidade] == $aBase[$key]['cidade']) ? 'selected' : '');
                                          echo "<option value='$key' $sSelected>".$aBase[$key]['cidade']."</option>";
                                        }
                                      ?>
                                    </select>
                                </div>
                              </div>
                              <button class="btn btn-default" rel="OS"><span class="fa fa-search"></span> O.S.</button>
                              <button class="btn btn-default" rel="DOC"><span class="fa fa-search"></span> CPF/CNPJ</button>
                              <button class="btn btn-default" rel="NOME"><span class="fa fa-search"></span> NOME</button>
                              <button class="btn btn-default" rel="SERIAL"><span class="fa fa-search"></span> SERIAL</button>
                          </div>
                      </div>

                    </form>

                  </div>
              </div>
          </div>
          <!-- END SEARCH -->

          <div id="div_os_print">Informe o critério de busca... ou nao!</div>
          <div id="div_resultado" class="container col-md-12">o resultado devera aparecer aqui!</div>

          <!-- START SEARCH RESULT -->
          <div class="search-results hide">

            <div class="sr-item">
              <div class="col-md-9">
                  <p><small>Mobile</small><br/>(555) 555-55-55</p>
                  <p><small>Email</small><br/>nadiaali@domain.com</p>
                  <p><small>Address</small><br/>123 45 Street San Francisco, CA, USA</p>
              </div>
              <div class="col-md-3">
                <div class="contact-info">
                  <div class="col-md-6">
                    <small>Entrada:</small><br/>99/99/9999
                  </div>
                  <div class="col-md-6">
                    <small>Saída:</small><br/>99/99/9999
                  </div>
                  <hr />
                  <p><small>Ações:</small><br/>
                    <div class="form-group">
                        <button type="button" class="btn btn-default btn-rounded">Print</button>
                        <button type="button" class="btn btn-primary btn-rounded">OBS</button>
                        <button type="button" class="btn btn-success btn-rounded">Status</button>
                    </div>
                  </p>
                </div>
              </div>
            </div>

            <div class="sr-item">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-actions">
                  <thead>
                    <tr>
                      <th width="50">OS #</th>
                      <th width="100">Produto</th>
                      <th>Problema Relacionado</th>
                      <th width="100">Status</th>
                      <th width="100">Data Entrada</th>
                      <th width="100">Data Saída</th>
                      <th width="100">actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr id="trow_1">
                      <td class="text-center">1</td>
                      <td><strong>John Doe</strong></td>
                      <td><span class="label label-success">New</span></td>
                      <td>$430.20</td>
                      <td>24/09/2014</td>
                      <td>24/09/2014</td>
                      <td>
                        <button class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button>
                        <button class="btn btn-danger btn-rounded btn-sm" onClick="delete_row('trow_1');"><span class="fa fa-times"></span></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="sr-item">
              <a href="#" class="sr-item-title">Top 100 Admin Templates</a>
              <div class="sr-item-link">http://themifycloud.com/downloads/free-responsive-bootstrap-joli-angular-js-admin-template-dashboard-web-app/</div>
              <p>1st place <strong>Joli Admin</strong> - Responsive Bootstrap Admin Template. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis a dui vel pretium. Duis nisi turpis, laoreet eu semper ut, eleifend sed dolor. Fusce dapibus dignissim velit vel pulvinar. Sed commodo arcu ac tortor hendrerit dapibus. Maecenas vehicula lacinia neque, quis venenatis dolor venenatis eu. Maecenas maximus est vel purus cursus suscipit. Nunc placerat arcu et ultricies faucibus.</p>
              <p class="sr-item-links"><a href="#">Translate this page</a> - <a href="#">View cache</a> - <a href="#">Remove from search</a></p>
            </div>

          </div>
      </div>
    </div>


    <div id="vendas_os_div" class="container col-md-12 hide">Resultado da pesquisa
        <table id="example" class="display table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Extn.</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Extn.</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </tfoot>
        </table>
    </div>

</div> <!-- fim da área de vendas //-->
