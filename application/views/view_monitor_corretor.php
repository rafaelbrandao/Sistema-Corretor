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
		<li>Corretor</li>
	</ul>
<pre>
<h1>Corretor</h1>
As atividades aqui listadas podem fazer o servidor ficar sobrecarregado, portanto utilize somente quando for necessário (ao final de listas, ou após revisões). Você deve especificar os dados necessários para cada atividade e então enviar os dados. Depois disso, basta <strong>aguardar um email</strong> que será enviado para você informando que a correção foi concluída.

<h2>Corrigir lista</h2>Neste caso, todas as submissões da lista especificada serão corrigidas.

Lista #: <input type="text" style="width: 40px;" />
<input type="submit" value="Corrigir" />

<h2>Corrigir questão da lista</h2>Neste caso, apenas as submissões da questão da lista especificada serão corrigidas.

Lista #: <input type="text" style="width: 40px;" />
Questão #: <input type="text" style="width: 40px;" />
<input type="submit" value="Corrigir" />

<h2>Corrigir questões de um aluno</h2>Neste caso, apenas as submissões de um aluno na lista especificada serão corrigidas.

Lista #: <input type="text" style="width: 40px;" />
Login: <input type="text" style="width: 80px;" />
<input type="submit" value="Corrigir" />

<h2>Corrigir uma questão de um aluno</h2>Neste caso, apenas a submissão de um aluno numa questão na lista especificada será corrigida.

Lista #: <input type="text" style="width: 40px;" />
Questão #: <input type="text" style="width: 40px;" />
Login: <input type="text" style="width: 80px;" />
<input type="submit" value="Corrigir" />

</pre>

</div>
</div>


</body>
</html>
