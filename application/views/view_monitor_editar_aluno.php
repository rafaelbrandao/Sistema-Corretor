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
		<li>Editar Dados</li>
		<li>Aluno/Monitor</li>
	</ul>
<pre>
<h1>Edição de Dados de <strong>Aluno</strong> (ou <strong>Monitor</strong>)</h1>
Os alunos não possuem essa interface, então qualquer alteração nas informações deles deve ser feitas por intermédio de um monitor. Além de fornecer os novos dados do usuário, você deverá fornecer sua senha, para confirmar as alterações dessas informações. Para <strong>não mudar a senha</strong> desse usuário, basta deixar o campo <strong>Senha</strong> em branco.

Nome: <input type="text" style="width: 200px;" />
Login: <input type="text" style="width: 120px;" />
Senha: <input type="password" style="width: 120px;" />

Email: <input type="text" style="width: 200px;" />

<input type="checkbox" name="admin" value="true"> Marque se este usuário é <strong>Monitor</strong>.

Digite sua senha para confirmar mudanças:
<input type="password" style="width: 120px;" />

<input type="submit" value="Salvar alterações" />

</pre>

</div>
</div>


</body>
</html>
