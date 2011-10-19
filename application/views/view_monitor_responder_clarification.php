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
		<!--<div id="login_button">login</div>-->

		<div id="perfil_button">perfil</div>
		<div id="logout_button">logout</div>

	</ul>
	
</div>

<div id="content">
	<ul id="browse">
		<li>Administrador</li>
		<li>Clarifications</li>
		<li>Responder</li>
	</ul>
<pre>
<h1><strong>L2Q2</strong> - Responder Clarification</h1>
Aqui você pode <strong>confirmar</strong> que o problema descrito no clarification é real e assim criar um clarification que esclarece esse problema, ou você pode <strong>rejeitar</strong> o pedido, caso o problema não exista ou já tenha sido respondido. Só no primeiro caso que a resposta é publicada oficialmente no site e fica visível para todos verem. No segundo, o motivo da recusa será enviado somente por email para o usuário que solicitou.

<h2>Enviado por <strong>nana</strong> em <strong>13/09 12:32</strong></h2>As arestas dadas na entrada são direcionadas? Não entendi!

<h2>Confirmar</h2>Digite o conteúdo do clarification que esclarece o problema descrito.
<textarea rows="4" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Confirmar" />

<h2>Rejeitar</h2>Digite a sua justificativa para recusar este pedido de clarification (será enviado por email ao aluno).
<textarea rows="4" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Rejeitar" />

</pre>

</div>
</div>


</body>
</html>
