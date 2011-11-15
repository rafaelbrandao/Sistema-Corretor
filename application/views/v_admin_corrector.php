
<ul id="browse">
	<li>Administrador</li>
	<li>Sistema Corretor</li>
</ul>

<div id="corretor_escolha">
	<pre>
	Para corrigir uma lista, selecione-a no combobox e aperte em Corrigir. A correção poderá levar vários minutos, atualize a página para saber se já foi concluída. Apenas inicie uma correção após se certificar de que todos os dados estão corretos, pois não será possível interromper a correção, e um novo pedido só entrará em andamento após o anterior ter sido concluído.
	</pre>
	<?=form_open(base_url('/index.php/monitor/submit/'.$oi))?>
Corrigir Lista: <select name='corrigirLista'>
<option value="3" >L4</option>
<option value="1" >L2</option>
<option value="2" >L3</option>
</select>
		 <input type="submit" value="Corrigir" style="margin-left: 40px; width: 60px;"/></form>	
</div>
	
<table>
	
	<tbody >
		<tr class="corretor_pedido_cabecalho">
			<td class="item" style="width:230px; height:100%;">Data do Pedido de Correção</td>
			<td class="item" style="width:150px;"> Lista </td>
			<td class="item" style="width:150px;"> Estado </td>
			<td class="item" style="width:150px;">Pega-Cópias</td>
		</tr>
		
		<tr class="corretor_pedido">
			<td class="item" style="width:230px; height:100%;">12-10-2011 10:10:10</td>
			<td class="item" style="width:150px;"> L2 </td>
			<td class="item" style="width:150px;"> Em Andamento </td>
			<td class="item" style="width:150px;">relatorio.txt</td>
		</tr>
		<tr class="corretor_pedido_feito">
			<td class="item" style="width:230px;  height:100%;">12-10-2011 10:10:10</td>
			<td class="item" style="width:150px;"> L1 </td>
			<td class="item" style="width:150px;"> Corrigido </td>
			<td class="item" style="width:150px;"> <a href="oi.txt">relatorio.txt </a> </td>
		</tr>
	</tbody>
</table>
