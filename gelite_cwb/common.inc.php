<?php
    session_start();

    $appNome    = 'rwTCtrl';
    $appVersao  = 'v1.0a 2017&copy;';
    $appDesc    = 'Sistema para Gestão de Vendas e Serviços';
    $appCliente = 'OMNI Informática';


    $_SESSION[sys][pagina] = array( 'sobre.inc.php',
    								'dashboard/dashboard',
    								'atendimento/atendimento',
                    'suporte/suporte',
                    'gelite/gelite'
    							  );

    // Controle de unidade
    $_SESSION[sys][unidade] = $_REQUEST['unidade'] ? $_REQUEST['unidade'] : $_SESSION[sys][unidade];
    $_SESSION[sys][unidade] = $_SESSION[sys][unidade] ? $_SESSION[sys][unidade] : 'CWB';

    // Controle de menus
    // Controle de unidade
    // $_SESSION[sys][menu] = 1;
    $_SESSION[sys][menu] = $_REQUEST['opc'] ? $_REQUEST['opc'] : $_SESSION[sys][menu];
    $iOpc = $_SESSION[sys][menu] ? $_SESSION[sys][menu] : 1;

    //
    $_SESSION[aMenu_Opcoes] = array(    ['Sobre o Sistema', 'Informações sobre o sistema', 'fa-info'],
                                        ['Dashboard', 'Tela de Resultados', 'fa-tachometer'],
                                        ['Atendimento', 'Tela de Manutenção Ordens de Serviços', 'fa-cog'],
                                        ['Suporte', 'Definições de comportamento do sistema', 'fa-cogs'],
                                        ['GeLiTe', 'Gerenciamento de Ligações Telefônicas', 'fa-cogs']
                                   );




//*************************
function menu_sup($iOpc){

    $sTxt = '
    <div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse          ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState("sidebar")}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large hide" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">';

    for ($i=1;$i<sizeOf($_SESSION[aMenu_Opcoes]);$i++)
        $sTxt .= ' <li class="hover '.menu_sup_ativo($i, $iOpc).'">
						<a href="./?opc='.$i.'">
							<i class="menu-icon fa '.$_SESSION[aMenu_Opcoes][$i][2].' "></i>
							<span class="menu-text"> '.$_SESSION[aMenu_Opcoes][$i][0].' </span>
						</a>
						<b class="arrow"></b>
					</li>';

    $sTxt .= '</ul><!-- /.nav-list -->
			</div>';

    echo $sTxt;
}


//*************************
function menu_sup_ativo($iMenu, $iOpc){

    if ($iMenu == $iOpc)
        return "active";

}


//*************************
function menu_esq($iOpc){

    $sTxt = '
								<div class="invisible">
									<button data-target="#sidebar2" type="button" class="pull-left menu-toggler navbar-toggle">
										<span class="sr-only">Toggle sidebar</span>

										<i class="ace-icon fa fa-dashboard white bigger-125"></i>
									</button>

									<div id="sidebar2" class="sidebar responsive menu-min ace-save-state">
										<ul class="nav nav-list">';

    for ($i=1;$i<sizeOf($_SESSION[aMenu_Opcoes]);$i++)
        $sTxt .= ' <li class="'.menu_sup_ativo($i, $iOpc).'">
                        <a href="./?opc='.$i.'">
                            <i class="menu-icon fa '.$_SESSION[aMenu_Opcoes][$i][2].'"></i>
                            <span class="menu-text"> '.$_SESSION[aMenu_Opcoes][$i][0].' </span>
                        </a>

                        <b class="arrow"></b>
                    </li>';


    $sTxt .= '
										</ul><!-- /.nav-list -->

										<div class="sidebar-toggle sidebar-collapse">
											<i id="sidebar3-toggle-icon" class="ace-icon fa fa-angle-double-right ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
										</div>
									</div><!-- .sidebar -->
								</div>';

    echo $sTxt;

}

?>
