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
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OMNI INFORMÁTICA - RECIBO DE ENTREGA</title>
    <script src="<?php echo $sPathBase;?>vendor/jquery/jquery.min.js"></script>
	  <link rel="stylesheet" href="<?php echo $sPathBase;?>css/style.css">

	<script>
		function printThis(){
			window.print();
      parent.$.fancybox.getInstance().close();
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
					ORDEM DE SERVIÇO N. <span id="os_nr"></span>
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
							<td colspan="100%"><strong>Complemento:</strong>
							<span id="os_complemento"></span></td>

						</tr>
						<tr class="">
							<td colspan="2"><strong>Bairro:</strong>
							<span id="os_bairro"></span></td>

							<td colspan="2"><strong>Cidade:</strong>
							<span id="os_cidade"></span></td>

						</tr>

					</table>
					<hr />
					<p><strong>OBJETOS</strong></p>

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
							<td id="os_objeto_prisma"align="center"></td>
						</tr>
						<tr>
							<td colspan="6"><br />Problemas reclamados: <span id="os_problema"></span>
								<span style="float:right;display:none;">Prox.Rev.Gar: <span id="os_garantia"></span></span></td>
						</tr>
					</table>

					<hr />

					<br />

					<table border="1" width="100%">
						<tr>
							<td><small>
								<strong>Observações: </strong>
								<span id="os_observacoes">Observações do serviço.</span></small>
							</td>
						</tr>
					</table>

					<br />

                                        <p><h3> <center><strong>TERMOS E CONDIÇÕES</strong></center></h3></p>

                                        <table border="1" width="100%">
                                                <tr>
							<td><small>
								1 - Não nos responsabilizamos pelo estado e duração da bateria de equipamentos deixados.<br>
								2 - Caso seja aprovado o reparo, após 60 dias da data da finalização do mesmo, V.Sa. será advertido(a), e após 90 dias, o equipamento poderá ser vendido pelo valor do conserto e será perdido o direito a retirada.<br>
								3 - A garantia de um ano do equipamento está vinculada a integridade física do mesmo, não haverá garantia para: Marcas de violação, danos acidentais ou mau uso.<br>
								4 - Aparelhos em sistema de trocas Apple, quando aprovados pelo cliente, herdam a garantia do aparelho anterior ou 90 dias a partir da ativação. Estes aparelhos virão sem os acessórios e em uma embalagem de transporte.<br>
								5 - Os equipamentos serão entregues somente com a apresentação deste recibo (original), ou mediante prévia autorização por e-mail para retirada por terceiros.<br>
								6 - Para orçamentos não aprovados, será cobrada uma hora técnica. (MacBooks R$ 90,00 / MacPro e iMacs R$ 190,00)<br>
								7 - Não nos responsabilizamos por dados ou programas instalados no equipamento.<br>
								8 - Problemas resolvidos com formatação ou reinstalação, será cobrado: MacBooks = R$ 290,00 / MacPros e iMacs = R$ 290,00 / iDevices = R$ 150,00 (SEM PRÉVIA AUTORIZAÇÃO)<br>
								9 - Verifique o status da sua Ordem de Serviço através do site: www.omniinformatica.com.br<br>
							    </small>
                                                        </td>
                                                </tr>
                                        </table>

					<table border="0" width="100%">
						<tr>
							<td colspan="100%" WIDTH="50%"><small><br>
								Atendido por: <span id="os_atendente"></span>
								</small>
							</td>

						</tr>
						<tr>
							<td align="center"><br />_________________________________________________
							</td>
						</tr>
						<tr>
							<td align="center">Assinatura Consultor Apple
							</td>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><strong><br />
								</strong>
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
