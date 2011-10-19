<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>
	<link href="<?=base_url('/css/notas_semestre.css')?>" rel="stylesheet" type="text/css"/>

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
		<div id="perfil_button">perfil</div>
		<div id="logout_button">logout</div>
	</ul>
	
</div>

<div id="content">
	<ul id="browse">
		<li>Administrador</li>
		<li>Notas</li>
	</ul>
	
	
<h1>Notas do Semestre (Listas de Exercícios)</h1>

<pre>Aqui você tem acesso às notas de todas as listas, de todos os alunos cadastrados no sistema. Você pode também exportar para alguma planilha de texto, clicando <a href="oi">aqui</a>. À medida que novas listas forem criadas e finalizadas, elas vão aparecer aqui.

</pre>

<table class='campos'><tr><td class='login'></td><td class='campo'>login</td><td class='campo'>L1</td><td class='campo'>L2</td><td class='campo'>L3</td><td class='campo'>L4</td></tr></table> 
<table class='score'><tr><td class='login'>Adriano Barbosa Carvalho</td><td class='nota'> abcd </td><td class='nota acc'> 100% </td><td class='nota avg'> 58% </td><td class='nota '> 0% </td><td class='nota good'> 81% </td></tr></table>
<table class='score'><tr><td class='login'>Bruno Coelho Duarte</td><td class='nota'>bcdef</td><td class='nota acc'> 100% </td><td class='nota acc'> 100% </td><td class='nota bad'> 20% </td><td class='nota bad'> 20% </td></tr></table>
<table class='score'><tr><td class='login'>Rafael Brandão Lôbo</td><td class='nota'>rbl</td><td class='nota acc'> 100% </td><td class='nota acc'> 100% </td><td class='nota acc'> 100% </td><td class='nota good'> 80% </td></tr></table>


</div>
</div>


</body>
</html>
