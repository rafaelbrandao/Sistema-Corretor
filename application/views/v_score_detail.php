<?
$list_number = $this->uri->segment(3);
$list_name = $this->lists->get_list_name($list_number);
$problem_number = $this->uri->segment(4);
$problem = $this->problems->get_data_for_problem($problem_number);
$user = $this->uri->segment(5);
$problem_string = $list_name.'Q'.$problem['numero'];
$solutions = $this->score->get_peso_tempo($problem_number);
$i=1;
$days_bonus = $this->submissions->get_days_bonus($list_number, $problem_number, $user);
$days_bonus = max(0, $days_bonus);
$days_bonus = min(5, $days_bonus);
$bonus = $days_bonus*0.03;


?>

	<ul id="browse">
		<li>Listas</li>
		<li>Notas</li>
		<li><?=$problem_string?></li>
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
		$nota_rows = $this->score->get_nota_user($problem_number, $user, $solution['id']);
		$nota = sizeof($nota_rows) > 0 ? $nota_rows[0]['nota'] : 0;
		if(sizeof($nota_rows) == 0)
			$msg = "Não Entregou";
		

?>

<strong><?='E'.$i++?></strong>:
	Nota:  <strong><?=sprintf("%.2f", $nota/100)?></strong>, com bônus <strong><?=$bonus*100?>%</strong>: <strong><?=sprintf("%.2f", $nota/100*($bonus + 1))?></strong>.
	Observação: <strong><?=$msg?></strong>.
<?
	}
?>

</pre>

