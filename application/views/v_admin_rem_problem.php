<?
if (!isset($problem_id)) $problem_id = 0;
if (!isset($list)) $list = array();
if (!isset($filename)) $filename = '';
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/lists')?>'">Listas</li>
	<li>Remover Questão</li>
</ul>
<pre>
<?=form_open(base_url('/index.php/monitor/rem_problem/'.$problem_id.'/confirm'))?>
<h1><strong><?=$list['nome_lista']?></strong> - Remover Questão</h1>
Você está tentando remover a questão <strong><?=$filename?></strong>. Deseja realmente removê-la? Se não quiser, basta voltar para a página anterior. Entretanto, se deseja prosseguir, digite sua senha para confirmar a remoção.

Senha: <input name="pwd" type="password" style="width: 120px;" />
<input type="submit" value="Remover" /></form>

</pre>
