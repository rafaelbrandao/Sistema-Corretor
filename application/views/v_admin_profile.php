<ul id="browse">
	<li>Administrador</li>
</ul>

<pre>
<h1>Perfil</h1>Olá, <strong><?=$nome?></strong>, seu login é <strong><?=$login?></strong> e seu email, <strong><?=$email?></strong>.

<h1>Administrador</h1>Você tem privilégios de administrador neste sistema.

<a href="<?=base_url('/index.php/monitor/lists')?>">Listas de Exercícios</a> - criar, editar ou remover listas e suas respectivas questões.

<a href="oi">Clarifications</a> - listar clarifications pendentes e respondê-los.

<a href="oi">Revisões</a> - listar revisões solicitadas e analisá-las.

<a href="oi">Corretor</a> - executa correção de listas ou de questões de alunos.

<a href="oi">Pega-cópia</a> - executa pega-cópia.

<a href="<?=base_url('/index.php/monitor/pending_registers')?>">Cadastros Pendentes</a> - lista cadastros pendentes e efetua confirmação dos mesmos.

<a href="<?=base_url('/index.php/monitor/register_user')?>">Cadastrar Aluno/Monitor</a> - permite o cadastro manual de alunos ou de monitores.

<a href="<?=base_url('/index.php/monitor/list_users')?>">Listar Alunos e Monitores</a> - listar, editar ou excluir dados de alunos ou monitores cadastrados.

<a href="oi">Notas do Semestre</a> - ver a lista de notas dos alunos nas listas.


</pre>
