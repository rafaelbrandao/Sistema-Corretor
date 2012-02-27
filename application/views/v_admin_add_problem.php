<?
if (!isset($list_id)) $list_id = '';
if (!isset($listprefix)) $listprefix = '';
if (!isset($problem_num)) $problem_num = '';
?>

<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li onclick="document.location = '<?=base_url('/index.php/monitor/lists')?>'">Listas</li>
	<li>Criar Questão</li>
</ul>
<pre>
<h1><strong>Lista '<?=$listprefix?>'</strong> - Criar Questão</h1>
Para criar uma questão você só precisa especificar seu número. Uma vez com a questão criada, você pode editá-la da maneira que quiser. O número definido aqui servirá para ordenar as questões, assim a questão de número 3 poderá ser inserida antes da primeira sem influir na configuração final.

<?=form_open(base_url('/index.php/monitor/add_problem/'.$list_id))?>
Número: <input name='problem_num' value="<?=$problem_num?>" type="text" style="width: 20px;" />

<input type="submit" value="Criar" /></form>

</pre>
