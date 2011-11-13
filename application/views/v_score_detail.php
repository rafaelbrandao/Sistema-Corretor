<?
$list_number = $this->uri->segment(3);
$list_name = $this->lists->get_list_name($list_number);
$problem_number = $this->uri->segment(4);
$problem = $this->problems->get_data_for_problem($problem_number);
$user = $this->uri->segment(5);
$problem_string = $list_name.'Q'.$problem['numero'];

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
</pre>



</body>

