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
	
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice, 'error'=>$error));
		$this->load->view('v_admin_lists');
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
