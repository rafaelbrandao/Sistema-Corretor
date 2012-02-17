<?php

class User extends CI_Model {
	var $teacher_login = 'katiag';
    var $login = '';
    var $pwd = '';

    function __construct()
    {
        parent::__construct();
    }
    
    function init_default_user()
    {
    	$query = $this->db->query('SELECT login, senha FROM Usuario WHERE login = "admin"');
    	if ($query->num_rows() > 0) return FALSE;
    	else {
			$this->db->query('INSERT INTO Usuario (nome, tipo_permissao, email, login, senha, data_confirmacao) VALUES ("admin", "administrador", "admin@nomail", "admin", "admin", "'.date("Y-m-d H:i:s").'")');
			return TRUE;
    	}
    }
    
    function is_user_registered($login='')
    {
    	if (!$login) return FALSE;
    	$query = $this->db->query('SELECT login FROM Usuario WHERE login = "'.$login.'"');
    	return $query->num_rows() > 0;
    }

    function is_user_confirmed($login='')
    {
    	if (!$login) return FALSE;
    	$query = $this->db->query('SELECT login FROM Usuario WHERE login = "'.$login.'" AND data_confirmacao IS NOT NULL');
    	return $query->num_rows() > 0;
    }
    
    function is_user_admin($login='')
    {
    	if (!$login) return FALSE;
    	$query = $this->db->query('SELECT login FROM Usuario WHERE login = "'.$login.'" AND tipo_permissao = "administrador"');
    	return $query->num_rows() > 0;
    }
    
    function is_pwd_correct($login='', $pwd='')
    {
    	if (!$login || !$pwd) return FALSE;
    	$query = $this->db->query('SELECT login FROM Usuario WHERE login = "'.$login.'" AND senha = "'.$pwd.'"');
    	return $query->num_rows() > 0;
    }
    
    function add_user($login='', $pwd='', $nome='', $email='', $is_admin=FALSE, $skip_confirmation=FALSE)
    {
    	if (!$login || !$pwd || !$nome || !$email) return FALSE;
    	$this->db->query("INSERT INTO Usuario (nome, tipo_permissao, email, login, senha".($skip_confirmation ? ', data_confirmacao' : '').") VALUES ('$nome', '".($is_admin ? 'administrador' : 'aluno')."', '$email', '$login', '$pwd'".($skip_confirmation ? ", '".date("Y-m-d H:i:s")."'" : '').")");
    	return TRUE;
    }
    
    function retrieve_info($login='', $retrieve_access=FALSE) {
    	if (!$login)
    		return array();
    	$query = $this->db->query('SELECT nome, login, email'.($retrieve_access ? ', tipo_permissao' : '').' FROM Usuario WHERE login = "'.$login.'"');
    	if ($query->num_rows() < 1)
    		return array();
    		
    	foreach ($query->result_array() as $row)
    		return $row;
    	
    	return array();
    }
    
    function retrieve_pending_registers() {
    	$query = $this->db->query('SELECT nome, login, email FROM Usuario WHERE data_confirmacao IS NULL');
    	return $query->result_array();
    }
    
    function register_confirm($login='') {
    	if (!$login) return;
    	if ($this->is_user_confirmed($login)) return;
    	$this->db->query('UPDATE Usuario SET data_confirmacao="'.date("Y-m-d H:i:s").'" WHERE login="'.$login.'"');
    }
    
	function register_reject($login='') {
    	if (!$login) return;
    	if ($this->is_user_confirmed($login)) return;
    	$this->db->query('DELETE FROM Usuario WHERE login="'.$login.'"');
    }
    
	function delete_user($login='') {
    	if (!$login) return;
    	$this->db->query('DELETE FROM Usuario WHERE login="'.$login.'"');
    }
    
    function retrieve_list_students() {
		$query = $this->db->query('SELECT login FROM Usuario WHERE tipo_permissao="aluno"');
    	return $query->result_array();
    }
    
    function retrieve_list_students_order() {
		$query = $this->db->query('SELECT login, nome FROM Usuario WHERE tipo_permissao="aluno" ORDER BY nome');
    		return $query->result_array();
    }
    
    function retrieve_list_admins() {
		$query = $this->db->query('SELECT login FROM Usuario WHERE tipo_permissao="administrador" AND login!="admin"');
    	return $query->result_array();
    }
    
    function update_user($login='', $pwd='', $nome='', $email='', $grant_access=FALSE) {
    	if (!$login) return;
    	$this->db->query("UPDATE Usuario SET nome='$nome', email='$email', tipo_permissao='".($grant_access != FALSE ? 'administrador' : 'aluno')."'".($pwd != '' ? ", senha='$pwd'" : '')." WHERE login='$login'");
    }
    
}
