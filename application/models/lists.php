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
    
}
