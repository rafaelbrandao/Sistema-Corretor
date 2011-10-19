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
		<li>Cadastro</li>
		<li>Remover</li>
	</ul>
<pre>
<h1>Remover Cadastro</h1>
Você está tentando remover o cadastro do usuário com login <strong>abcd</strong>. Deseja realmente removê-lo? Se não quiser, basta voltar para a página anterior. Entretanto, se deseja prosseguir, digite sua senha para confirmar a remoção.

Senha: <input type="password" style="width: 120px;" />
<input type="submit" value="Remover" />

</pre>

</div>
</div>


</body>
</html>
