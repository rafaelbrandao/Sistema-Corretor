<?
if (!isset($list_id)) $list_id = 0;
if (!isset($problem_id)) $problem_id = 0;
if (!isset($user)) $user = '';

$list_name = $this->lists->get_list_name($list_id);
$problem = $this->problems->get_data_for_problem($problem_id);
$problem_string = $list_name.'Q'.$problem['numero'];
$solutions = $this->score->get_peso_tempo($problem_id);
$bonus = $this->score->get_bonus_modifier($problem_id, $user, $list_id);

$i = 1;
?>
<ul id="browse">
	<li onclick="document.location = '<?=base_url('/index.php/home/lists')?>'">Listas</li>
	<li onclick="document.location = '<?=base_url('/index.php/home/score/'.$list_id)?>'">Notas</li>
	<li>Detalhes</li>
</ul>
	
<body>


<h1><strong><?=$problem_string?></strong> - Detalhes da Nota</h1>
<pre>
A seguir os detalhes da nota da questão <strong><?=$problem_string?></strong> feita por <strong><?=$user?></strong>.

Cada entrada é executada separadamente, e o cálculo final da nota na questão é o resultado da média ponderada dessas notas. O peso de cada entrada é apresentado na página das <strong>Notas</strong> e você pode baixar cada entrada e saída esperada para testar na sua máquina, com seu código enviado e descobrir a razão da falha (se houver).

<?
	foreach($solutions as $solution)
	{
		$msg = "nenhuma";
		$nota_rows = $this->score->get_nota_user($problem_id, $user, $solution['id']);
		$nota = sizeof($nota_rows) > 0 ? $nota_rows[0]['nota'] : 0;
		if(sizeof($nota_rows) == 0)
			$msg = "Não Entregou";
		if ($this->submissions->has_invalid_for_list($list_id, $user))
			$msg = "Lista zerada";
?>

<strong><?='E'.$i++?></strong>:
	Nota:  <strong><?=sprintf("%.2f", $nota/100)?></strong>, com bônus <strong><?=($bonus-1.0)*100?>%</strong>: <strong><?=sprintf("%.2f",min(($nota*$bonus)/100.0, 10.0))?></strong>.
	Observação: <strong><?=$msg?></strong>.
<?
	}
?>

</pre>

