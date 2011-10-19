<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>
	<link href="<?=base_url('/css/notas.css')?>" rel="stylesheet" type="text/css"/>

</head>
<body>

<div id="navi">
	<div id="navi_shadow"></div>
	<ul id="navi_options">
		<div id="logo_cin"></div>
		<li>Home</li>
		<li>Avisos</li>
		<li>Cronograma</li>
		<li>Listas</li>
		<li>Material</li>
		<div id="perfil_button">perfil</div>
		<div id="logout_button">logout</div>
	</ul>
	
</div>

<div id="content">
	<ul id="browse">
		<li>Listas</li>
		<li>Notas</li>
		<li>Respostas</li>
	</ul>
	
	
<h1><strong>Lista 1</strong> - Notas</h1>

<pre>Clique em uma nota para ver mais detalhes da mesma, exceto a nota final que é apenas a média das notas das questões.

O prazo de submissão de um pedido de <strong>revisão</strong> vai até <strong>15/09 14:00</strong>. Neste momento, o horário do servidor é <strong>14/09 13:50</strong>.
Para fazer seu pedido de revisão, abra a página que contém o formato de entrada e saída da questão e clique em <strong>Revisão</strong>.

</pre>

<table class='campos'><tr><td class='login'></td><td class='campo'>L1Q1</td><td class='campo'>L1Q2</td><td class='campo'>L1Q3</td><td class='campo'>L1Q4</td><td class='campo'>FINAL</td></tr></table> 
<table class='score'><tr><td class='login'>abcd</td><td class='nota acc'> 100% </td><td class='nota avg'> 58% </td><td class='nota '> 0% </td><td class='nota good'> 81% </td><td class='nota avg'>59%</td></tr></table>
<table class='score'><tr><td class='login'>bcdef</td><td class='nota acc'> 100% </td><td class='nota acc'> 100% </td><td class='nota bad'> 20% </td><td class='nota bad'> 20% </td><td class='nota avg'>60%</td></tr></table>
<table class='score'><tr><td class='login'>rbl</td><td class='nota acc'> 100% </td><td class='nota acc'> 100% </td><td class='nota acc'> 100% </td><td class='nota good'> 80% </td><td class='nota good'>95%</td></tr></table>

<h2>Respostas (entradas e saídas usadas na correção)</h2>

<pre>Clique no nome do arquivo de entrada e de saída para fazer seu download. A sua nota na questão é calculada a partir da média ponderada das notas em cada entrada, e cada uma tem um peso associado. Tempo é o tempo limite de execução.

</pre>

<table class='campos'><tr><td class='login'></td><td class='campo'>entrada</td><td class='campo'>saida</td><td class='campo'>peso</td><td class='campo'>tempo</td></tr></table><table class='score'><tr><td class='login'>L1Q1</td><td class='nota'><a href='./L1Q1E1.in'>E1.in</a></td><td class='nota'><a href='./L1Q1E1.out'>E1.out</a></td><td class='nota avg'>1</td><td class='nota acc'>2 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q1E2.in'>E2.in</a></td><td class='nota'><a href='./L1Q1E2.out'>E2.out</a></td><td class='nota avg'>2</td><td class='nota acc'>3 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q1E3.in'>E3.in</a></td><td class='nota'><a href='./L1Q1E3.out'>E3.out</a></td><td class='nota avg'>2</td><td class='nota acc'>3 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q1E4.in'>E4.in</a></td><td class='nota'><a href='./L1Q1E4.out'>E4.out</a></td><td class='nota avg'>3</td><td class='nota acc'>4 sec</td></tr></table> 
<table class='score'><tr><td class='login'>L1Q2</td><td class='nota'><a href='./L1Q2E1.in'>E1.in</a></td><td class='nota'><a href='./L1Q2E1.out'>E1.out</a></td><td class='nota avg'>1</td><td class='nota acc'>2 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q2E2.in'>E2.in</a></td><td class='nota'><a href='./L1Q2E2.out'>E2.out</a></td><td class='nota avg'>2</td><td class='nota acc'>2 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q2E3.in'>E3.in</a></td><td class='nota'><a href='./L1Q2E3.out'>E3.out</a></td><td class='nota avg'>3</td><td class='nota acc'>2 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q2E4.in'>E4.in</a></td><td class='nota'><a href='./L1Q2E4.out'>E4.out</a></td><td class='nota avg'>4</td><td class='nota acc'>3 sec</td></tr></table> 
<table class='score'><tr><td class='login'>L1Q3</td><td class='nota'><a href='./L1Q3E1.in'>E1.in</a></td><td class='nota'><a href='./L1Q3E1.out'>E1.out</a></td><td class='nota avg'>2</td><td class='nota acc'>3 sec</td></tr><tr><td class='login'><td class='nota'><a href='./L1Q3E2.in'>E2.in</a></td><td class='nota'><a href='./L1Q3E2.out'>E2.out</a></td><td class='nota avg'>2</td><td class='nota acc'>4 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q3E3.in'>E3.in</a></td><td class='nota'><a href='./L1Q3E3.out'>E3.out</a></td><td class='nota avg'>3</td><td class='nota acc'>5 sec</td></tr></table> 
<table class='score'><tr><td class='login'>L1Q4</td><td class='nota'><a href='./L1Q4E1.in'>E1.in</a></td><td class='nota'><a href='./L1Q4E1.out'>E1.out</a></td><td class='nota avg'>1</td><td class='nota acc'>4 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q4E2.in'>E2.in</a></td><td class='nota'><a href='./L1Q4E2.out'>E2.out</a></td><td class='nota avg'>2</td><td class='nota acc'>4 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q4E3.in'>E3.in</a></td><td class='nota'><a href='./L1Q4E3.out'>E3.out</a></td><td class='nota avg'>3</td><td class='nota acc'>5 sec</td></tr><tr><td class='login'></td><td class='nota'><a href='./L1Q4E4.in'>E4.in</a></td><td class='nota'><a href='./L1Q4E4.out'>E4.out</a></td><td class='nota avg'>2</td><td class='nota acc'>4 sec</td></tr></table>


</div>
</div>


</body>
</html>
