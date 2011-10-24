<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		
		$this->logged = $this->session->userdata('logged');
		if ($this->logged) 
			$this->is_admin = $this->user->is_user_admin($this->logged);
		
		//$this->user->init_default_user();
		//$this->datahandler->bla();
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url('/'), 'location');
	}
	
	public function teste() {
		$this->session->set_userdata('logged', 'admin');
	}

	public function index()
	{
//		$this->load->helper('url');
		
		//if ($this->user->is_user_confirmed('admin')) echo 'SUCCESS!';
		//else echo 'FAILURE!';
		
		//echo $this->logged;
		//if ($this->is_admin) echo 'wooot!';
		$notice = $this->session->flashdata('notice');
		$this->load->view('v_header', array('tab'=>'home', 'logged'=>$this->logged, 'is_admin'=>$this->is_admin, 'notice'=>$notice));
		$this->load->view('v_index');
		$this->load->view('v_footer');
	}
	
	public function login() {
		//$this->load->view('view_login');	
		
		if ($this->logged) {
			redirect(base_url('/'), 'location');
			return;
		}
		
		$login = $this->input->post('login');
		$pwd = $this->input->post('pwd');
		
		if (!$login && !$pwd) {
			$this->load->view('v_header');
			$this->load->view('v_login');
			$this->load->view('v_footer');
			return;
		}
		
		$error='';
		if (!$login) $error='Você precisa especificar seu login no sistema.';
		else if (!$pwd) $error='Você precisa especificar sua senha no sistema.';
		else if (!$this->user->is_user_registered($login)) $error='Login especificado não está cadastrado no sistema.';
		else if (!$this->user->is_user_confirmed($login)) $error='Login especificado ainda está aguardando confirmação de cadastro.';
		else if (!$this->user->is_pwd_correct($login,$pwd)) $error='Login e/ou senha incorretos.';
		
		if ($error) {
			$this->load->view('v_header',array('error'=>$error));
			$this->load->view('v_login',array('login'=>$login));
			$this->load->view('v_footer');
			return;
		}
		
		$this->session->set_userdata('logged', $login);
		redirect(base_url('/'), 'location');
		
	}
	
	public function register() {
		if ($this->logged) {
			redirect(base_url('/'), 'location');
			return;
		}
		
		$nome = $this->input->post('nome');
		$login = $this->input->post('login');
		$pwd = $this->input->post('pwd');
		
		if (!$nome && !$login && !$pwd) {
			$this->load->view('v_header');
			$this->load->view('v_register');
			$this->load->view('v_footer');
			return;
		}
		
		$error = '';
		
		if (!$nome) $error = 'Você precisa especificar seu nome completo no sistema.';
		else if (!$login) $error = 'Você precisa especificar seu login no sistema.';
		else if (!$pwd) $error = 'Você precisa especificar sua senha no sistema.';
		else if (count(explode(" ",$nome)) < 2) $error = 'Você precisa especificar seu nome completo no sistema.';
		else if ($this->user->is_user_registered($login)) $error = 'Login especificado já está cadastrado. Por favor, use seu login do CIn.';
		else if (!$this->user->add_user($login,$pwd,$nome,"$login@cin.ufpe.br")) $error = 'Erro desconhecido. Por favor, comunique aos monitores.';
		
		if ($error) {
			$this->load->view('v_header',array('error'=>$error));
			$this->load->view('v_register', array('login'=>$login, 'nome'=>$nome));
			$this->load->view('v_footer');
			return;			
		}
		
		$this->session->set_flashdata('notice','Cadastro solicitado com sucesso. Seu pedido será analisado pelos monitores. Por favor, aguarde confirmação por email.');
		redirect(base_url('/'), 'location');
	}

	function lists()
	{
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_lists');
		$this->load->view('v_footer');
	}	

	function problem($problem_id=0) {
		$list_id = $this->problems->get_list_id_for_problem($problem_id);
		if (!$list_id)  {
			redirect(base_url('/'), 'location');
			return;
		}
		$list = $this->lists->get_list_data($list_id);
		if ($list['estado_lista'] == 'preparacao') {
			redirect(base_url('/'), 'location');
			return;			
		}
		$problem = $this->problems->get_data_for_problem($problem_id);
		
		$this->load->view('v_header', array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_problem', array('list'=>$list, 'problem'=>$problem, 'problem_id'=>$problem_id, 'list_id'=>$list_id));
		$this->load->view('v_footer');
	}
	
	
	
	public function cadastro() {
		$this->load->view('view_cadastro');
	}
	
	public function perfil() {
		if ($this->is_admin) {
			redirect(base_url('/index.php/monitor'), 'location');
			return;
		}
		
		if (!$this->logged) {
			redirect(base_url('/'), 'location');
			return;			
		}
		
		$user = $this->user->retrieve_info($this->logged);
		
		$this->load->view('v_header',array('logged'=>$this->logged, 'is_admin'=>$this->is_admin));
		$this->load->view('v_profile', array('login'=>$this->logged, 'nome'=>$user['nome'], 'email'=>$user['email']));
		$this->load->view('v_footer');
		
//		$this->load->helper('url');
		//$this->load->view('view_perfil');	
	}

	public function listas() {
		$this->load->view('view_listas');	
	}
	
	public function questao() {
		$this->load->view('view_questao');	
	}
	
	public function questao_clarifications() {
		$this->load->view('view_questao_clarifications');
	}
	
	public function clarifications() {
		$this->load->view('view_clarifications');
	}
	
	public function submissao() {
		$this->load->view('view_submissao');
	}
	
	public function notas_lista() {
		$this->load->view('view_notas_lista');
	}
	
	public function notas_questao() {
		$this->load->view('view_notas_questao');
	}
	
	public function questao_revisao() {
		$this->load->view('view_questao_revisao');
	}
	
	public function pedir_revisao() {
		$this->load->view('view_pedir_revisao');
	}
	
	
}
