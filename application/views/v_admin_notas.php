<?
if (!isset($students)) $students = $this->user->retrieve_list_students_order();
if (!isset($lists)) $lists = $this->lists->get_all_available_lists_asc();

$graded_students = $this->score->final_scores_for_lists($lists, $students);
?>

<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li>Notas</li>
</ul>

<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('/css/notas_semestre.css')?>" rel="stylesheet" type="text/css"/>
	
<h1>Notas do Semestre (Listas de Exercícios)</h1>
<pre>Aqui você tem acesso às notas de todas as listas, de todos os alunos cadastrados no sistema. Você pode também exportar para alguma planilha de texto, clicando <a href="download_notas">aqui</a>. À medida que novas listas forem criadas e finalizadas, elas vão aparecer aqui.
</pre>

<table class='campos'>
<tr>
	<td class='login'></td>
	<td class='campo'>login</td>
	<? foreach($lists as $list) { ?>
		<td class='campo'><?=$list['nome_lista']?></td>
	<? } ?>
</tr>
</table>

<? foreach ($graded_students as $user) { ?>
	<table class='score'>
	<tr>
		<td class='login'><?=$user['nome']?></td>
		<td class='nota'><?=$user['login']?></td>
		<? foreach ($lists as $list) { ?>
			<td class=' <?=$this->score->get_css_type($user['final_results'][ $list['id_lista'] ])?> ' ><?=sprintf("%.2f", $user['final_results'][ $list['id_lista'] ])?>%</td>
		<? } ?>
	</tr>
	</table>
<? } ?>

