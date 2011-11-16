<?php

class Reviews extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function request_state($problem_id=0, $login='')
    {
    	$query = $this->db->query("SELECT estado_pedido FROM Pedido_Revisao WHERE id_questao='$problem_id' AND login_usuario='$login'");
    	return $query->num_rows() > 0 ? $query->row()->estado_pedido : NULL;
    }
    
    function create_request($problem_id=0, $login='', $request='')
    {
    	if (!$problem_id || !$login || !$request) return FALSE;
    	$data = array(
    		'data_pedido' => date("Y-m-d H:i:s"),
    		'id_questao' => $problem_id,
    		'login_usuario' => $login,
    		'estado_pedido' => 'pendente',
    		'descricao_pedido' => $request
    	);
    	$this->db->insert('Pedido_Revisao', $data);
    	return TRUE;
    }
    
    function get_pending_reviews()
    {
    	$result = array();
    	$query = $this->db->query("SELECT id_questao, login_usuario, data_pedido FROM Pedido_Revisao WHERE estado_pedido='pendente' ORDER BY id_questao, data_pedido");
    	return $query->result_array();
    }
    
    function get_request($problem_id=0, $login='', $time=0)
    {
    	if (!$problem_id || !$login || !$time)
    		return '';
    	$data = array(
    		'data_pedido' => date("Y-m-d H:i:s", $time),
    		'login_usuario' => $login,
    		'id_questao' => $problem_id
    	);
    	$this->db->where($data);
    	$this->db->select('descricao_pedido');
    	$query = $this->db->get('Pedido_Revisao');
    	return $query->num_rows() > 0 ? $query->row()->descricao_pedido : '';
    }
    
    function has_request($problem_id=0, $login='', $time=0)
    {
    	if (!$problem_id || !$login || !$time)
    		return FALSE;
    	$data = array(
    		'data_pedido' => date("Y-m-d H:i:s", $time),
    		'login_usuario' => $login,
    		'id_questao' => $problem_id
    	);
    	$this->db->where($data);
    	$this->db->select('id_questao');
    	$query = $this->db->get('Pedido_Revisao');
    	return $query->num_rows() > 0;
    }
    
    private function modify_request($problem_id=0, $login='', $time=0, $state='')
    {
    	if (!$problem_id || !$login || !$time || !$state)
    		return;
    	
    	$where = array(
    		'data_pedido' => date("Y-m-d H:i:s", $time),
    		'login_usuario' => $login,
    		'id_questao' => $problem_id
    	);
    	
    	$data = array('estado_pedido' => $state);
    	
    	$this->db->where($where);
    	$this->db->update('Pedido_Revisao', $data);
    }
    
    function reject_request($problem_id=0, $login='', $time=0)
    {
    	if (!$problem_id || !$login || !$time)
    		return FALSE;
    	
    	$this->modify_request($problem_id, $login, $time, 'desconsiderado');
    }
    
    function accept_request($problem_id=0, $login='', $time=0)
    {
    	if (!$problem_id || !$login || !$time)
    		return FALSE;
    	
    	$this->modify_request($problem_id, $login, $time, 'respondido');
    }
	
	function get_review_id($login_request='', $problem_id=0, $time_request=0){
		$where = array(
    		'data_pedido' => date("Y-m-d H:i:s", $time_request),
    		'login_usuario' => $login,
    		'id_questao' => $problem_id
    	);
		$this->db->where($where);
    	$this->db->select('id_revisao');
    	$query = $this->db->get('Pedido_Revisao');
		return $query->row()->id_revisao;
	}
}
