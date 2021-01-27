<?php
  session_start();

  $sOS = $_REQUEST['os'];
  $sOrigem = $_REQUEST['origem'];

  $sOrigem = (($sOrigem == '') ? $_SESSION[sys][login][sigla] : $sOrigem);

  if (($sOS == '') OR ($sOrigem == '')) {
    echo "Parâmetros inválidos ou inexistentes.";
    return false;
    exit;
  }

  $data = date("d/m/y");
	$hora = date("H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];

  $sLocalidade = (($sOrigem == '') ? $_SESSION[sys][login][localidade][cabecalho] : $_SESSION[sys][FBConn][$sOrigem][cabecalho] );
  $sPathBase = "../";

  require($sPathBase . 'conn.inc.php');

  $sql = "SELECT ID_OS
					From V_OS
					Where ID_OS = $sOS;";

	//Executa a instrução SQL
	$data_os = queryFB($sql, 1, $sOrigem);

	if ($data_os[ID_OS] == '') {
		echo "OS #$sOS não encontrada!!";
		return false;
    exit;
	}

	//Nome do arquivo:
	$arquivo = $sPathBase."comum/logs/Acao_$data.txt";

  $sResponsavel = " - Encerrada por: " . $_SESSION[sys][login][id] . " - " . $_SESSION[sys][login][usuario] . " - $data $hora" ;

  $sql = "UPDATE TB_OS SET ID_STATUS = '12', DT_RETIRADA = CURRENT_DATE, OBS_INTERNA = OBS_INTERNA || '".
          utf8_decode( $sResponsavel )."', OBSERVACAO = OBSERVACAO || '".
          utf8_decode( $sResponsavel ).
         "' WHERE ID_OS = ".$sOS." AND DT_RETIRADA IS NULL;";

 // echo $sql . "<hr/>";

	//Executa a instrução SQL
  $res = queryFB($sql, '', $sOrigem );

	if ($res)

		//Texto a ser impresso no log:
		$texto = "[$hora][$ip]> Baixa e Impressao da OS ".$sOS.$sResponsavel."\n";

	else
		//Texto a ser impresso no log:
		$texto = "[$hora][$ip]> Impressao de OS jah baixada - OS: ".$sOS.$sResponsavel."\n";

	$manipular = fopen("$arquivo", "a+b");
	fwrite($manipular, $texto);
	fclose($manipular);

?>
<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OMNI INFORMÁTICA - COMPROVANTE DE RETIRADA</title>
    <script src="<?php echo $sPathBase;?>vendor/jquery/jquery.min.js"></script>
	  <link rel="stylesheet" href="<?php echo $sPathBase;?>css/style.css">

	<script>
		function printThis(){
      window.print();
      parent.$.fancybox.getInstance().close();
			// javascript:parent.jQuery.fancybox.close();
		}
	</script>
</head>
<body style="margin:0 auto;width:850px;">
	<a href="javascript:printThis();" style="float:right;padding-right:10px;"> [ Imprimir e Fechar X ] </a>

	<table border="0" style="margin:0 auto;width:850px;" id="os_corpo">

		<thead>
			<tr>
				<td>
					<table border="1" width="100%" cellpadding="10">
            <th colspan="*" id="cabecalho">
              <span class="esquerda">
    						<img src="<?php echo $sPathBase;?>img/logo144x58.png" class="logo" />
    						<label class="institucional">
    						<?php
                    echo $sLocalidade;
                ?>
    						</label>
    					</span>
    				</th>
					</table>
				</td>
			</tr>
			<tr>
				<th class="titulo meio">
					COMPROVANTE DE RETIRADA N. <span id="os_nr"></span>
				</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>

					<table border="0" width="100%" class="table_form">
						<tr>
							<td colspan="100%"><strong>Tipo Atendimento:</strong>
								<span id="os_antendimento"></span>
								<span style="padding-left:50px;"><strong>Situação: </strong>
								<span id="os_situacao"></span> </span>
								<span style="float: right;">
								<strong>Data:</strong><span id="os_data"></span>
								<strong>Hora:</strong><span id="os_hora"></span>
								</span>
							</td>

						</tr>
						<tr>
							<td width="*" colspan="2"><strong>Cliente:</strong>
							<span id="os_cliente"></span></td>

							<td width="*" colspan="3"><strong>CPF/CNPJ:</strong>
							<span id="os_cnpj"></span></td>

						</tr>
						<tr class="">
							<td colspan="2"><strong>Contato:</strong>
							<span id="os_contato"></span></td>

							<td><strong>Fone:</strong>
							<span id="os_fone"></span></td>

							<td><strong>RG/IE:</strong>
							<span id="os_rg"></span></td>

						</tr>
						<tr class="">
							<td colspan="2"><strong>Celular:</strong>
							<span id="os_celular"></span></td>

							<td colspan="1"><strong>I.Mun:</strong>
							<span id="os_imun"></span></td>

							<td colspan="1"><strong>CEP:</strong>
							<span id="os_cep"></span></td>

						</tr>
						<tr class="">
							<td colspan="2"><strong>Endereço:</strong>
							<span id="os_endereco"></span></td>

							<td colspan="2"><strong>Email:</strong>
							<span id="os_email"></span></td>

						</tr>
						<tr class="">
							<td colspan="2"><strong>Bairro:</strong>
							<span id="os_bairro"></span></td>

							<td colspan="2"><strong>Cidade:</strong>
							<span id="os_cidade"></span></td>

						</tr>

					</table>

					<hr />

					<table border="0" width="100%" class="table_form">
						<tr>
							<th width="50">Código</th>
							<th width="">Descrição</th>
							<th width="">Modelo</th>
							<th width="">Serial</th>
							<th width="">Acessórios</th>
							<th width="70">Prisma</th>
						</tr>
						<tr>
							<td colspan="100%">
								<hr />
							</td>
						</tr>
						<tr>
							<td id="os_objeto_id"></td>
							<td id="os_objeto_descricao" align="center"></td>
							<td id="os_objeto_modelo" align="center"></td>
							<td id="os_objeto_serial" align="center"></td>
							<td id="os_objeto_acessorio" align="center"></td>
							<td id="os_objeto_prisma" align="center"></td>
						</tr>
						<tr>
							<td colspan="6"><br /><strong>Problemas reclamados:</strong> <span id="os_problema"></span>
								<span style="float:right;display:none;">Prox.Rev.Gar: <span id="os_garantia"></span></span></td>
						</tr>
					</table>

					<hr />

                                        <p><h3><strong>SERVIÇOS</strong></h3></p>

                                        <table border="0" width="100%" class="table_form">
                                                <tr>
                                                        <td widtd="58" align="right">Cód Obj.</td>
                                                        <td widtd="">Serviço</td>
                                                        <td widtd="70" align="right">Quant.</td>
                                                        <td widtd="70" align="right">Unid.</td>
                                                        <td widtd="90" align="right">Valor Unit.</td>
                                                        <td widtd="90" align="right">Valor Total</td>
                                                        <td widtd="170" align="right">Técnico</td>
                                                </tr>
                                                <tr>
                                                        <td colspan="100%">
                                                                <hr />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td id="os_serv_11" align="right"></td>
                                                        <td id="os_serv_12"></td>
                                                        <td id="os_serv_13" align="right"></td>
                                                        <td id="os_serv_14" align="right"></td>
                                                        <td id="os_serv_15" align="right"></td>
                                                        <td id="os_serv_16" align="right"></td>
                                                        <td id="os_serv_17" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td id="os_serv_21" align="right"></td>
                                                        <td id="os_serv_22"></td>
                                                        <td id="os_serv_23" align="right"></td>
                                                        <td id="os_serv_24" align="right"></td>
                                                        <td id="os_serv_25" align="right"></td>
                                                        <td id="os_serv_26" align="right"></td>
                                                        <td id="os_serv_27" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td id="os_serv_31" align="right"></td>
                                                        <td id="os_serv_32"></td>
                                                        <td id="os_serv_33" align="right"></td>
                                                        <td id="os_serv_34" align="right"></td>
                                                        <td id="os_serv_35" align="right"></td>
                                                        <td id="os_serv_36" align="right"></td>
                                                        <td id="os_serv_37" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td id="os_serv_41" align="right"></td>
                                                        <td id="os_serv_42"></td>
                                                        <td id="os_serv_43" align="right"></td>
                                                        <td id="os_serv_44" align="right"></td>
                                                        <td id="os_serv_45" align="right"></td>
                                                        <td id="os_serv_46" align="right"></td>
                                                        <td id="os_serv_47" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td id="os_serv_51" align="right"></td>
                                                        <td id="os_serv_52"></td>
                                                        <td id="os_serv_53" align="right"></td>
                                                        <td id="os_serv_54" align="right"></td>
                                                        <td id="os_serv_55" align="right"></td>
                                                        <td id="os_serv_56" align="right"></td>
                                                        <td id="os_serv_57" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td colspan="100%">
                                                                <hr />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" style="text-align:right;">TOTAL:&nbsp;</td>
                                                        <td id="os_total_servicos" align="right">&nbsp;0,00</td>
                                                        <td>&nbsp;</td>
                                                </tr>
                                        </table>

                                        <p><h3><strong>PEÇAS</strong></h3></p>

                                        <table border="0" width="100%" class="table_form">
                                                <tr>
                                                        <td width="50">Cód Obj</td>
                                                        <td width="">Descriçao</td>
                                                        <td width="70" align="right">Código.</td>
                                                        <td width="70" align="right">Quant.</td>
                                                        <td width="90" align="right">Valor Unit.</td>
                                                        <td width="90" align="right">Valor Total</td>
                                                        <td width="90" align="right">Técnico</td>
                                                </tr>
                                                <tr>
                                                        <td colspan="100%">
                                                                <hr />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td id="os_pecas_11" align="right"></td>
                                                        <td id="os_pecas_12"></td>
                                                        <td id="os_pecas_13" align="right"></td>
                                                        <td id="os_pecas_14" align="right"></td>
                                                        <td id="os_pecas_15" align="right"></td>
                                                        <td id="os_pecas_16" align="right"></td>
                                                        <td id="os_pecas_17" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td id="os_pecas_21" align="right"></td>
                                                        <td id="os_pecas_22"></td>
                                                        <td id="os_pecas_23" align="right"></td>
                                                        <td id="os_pecas_24" align="right"></td>
                                                        <td id="os_pecas_25" align="right"></td>
                                                        <td id="os_pecas_26" align="right"></td>
                                                        <td id="os_pecas_27" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td id="os_pecas_31" align="right"></td>
                                                        <td id="os_pecas_32"></td>
                                                        <td id="os_pecas_33" align="right"></td>
                                                        <td id="os_pecas_34" align="right"></td>
                                                        <td id="os_pecas_35" align="right"></td>
                                                        <td id="os_pecas_36" align="right"></td>
                                                        <td id="os_pecas_37" align="right"></td>
                                                </tr>

                                                <tr>
                                                        <td id="os_pecas_41" align="right"></td>
                                                        <td id="os_pecas_42"></td>
                                                        <td id="os_pecas_43" align="right"></td>
                                                        <td id="os_pecas_44" align="right"></td>
                                                        <td id="os_pecas_45" align="right"></td>
                                                        <td id="os_pecas_46" align="right"></td>
                                                        <td id="os_pecas_47" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td id="os_pecas_51" align="right"></td>
                                                        <td id="os_pecas_52"></td>
                                                        <td id="os_pecas_53" align="right"></td>
                                                        <td id="os_pecas_54" align="right"></td>
                                                        <td id="os_pecas_55" align="right"></td>
                                                        <td id="os_pecas_56" align="right"></td>
                                                        <td id="os_pecas_57" align="right"></td>
                                                </tr>
                                                <tr>
                                                        <td colspan="100%">
                                                                <hr />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" style="text-align:right;">TOTAL:&nbsp;</td>
                                                        <td id="os_total_pecas" align="right">&nbsp;0,00</td>
                                                        <td>&nbsp;</td>
                                                </tr>
                                        </table>

                                        <br />

					<table border="0" width="100%" class="table_form">
						<tr>
							<td align="right"><span style="font-size: 11pt;float: left;"><strong>TOTAIS</strong></span>TOTAL DE SERVIÇOS R$:&nbsp;</td>
							<td id="os_totais_servico" align="right">&nbsp;0,00</td>
						</tr>
						<tr>
							<td align="right">TOTAL DE PEÇAS R$:&nbsp;</td>
							<td id="os_totais_peca" align="right">&nbsp;0,00</td>
						</tr>
						<tr>
							<td align="right">FRETE R$:&nbsp;</td>
							<td id="os_totais_frete" align="right">&nbsp;0,00</td>
						</tr>
						<tr>
							<td align="right">TOTAL R$:&nbsp;</td>
							<td id="os_totais_geral" align="right">&nbsp;0,00</td>
						</tr>
					</table>

					<br />

					<table border="1" width="100%">
						<tr>
							<td>
								<strong>Observações: </strong>
								<span id="os_observacoes">Observações do serviço.</span>
							</td>
						</tr>
					</table>

					<br />

					<table border="0" width="100%">
						<tr>
							<td colspan="2"><br /><small>
								Entregue em: <span id="os_dt_entrega"></span>
								</small>
							</td>
						</tr>
						<tr>
							<td WIDTH="50%"><small>
								Atendido por: <span id="os_atendente"></span>
								</small>
							</td>
							<td align="center"><br />_________________________________________________
							</td>
						</tr>
						<tr>
							<td><small>
								Entregue por: <span id="os_logado"><?php echo $_SESSION[login][nome]?></span>
                </small></td>
							<td align="center">Assinatura do Cliente
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>

	</table>
  </body>
</html>

<script type="text/javascript">
jQuery(function($) {

	console.log("jquery os_print");


    var sOpc = "<?php echo $sOS;?>";
    var sOrigem = "<?php echo $sOrigem;?>";
    var sLocal = "<?php echo $sPathBase;?>";
    var print_opc = "os_print.inc.php?os="+sOpc+"&origem="+sOrigem+"&local="+sLocal;

    //
    $.ajax({
              type: "POST",
              url: 'os_print.inc.php',
              dataType: 'json',
              async: false,
              cache: false,
              data: {os: sOpc, origem: sOrigem, local: sLocal},
              error: function(result){
                    console.log('não deu boa',result);
              },
              success: function(result){
                var aDados = result.data;

                console.log('aDados', aDados);

                $.each(aDados, function(index, value) {
                    // console.log(value);
                    $("#"+index).html(value);
                });

                // Repasse para os campos da OS
                $(".institucional").html(aDados.cab);
                // $("#os_nr").text(aDados.os);

          }

    });

});
</script>