

	<ul id="browse">
		<li>Listas</li>
		<li>Notas</li>
		<li>Respostas</li>
	</ul>
	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>IF672 [CIn-UFPE]</title>

	<link href="<?=base_url('/css/notas.css')?>" rel="stylesheet" type="text/css"/>

</head>
<body>
<?
$list_number = $this->uri->segment(3);
$list_name = $this->lists->get_list_name($list_number);
$problems = $this->problems->get_problems_from_list($list_number);
$students = $this->user->retrieve_list_students_order();
?>

<h1><strong><?=$list_name?></strong> - Notas</h1>
<pre>
Clique em uma nota para ver mais detalhes da mesma, exceto a nota final que é apenas a média das notas das questões.

O prazo de submissão de um pedido de <strong>revisão</strong> vai até ... . Nesse momento, o horário do servidor é <strong><?=date('j/n G:i')?></strong>.
Para fazer seu pedido de revisão, abra a página que contém o formato de entrada e saída da questão e clique em <strong>Revisão</strong>.

[Add links para revisao e data da revisao]
</pre>

<table class='campos'><tr><td class='login'></td>

<?
foreach($problems as $problem){?>

	<td class='campo'><?=$list_name."Q".$problem['numero']?></td>

<?
}
?>

<td class='campo'>FINAL</td></tr></table>

<?
foreach($students as $user){
$score_final=0;
?>

<table class='score'><tr><td class='login'><?=$user['login']?></td>

<?

	foreach($problems as $problem){
		$user_score = $this->score->score_user_problem($problem['id_questao'], $user['login']);
		$problem_weight = $this->score->sum_weights_problem($problem['id_questao']);
		$score_pro = ($user_score/$problem_weight)*10;
		$score_final += $score_pro;
?>


<td class=' <?=$this->score->get_css_type($score_pro)?> ' onclick="window.location='<?=base_url('/index.php/home/score_detail/'.$list_number.'/'.$problem['id_questao'].'/'.$user['login'])?>'"> <?=sprintf("%.2f", $score_pro)?>% </td>

<?
	}
$score_final = $score_final/sizeof($problems);
?>	
<td class=' <?=$this->score->get_css_type($score_final)?>'><?=sprintf("%.2f", $score_final)?>%</td></tr></table>
<?
}
?>

<h2>Respostas (entradas e saídas usadas na correção)</h2>
<pre>
Clique no nome do arquivo de entrada e de saída para fazer seu download. A sua nota da questão é calculada a partir da média ponderada das notas em cada entrada, e cada uma tem um peso associado. Tempo é o limite de execução.
</pre>

<table class='campos'><tr><td class='login'></td><td class='campo'>entrada</td><td class='campo'>saida</td><td class='campo'>peso</td><td class='campo'>tempo</td></tr></table>

<table class='score'><tr><td class='login'>L0Q1</td><td class='nota'><a href='./L0Q1E1.in'>E1.in</a></td><td class='nota'><a href='./L0Q1E1.out'>E1.out</a></td><td class='nota avg'>3</td><td class='nota acc'>3 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L0Q1E2.in'>E2.in</a></td><td class='nota'><a href='./L0Q1E2.out'>E2.out</a></td><td class='nota avg'>4</td><td class='nota acc'>2 sec</td></tr></table>
<table class='score'><tr><td class='login'>L0Q2</td><td class='nota'><a href='./L0Q2E1.in'>E1.in</a></td><td class='nota'><a href='./L0Q2E1.out'>E1.out</a></td><td class='nota avg'>5</td><td class='nota acc'>2 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L0Q2E2.in'>E2.in</a></td><td class='nota'><a href='./L0Q2E2.out'>E2.out</a></td><td class='nota avg'>15</td><td class='nota acc'>2 sec</td></tr></table>
</tr></table>

[Implementar essa parte]


</body>

