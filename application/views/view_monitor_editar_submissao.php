<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link href="<?=base_url('/css/style.css')?>" rel="stylesheet" type="text/css"/>

</head>
<body>

<div id="notice_box" style="visibility: hidden;"><div class="warning_content" onclick="this.parentNode.style.visibility = 'hidden';">Submissão enviada com sucesso.</div></div>
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
		<li>Administrador</li>
		<li>Submissões</li>
		<li>Editar</li>
	</ul>
	
	
<h1>Editar Submissão</h1>
<pre>Nesta seção você pode analisar uma submissão de algum aluno, mas não pode alterá-la. O que pode fazer é sinalizar que esta submissão deve ser penalizada (em caso de detecção de cópias, por exemplo).
</pre>


<h2><strong>L1Q4.cpp</strong> enviado por <strong>rbl</strong> em <strong>12/09 15:00</strong></h2>
<pre>Houve um <strong>erro de compilação</strong>:

<div style="border-left: solid 2px #ddd; padding-left: 10px; font-weight: bold;">L1Q4.cpp: In function ‘int main()’:
L1Q4.cpp:6: error: expected ‘;’ before ‘return’
</div>


A seguir, o conteúdo do arquivo <strong>L1Q4.cpp</strong>:

<div style="border-left: solid 2px #ddd; padding-left: 10px;">#include &lt;cstdio>
#include &lt;cstdlib>

int main() {
	printf("Hello world\n")
	return 0;
}
</div>
</pre>

<h2>Penalizar Submissão</h2>
<pre><input type="checkbox" name="admin" value="true"> Marque esta opção para sinalizar que sua nota deverá ser <strong>zerada</strong>, independentemente da correção.

<input type="submit" value="Salvar alterações" />


</pre>



</div>
</div>


</body>
</html>
