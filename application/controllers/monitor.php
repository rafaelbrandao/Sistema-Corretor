<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends CI_Controller {

	var $logged = '';
	var $is_admin = FALSE;

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library(array('datahandler','session','input'));
		$this->load->model('user','', TRUE);
		$this->load->model('lists','', TRUE);
		$this->load->model('problems','', TRUE);
		$this->load->model('judge','', TRUE);
		$this->load->model('clarifications','', TRUE);
		
		$this->logged = $this->session->userdata('logged');
		if ($this->logged) 
			$this->is_admin = $this->user->is_user_admin($this->logged);
		
		if (!$this->logged || !$this->is_admin)
			redirect(base_url('/'), 'location');
	}

	function index()
	{
		$notice = $this->session->flashdata('notice');
		
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_admin_profile', $this->user->retrieve_info($this->logged));
		$this->load->view('v_footer');
		//$this->load->view('view_monitor_perfil');
	}
	
	function register_user()
	{
		$nome = $this->input->post('nome');
		$email = $this->input->post('email');
		$pwd = $this->input->post('pwd');
		$login = $this->input->post('login');
		$grant_access = $this->input->post('grant_access');
		
		if (!$nome && !$email && !$pwd && !$login) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_register_user');
			$this->load->view('v_footer');
			return;
		}
		
		$error='';
		
		if (!$nome) $error = 'É preciso especificar nome completo no sistema.';
		else if (!$login) $error = 'É preciso especificar login no sistema.';
		else if (!$pwd) $error = 'É preciso especificar uma senha no sistema.';
		else if (!$email) $error = 'É preciso especificar um email no sistema.';
		else if (count(explode(" ",$nome)) < 2) $error = 'É preciso especificar nome completo no sistema.';
		else if ($this->user->is_user_registered($login)) $error = 'Login especificado já está cadastrado.';
		else if (!$this->user->add_user($login,$pwd,$nome,$email,($grant_access == '1'),TRUE)) $error = 'Erro desconhecido.';
		
		if ($error) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_register_user', array('nome'=>$nome, 'email'=>$email, 'pwd'=>$pwd, 'login'=>$login, 'grant_access'=>$grant_access));
			$this->load->view('v_footer');
			return;
		}
		
		$this->session->set_flashdata('notice','Usuário (login: '.$login.') foi cadastrado com sucesso!');
		redirect(base_url('/index.php/monitor'), 'location');
		
		
	}
	
	function pending_registers()
	{
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_admin_pending_registers', array('pending_list'=>$this->user->retrieve_pending_registers()));
		$this->load->view('v_footer');
		
		//$this->load->view('view_monitor_listar_cadastros');
	}
	
	function register_confirm($login='')
	{
		$user = $this->user->retrieve_info($login);
		/* SENDS EMAIL TO USER
		
		$this->load->library('email');
		$this->email->from('your@example.com', 'Your Name');
		$this->email->to($user['email']); 
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class, '.$user['login']);	
		$this->email->send();
		*/
		$this->user->register_confirm($login);
		redirect(base_url('/index.php/monitor/pending_registers'), 'location');
	}
	
	function register_reject($login='')
	{
		$this->user->register_reject($login);
		redirect(base_url('/index.php/monitor/pending_registers'), 'location');
	}
	
	function list_users()
	{
		$students = $this->user->retrieve_list_students();
		$admins = $this->user->retrieve_list_admins();
		
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_admin_list_users', array('students'=>$students, 'admins'=>$admins));
		$this->load->view('v_footer');
	}
	
	function edit_user($login='')
	{	
		if ($login=='admin') {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		$pwd = $this->input->post('pwd');
		$nome = $this->input->post('nome');
		$email = $this->input->post('email');
		$grant_access = $this->input->post('grant_access');
		$confirm_pwd = $this->input->post('confirm_pwd');
		
		if (!$pwd && !$nome && !$email) {
			if (!$login) {
				redirect(base_url('/index.php/monitor'), 'location');
				return;
			}
			$user = $this->user->retrieve_info($login,TRUE);
			$pwd = '';
			$nome = $user['nome'];
			$email = $user['email'];
			$grant_access = $user['tipo_permissao'] == 'aluno' ? FALSE : '1';
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_edit_user', array('pwd'=>$pwd,'nome'=>$nome,'email'=>$email,'grant_access'=>$grant_access,'login'=>$login));
			$this->load->view('v_footer');			
			return;
		}
		
		$error = '';
		if (!$nome) $error = 'Usuários precisam ter seu nome completo especificado.';
		else if (!$email) $error = 'Usuários precisam ter seu email especificado.';
		else if (count(explode(" ",$nome)) < 2) $error = 'Usuários precisam ter seu nome completo especificado.';
		else if (!$confirm_pwd) $error='Você precisa confirmar as mudanças digitando sua senha.';
		else if (!$this->user->is_pwd_correct($this->logged, $confirm_pwd)) $error='Sua senha está incorreta. Mudanças não foram efetuadas.';
		
		if ($error) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_edit_user', array('pwd'=>$pwd,'nome'=>$nome,'email'=>$email,'grant_access'=>$grant_access,'login'=>$login));
			$this->load->view('v_footer');			
			return;
		}
		
		
		$this->user->update_user($login, $pwd, $nome, $email, $grant_access);
		$this->session->set_flashdata('notice',"Usuário (login: $login) teve seus dados atualizados com sucesso!");
		redirect(base_url('/index.php/monitor'), 'location');
	}	
	
	function delete_user($login='', $confirm=FALSE)
	{
		if (!$login || $login=='admin') {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		
		if (!$confirm) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_rem_user', array('login'=>$login));
			$this->load->view('v_footer');
			return;
		}
		
		$confirm_pwd = $this->input->post('confirm_pwd');
		if (!$this->user->is_pwd_correct($this->logged, $confirm_pwd)) {
			$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>'Sua senha está incorreta. Usuário não foi excluido.'));
			$this->load->view('v_admin_rem_user', array('login'=>$login));
			$this->load->view('v_footer');
			return;			
		}
		
		$this->user->delete_user($login);
		$this->session->set_flashdata('notice',"Usuário (login: $login) foi excluido com sucesso!");
		redirect(base_url('/index.php/monitor'), 'location');
	}
	
	function lists()
	{
		$notice = $this->session->flashdata('notice');
		$error = $this->session->flashdata('error');
		$lists_data = $this->lists->get_all_lists_data();
	
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice, 'error'=>$error));
		$this->load->view('v_admin_lists', array('lists_data'=>$lists_data));
		$this->load->view('v_footer');
	}
	
	function add_list()
	{
		$listprefix = $this->input->post('listprefix');
		$timebegin = $this->input->post('timebegin');
		$timeend = $this->input->post('timeend');
		
		if (!$listprefix && !$timebegin && !$timeend) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_add_list');
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		if (!$listprefix)
			$error = 'Você precisa especificar o prefixo da lista.';
		else if ($timebegin && $timebegin != '' && !$this->datahandler->validate_date_format($timebegin))
			$error = 'O formato da data de inicio deve ser DD/MM HH:mm. Veja o exemplo para esclarecimento.';
		else if ($timeend && $timeend != '' && !$this->datahandler->validate_date_format($timeend))
			$error = 'O formato da data de término deve ser DD/MM HH:mm. Veja o exemplo para esclarecimento.';
		
		if ($error == '') {
			$_timebegin = $this->datahandler->convert_date_format($timebegin);
			$_timeend = $this->datahandler->convert_date_format($timeend);
			
			if ($_timebegin != '' && $_timeend != '' && strtotime($_timebegin) > strtotime($_timeend))
				$error = 'O inicio da lista deve acontecer antes do fim da mesma.';
			else if ($this->lists->create_list($listprefix, $_timebegin, $_timeend) == 0)
				$error = 'O prefixo escolhido para a lista já existe. Escolha outro.';
		}
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_add_list', array('listprefix' => $listprefix, 'timebegin'=>$timebegin, 'timeend'=>$timeend));
			$this->load->view('v_footer');
			return;
		}
		
		$this->session->set_flashdata('notice',"Lista '$listprefix' adicionada com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function edit_list($list_id=0)
	{
		if (!$list_id || !$this->lists->has_list_id($list_id)) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		
		$form['list_id'] = $list_id;
		$form['listprefix'] = $this->input->post('listprefix');
		$form['liststate'] = $this->input->post('liststate');
		$form['timebegin'] = $this->input->post('timebegin');
		$form['timeend'] = $this->input->post('timeend');
		$form['rev_timebegin'] = $this->input->post('rev_timebegin');
		$form['rev_timeend'] = $this->input->post('rev_timeend');
		if (!$form['listprefix'] & !$form['liststate'] && !$form['timebegin']
			&& !$form['timeend'] && !$form['rev_timebegin'] && !$form['rev_timeend']) {
			$data = $this->lists->get_list_data($list_id);
			$form['listprefix'] = $data['nome_lista'];
			$form['liststate'] = $data['estado_lista'];
			$form['timebegin'] = $this->datahandler->translate_date_format($data['data_lancamento']);
			$form['timeend'] = $this->datahandler->translate_date_format($data['data_finalizacao']);
			$form['rev_timebegin'] = $this->datahandler->translate_date_format($data['data_inicio_revisao']);
			$form['rev_timeend'] = $this->datahandler->translate_date_format($data['data_fim_revisao']);
			
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_edit_list', $form);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$other_id = $this->lists->get_list_id($form['listprefix']);
		$timebegin = '';
		$timeend = '';
		$rev_timebegin = '';
		$rev_timeend = '';
		
		if ($other_id && $other_id != $list_id) $error = 'Você escolheu um prefixo que já está sendo usado em outra lista.';
		else if (!$form['liststate']) $error = 'Você deveria selecionar um estado válido da lista.';
		if (!$error) {
			$timebegin = $this->datahandler->convert_date_format($form['timebegin']);
			$timeend = $this->datahandler->convert_date_format($form['timeend']);
			$rev_timebegin = $this->datahandler->convert_date_format($form['rev_timebegin']);
			$rev_timeend = $this->datahandler->convert_date_format($form['rev_timeend']);
			if ($timebegin != '' && $timeend != '' && strtotime($timebegin) > strtotime($timeend))
				$error = 'A data de inicio da lista deveria ser antes da data de término da mesma.';
			else if ($rev_timebegin != '' && $rev_timeend != '' && strtotime($rev_timebegin) > strtotime($rev_timeend))
				$error = 'A data de inicio da revisão deveria ser antes da data de término da mesma.';
			else if (!$this->lists->edit_list($list_id, $form['listprefix'], $form['liststate'], $timebegin, $timeend, $rev_timebegin, $rev_timeend))
				$error = 'Erro desconhecido.';
		}
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_edit_list', $form);
			$this->load->view('v_footer');
			return;
		}
		$this->session->set_flashdata('notice',"Lista '".$form['listprefix']."' modificada com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function rem_list($list_id=0, $confirm='')
	{
		if (!$list_id || !$this->lists->has_list_id($list_id)) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		
		$listprefix = $this->lists->get_list_name($list_id);
		
		if ($confirm == '') {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_rem_list', array('listprefix'=>$listprefix, 'list_id'=>$list_id));
			$this->load->view('v_footer');
			return;
		}
		
		$confirm_pwd = $this->input->post('confirm_pwd');
		if (!$this->user->is_pwd_correct($this->logged, $confirm_pwd)) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>'Senha incorreta. Lista não foi removida.'));
			$this->load->view('v_admin_rem_list', array('listprefix'=>$listprefix, 'list_id'=>$list_id));
			$this->load->view('v_footer');
			return;
		}
		$this->lists->delete_list($list_id);
		$this->session->set_flashdata('notice', "Lista '$listprefix' foi removida com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function add_problem($list_id=0)
	{
		if (!$list_id || !$this->lists->has_list_id($list_id)) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		$data['listprefix'] = $this->lists->get_list_name($list_id);
		$data['list_id'] = $list_id;
		$data['problem_num'] = $this->input->post('problem_num');
		
		if (!$data['problem_num']) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_add_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$problem_num = 0;
		if (!is_numeric($data['problem_num']))
			$error = 'Você deve passar um número inteiro positivo.';
		else if (($problem_num = intval($data['problem_num'])) <= 0)
			$error = 'Você deve passar um número inteiro positivo. Zero ou números negativos são inválidos.';
		else if ($this->problems->has_problem_num($list_id, $problem_num))
			$error = "Uma questão com número $problem_num já existe. Escolha outro.";
		
		if ($error) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
			$this->load->view('v_admin_add_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$this->problems->create_problem_num($list_id, $problem_num);
		$this->session->set_flashdata('notice', "Questão #$problem_num criada com sucesso!");
		redirect(base_url('/index.php/monitor/lists'), 'location');
	}
	
	function edit_problem($problem_id=0, $step='')
	{
		$list_id = 0;
		if (!$problem_id || !($list_id = $this->problems->get_list_id_for_problem($problem_id))) {
			redirect(base_url('/index.php/monitor/lists'), 'location');
			return;
		}
		$data['list_id'] = $list_id;
		$data['listprefix'] = $this->lists->get_list_name($list_id);
		$data['problem_id'] = $problem_id;
		$pro = $this->problems->get_data_for_problem($problem_id);
		
		$data['problem_num'] = $pro['numero'];
		$data['specs'] = $step == 'specs' ? $this->input->post('specs') : $pro['enunciado'];
		$data['title'] = $step == 'specs' ? $this->input->post('title') : $pro['nome'];
		$data['in_format'] = $step == 'specs' ? $this->input->post('in_format') : $pro['descricao_entrada'];
		$data['out_format'] = $step == 'specs' ? $this->input->post('out_format') : $pro['descricao_saida'];
		$data['in_sample'] = $step == 'samples' ? $this->input->post('in_sample') : $pro['entrada_exemplo'];
		$data['out_sample'] = $step == 'samples' ? $this->input->post('out_sample') : $pro['saida_exemplo'];
		
		if (!$step) {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_edit_problem', $data);
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		$question = $data['listprefix'].'Q'.$data['problem_num'];
		
		if ($step == 'add_answer') {
			$data['new_input'] = $this->input->post('new_input');
			$data['new_output'] = $this->input->post('new_output');
			$data['timelimit'] = $this->input->post('timelimit');
			$data['weight'] = $this->input->post('weight');
			$timelimit = 0;
			$weight = 0;
			if (!$data['new_input'])
				$error = 'Você precisa especificar alguma entrada para o corretor.';
			else if (!$data['timelimit'])
				$error = 'Você precisa especificar tempo limite para o corretor.';
			else if (!$data['weight'])
				$error = 'Você precisa especificar o peso para uma nova entrada.';
			else if (!is_numeric($data['timelimit']))
				$error = 'Você deve passar um número inteiro positivo como tempo limite.';
			else if (($timelimit = intval($data['timelimit'])) <= 0)
				$error = 'Você deve passar um número inteiro positivo como tempo limite. Zero ou números negativos são inválidos.';
			else if (!is_numeric($data['weight']))
				$error = 'Você deve passar um número inteiro positivo como peso.';
			else if (($weight = intval($data['weight'])) <= 0)
				$error = 'Você deve passar um número inteiro positivo como peso. Zero ou números negativos são inválidos.';
			
			if ($error) {
				$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'error'=>$error));
				$this->load->view('v_admin_edit_problem', $data);
				$this->load->view('v_footer');
				return;
			}
			$this->judge->add_input_for_problem($problem_id, $data['new_input'], $data['new_output'], $timelimit, $weight);
		}
		else if ($step == 'specs') {
			$this->problems->update_problem_specs($problem_id, $data['title'], $data['specs'], $data['in_format'], $data['out_format']);
		}
		else if ($step == 'samples') {
			$this->problems->update_problem_samples($problem_id, $data['in_sample'], $data['out_sample']);
		}
		
		$this->session->set_flashdata('notice', "Questão $question foi atualizada com sucesso.");
		redirect(base_url('/index.php/monitor/lists'), 'location');
		return;
	}
	
	function clarifications()
	{
		$notice = $this->session->flashdata('notice');
		$data['requests'] = $this->clarifications->get_pending();
		
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_admin_clarifications', $data);
		$this->load->view('v_footer');
	}
	
	function answer_clarification($problem_id=0, $login_request='', $time_request=0, $handle='')
	{
		if (!$problem_id || !$login_request || !$time_request) {
			redirect(base_url('/index.php/monitor/clarifications'), 'location');
			return;
		}
		
		$data['problem_id'] = $problem_id;
		$data['login_request'] = $login_request;
		$data['time_request'] = $time_request;
		$data['request'] = $this->clarifications->get_data($problem_id, $login_request, $time_request);
		if (!$data['request']) {
			redirect(base_url('/index.php/monitor/clarifications'), 'location');
			return;		
		}
		if ($handle != '')
			$data['answer'] = $this->input->post('answer');
		
		if ($handle == '') {
			$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
			$this->load->view('v_admin_answer_clarification', $data);
			$this->load->view('v_footer');
			return;
		} else if ($handle == 'confirm') {
			$this->clarifications->update_data($problem_id, $login_request, $time_request, $data['answer'], 'respondido');
			$this->session->set_flashdata('notice', 'Clarification respondido com sucesso.');
		} else if ($handle == 'reject') {
			$this->clarifications->update_data($problem_id, $login_request, $time_request, $data['answer'], 'desconsiderado');
			$this->session->set_flashdata('notice', 'Clarification respondido com sucesso.');
		}
		redirect(base_url('/index.php/monitor/clarifications'), 'location');
	}
	
	
	
	
	public function listas()
	{
		$this->load->view('view_monitor_listas');
	}
	
	public function criar_lista()
	{
		$this->load->view('view_monitor_criar_lista');
	}
	
	public function editar_questao()
	{
		$this->load->view('view_monitor_editar_questao');
	}
	
	public function criar_questao()
	{
		$this->load->view('view_monitor_criar_questao');
	}
	
	
	public function remover_questao()
	{
		$this->load->view('view_monitor_remover_questao');
	}
	
	public function remover_entrada_corretor()
	{
		$this->load->view('view_monitor_remover_entrada_corretor');
	}

	public function remover_lista()
	{
		$this->load->view('view_monitor_remover_lista');
	}
	
	public function remover_cadastro()
	{
		$this->load->view('view_monitor_remover_cadastro');
	}
	
	public function editar_lista()
	{
		$this->load->view('view_monitor_editar_lista');
	}

	public function cadastrar_aluno()
	{
		$this->load->view('view_monitor_cadastrar_aluno');
	}
	
	public function editar_aluno()
	{
		$this->load->view('view_monitor_editar_aluno');
	}
	
	public function listar_usuarios()
	{
		$this->load->view('view_monitor_listar_usuarios');
	}	
	


	public function listar_clarifications()
	{
		$this->load->view('view_monitor_listar_clarifications');
	}
	
	public function responder_clarification()
	{
		$this->load->view('view_monitor_responder_clarification');
	}		
	
	public function listar_revisoes()
	{
		$this->load->view('view_monitor_listar_revisoes');
	}
	
	public function analisar_revisao()
	{
		$this->load->view('view_monitor_analisar_revisao');
	}
	
	public function listar_submissoes()
	{
		$this->load->view('view_monitor_listar_submissoes');
	}
	
	public function editar_submissao()
	{
		$this->load->view('view_monitor_editar_submissao');
	}
	
	public function corretor()
	{
		$this->load->view('view_monitor_corretor');
	}
	
	public function pegacopia()
	{
		$this->load->view('view_monitor_pegacopia');
	}
	
	public function notas_semestre()
	{
		$this->load->view('view_monitor_notas_semestre');
	}
}
