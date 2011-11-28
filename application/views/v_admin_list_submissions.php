<?
if (!isset($problem_id)) $problem_id = 0;
$filename = $this->problems->get_problem_repr($problem_id);
$logins = $this->submissions->logins_for_problem($problem_id);
?>

<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/monitor')?>'">Administrador</li>
	<li>Submissões</li>
</ul>
<pre>
<h1><strong><?=$filename?></strong> - Lista de Submissões</h1>
Nesta seção você terá a lista de submissões enviadas para essa questão da lista. Você pode baixar o código fonte ou editar uma submissão (caso queira aplicar alguma penalidade na nota ou queira checar se houve erro de compilação).
<? foreach ($logins as $login) {
	$submit = $this->submissions->last_submission_basic_data($problem_id, $login);
	$ext = $this->datahandler->file_extension_for_language($submit['linguagem']);
	$date = $submit['data_submissao'];
	$time = strtotime($date);
?>

	<strong><?=$login?></strong> - enviado em <strong><?=$this->datahandler->translate_date_format($date)?></strong> [ <a href="<?=base_url('/index.php/monitor/download_src/'.$problem_id.'/'.$login.'/'.$time)?>"><?=$filename?>.<?=$ext?></a> / <a href="<?=base_url('/index.php/monitor/edit_submission/'.$problem_id.'/'.$login.'/'.$time)?>">editar</a> ]
<? } ?>



</pre>
