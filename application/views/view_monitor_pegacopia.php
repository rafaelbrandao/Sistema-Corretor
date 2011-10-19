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
		<li>Pega-cópia</li>
	</ul>
<pre>
<h1>Pega-cópia</h1>
A execução do pega-cópia pode fazer o servidor ficar sobrecarregado, portanto utilize somente quando for necessário. Para executá-lo, basta especificar o número da lista. Depois disso, basta <strong>aguardar um email</strong> que será enviado para você informando que sua execução foi concluída e enviará o relatório com as informações pertinentes, também por email.

Lista #: <input type="text" style="width: 40px;" />

<input type="submit" value="Executar" />


</pre>

</div>
</div>


</body>
</html>
