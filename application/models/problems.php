<?php

class Problems extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function get_problems_from_list($list_id=0)
    {
    	if (!$list_id) return array();
    	$query = $this->db->query("SELECT id_questao, numero FROM Questao WHERE id_lista=$list_id ORDER BY numero");
    	return $query->result_array();
    }
    
}
