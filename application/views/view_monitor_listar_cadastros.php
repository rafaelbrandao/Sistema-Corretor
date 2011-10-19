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
		<li>Solicitações</li>
	</ul>
<pre>
<h1>Lista de Cadastros Pendentes</h1>
Nesta seção você terá a lista de usuários que solicitaram cadastro no sistema e que estão aguardando aprovação. Ao aceitar ou rejeitar um pedido de cadastro, o usuário que solicitou será informado da decisão através de seu email (informado no cadastro). Fique atento porque a operação de rejeitar um cadastro não pedirá confirmação para conclui-la.


<strong>loginErrado@teste</strong> [ <a href="oi">aceitar</a> / <a href="oi">rejeitar</a> ]
	Nome: <strong>Nome Totalmente Errado</strong>
	Email: <strong>loginErrado@teste@cin.ufpe.br</strong>

<strong>nomeerrado</strong> [ <a href="oi">aceitar</a> / <a href="oi">rejeitar</a> ]
	Nome: <strong>email@gmail.com</strong>
	Email: <strong>nomeerrado@cin.ufpe.br</strong>

<strong>lala</strong> [ <a href="oi">aceitar</a> / <a href="oi">rejeitar</a> ]
	Nome: <strong>Lais Alencar Luna Amorim</strong>
	Email: <strong>lala@cin.ufpe.br</strong>

</pre>

</div>
</div>


</body>
</html>
