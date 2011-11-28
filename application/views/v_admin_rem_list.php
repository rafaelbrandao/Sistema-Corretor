<?
if (!isset($list_id)) $list_id = '';
if (!isset($listprefix)) $listprefix = '';
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/lists')?>'">Listas</li>
	<li>Remover Lista</li>
</ul>
<pre>
<h1><strong>Lista <?=$listprefix?></strong> - Remover Lista</h1>
Você está tentando remover a lista <strong><?=$listprefix?></strong>. Deseja realmente removê-la? Se não quiser, basta voltar para a página anterior. Entretanto, se deseja prosseguir, digite sua senha para confirmar a remoção.

<?=form_open(base_url('/index.php/monitor/rem_list/'.$list_id.'/confirm'))?>
Senha: <input name='confirm_pwd' type="password" style="width: 120px;" />
<input type="submit" value="Remover" /></form>

</pre>
