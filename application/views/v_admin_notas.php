
	<ul id="browse">
		<li>Administrador</li>
		<li>Notas</li>
	</ul>
	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>
	<link href="<?=base_url('/css/notas_semestre.css')?>" rel="stylesheet" type="text/css"/>

</head>

<body>	
	
<h1>Notas do Semestre (Listas de Exercícios)</h1>

<pre>Aqui você tem acesso às notas de todas as listas, de todos os alunos cadastrados no sistema. Você pode também exportar para alguma planilha de texto, clicando <a href="download_notas">aqui</a>. À medida que novas listas forem criadas e finalizadas, elas vão aparecer aqui.

</pre>

<table class='campos'><tr><td class='login'></td><td class='campo'>login</td>

<?

$students = $this->user->retrieve_list_students_order();
$lists = $this->lists->get_all_available_lists_asc();

foreach($lists as $lista)
{
?>

<td class='campo'><?=$lista['nome_lista']?></td>
<?
}
?>

</tr></table>

<?


foreach($students as $user)
{

?>

<table class='score'><tr><td class='login'><?=$user['nome']?></td><td class='nota'><?=$user['login']?></td>

<?
	
	foreach($lists as $lista)
	{
		$score_final=0;
		$list_name = $lista['nome_lista'];
		$problems = $this->problems->get_problems_from_list($lista['id_lista']);
		foreach($problems as $problem){
			$user_score = $this->score->score_user_problem($problem['id_questao'], $user['login']);
			$problem_weight = $this->score->sum_weights_problem($problem['id_questao']);
			$days_bonus = $this->submissions->get_days_bonus($lista['id_lista'], $problem['id_questao'], $user['login']);
			$days_bonus = max(0, $days_bonus);
			$days_bonus = min(5, $days_bonus);
			$bonus = $days_bonus*0.03;
			$score_pro = $problem_weight != 0 ? ($user_score/$problem_weight)/10*($bonus + 1) : 0;
			$score_final += $score_pro;
		}
		if(sizeof($problems) == 0) $score_final = 0;
		else $score_final = $score_final/sizeof($problems);

?>

<td class=' <?=$this->score->get_css_type($score_final)?> ' ><?=sprintf("%.2f", $score_final)?>%</td>

<?
	}
	
?>

</tr></table>

<?
}

?>


</div>
</div>
