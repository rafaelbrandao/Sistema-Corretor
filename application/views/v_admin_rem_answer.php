<?
if (!isset($list)) $list = array();
if (!isset($judge_input)) $judge_input = array();
if (!isset($input_num)) $input_num = 0;
if (!isset($filename)) $filename = '';
?>

<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/lists')?>'">Listas</li>
	<li>Remover Entrada</li>
</ul>
<pre>
<?=form_open(base_url('/index.php/monitor/rem_answer/'.$judge_input['id_correcao'].'/confirm'))?>
<h1><strong><?=$list['nome_lista']?></strong> - Remover Entrada do Corretor</h1>
Você está tentando remover a entrada do corretor <strong><?=$filename.'E'.$input_num?></strong>. Deseja realmente removê-la? Se não quiser, basta voltar para a página anterior. Entretanto, se deseja prosseguir, digite sua senha para confirmar a remoção.

Senha: <input name='pwd' type="password" style="width: 120px;" />
<input type="submit" value="Remover" /></form>

</pre>
