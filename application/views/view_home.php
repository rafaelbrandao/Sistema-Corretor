<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>

</head>
<body>

<div id="notice_box" style="visibility: visible;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';">Cadastro solicitado com sucesso. Seu pedido será analisado pelos monitores. Por favor, aguarde confirmação por email.</div></div>
<div id="error_box" style="visibility: hidden;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';">Oh shit!</div></div>

<div id="navi">
	<div id="navi_shadow"></div>
	<ul id="navi_options">
		<div id="logo_cin"></div>
		<li class="selected">Home</li>
		<li>Avisos</li>
		<li>Cronograma</li>
		<li>Listas</li>
		<li>Material</li>
		<div id="login_button">login</div>
		<!--
		<div id="perfil_button">perfil</div>
		<div id="logout_button">logout</div>
		-->
	</ul>
	
</div>

<div id="content">
	<ul id="browse">
		<li>Home</li>
	</ul>
<pre>
<h1>IF672 - Algoritmos e Estruturas de Dados</h1>
Período: <strong>2011.2</strong>
Local: <strong>D004</strong>
Horário:
	<strong>Terças (08:00 - 10:00)</strong>
	<strong>Quintas (10:00 - 12:00)</strong>
	
Aula prática:
	<strong>Terças (12:00 - 13:00)</strong>

Email da disciplina (para dúvidas e informações):
	<a href="ae">if672.ufpe@gmail.com</a>
	
Inscreva-se no grupo (para receber avisos/informações):
	<a href="ae">http://groups.google.com/a/cin.ufpe.br/group/if672-l</a>
	
<h1>Equipe de Ensino</h1>
Professora:
	<a href="ae">Kátia Guimarães</a>
	
Monitores:
	<a href="ae">Rafael Brandão</a>
	
</pre>
</div>


</div>
</body>
</html>
