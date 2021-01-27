<?php
    session_start();

    $appNome    = 'Omni Control';
    $appVersao  = 'oCtrl - v1.0a 2017&copy;';
    $appDesc    = 'Sistema para Gestão de Vendas e Ordens de Serviços';

    $_SESSION[sys][pagina] = array( 'sobre.inc.php',
    								'dashboard/dashboard',
                    'venda/venda',
                    'retirada/retirada',
                    // 'entrada/entrada',
                    // 'suporte/suporte',
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
    $_SESSION[aMenu_Opcoes] = array(     ['Sobre o Sistema', 'Informações sobre o sistema', 'fa-info']
                                        ,['Dashboard', 'Tela de Resultados', 'fa-tachometer']
                                        ,['Cadastro / OS', '', 'fa-barcode']
                                        ,['Consulta / Retirada', '', 'fa-upload']
                                        // ,['Entrada / Venda', 'Tela de Entrada dos elementos', 'fa-wrench'],
                                        // ,['Suporte', '', 'fa-cogs']
                                        ,['GeLiTe', 'Gerenciamento de Ligações Telefônicas', 'fa-calendar']
                                   );



//*************************
function validaLogin(){

      $_SESSION[sys][login] = array(
                                     'id' => 0,
                                     'usuario' => '',
                                     'nivel' => '0',
                                     'funcao' => '',
                                     'login' => '',
                                     'senha' => '',
                                     'acesso_em' => ''
                                   );

}



//*************************
function menu_sup($iOpc){
    $sTxt = '';
    $aPermissao = $_SESSION[sys][login][localidade][master];

    for ($i=1;$i<sizeOf($_SESSION[aMenu_Opcoes]);$i++){

      if ($_SESSION[aMenu_Opcoes][$i][0] == 'Suporte')
        if ($_SESSION[sys][login][funcao] != 'Técnico')
          if (!$bAdmin)
            continue;

      if ($_SESSION[aMenu_Opcoes][$i][0] == 'GeLiTe')
        if ($_SERVER['REMOTE_ADDR'] !== '192.168.0.145')
           continue;

        $sTxt .= '<li class="'.menu_sup_ativo($i, $iOpc).'">
                      <a href="./?opc='.$i.'"><span class="fa '.$_SESSION[aMenu_Opcoes][$i][2].'"></span> <span class="xn-text">'.$_SESSION[aMenu_Opcoes][$i][0].'</span></a>
                      <b class="arrow"></b>
                  </li>';
    }

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
