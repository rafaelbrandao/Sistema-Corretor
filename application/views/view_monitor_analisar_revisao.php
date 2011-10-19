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
		<li>Revisões</li>
		<li>Analisar</li>
	</ul>
<pre>
<h1>Analisar Revisão</h1>
O processo de revisão é feito manualmente. Você faz o download da solicitação de revisão que deve estar no formato proposto na disciplina, faz o download do código fonte do aluno na questão, aplica as alterações no código, e depois submete o novo código ao confirmar. Ao rejeitar o pedido você pode opcionalmente colocar uma mensagem que será recebida pelo aluno por email. 

<h2><strong>L1Q4</strong> - Enviado por <strong>rbl</strong> em <strong>12/08 14:50</strong></h2>Download [ <a href="a">L1Q4.cpp</a> / <a href="a">L1Q4.revisao</a> ]

<h2>Confirmar</h2>Selecione o arquivo com o novo código fonte (após aplicada as mudanças propostas pelo aluno):

<input type="file" name="codigofonte" style="width: 200px;" text="selecionar" />
<input type="checkbox" name="admin" value="true"> Recorrigir esta questão após as alterações.

<input type="submit" value="Confirmar" />

<h2>Rejeitar</h2>Digite a sua justificativa para recusar este pedido de revisão (será enviado por email ao aluno).
<textarea rows="4" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>
<input type="submit" value="Rejeitar" />

</pre>

</div>
</div>


</body>
</html>
