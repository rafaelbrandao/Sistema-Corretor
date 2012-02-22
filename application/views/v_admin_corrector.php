<?
if (!isset($listas)) $listas = array();
if (!isset($correcoes)) $correcoes = array();
?>

<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li>Corretor</li>
</ul>

<div id="corretor_escolha">
	<pre>
	Para corrigir uma lista, selecione-a no combobox e aperte em Corrigir. A correção poderá levar vários minutos, atualize a página para saber se já foi concluída. Apenas inicie uma correção após se certificar de que todos os dados estão corretos, pois não será possível interromper a correção, e um novo pedido só entrará em andamento após o anterior ter sido concluído.
	Se o estado da última correção permanecer mais do que 5 minutos em 'Aguardando Corretor', há a necessidade de iniciar o Corretor.jar, pois provavelmente ele não está em funcionamento.
	</pre>
	<?=form_open(base_url('/index.php/monitor/submit_correct_request'))?>
	Corrigir Lista: <select name='corrigirLista'>
		<?
			foreach ($listas as $lista) {
		?>
			<option value="<?= $lista['id_lista'] ?>" ><?= $lista['nome_lista'] ?></option>
		<?
			}
		?>
	</select>
	 <input type="submit" value="Corrigir" style="margin-left: 40px; width: 60px;"/></form>	
</div>
	
<table style="position:absolute; top:220px;">
	
	<tbody >
		<tr class="corretor_pedido_cabecalho">
			<td class="item" style="width:230px; height:100%;">Data do Pedido de Correção</td>
			<td class="item" style="width:150px;"> Lista </td>
			<td class="item" style="width:150px;"> Estado </td>
			<td class="item" style="width:150px;">Pega-Cópias</td>
		</tr>
		
		<?
			foreach ($correcoes as $cor) {
				$classFeito = '';
				$mensagemStatus = 'Aguardando Corretor';
				if($cor['estado'] == 'Feito') {
					$classFeito = '_feito';
					$mensagemStatus = 'Corrigido';
				} else if($cor['estado'] == 'Em Andamento'){
					$mensagemStatus = 'Em Andamento';
				}
		?>
				<tr class="corretor_pedido<?= $classFeito ?>">
				<td class="item" style="width:230px; height:100%;"><?= $cor['data_pedido'] ?></td>
				<td class="item" style="width:150px;"> <?= $cor['nome_lista'] ?> </td>
				<td class="item" style="width:150px;"> <?= $mensagemStatus ?> </td>
				<td class="item" style="width:150px;"> <?
				if($cor['estado'] == 'Feito'){ ?>
					<a href="<?=base_url('/index.php/monitor/get_copycatch_report/'.$cor['id_corretor'])?>">
					relatorio.txt</a>
				<? } else { ?>
					relatorio.txt
				<? } ?>
			</td>
		</tr>
		<? } ?>
	</tbody>
</table>
