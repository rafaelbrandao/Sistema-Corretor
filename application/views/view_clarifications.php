<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>

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
		<!-- <div id="login_button">login</div> -->
		<div id="perfil_button">perfil</div>
		<div id="logout_button">logout</div>
	</ul>
	
</div>

<div id="content">
	<ul id="browse">
		<li>Listas</li>
		<li>Clarifications</li>
	</ul>
	
	
<h1><strong>Lista 2</strong> - Clarifications Confirmados</h1>

<pre>Nesta seção, todos os clarifications referentes a esta lista e que já foram confirmados serão listados aqui.

<strong>[13/09 13:00] [L2Q2]</strong> As arestas dadas na entrada são <strong>direcionadas</strong>.
<strong>[12/09 09:00] [L2Q1]</strong> O balance da segunda saída foi corrigida, ao invés de 1 era pra ser 2 por causa da propriedade definida pela questão como balanceado.
<strong>[11/09 21:33] [L2Q2]</strong> Alice e Bob não são irmãos, mas isso não é relevante na questão.

</pre>

<h1><strong>Lista 2</strong> - Clarifications Pendentes</h1>
<pre>Aqui será listado todos os clarifications enviados para essa lista e que ainda não foram confirmados pelos monitores.

<strong>[13/09 14:52] [L2Q2]</strong> Se houver dois nós, A e B, e duas arestas, uma de A até B e outra de B até A, isso pode ser considerado uma árvore? Em outras palavras, isso deve ser considerado um ciclo? Ou eu devo assumir que as arestas de uma árvore podem ser bidirecionais??

</pre>

<h1><strong>Lista 2</strong> - Solicitar Clarification</h1>
<pre>Antes de solicitar um novo clarification, faça a releitura da questão e verifique se alguém já solicitou algum clarification relacionado e que foi confirmado ou que ainda esteja pendente, para evitar repetição de perguntas que já foram respondidas.

Questão: <select name="questao">
	<option value="L2Q1">L2Q1</option>
	<option value="L2Q2">L2Q2</option>
	<option value="L2Q3">L2Q3</option>
	<option value="L2Q4">L2Q4</option>
</select>
<textarea rows="3" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;">Alguém pode responder meu clarification anterior?</textarea>
<input type="submit" value="Enviar" style="position: relative; left: 548px; width: 60px;" />
</pre>


</div>
</div>


</body>
</html>
