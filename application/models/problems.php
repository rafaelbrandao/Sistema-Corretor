<?php

class Problems extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function get_problems_from_list($list_id=0)
    {
    	if (!$list_id) return array();
    	$query = $this->db->query("SELECT id_questao, numero FROM Questao WHERE id_lista='$list_id' ORDER BY numero");
    	return $query->result_array();
    }
    
    function has_problem_num($list_id=0, $num=0)
    {
    	if (!$list_id || !$num) return TRUE;
    	$query = $this->db->query("SELECT id_questao FROM Questao WHERE id_lista='$list_id' and numero='$num'");
    	return $query->num_rows() > 0;
    }
    
    function create_problem_num($list_id=0, $num=0)
    {
    	if (!$list_id || !$num) return FALSE;
    	$data['id_lista'] = $list_id;
    	$data['numero'] = $num;
    	$this->db->insert('Questao', $data);
    	return TRUE;
    }
    
}
