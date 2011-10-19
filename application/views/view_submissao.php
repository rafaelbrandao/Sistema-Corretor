<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>

</head>
<body>

<div id="notice_box" style="visibility: visible;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';">Submissão enviada com sucesso.</div></div>
<div id="error_box" style="visibility: hidden;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';">Login e/ou senha inválidos.</div></div>

<div id="navi">
	<div id="navi_shadow"></div>
	<ul id="navi_options">
		<div id="logo_cin"></div>
		<li>Home</li>
		<li>Avisos</li>
		<li>Cronograma</li>
		<li>Listas</li>
		<li>Material</li>
		<!-- <div id="login_button">login</div> -->
		<div id="perfil_button">perfil</div>
		<div id="logout_button">logout</div>
	</ul>
	
</div>

<div id="content">
	<ul id="browse">
		<li>Listas</li>
		<li>L2Q2</li>
		<li>Submissão</li>
	</ul>
	
	
<h1><strong>L2Q2</strong> - Submissão</h1>
<ul class="lista_menu">
	<li>Código fonte: <strong>L2Q2.c</strong>, <strong>L2Q2.cpp</strong> ou <strong>L2Q2.java</strong></li>
	<li>Entrada: <strong>L2Q2.in</strong></li>
	<li>Saída: <strong>L2Q2.out</strong></li>
</ul>
<pre>Selecione o arquivo contendo sua solução e digite sua senha. O nome do arquivo precisa ser igual a um dos listados em "código fonte". Verifique os nomes dos arquivos de <strong>entrada</strong> e de <strong>saída</strong>. Seu arquivo não pode exceder <strong>1 MB</strong> de tamanho.

Arquivo: <input type="file" name="solucao" style="width: 300px;" text="selecionar" />
Senha:   <input type="password" name="senha" style="width: 200px;" />
		 <input type="submit" value="Enviar" style="margin-left: 132px; width: 60px;"/>
</pre>


<h2>Última Submissão</h2>
<pre>Houve um <strong>erro de compilação</strong> no seu último código enviado:

<div style="border-left: solid 2px #ddd; padding-left: 10px; font-weight: bold;">L2Q2.cpp: In function ‘int main()’:
L2Q2.cpp:6: error: expected ‘;’ before ‘return’
</div>


A seguir, o conteúdo do arquivo <strong>L2Q2.cpp</strong>, enviado por você em <strong>12/09 23:50</strong>:

<div style="border-left: solid 2px #ddd; padding-left: 10px;">#include &lt;cstdio>
#include &lt;cstdlib>

int main() {
	printf("Hello world\n")
	return 0;
}
</div>
</pre>



</div>
</div>


</body>
</html>
