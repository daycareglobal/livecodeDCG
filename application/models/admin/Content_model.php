<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Content_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'tbl_static_contents';
	}
	
	function getAllRecords() {
		$this->db->order_by ( 'id', 'DESC' );
		$query = $this->db->get ( $this->table );
		$record = $query->result ();
		return $record;
	}

	function getRecordById($id) {
		$this->db->where ( 'id', $id );
		$query = $this->db->get ( $this->table );
		return $query->row ();
	}
	
	function updateData( $data = array(), $id = '' )
	{
		$this->db->where(array('id' => $id));
	  	$status = $this->db->update($this->table, $data);
	  	
	  	if( $status )
	  		return TRUE;
	  	else
	  		return FALSE;
	}
	function getRecordBySlug($slug)
	{
		$this->db->select('description');
		$record = $this->db->get_where($this->table,array('slug' => $slug ));
		$data = $record->row();
		return $data;
	}

	function getAboutUsTeam()
	{
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('tbl_about_us_team');
		$record = $query->result();
		return $record;
	}
	
	function insert_team_record($data)
	{
		$this->db->insert('tbl_about_us_team', $data);
        return $this->db->insert_id();
	}

	function changeTeamStatusById($id,$status)
    {
        $this->db->where('id',$id);
        $this->db->update('tbl_about_us_team',array('status' => $status));
    }

    function deleteTeam($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_about_us_team');
    }

    function getTeamRecordById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_about_us_team');
		return $query->row();
	}

	function update_team_record($data = array(), $id = '')
	{
		$this->db->where(array('id' => $id));
	  	$status = $this->db->update('tbl_about_us_team', $data);

	  	if ($status)
	  		return TRUE;
	  	else
	  		return FALSE;
	}

	function getHomePageContent()
    {
        $query = $this->db->get('tbl_home_page');      
        return $query->result();
    }

    function update_single_record_by_slug($slug, $value)
	{
		$this->db->where(array('slug' => $slug))->set('image', $value)->update('tbl_home_page');
	}

	function update_home_record($options = array())
	{
		if (!empty($options)) {

			foreach ($options as $key => $value) {
				$this->updateSingleOption($key, $value);
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
		if (is_array($value)) {

			foreach ($value as $keys => $values) {

				if ($keys == 0) {
					$this->db->where('tbl_home_page.slug', 'over-values-one');
					$this->db->set('tbl_home_page.title', $values['title']);
					$this->db->set('tbl_home_page.value', $values['value']);
					$this->db->update('tbl_home_page');
				}

				if ($keys == 1) {
					$this->db->where('tbl_home_page.slug', 'over-values-two');
					$this->db->set('tbl_home_page.title', $values['title']);
					$this->db->set('tbl_home_page.value', $values['value']);
					$this->db->update('tbl_home_page');
				}

				if ($keys == 2) {
					$this->db->where('tbl_home_page.slug', 'over-values-three');
					$this->db->set('tbl_home_page.title', $values['title']);
					$this->db->set('tbl_home_page.value', $values['value']);
					$this->db->update('tbl_home_page');
				}

				if ($keys == 3) {
					$this->db->where('tbl_home_page.slug', 'over-values-four');
					$this->db->set('tbl_home_page.title', $values['title']);
					$this->db->set('tbl_home_page.value', $values['value']);
					$this->db->update('tbl_home_page');
				}
				$updated = true;

				// foreach ($values as $k => $v) {
				// 	$this->db->where('tbl_home_page.slug', $k);
				// 	$this->db->set('tbl_home_page.title', $v);
				// 	$this->db->set('tbl_home_page.value', $v);
				// 	$this->db->update('tbl_home_page');
				// }
			}
		}
		else
		{
			$updated = $this->db->where(array('slug' => $key))->set(array('value' => $value))->update('tbl_home_page');
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
}