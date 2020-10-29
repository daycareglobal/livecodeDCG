<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Website_model extends CI_Model {
    
    private $table = 'website_setting';

    public function __construct() {
        $this->load->database(); 
    }	

	function getValueBySlug($key = '', $value = false)
	{
		if($key != '')
		{
			$query = $this->db->get_where($this->table,array('slug' => $key));
			$option = $query->row();
			if(!empty($option))
			{
				if($value)
				{
					return $option->value;
				}
				else
				{
					return $option;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function updateOptionsSetting($options = array())
	{
		if(!empty($options))
		{
			foreach ($options as $key => $value) 
			{
				if($this->getValueBySlug($key))
				{
					$this->updateSingleOption($key,$value);
				}
				else
				{
					$this->addOptionBySlug($key,$value);
				}
			}
			return true;
		}	
		else
		{
			return false;
		}
	}

	function updateSingleOption($key = '', $value = '')
	{
		if(is_array($value))
		{
			foreach ($value as $keys => $values) 
			{
				foreach ($values as $k => $v) 
				{
					$this->db->where('website_setting.language_abbr',$keys);
					$this->db->where('website_setting.slug',$k);
					$this->db->set('website_setting.value',$v);
					$this->db->update('website_setting');
				}				
			}
		}
		else
		{
			$updated = $this->db->where(array('slug' => $key))->set(array('value' => $value))->update($this->table);
		}
		if($key == '')
		{
			return false;
		}
		if($updated)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function addOptionBySlug($key = '', $value ='')
	{
		if($key != '')
		{
			$data = array();
			$data['slug'] = $key;
			$data['value'] = $value;
			$result = $this->db->insert($this->table,$data);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
 
}