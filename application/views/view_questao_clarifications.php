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
		<li>L2Q2</li>
		<li>Clarifications</li>
	</ul>
	
	
<h1><strong>L2Q2</strong> - Clarifications Confirmados</h1>

<pre>Nesta seção, todos os clarifications já confirmados serão listados aqui.

<strong>[13/09 13:00]</strong> As arestas dadas na entrada são <strong>direcionadas</strong>.
<strong>[11/09 21:33]</strong> Alice e Bob não são irmãos, mas isso não é relevante na questão.

</pre>

<h1><strong>L2Q2</strong> - Clarifications Pendentes</h1>
<pre>Aqui será listado todos os clarifications enviados para essa questão e que ainda não foram confirmados pelos monitores.

<strong>[13/09 14:52]</strong> Se houver dois nós, A e B, e duas arestas, uma de A até B e outra de B até A, isso pode ser considerado uma árvore? Em outras palavras, isso deve ser considerado um ciclo? Ou eu devo assumir que as arestas de uma árvore podem ser bidirecionais??

</pre>

<h1><strong>L2Q2</strong> - Solicitar Clarification</h1>
<pre>Antes de solicitar um novo clarification, faça a releitura da questão e verifique se alguém já solicitou algum clarification relacionado e que foi confirmado ou que ainda esteja pendente, para evitar repetição de perguntas que já foram respondidas.

<textarea rows="3" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;">Alguém pode responder meu clarification anterior?</textarea>
<input type="submit" value="Enviar" style="position: relative; left: 548px; width: 60px;" />
</pre>


</div>
</div>


</body>
</html>
