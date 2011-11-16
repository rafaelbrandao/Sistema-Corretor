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
    
    function rem_input($input_id = 0)
    {
    	if (!$input_id)
    		return;
    	$this->db->delete('Material_Correcao', array('id_Correcao' => $input_id));
    }
    
    function get_inputs_for_problem($problem_id=0)
    {
    	if (!$problem_id) return array();
    	$query = $this->db->query("SELECT id_Correcao as id_correcao, max_tempo_execucao, peso_correcao FROM Material_Correcao WHERE id_Questao='$problem_id'");
    	return $query->result_array();
    }
    
    function get_input_basic_data($input_id = 0)
    {
    	if (!$input_id)
    		return array();
    	$query = $this->db->query("SELECT id_Questao as id_questao, id_Correcao as id_correcao, max_tempo_execucao, peso_correcao FROM Material_Correcao WHERE id_Correcao='$input_id'");
    	return $query->num_rows() > 0 ? $query->row_array() : array();
    }

	function get_file_for_inputs($input_id=0, $column_name=''){
		if (!$input_id) return '';
		if($column_name != 'saida' && $column_name != 'entrada') return '';
		$query = $this->db->query("SELECT $column_name FROM Material_Correcao WHERE id_correcao='$input_id'");
		$resultado = $query->result_array();
		return $resultado[0][$column_name];
	}

	function get_corrector_submissions(){
		$query = $this->db->query("SELECT l.nome_lista as nome_lista, c.id_corretor as id_corretor, c.estado as estado, c.data_pedido as data_pedido FROM Lista_Exercicios l, Corretor c WHERE c.id_lista AND l.id_lista = c.id_lista ORDER BY data_pedido DESC");
		$resultado = $query->result_array();
		return $resultado;
	}
	
	function add_corrector_request($data){
		$this->db->insert('Corretor', $data);
	}
	
	function get_copy_report($id_corretor){
		$query = $this->db->query("SELECT relatorio_pcopia as relatorio, l.nome_lista as nome_lista FROM Corretor c, Lista_Exercicios l WHERE l.id_lista=c.id_lista AND id_corretor = $id_corretor");
		return $query->num_rows() > 0 ? $query->row() : array();
	}
	
}
