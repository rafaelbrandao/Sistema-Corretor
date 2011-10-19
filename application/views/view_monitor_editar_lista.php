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
		<li>Listas</li>
		<li>Editar Lista</li>
	</ul>
<pre>
<h1><strong>Lista 2</strong> - Editar Lista</h1>
Para os campos <strong>Inicio</strong> e <strong>Prazo</strong>, coloque a data no formato "<strong>DD/MM HH:mm</strong>", por exemplo: <strong>13/09 13:50</strong>. Da mesma forma para os campos <strong>Revisão (início)</strong> e <strong>Revisão (prazo)</strong>. Se não quiser modificá-los agora, basta manter os valores atuais inalterados.

Uma lista só estará disponível para o público quando das datas de inicio e prazo estiverem bem definidas (e depois da data de lançamento da lista). Da mesma forma para as revisões dessa lista, que só estará disponível para os alunos quando as duas datas forem definidas.

Inicio: <input type="text" style="width: 100px;" />
Prazo: <input type="text" style="width: 100px;" />
Revisão (inicio): <input type="text" style="width: 100px;" />
Revisão (prazo): <input type="text" style="width: 100px;" />

<input type="submit" value="Salvar alterações" />

</pre>

</div>
</div>


</body>
</html>
