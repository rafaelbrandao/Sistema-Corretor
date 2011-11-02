<?php

class Judge extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function add_input_for_problem($problem_id=0, $input='', $output='', $timelimit=0, $weight=0)
    {
    	if (!$problem_id) return FALSE;
    	$data = array(
    		'id_Questao' => $problem_id,
    		'entrada' => $input,
    		'saida' => $output,
    		'max_tempo_execucao' => $timelimit,
    		'peso_correcao' => $weight
    		);
    	$this->db->insert('Material_Correcao', $data);
    }
    
    function get_inputs_for_problem($problem_id=0)
    {
    	if (!$problem_id) return array();
    	$query = $this->db->query("SELECT id_Correcao as id_correcao, max_tempo_execucao, peso_correcao FROM Material_Correcao WHERE id_Questao='$problem_id'");
    	return $query->result_array();
    }

	function get_file_for_inputs($input_id=0, $column_name=''){
		if (!$input_id) return '';
		if($column_name != 'saida' && $column_name != 'entrada') return '';
		$query = $this->db->query("SELECT $column_name FROM Material_Correcao WHERE id_correcao='$input_id'");
		$resultado = $query->result_array();
		return $resultado[0][$column_name];
	}

}
