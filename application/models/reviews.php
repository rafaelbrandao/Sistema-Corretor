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
    
}
