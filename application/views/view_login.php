<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>
	
<script type="text/javascript">
	function showLogin() {
		document.getElementById('login_div').style.opacity = 1;
		document.getElementById('register_div').style.opacity = 0.25;
	}
	
	function showRegister() {
		document.getElementById('login_div').style.opacity = 0.25;
		document.getElementById('register_div').style.opacity = 1;
	}
</script>

</head>
<body>

<div id="notice_box" style="visibility: hidden;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';">Cadastro solicitado com sucesso. Seu pedido será analisado pelos monitores. Por favor, aguarde confirmação por email.</div></div>
<div id="error_box" style="visibility: visible;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';">Login e/ou senha inválidos.</div></div>

<div id="navi">
	<div id="navi_shadow"></div>
	<ul id="navi_options">
		<div id="logo_cin"></div>
		<li>Home</li>
		<li>Avisos</li>
		<li>Cronograma</li>
		<li>Listas</li>
		<li>Material</li>
		<div id="login_button">login</div>
		<!--
		<div id="perfil_button">perfil</div>
		<div id="logout_button">logout</div>
		<!-- -->
	</ul>
	
</div>

<div id="content">
	<ul id="browse">
		<li onclick="showLogin();">Login</li>
		<li onclick="showRegister();">Cadastro</li>
	</ul>
<pre>
<div id="login_div"><h1>Login</h1>Caso você ainda não esteja cadastrado, <strong onclick="showRegister();" style="cursor:pointer;">clique aqui</strong>. Digite o login que você escolheu ao se cadastrar e sua respectiva senha para logar no sistema.

<div id="login_block">Login: <input type="text" style="position: absolute; right: 0px; width: 200px;"/>
Senha: <input type="password" style="position: absolute; right: 0px; width: 200px;"/>
<input type="submit" value="Enviar" style="position: absolute; right: 0px;"/>
</div></div>
<!--<div id="register_div"><h1>Cadastro</h1>Preencha com seu nome completo, seu <strong>login do CIn</strong> e, finalmente, crie uma senha para usar neste sistema. Seu email será no formato <strong>login@cin.ufpe.br</strong>.

<div id="register_block">Nome: <input type="text" style="position: absolute; right: 0px; width: 200px;"/>
Login: <input type="text" style="position: absolute; right: 0px; width: 200px;"/>
Senha: <input type="password" style="position: absolute; right: 0px; width: 200px;"/>
Email: <input type="text" style="position: absolute; right: 0px; width: 200px;" disabled="disabled" value="rbl@cin.ufpe.br"/>
<input type="submit" value="Enviar" style="position: absolute; right: 0px;"/>
</div>
</div>-->

</pre>

</div>
</div>


</body>
</html>
