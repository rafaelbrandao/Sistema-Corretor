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
		<li>Editar Questão</li>
		<li>Exemplos IN/OUT</li>
		<li>Corretor IN/OUT</li>
	</ul>
<pre>
<h1><strong>L2Q1</strong> - Editar questão (enunciado)</h1>
Título: <input type="text" style="width: 200px;" />

Especificação:
<textarea rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>

Formato de entrada:
<textarea rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>

Formato de saída:
<textarea rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>

<input type="submit" value="Salvar alterações" />


<h1><strong>L2Q1</strong> - Exemplos de entrada e de saída</h1>
Exemplo de entrada:
<textarea rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>

Exemplo de saída:
<textarea rows="6" style="width: 600px; border: solid 2px #CCC; border-radius: 4px;"></textarea>

Entrada para download (opcional): <input type="file" name="solucao" style="width: 200px;" text="selecionar" />

Saída para download (opcional): <input type="file" name="solucao" style="width: 200px;" text="selecionar" />

<input type="submit" value="Salvar alterações" />


<h1><strong>L2Q1</strong> - Entradas e saídas para o corretor</h1>Nesta seção, você vê a lista de entradas e saídas já criadas.

	L2Q1E<strong>1</strong> [ <a href="oi">excluir</a> ]:
	
		Peso: <strong>1</strong>
		Tempo: <strong>4</strong> segundo(s)
		Entrada: <a href="oi">download</a>
		Saida: <a href="oi">download</a>
		
<h2>Enviar nova entrada e saída para o corretor</h2>Entrada #: <input type="text" style="width: 20px;" />
Peso (para média): <input type="text" style="width: 30px;" value="1" />
Tempo (em segundos): <input type="text" style="width: 30px;" value="1" />
Arquivo de entrada: <input type="file" name="solucao" style="width: 200px;" text="selecionar" />
Arquivo de saída: <input type="file" name="solucao" style="width: 200px;" text="selecionar" />
<input type="submit" value="Adicionar" />


</pre>

</div>
</div>


</body>
</html>
