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
		<li>Criar Lista</li>
	</ul>
<pre>
<h1>Criar Lista</h1>
Para os campos <strong>Inicio</strong> e <strong>Prazo</strong>, coloque a data no formato "<strong>DD/MM HH:mm</strong>", por exemplo: <strong>13/09 13:50</strong>. Se não quiser especificá-las agora, deixe-as em branco. Uma lista só estará disponível para o público quando essas duas datas estiverem bem definidas (e depois da data de lançamento da lista).

Lista #: <input type="text" style="width: 20px;" />
Inicio: <input type="text" style="width: 100px;" />
Prazo: <input type="text" style="width: 100px;" />

<input type="submit" value="Criar" />

</pre>

</div>
</div>


</body>
</html>
