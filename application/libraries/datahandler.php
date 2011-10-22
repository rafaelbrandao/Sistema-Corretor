<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class DataHandler {

    function convert_date_format($format='')
    {
    	$words = explode(' ', $format);
    	if (count($words) == 2) {
			$date = explode('/', $words[0]);
			$time = explode(':', $words[1]);
			$year = date('Y');
			if (count($date) == 2 && count($time) == 2)
				return $year.'-'.$date[1].'-'.$date[0].' '.$time[0].':'.$time[1].':00';
    	}
    	return '';
    }
    
    function translate_date_format($format='')
    {
    	$words = explode(' ', $format);
    	if (count($words) == 2) {
			$date = explode('-', $words[0]);
			$time = explode('-', $words[1]);
			if (count($date) == 3 && count($time) == 3)
				return $date[2].'/'.$date[1].' '.$time[0].':'.$time[1];
    	}
    	return '';
    }
    
    function validate_date_format($format='')
    {
    	$words = explode(' ', $format);
    	if (count($words) != 2)
    		return FALSE;
    	
		$date = explode('/', $words[0]);
		if (count($date) != 2)
			return FALSE;
			
		$time = explode(':', $words[1]);    	
		if (count($time) != 2)
			return FALSE;
    	
    	return TRUE;
    }
    
    function get_list_state($timebegin='', $timeend='', $rev_timebegin='', $rev_timeend='')
    {
    	$states = array('preparacao', 'andamento', 'correcao', 'revisao', 'finalizada');
    	if ($timebegin == '' || $timeend == '')
    		return $states[0];
    	
    	$now = time();
    	
    	if ($now < strtotime($timebegin))
    		return $states[0];
    		
    	if ($now <= strtotime($timeend))
    		return $states[1];
    	
    	if ($rev_timebegin == '' || $rev_timeend == '')
    		return $states[2];
    	
    	if ($now < strtotime($rev_timebegin))
    		return $state[2];
    	
    	if ($now <= strtotime($rev_timeend))
    		return $state[3];
    	
    	return $states[2];
    }
}

/* End of file Someclass.php */
