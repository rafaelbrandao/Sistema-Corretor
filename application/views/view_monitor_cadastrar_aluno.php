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
		<li>Aluno/Monitor</li>
	</ul>
<pre>
<h1>Cadastro de <strong>Aluno</strong> (ou <strong>Monitor</strong>)</h1>
É recomendado que os alunos solicitem seus próprios cadastros ao invés de serem cadastrados por monitores. O email do aluno será preenchido automaticamente, após inserido o login, com o email do CIn, mas você poderá alterá-lo se necessário.

Nome: <input type="text" style="width: 200px;" />
Login: <input type="text" style="width: 120px;" />
Senha: <input type="password" style="width: 120px;" />

Email: <input type="text" style="width: 200px;" />

<input type="checkbox" name="admin" value="true"> Marque esta opção para cadastrar como <strong>Monitor</strong>.

<input type="submit" value="Cadastrar" />

</pre>

</div>
</div>


</body>
</html>
