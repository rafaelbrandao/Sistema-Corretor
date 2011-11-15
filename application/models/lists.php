<?php

class Lists extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->library('datahandler');
    }
    
    function get_list_id($listprefix='')
    {
    	$query = $this->db->query("SELECT id_lista FROM Lista_Exercicios WHERE nome_lista='$listprefix'");
    	return $query->num_rows() > 0 ? $query->row()->id_lista : 0;
    }
    
    function get_list_name($id=0)
    {
    	$query = $this->db->query("SELECT nome_lista FROM Lista_Exercicios WHERE id_lista='$id'");
    	return $query->num_rows() > 0 ? $query->row()->nome_lista : '';
    }
    
    function has_list_id($id=0)
    {
    	if (!$id) return FALSE;
    	$query = $this->db->query("SELECT nome_lista FROM Lista_Exercicios WHERE id_lista='$id'");
    	return $query->num_rows() > 0;
    }
    
    function create_list($listprefix='', $timebegin='', $timeend='')
    {
    	if ($listprefix == '')
    		return 0;
    	if ($this->get_list_id($listprefix) > 0)
    		return 0;
    	$data = array();
    	
    	$data['nome_lista'] = $listprefix;
    	$data['estado_lista'] = $this->datahandler->get_list_state($timebegin, $timeend);
    	if ($timebegin != '')
    		$data['data_lancamento'] = $timebegin;
    	if ($timeend != '')
    		$data['data_finalizacao'] = $timeend;
    	
    	$this->db->insert('Lista_Exercicios', $data);
    	return $this->db->insert_id();
    }
    
    function get_all_available_lists()
    {
    	$query = $this->db->query("SELECT * FROM Lista_Exercicios WHERE estado_lista != 'preparacao' ORDER BY data_finalizacao DESC");
    	return $query->result_array();
    }
    
    function get_all_lists_data()
    {
    	$query = $this->db->query("SELECT * FROM Lista_Exercicios");
    	return $query->result_array();
    }

	function get_all_lists_idnames()
	{
		$query = $this->db->query("SELECT id_lista, nome_lista FROM Lista_Exercicios");
		return $query->result_array();
	}
    
    function get_list_data($id=0)
    {
    	if (!$id) return array();
    	$query = $this->db->query("SELECT * FROM Lista_Exercicios WHERE id_lista='$id'");
    	return $query->row_array();    	
    }
    
    function edit_list($id=0, $listprefix='', $liststate='', $timebegin='', $timeend='', $rev_timebegin='', $rev_timeend='')
    {
    	if (!$id) return FALSE;
    	$data = array(
    		'nome_lista'=>$listprefix,
    		'estado_lista'=>$liststate,
    		'data_lancamento'=>$timebegin == '' ? NULL : $timebegin,
    		'data_finalizacao'=>$timeend == '' ? NULL : $timeend,
    		'data_inicio_revisao'=>$rev_timebegin == '' ? NULL : $rev_timebegin,
    		'data_fim_revisao'=>$rev_timeend == '' ? NULL : $rev_timeend
    		);
    	$this->db->where('id_lista', $id);
    	$this->db->update('Lista_Exercicios', $data);
    	
    	return TRUE;
    }
    
    function delete_list($id=0)
    {
    	if (!$id) return;
    	$this->db->delete('Lista_Exercicios', array('id_lista' => $id)); 
    }
    
}
