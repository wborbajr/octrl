<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OMNI INFORMÁTICA - RECIBO DE ENTREGA</title>
    <script src="js/jquery.min.js"></script>

	<link rel="stylesheet" href="css/style.css">

	<script>
		function printThis(){
			// javascript:parent.jQuery.fancybox.close();
      parent.$.fancybox.getInstance().close();
			window.print();
		}
	</script>

  </head>
  <body>

	<a href="javascript:printThis();" style="float:right;padding-right:10px;"> [ Imprimir e Fechar X ] </a>

	<table border="0" style="margin:0 auto;width:850px;" id="os_corpo">

		<thead>
			<tr>
				<td>
					<table border="1" width="100%" cellpadding="10">
				<th colspan="*" id="cabecalho">
					<span class="esquerda">
						<img src="img/logo144x58.png" class="logo" />
						<label class="institucional">
						<?php


	                        // curitiba
                            if ($_SESSION[login][localid] == 7)
		                        require( '7.inc.php' );

	                        // londrina
                            if ($_SESSION[login][localid] == 9)
		                        require( '9.inc.php' );

	                        // natal
                            if ($_SESSION[login][localid] == 1)
		                        require( '1.inc.php' );


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

<?php
	include("os_print.inc.php");
?>
